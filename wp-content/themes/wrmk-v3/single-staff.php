<?php
/**
 * Individual staff profile. Pulls the real ACF fields + featured image
 * already stored on this staff post.
 */
get_header();
while ( have_posts() ) : the_post();
	$id = get_the_ID();
	$tax = wrmk_v3_get_staff_taxonomy( $id );
	$offices = wrmk_v3_get_staff_offices_field( $id );
	if ( empty( $offices ) ) $offices = $tax['offices'];

	$phone   = get_post_meta( $id, 'staff-phone', true );
	$mobile  = get_post_meta( $id, 'staff-mobile', true );
	$email   = get_post_meta( $id, 'staff_email_address', true );
	$intro   = get_post_meta( $id, 'introduction_line', true );
	$blurb   = get_post_meta( $id, 'main_staff_blurb', true );
	$about   = get_post_meta( $id, 'about_blurb', true );
	$linkedin = get_post_meta( $id, 'linked_in_profile', true );
	$nzsl    = get_post_meta( $id, 'nzsl_url', true );
	$quals   = get_post_meta( $id, 'qualifications', true );
	$admitted = get_post_meta( $id, 'admitted-date', true );
	$sec_name  = get_post_meta( $id, 'secretary_name', true );
	$sec_phone = get_post_meta( $id, 'secretary_phone_number', true );
	$sec_email = get_post_meta( $id, 'secretary_email', true );

	// From-services-page breadcrumb support: ?from=services-SLUG
	$from = isset( $_GET['from'] ) ? sanitize_title( wp_unslash( $_GET['from'] ) ) : '';
	$breadcrumb_html = '<a href="' . esc_url( home_url( '/' ) ) . '">Home</a> / ';
	if ( strpos( $from, 'services-' ) === 0 ) {
		$slug = substr( $from, strlen( 'services-' ) );
		$breadcrumb_html .= '<a href="' . esc_url( home_url( '/services/' ) ) . '">Services</a> / <a href="' . esc_url( home_url( '/services/' . $slug . '/' ) ) . '">' . esc_html( get_the_title( get_page_by_path( $slug ) ) ) . '</a>';
	} else {
		$breadcrumb_html .= '<a href="' . esc_url( home_url( '/our-people/' ) ) . '">Our people</a>';
	}
	$breadcrumb_html .= ' / ' . esc_html( get_the_title() );
	?>
	<section class="wrmk-v3-innerhero">
		<div class="wrmk-v3-innerhero__inner">
			<div class="wrmk-v3-breadcrumb"><?php echo $breadcrumb_html; ?></div>
			<div class="wrmk-v3-staffprofile">
				<div>
					<div class="wrmk-v3-staffprofile__photo">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'medium' ); else : ?>
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/wrmk-COL-RGB.png' ); ?>" alt="<?php the_title_attribute(); ?>" />
						<?php endif; ?>
					</div>
					<div class="wrmk-v3-staffprofile__contact">
						<?php if ( $phone ) : ?><a href="tel:+<?php echo esc_attr( $phone ); ?>"><?php echo esc_html( wrmk_v3_format_nz_phone( $phone ) ); ?></a><?php endif; ?>
						<?php if ( $email ) : ?><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a><?php endif; ?>
						<?php if ( $linkedin ) : ?><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener">LinkedIn profile &rarr;</a><?php endif; ?>
						<?php if ( $nzsl ) : ?><a href="<?php echo esc_url( $nzsl ); ?>" target="_blank" rel="noopener">NZ Law Society register &rarr;</a><?php endif; ?>
					</div>
				</div>
				<div>
					<h1 class="wrmk-v3-innerhero__title" style="margin-bottom:6px;"><?php the_title(); ?></h1>
					<div style="font-size:17px;color:var(--orange-deep);font-weight:600;margin-bottom:14px;">
						<?php
						echo esc_html( $tax['role'] );
						if ( ! empty( $offices ) ) {
							echo ' &middot; ';
							$links = array();
							foreach ( $offices as $o ) {
								$links[] = '<a href="' . esc_url( wrmk_v3_office_permalink( sanitize_title( $o ) ) ) . '">' . esc_html( $o ) . '</a>';
							}
							echo implode( ', ', $links );
						}
						?>
					</div>
					<?php if ( $intro ) : ?><p class="wrmk-v3-innerhero__lead"><?php echo esc_html( $intro ); ?></p><?php endif; ?>
					<?php if ( ! empty( $tax['areas'] ) ) : ?>
					<div class="wrmk-v3-staffprofile__tags">
						<?php foreach ( $tax['areas'] as $area ) : ?><span><?php echo esc_html( $area ); ?></span><?php endforeach; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<section class="wrmk-v3-section">
		<div class="wrmk-v3-layout">
			<div class="wrmk-v3-prose">
				<?php if ( $blurb ) : ?><p><?php echo wp_kses_post( wpautop( $blurb ) ); ?></p><?php endif; ?>
				<?php if ( $about ) : ?><h3>Outside the office</h3><p><?php echo wp_kses_post( wpautop( $about ) ); ?></p><?php endif; ?>
				<?php the_content(); ?>
			</div>
			<aside class="wrmk-v3-side">
				<?php if ( $quals || $admitted ) : ?>
				<div class="wrmk-v3-side-box">
					<h4>Qualifications</h4>
					<p><?php echo esc_html( $quals ); ?><?php if ( $admitted ) : ?><br>Admitted <?php echo esc_html( $admitted ); ?><?php endif; ?></p>
				</div>
				<?php endif; ?>
				<?php if ( $sec_name ) : ?>
				<div class="wrmk-v3-side-box">
					<h4>Secretary</h4>
					<p><?php echo esc_html( $sec_name ); ?><?php if ( $sec_phone ) : ?><br><a href="tel:+<?php echo esc_attr( $sec_phone ); ?>"><?php echo esc_html( wrmk_v3_format_nz_phone( $sec_phone ) ); ?></a><?php endif; ?><?php if ( $sec_email ) : ?><br><a href="mailto:<?php echo esc_attr( $sec_email ); ?>"><?php echo esc_html( $sec_email ); ?></a><?php endif; ?></p>
				</div>
				<?php endif; ?>
				<div class="wrmk-v3-side-box">
					<h4>Our people</h4>
					<p>Meet the rest of the WRMK team.</p>
					<a href="<?php echo esc_url( home_url( '/our-people/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--dark">All our people &rarr;</a>
				</div>
			</aside>
		</div>
	</section>
<?php endwhile; get_footer(); ?>
