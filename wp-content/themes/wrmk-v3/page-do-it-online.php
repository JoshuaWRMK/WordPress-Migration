<?php
/** "Do it online" index (page slug: do-it-online). Grouped tool cards. */
get_header();
?>
<section class="wrmk-v3-innerhero">
	<div class="wrmk-v3-innerhero__inner">
		<div class="wrmk-v3-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / Do it online</div>
		<h1 class="wrmk-v3-innerhero__title">Do it online</h1>
		<p class="wrmk-v3-innerhero__lead">Start without picking up the phone &mdash; real self-service tools from the WRMK Lawyers site.</p>
	</div>
</section>
<section class="wrmk-v3-section">
	<?php
	$groups = array(
		'General' => array(
			array( '/pay-online/', 'Pay online', 'Pay your WRMK Lawyers account online.' ),
			array( '/do-it-online/make-an-appointment/', 'Make an appointment', 'Book an appointment at any WRMK Lawyers office.' ),
			array( '/wrmk-client-information-form/', 'New client information', 'Complete your ID and details before you come in.' ),
			array( '/do-it-online/subscribe/', 'Subscribe to updates', 'Subscribe to WRMK Lawyers legal updates.' ),
		),
		'Property' => array(
			array( '/do-it-online/start-your-rpa-online/', 'Relationship property agreement', 'Start your relationship property agreement online, at your own pace.' ),
			array( '/do-it-online/property-purchase-fees/', 'Property purchase fees', "Estimate WRMK Lawyers' fees for a property purchase." ),
			array( '/do-it-online/property-sale-fees/', 'Property sale fees', "Estimate WRMK Lawyers' fees for a property sale." ),
		),
		'Trusts &amp; wills' => array(
			array( '/do-it-online/trust-circumstances-review/', 'Trust circumstances review', 'Answer a few questions and WRMK will flag the risks in your trust.' ),
			array( '/do-it-online/will-instructions/', 'Start your will online', 'Start your will instructions online.' ),
		),
		'Employment' => array(
			array( '/do-it-online/register-now/', 'Employment Law Drop-In Clinic', "Register for WRMK's free Employment Law Drop-In Clinic." ),
			array( '/services/employment/health-check/', 'Employment Health Check', 'A quick health check for employers.' ),
		),
	);
	foreach ( $groups as $label => $tools ) :
	?>
	<div class="wrmk-v3-toolgroup" data-reveal>
		<h3 class="wrmk-v3-toolgroup__title"><?php echo wp_kses_post( $label ); ?></h3>
		<div class="wrmk-v3-grid wrmk-v3-toolgrid">
			<?php foreach ( $tools as $i => $t ) : ?>
			<a href="<?php echo esc_url( home_url( $t[0] ) ); ?>" class="wrmk-v3-toolcard" data-reveal><span class="wrmk-v3-toolcard__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3 class="wrmk-v3-toolcard__title"><?php echo esc_html( $t[1] ); ?></h3><p class="wrmk-v3-toolcard__desc"><?php echo esc_html( $t[2] ); ?></p><span class="wrmk-v3-toolcard__cta">Start now <span class="wrmk-v3-toolcard__cta-arrow">&rarr;</span></span></a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endforeach; ?>
</section>
<?php get_footer(); ?>
