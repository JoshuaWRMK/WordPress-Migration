<?php
/** "Contact us" (page slug: contact-us) -- merged with the old "Offices" page. */
get_header();
$offices = array(
	array( 'id' => 'whangarei', 'name' => 'Whang&#257;rei', 'address' => 'Legal House, 9 Hunt Street, Whangarei, 0110', 'maps' => '9+Hunt+Street,+Whangarei', 'tel' => '+6494702400', 'phone' => '09 470 2400', 'hours' => '8.30am&ndash;5pm Monday&ndash;Friday, or by appointment', 'parking' => 'Free client parking is available under our building.', 'people' => 47 ),
	array( 'id' => 'dargaville', 'name' => 'Dargaville', 'address' => '118 Victoria Street, Dargaville, 0310', 'maps' => '118+Victoria+Street,+Dargaville', 'tel' => '+6494398001', 'phone' => '09 439 8001', 'hours' => '9am&ndash;5pm Monday&ndash;Friday, or by appointment', 'parking' => 'Free parking is available on Victoria Street and nearby streets.', 'people' => 7 ),
	array( 'id' => 'kerikeri', 'name' => 'Kerikeri', 'address' => 'Street level, John Butler Centre, 60 Kerikeri Road, Kerikeri 0230', 'maps' => '60+Kerikeri+Road,+Kerikeri', 'tel' => '+6494016354', 'phone' => '09 401 6354', 'hours' => '9am&ndash;4.30pm Monday&ndash;Friday, or by appointment', 'parking' => 'Free parking is available on Kerikeri Road and nearby streets.', 'people' => 7 ),
	array( 'id' => 'warkworth', 'name' => 'Warkworth', 'address' => 'The Oaks on Neville (at the end of the lane), 9 Queen Street, Warkworth', 'maps' => '9+Queen+Street,+Warkworth', 'tel' => '+6494702459', 'phone' => '09 470 2459', 'hours' => '9am&ndash;5pm Monday&ndash;Friday, or by appointment', 'parking' => 'Free parking is available at the end of the lane in The Oaks for our clients.', 'people' => 3 ),
);
?>
<section class="wrmk-v3-innerhero">
	<div class="wrmk-v3-innerhero__inner">
		<div class="wrmk-v3-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / Contact us</div>
		<h1 class="wrmk-v3-innerhero__title">Contact us</h1>
		<p class="wrmk-v3-innerhero__lead">Call or visit &mdash; real addresses, phone numbers and teams for each of WRMK's four Northland offices.</p>
		<div class="wrmk-v3-contactbox" data-reveal>
			<span class="wrmk-v3-contactbox__title">For all offices</span>
			<div class="wrmk-v3-contactbox__row">
				<div class="wrmk-v3-contactbox__item"><span class="wrmk-v3-contactbox__label">Email</span><a href="mailto:info@wrmk.co.nz">info@wrmk.co.nz</a></div>
				<div class="wrmk-v3-contactbox__item"><span class="wrmk-v3-contactbox__label">Postal address</span><span>Private Bag 9012, Te Mai, Whangarei 0143</span></div>
			</div>
		</div>
	</div>
</section>
<section class="wrmk-v3-section wrmk-v3-section--tight">
	<div class="wrmk-v3-grid" style="grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;">
		<?php foreach ( $offices as $o ) : ?>
		<div class="wrmk-v3-office wrmk-v3-office--card" data-office="<?php echo esc_attr( $o['id'] ); ?>" data-office-href="<?php echo esc_url( wrmk_v3_office_permalink( $o['id'] ) ); ?>" tabindex="0">
			<div class="wrmk-v3-office__geo-tag" data-geo-tag hidden>Your nearest office</div>
			<div class="wrmk-v3-office__row"><h3 class="wrmk-v3-office__name"><a href="<?php echo esc_url( wrmk_v3_office_permalink( $o['id'] ) ); ?>"><?php echo $o['name']; ?></a></h3></div>
			<div class="wrmk-v3-office__address"><a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo esc_attr( $o['maps'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $o['address'] ); ?></a></div>
			<div class="wrmk-v3-office__meta">
				<div><strong>Office hours:</strong> <?php echo $o['hours']; ?></div>
				<div><strong>Car parking:</strong> <?php echo esc_html( $o['parking'] ); ?></div>
			</div>
			<div class="wrmk-v3-office__contact">
				<a href="tel:<?php echo esc_attr( $o['tel'] ); ?>" class="wrmk-v3-office__phone"><?php echo esc_html( $o['phone'] ); ?></a>
				<span class="wrmk-v3-office__hint"><?php echo (int) $o['people']; ?> people &rarr;</span>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>
<?php get_footer(); ?>
