<?php
/** "Testimonials" (page slug: testimonials) -- all real client reviews. */
get_header();

$matter_map = array(
	'Business'                      => 'business',
	'Employment'                    => 'employment',
	'Trusts'                        => 'trusts',
	'Litigation'                    => 'litigation',
	'Property'                      => 'property',
	'Rural'                         => 'rural',
	'Wills, estates & life planning' => 'wills-and-estates',
);
$all = get_posts( array( 'post_type' => 'testimonial', 'posts_per_page' => -1, 'orderby' => 'rand' ) );
$count = count( $all );
?>
<section class="wrmk-v3-innerhero">
	<div class="wrmk-v3-innerhero__inner">
		<div class="wrmk-v3-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / Testimonials</div>
		<h1 class="wrmk-v3-innerhero__title">What our clients say</h1>
		<p class="wrmk-v3-innerhero__lead">What our clients say about working with us.</p>
	</div>
</section>
<section class="wrmk-v3-section">
	<div class="wrmk-v3-newsfilter">
		<a href="#" data-tfilter="all" class="is-active">All (<?php echo (int) $count; ?>)</a>
		<?php foreach ( array_unique( $matter_map ) as $slug ) :
			$label = array_search( $slug, $matter_map, true );
		?>
		<a href="#" data-tfilter="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $label ); ?></a>
		<?php endforeach; ?>
	</div>
	<div class="wrmk-v3-quotewall">
		<?php foreach ( $all as $t ) :
			$terms = get_the_terms( $t->ID, 'testimonial-group' );
			$matter = 'General';
			$group_slug = '';
			if ( $terms && ! is_wp_error( $terms ) ) {
				foreach ( $terms as $term ) {
					$name = html_entity_decode( $term->name );
					if ( isset( $matter_map[ $name ] ) ) {
						$matter = $name;
						$group_slug = $matter_map[ $name ];
						break;
					}
				}
			}
			$quote = wp_strip_all_tags( apply_filters( 'the_content', $t->post_content ) );
		?>
		<figure class="wrmk-v3-quote-card" data-groups="<?php echo esc_attr( $group_slug ); ?>">
			<blockquote><?php echo esc_html( $quote ); ?></blockquote>
			<figcaption><div class="wrmk-v3-quote-card__name"><?php echo esc_html( $t->post_title ); ?></div><div class="wrmk-v3-quote-card__matter"><?php echo esc_html( $matter ); ?></div></figcaption>
		</figure>
		<?php endforeach; ?>
	</div>
</section>
<?php get_footer(); ?>
