<?php
/**
 * Fallback template (required by WordPress). Real templates are
 * front-page.php, single.php, page.php, single-staff.php, etc.
 */
get_header();
?>
<section class="wrmk-v3-section">
	<div class="wrmk-v3-prose">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
	<?php endwhile; else : ?>
		<p>Nothing found.</p>
	<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
