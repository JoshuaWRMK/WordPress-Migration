<?php
/**
 * "Our people" staff directory. Renders every real staff post; filtering by
 * role/office/practice-area happens client-side in wrmk-v3.js, same as the
 * static build.
 */
get_header();

$staff = get_posts( array(
	'post_type'      => 'staff',
	'posts_per_page' => -1,
	'orderby'        => 'title',
	'order'          => 'ASC',
) );
$count = count( $staff );
?>
<section class="wrmk-v3-innerhero">
	<div class="wrmk-v3-innerhero__inner">
		<div class="wrmk-v3-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / Our people</div>
		<h1 class="wrmk-v3-innerhero__title">Our people</h1>
		<p class="wrmk-v3-innerhero__lead"><?php echo (int) $count; ?> real people across four Northland offices &mdash; directors, lawyers, legal executives and support staff.</p>
	</div>
</section>
<section class="wrmk-v3-section">
	<div class="wrmk-v3-people-filters">
		<label class="wrmk-v3-people-filters__field">
			<span>Job title</span>
			<select id="people-filter-role" class="wrmk-v3-select">
				<option value="">All job titles</option>
				<option value="director">Director</option>
				<option value="managing-director">Managing Director</option>
				<option value="senior-lawyer">Senior Lawyer</option>
				<option value="lawyer">Lawyer</option>
				<option value="associate">Associate</option>
				<option value="legal-executive">Legal Executive</option>
				<option value="consultant">Consultant</option>
				<option value="law-clerk">Law Clerk</option>
				<option value="general-manager">General Manager</option>
				<option value="assistant-manager">Assistant Manager</option>
			</select>
		</label>
		<label class="wrmk-v3-people-filters__field">
			<span>Office</span>
			<select id="people-filter-office" class="wrmk-v3-select">
				<option value="">All offices</option>
				<option value="whangarei">Whang&#257;rei</option>
				<option value="dargaville">Dargaville</option>
				<option value="kerikeri">Kerikeri</option>
				<option value="warkworth">Warkworth</option>
			</select>
		</label>
	</div>
	<div class="wrmk-v3-staff-filters">
		<a href="#" data-filter="all" class="is-active">All</a>
		<a href="#" data-filter="business">Business &amp; commercial law</a>
		<a href="#" data-filter="criminal-law">Criminal law</a>
		<a href="#" data-filter="dispute-resolution">Dispute resolution</a>
		<a href="#" data-filter="employment">Employment</a>
		<a href="#" data-filter="property">Property law</a>
		<a href="#" data-filter="property-development">Property development &amp; subdivisions</a>
		<a href="#" data-filter="relationship-family-property">Relationship &amp; family property</a>
		<a href="#" data-filter="trusts-asset-planning">Trusts &amp; asset planning</a>
		<a href="#" data-filter="wills-estates-life-planning">Wills, estates &amp; life planning</a>
		<a href="#" data-filter="construction">Construction law</a>
		<a href="#" data-filter="rural">Rural</a>
		<a href="#" data-filter="notary">Notary Public</a>
	</div>
	<div class="wrmk-v3-staff-grid">
		<?php foreach ( $staff as $person ) :
			$tax = wrmk_v3_get_staff_taxonomy( $person->ID );
			$offices = wrmk_v3_get_staff_offices_field( $person->ID );
			if ( empty( $offices ) ) $offices = $tax['offices'];
			$service_slugs = array();
			foreach ( $tax['areas'] as $area ) {
				$slug = wrmk_v3_area_term_to_slug( $area );
				if ( $slug ) $service_slugs[] = $slug;
			}
		?>
		<a href="<?php echo esc_url( get_permalink( $person ) ); ?>" class="wrmk-v3-staff-card" data-services="<?php echo esc_attr( implode( ' ', array_unique( $service_slugs ) ) ); ?>">
			<div class="wrmk-v3-staff-card__photo">
				<?php if ( has_post_thumbnail( $person ) ) : echo get_the_post_thumbnail( $person, 'medium' ); else : ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/wrmk-COL-RGB.png' ); ?>" alt="<?php echo esc_attr( $person->post_title ); ?>" loading="lazy">
				<?php endif; ?>
			</div>
			<div class="wrmk-v3-staff-card__body">
				<h4 class="wrmk-v3-staff-card__name"><?php echo esc_html( $person->post_title ); ?></h4>
				<div class="wrmk-v3-staff-card__role"><?php echo esc_html( $tax['role'] ); ?></div>
				<div class="wrmk-v3-staff-card__office"><?php echo esc_html( implode( ', ', $offices ) ); ?></div>
				<div class="wrmk-v3-staff-card__link">View profile &rarr;</div>
			</div>
		</a>
		<?php endforeach; ?>
	</div>
</section>
<?php get_footer(); ?>
