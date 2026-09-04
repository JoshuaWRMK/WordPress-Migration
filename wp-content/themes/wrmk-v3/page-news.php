<?php
/**
 * News archive (page slug: blog). Renders every real post; filtering,
 * pagination and the year/month selects are all handled by the existing
 * client-side wrmk-v3.js news-filter script, same as the static build.
 */
get_header();

$category_map = array(
	'Employment'                          => 'employment',
	'Employment law'                      => 'employment',
	'Property'                            => 'property',
	'Commercial property'                 => 'property',
	'Business'                            => 'business',
	'Relationship & family property'      => 'relationship-family-property',
	'Wills, estates & life planning'      => 'wills-estates-life-planning',
	'Trusts & asset planning'             => 'trusts-asset-planning',
	'Dispute resolution'                  => 'dispute-resolution',
	'Rural'                               => 'rural',
	'Property development & subdivisions' => 'property-development',
	'Elder law'                           => 'elder-law',
	'Firm news'                            => 'firm-news',
	'COVID-19'                             => 'covid-19',
);
$chip_labels = array();
foreach ( $category_map as $slug ) { $chip_labels[ $slug ] = true; }
$chip_slugs = array_keys( $chip_labels );

$all_posts = get_posts( array( 'post_type' => 'post', 'posts_per_page' => -1 ) );

function wrmk_v3_post_data_tag( $post_id, $category_map ) {
	$tags = get_the_tags( $post_id );
	if ( ! $tags || is_wp_error( $tags ) ) return 'firm-news';
	foreach ( $tags as $t ) {
		$name = html_entity_decode( $t->name );
		if ( isset( $category_map[ $name ] ) ) return $category_map[ $name ];
	}
	return 'firm-news';
}
?>
<section class="wrmk-v3-innerhero">
	<div class="wrmk-v3-innerhero__inner">
		<div class="wrmk-v3-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / News</div>
		<h1 class="wrmk-v3-innerhero__title">News</h1>
		<p class="wrmk-v3-innerhero__lead">Plain-English updates on the law that affects you &mdash; <?php echo count( $all_posts ); ?> real articles.</p>
	</div>
</section>
<section class="wrmk-v3-section">
	<div class="wrmk-v3-newscategories wrmk-v3-staff-filters">
		<a href="#" data-nfilter="all" class="is-active">All</a>
		<?php foreach ( $chip_slugs as $slug ) :
			$label = array_search( $slug, $category_map, true );
		?>
		<a href="#" data-nfilter="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( ucwords( str_replace( '-', ' ', $slug ) ) ); ?></a>
		<?php endforeach; ?>
	</div>
	<div class="wrmk-v3-people-filters">
		<label class="wrmk-v3-people-filters__field">
			<span>Year</span>
			<select id="news-filter-year" class="wrmk-v3-select">
				<option value="">All years</option>
				<?php for ( $y = (int) date( 'Y' ); $y >= 2010; $y-- ) : ?>
				<option value="<?php echo esc_attr( $y ); ?>"><?php echo esc_html( $y ); ?></option>
				<?php endfor; ?>
			</select>
		</label>
		<label class="wrmk-v3-people-filters__field">
			<span>Month</span>
			<select id="news-filter-month" class="wrmk-v3-select">
				<option value="">All months</option>
				<?php foreach ( array( '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December' ) as $mn => $ml ) : ?>
				<option value="<?php echo esc_attr( $mn ); ?>"><?php echo esc_html( $ml ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label class="wrmk-v3-people-filters__field">
			<span>Show</span>
			<select id="news-page-size" class="wrmk-v3-select">
				<option value="10">10</option>
				<option value="30">30</option>
				<option value="100">100</option>
			</select>
		</label>
	</div>
	<div class="wrmk-v3-news-list">
		<?php foreach ( $all_posts as $p ) :
			$tags = get_the_tags( $p->ID );
			$tag_name = $tags && ! is_wp_error( $tags ) ? html_entity_decode( $tags[0]->name ) : '';
		?>
		<a href="<?php echo esc_url( get_permalink( $p ) ); ?>" class="wrmk-v3-news-item" data-tag="<?php echo esc_attr( wrmk_v3_post_data_tag( $p->ID, $category_map ) ); ?>" data-year="<?php echo esc_attr( get_the_date( 'Y', $p ) ); ?>" data-month="<?php echo esc_attr( get_the_date( 'm', $p ) ); ?>">
			<span class="wrmk-v3-news-item__date"><?php echo esc_html( get_the_date( 'j F Y', $p ) ); ?></span>
			<span><span class="wrmk-v3-news-item__title"><?php echo esc_html( get_the_title( $p ) ); ?></span></span>
			<?php if ( $tag_name ) : ?><span class="wrmk-v3-news-item__tag"><?php echo esc_html( $tag_name ); ?></span><?php endif; ?>
		</a>
		<?php endforeach; ?>
	</div>
	<div class="wrmk-v3-pagination" id="news-pagination"></div>
</section>
<?php get_footer(); ?>
