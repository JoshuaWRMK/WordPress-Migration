<?php
/**
 * News article. The "Related services" / "Related people" blocks are
 * already baked into the real post_content, so the_content() alone
 * reproduces the full original article.
 */
get_header();
while ( have_posts() ) : the_post();
	$tags = get_the_tags();
	$tag_name = $tags && ! is_wp_error( $tags ) ? $tags[0]->name : '';
	?>
	<section class="wrmk-v3-innerhero">
		<div class="wrmk-v3-innerhero__inner">
			<div class="wrmk-v3-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a> / <?php the_title(); ?></div>
			<h1 class="wrmk-v3-innerhero__title"><?php the_title(); ?></h1>
			<div class="wrmk-v3-innerhero__meta"><span><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></span><?php if ( $tag_name ) : ?><span><?php echo esc_html( $tag_name ); ?></span><?php endif; ?></div>
		</div>
	</section>
	<section class="wrmk-v3-section">
		<div class="wrmk-v3-layout">
			<div class="wrmk-v3-prose">
				<?php the_content(); ?>
			</div>
			<aside class="wrmk-v3-side">
				<div class="wrmk-v3-side-box">
					<h4>News</h4>
					<p>More plain-English updates on the law that affects you.</p>
					<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--dark">All articles &rarr;</a>
				</div>
				<div class="wrmk-v3-side-box">
					<h4>Talk to us</h4>
					<p>Book a first conversation with the right lawyer for your situation.</p>
					<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--orange">Contact us &rarr;</a>
				</div>
			</aside>
		</div>
	</section>
<?php endwhile; get_footer(); ?>
