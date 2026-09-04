<?php
/**
 * WRMK v3 theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WRMK_V3_VERSION', '1.0.0' );

/* ---- Theme setup ---- */
function wrmk_v3_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'wrmk_v3_setup' );

/* ---- Assets ---- */
function wrmk_v3_assets() {
	wp_enqueue_style( 'wrmk-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Oswald:wght@300;400;500;600&display=swap', array(), null );
	wp_enqueue_style( 'wrmk-v3', get_template_directory_uri() . '/assets/css/wrmk-v3.css', array(), WRMK_V3_VERSION );
	wp_enqueue_style( 'wrmk-v3-neu', get_template_directory_uri() . '/assets/css/wrmk-v3-neu.css', array( 'wrmk-v3' ), WRMK_V3_VERSION );
	wp_enqueue_script( 'wrmk-v3', get_template_directory_uri() . '/assets/js/wrmk-v3.js', array(), WRMK_V3_VERSION, true );

	// Feed the same office/service data the front-end JS already expects
	// (geolocation nearest-office finder, office-hours clock, etc.).
	wp_localize_script( 'wrmk-v3', 'WRMK_V3', wrmk_v3_js_data() );
}
add_action( 'wp_enqueue_scripts', 'wrmk_v3_assets' );

function wrmk_v3_js_data() {
	$offices = array(
		array( 'id' => 'whangarei', 'name' => 'Whangārei', 'address' => "Legal House, 9 Hunt Street", 'phone' => '09 470 2400', 'tel' => 'tel:+6494702400', 'lat' => -35.7275, 'lon' => 174.3166, 'maps' => '9+Hunt+Street,+Whangarei' ),
		array( 'id' => 'dargaville', 'name' => 'Dargaville', 'address' => '118 Victoria Street', 'phone' => '09 439 8001', 'tel' => 'tel:+6494398001', 'lat' => -35.9394, 'lon' => 173.8756, 'maps' => '118+Victoria+Street,+Dargaville' ),
		array( 'id' => 'kerikeri', 'name' => 'Kerikeri', 'address' => 'John Butler Centre, 60 Kerikeri Road', 'phone' => '09 401 6354', 'tel' => 'tel:+6494016354', 'lat' => -35.2268, 'lon' => 173.9474, 'maps' => '60+Kerikeri+Road,+Kerikeri' ),
		array( 'id' => 'warkworth', 'name' => 'Warkworth', 'address' => 'The Oaks on Neville, 9 Queen Street', 'phone' => '09 470 2459', 'tel' => 'tel:+6494702459', 'lat' => -36.3985, 'lon' => 174.6636, 'maps' => '9+Queen+Street,+Warkworth' ),
	);
	return array(
		'offices'  => $offices,
		'services' => array(),
		'openMin'  => 510,
		'closeMin' => 1020,
	);
}

/* ---- Custom post types (originally registered by a plugin that isn't
   part of this export -- re-declared here, matching the real data exactly:
   post_type/taxonomy slugs and field names all match what's already in
   the database, so no data needs to move or be renamed). ---- */
function wrmk_v3_register_post_types() {
	register_post_type( 'staff', array(
		'label'        => 'Staff',
		'public'       => true,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-groups',
		'has_archive'  => 'our-people',
		'rewrite'      => array( 'slug' => 'our-people' ),
		'supports'     => array( 'title', 'editor', 'thumbnail' ),
	) );

	register_post_type( 'testimonial', array(
		'label'        => 'Testimonials',
		'public'       => false,
		'publicly_queryable' => false,
		'show_ui'      => true,
		'show_in_menu' => true,
		'menu_icon'    => 'dashicons-format-quote',
		'supports'     => array( 'title', 'editor' ),
	) );

	register_taxonomy( 'staff-group', 'staff', array(
		'label'        => 'Staff groups',
		'public'       => false,
		'show_ui'      => true,
		'hierarchical' => false,
	) );

	register_taxonomy( 'testimonial-group', 'testimonial', array(
		'label'        => 'Testimonial groups',
		'public'       => false,
		'show_ui'      => true,
		'hierarchical' => false,
	) );
}
add_action( 'init', 'wrmk_v3_register_post_types' );

/* ---- staff-group is a single flat taxonomy mixing role, office and
   practice-area terms. These whitelists split it back into the three
   groups the design needs (role pill, office line, practice-area tags). ---- */
function wrmk_v3_staff_roles() {
	return array( 'Managing Director', 'Director', 'Consultant', 'Associate', 'Senior Lawyer', 'Lawyer', 'Legal Executive', 'Law Clerk', 'General Manager', 'Assistant Manager', 'Office Manager', 'Trust Accountant', 'HR Manager', 'Marketing & Communications Manager' );
}
function wrmk_v3_staff_offices() {
	return array( 'Whangarei', 'Dargaville', 'Kerikeri', 'Warkworth' );
}

/**
 * Split a staff member's staff-group terms into role / office / practice-area buckets.
 *
 * @param int $post_id
 * @return array{role: string, offices: string[], areas: string[]}
 */
function wrmk_v3_get_staff_taxonomy( $post_id ) {
	$terms = get_the_terms( $post_id, 'staff-group' );
	$out   = array( 'role' => '', 'offices' => array(), 'areas' => array() );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return $out;
	}
	$roles   = wrmk_v3_staff_roles();
	$offices = wrmk_v3_staff_offices();
	foreach ( $terms as $term ) {
		$name = html_entity_decode( $term->name );
		if ( in_array( $name, $roles, true ) ) {
			$out['role'] = $name;
		} elseif ( in_array( $name, $offices, true ) ) {
			$out['offices'][] = $name;
		} else {
			$out['areas'][] = $name;
		}
	}
	return $out;
}

/**
 * The stored numbers are plain digits with a leading NZ country code
 * (e.g. "6492228071"). Format them the way the rest of the site does:
 * "09 222 8071" (landline, 9 local digits) or "027 223 5853" (mobile, 10).
 */
function wrmk_v3_format_nz_phone( $raw ) {
	$digits = preg_replace( '/\D/', '', (string) $raw );
	if ( strpos( $digits, '64' ) === 0 ) {
		$digits = '0' . substr( $digits, 2 );
	}
	$len = strlen( $digits );
	if ( 9 === $len ) {
		return substr( $digits, 0, 2 ) . ' ' . substr( $digits, 2, 3 ) . ' ' . substr( $digits, 5 );
	}
	if ( 10 === $len ) {
		return substr( $digits, 0, 3 ) . ' ' . substr( $digits, 3, 3 ) . ' ' . substr( $digits, 6 );
	}
	return $raw;
}

/**
 * Map a staff-group practice-area term name to the 12-service filter slug
 * used by the "Our people" page and the wrmk-v3.js filter script.
 */
function wrmk_v3_area_term_to_slug( $name ) {
	$map = array(
		'Business'                            => 'business',
		'Business services'                   => 'business',
		'Construction'                         => 'construction',
		'Criminal Law'                         => 'criminal-law',
		'Dispute Resolution'                   => 'dispute-resolution',
		'Employment'                            => 'employment',
		'Property'                              => 'property',
		'Property Development & Subdivisions'  => 'property-development',
		'Relationship & Family Property'       => 'relationship-family-property',
		'Trusts & Asset Planning'              => 'trusts-asset-planning',
		'Wills'                                 => 'wills-estates-life-planning',
		'Wills, estates & life planning'       => 'wills-estates-life-planning',
		'Estates'                               => 'wills-estates-life-planning',
		'Rural'                                 => 'rural',
		'Notary'                                => 'notary',
	);
	return isset( $map[ $name ] ) ? $map[ $name ] : '';
}

/**
 * Real pages are nested inconsistently in the source data (e.g. "Criminal
 * law" is a grandchild of Services via "Dispute resolution", not a direct
 * child) -- always resolve a real permalink by slug instead of guessing
 * the URL shape, so nesting surprises never produce a broken/redirecting link.
 */
function wrmk_v3_page_permalink( $slug, $fallback = '/' ) {
	static $cache = array();
	if ( isset( $cache[ $slug ] ) ) return $cache[ $slug ];
	// get_page_by_path() expects the full hierarchical path for nested pages;
	// since these slugs are unique site-wide, a direct name lookup is simpler
	// and correct regardless of how deep the real page turns out to be nested.
	$found = get_posts( array( 'name' => $slug, 'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 1 ) );
	$url   = $found ? get_permalink( $found[0] ) : home_url( $fallback );
	$cache[ $slug ] = $url;
	return $url;
}

/**
 * The 4 real "X office" pages aren't consistently nested under Contact us in
 * the source data (one is misfiled under Services), so resolve their real
 * permalink by slug rather than assuming a URL shape.
 */
function wrmk_v3_office_permalink( $office_id ) {
	return wrmk_v3_page_permalink( $office_id . '-office', '/contact-us/' );
}

/** Real page slug (e.g. "property-lawyers") -> filter/data-services slug (e.g. "property"). */
function wrmk_v3_service_slug_map( $page_slug ) {
	$map = array(
		'property-lawyers'                  => 'property',
		'property-development-subdivisions' => 'property-development',
		'rural-lawyers'                      => 'rural',
		'notary-public'                      => 'notary',
	);
	return isset( $map[ $page_slug ] ) ? $map[ $page_slug ] : $page_slug;
}

/** Reverse of wrmk_v3_area_term_to_slug(): all staff-group term names that map to a given service slug. */
function wrmk_v3_service_slug_to_area_terms( $slug ) {
	$names = array();
	// Re-derive from the same source list rather than keeping two lists in sync.
	$sample = array( 'Business', 'Business services', 'Construction', 'Criminal Law', 'Dispute Resolution', 'Employment', 'Property', 'Property Development & Subdivisions', 'Relationship & Family Property', 'Trusts & Asset Planning', 'Wills', 'Wills, estates & life planning', 'Estates', 'Rural', 'Notary' );
	foreach ( $sample as $name ) {
		if ( wrmk_v3_area_term_to_slug( $name ) === $slug ) $names[] = $name;
	}
	return $names;
}

/** Staff members whose staff-group practice-area terms match a service slug (e.g. "property"). */
function wrmk_v3_get_staff_for_service( $slug, $limit = 20 ) {
	$terms = wrmk_v3_service_slug_to_area_terms( $slug );
	if ( empty( $terms ) ) return array();
	return get_posts( array(
		'post_type'      => 'staff',
		'posts_per_page' => $limit,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'tax_query'      => array( array( 'taxonomy' => 'staff-group', 'field' => 'name', 'terms' => $terms ) ),
	) );
}

/**
 * The ACF "office" field on staff is a plain checkbox field (serialized array
 * of office names), separate from the staff-group taxonomy above.
 */
function wrmk_v3_get_staff_offices_field( $post_id ) {
	$offices = get_post_meta( $post_id, 'office', true );
	return is_array( $offices ) ? $offices : array();
}
