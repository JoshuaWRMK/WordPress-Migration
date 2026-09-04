<?php
/**
 * Generic page template. Pages that are a direct child of "Services" get
 * the service-detail layout (sidebar + related team); everything else gets
 * a plain title + prose layout.
 */
get_header();
while ( have_posts() ) : the_post();
	$services_page = get_page_by_path( 'services' );
	$is_service = $services_page && in_array( (int) $services_page->ID, get_post_ancestors( $post ), true );
	$service_slug = $is_service ? wrmk_v3_service_slug_map( $post->post_name ) : '';
	$team = $is_service ? wrmk_v3_get_staff_for_service( $service_slug ) : array();
	?>
	<section class="wrmk-v3-innerhero">
		<div class="wrmk-v3-innerhero__inner">
			<div class="wrmk-v3-breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
				<?php if ( $is_service ) : ?> / <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a><?php endif; ?>
				/ <?php the_title(); ?>
			</div>
			<h1 class="wrmk-v3-innerhero__title"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p class="wrmk-v3-innerhero__lead"><?php the_excerpt(); ?></p><?php endif; ?>
		</div>
	</section>
	<section class="wrmk-v3-section">
		<?php if ( $is_service ) : ?>
		<div class="wrmk-v3-layout">
			<div class="wrmk-v3-prose">
				<?php the_content(); ?>
				<?php if ( ! empty( $team ) ) : ?>
				<h3 id="our-team">OUR TEAM</h3>
				<div class="wrmk-v3-staff-grid" style="margin:28px 0 40px;">
					<?php foreach ( $team as $person ) :
						$tax = wrmk_v3_get_staff_taxonomy( $person->ID );
						$offices = wrmk_v3_get_staff_offices_field( $person->ID );
						if ( empty( $offices ) ) $offices = $tax['offices'];
					?>
					<a href="<?php echo esc_url( add_query_arg( 'from', 'services-' . $service_slug, get_permalink( $person ) ) ); ?>" class="wrmk-v3-staff-card">
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
				<?php endif; ?>
			</div>
			<aside class="wrmk-v3-side">
				<div class="wrmk-v3-side-box">
					<h4>All areas of practice</h4>
					<p>Browse our full range of legal services across Northland.</p>
					<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--dark">Back to services &rarr;</a>
				</div>
				<div class="wrmk-v3-side-box">
					<h4>Talk to us</h4>
					<p>Book a first conversation with the right lawyer for your situation.</p>
					<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--orange">Contact us &rarr;</a>
				</div>
			</aside>
		</div>
		<?php else : ?>
		<div class="wrmk-v3-prose">
			<?php the_content(); ?>
		</div>
		<?php endif; ?>
	</section>
<?php endwhile; get_footer(); ?>
