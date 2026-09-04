<?php
/** Sitemap (page slug: sitemap). Real counts + links, resolved by slug so
 * nesting quirks in the source data don't produce broken links. */
get_header();

function wrmk_v3_sitemap_link( $slug, $label ) {
	$found = get_posts( array( 'name' => $slug, 'post_type' => 'page', 'post_status' => 'publish', 'posts_per_page' => 1 ) );
	if ( ! $found ) return '';
	return '<li><a href="' . esc_url( get_permalink( $found[0] ) ) . '">' . esc_html( $label ) . '</a></li>';
}

$services = array(
	'business' => 'Business &amp; commercial law', 'criminal-law' => 'Criminal law', 'dispute-resolution' => 'Dispute resolution',
	'employment' => 'Employment', 'property-lawyers' => 'Property law', 'property-development-subdivisions' => 'Property development &amp; subdivisions',
	'relationship-family-property' => 'Relationship &amp; family property', 'trusts-asset-planning' => 'Trusts &amp; asset planning',
	'wills-estates-life-planning' => 'Wills, estates &amp; life planning', 'construction' => 'Construction law', 'rural-lawyers' => 'Rural', 'notary-public' => 'Notary Public',
);
$resources = array(
	'employers' => 'Employers', 'employees' => 'Employees', 'rural-employers' => 'Rural Employers',
	'guide-to-employment-agreements' => 'Guide to Employment Agreements', 'how-to-handle-a-personal-grievance' => 'Guide to Handling a Personal Grievance',
	'guide-to-handling-employee-misconduct' => 'Guide to Handling Employee Misconduct', 'guide-to-hiring-workers-under-the-aewv-scheme' => 'Guide to Hiring Workers (AEWV)',
	'guide-to-restructuring-redundancies' => 'Guide to Restructuring &amp; Redundancies', 'guide-to-terminating-employment' => 'Guide to Terminating Employment',
	'farmers-guide-to-drug-and-alcohol-testing' => "Farmers' Guide to Drug and Alcohol Testing", 'farmers-guide-to-service-tenancies' => "Farmers' Guide to Service Tenancies",
	'scholarships' => 'WRMK Law Scholarships', 'scholarship-alumni' => 'Scholarship Alumni',
);
$staff_count = wp_count_posts( 'staff' )->publish;
$news_count = wp_count_posts( 'post' )->publish;
$testimonial_count = wp_count_posts( 'testimonial' )->publish;
$page_count = wp_count_posts( 'page' )->publish;
$recent_news = get_posts( array( 'post_type' => 'post', 'posts_per_page' => 40 ) );
?>
<section class="wrmk-v3-innerhero">
	<div class="wrmk-v3-innerhero__inner">
		<div class="wrmk-v3-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / Sitemap</div>
		<h1 class="wrmk-v3-innerhero__title">All pages of this website</h1>
		<p class="wrmk-v3-innerhero__lead"><?php echo (int) $page_count; ?> pages, <?php echo (int) $staff_count; ?> staff profiles, <?php echo (int) $news_count; ?> news articles and <?php echo (int) $testimonial_count; ?> client reviews. The news list below shows the first 40 &mdash; the complete, filterable archive is under <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a>.</p>
	</div>
</section>
<section class="wrmk-v3-section">
	<div class="wrmk-v3-sitemap-grid">
		<div><h3>Services (12)</h3><ul>
			<?php foreach ( $services as $slug => $label ) : ?><li><a href="<?php echo esc_url( wrmk_v3_page_permalink( $slug ) ); ?>"><?php echo wp_kses_post( $label ); ?></a></li><?php endforeach; ?>
		</ul></div>
		<div><h3>Offices (4)</h3><ul>
			<?php foreach ( array( 'whangarei' => 'Whang&#257;rei', 'dargaville' => 'Dargaville', 'kerikeri' => 'Kerikeri', 'warkworth' => 'Warkworth' ) as $id => $label ) : ?>
			<li><a href="<?php echo esc_url( wrmk_v3_office_permalink( $id ) ); ?>"><?php echo $label; ?></a></li>
			<?php endforeach; ?>
		</ul></div>
		<div><h3>Guides &amp; resources</h3><ul>
			<?php foreach ( $resources as $slug => $label ) { echo wrmk_v3_sitemap_link( $slug, $label ); } ?>
		</ul></div>
		<div><h3>Do it online</h3><ul>
			<li><a href="<?php echo esc_url( home_url( '/pay-online/' ) ); ?>">Pay online</a></li>
			<li><a href="<?php echo esc_url( home_url( '/do-it-online/make-an-appointment/' ) ); ?>">Make an appointment</a></li>
			<li><a href="<?php echo esc_url( home_url( '/wrmk-client-information-form/' ) ); ?>">New client information</a></li>
			<li><a href="<?php echo esc_url( home_url( '/do-it-online/subscribe/' ) ); ?>">Subscribe to updates</a></li>
			<li><a href="<?php echo esc_url( home_url( '/do-it-online/start-your-rpa-online/' ) ); ?>">Relationship property agreement</a></li>
			<li><a href="<?php echo esc_url( home_url( '/do-it-online/property-purchase-fees/' ) ); ?>">Property purchase fees</a></li>
			<li><a href="<?php echo esc_url( home_url( '/do-it-online/property-sale-fees/' ) ); ?>">Property sale fees</a></li>
			<li><a href="<?php echo esc_url( home_url( '/do-it-online/trust-circumstances-review/' ) ); ?>">Trust circumstances review</a></li>
			<li><a href="<?php echo esc_url( home_url( '/do-it-online/will-instructions/' ) ); ?>">Start your will online</a></li>
			<li><a href="<?php echo esc_url( home_url( '/do-it-online/register-now/' ) ); ?>">Employment Law Drop-In Clinic</a></li>
			<li><a href="<?php echo esc_url( home_url( '/services/employment/health-check/' ) ); ?>">Employment Health Check</a></li>
		</ul></div>
		<div><h3>About</h3><ul>
			<li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">About us</a></li>
			<li><a href="<?php echo esc_url( home_url( '/about-us/careers/' ) ); ?>">Careers</a></li>
			<li><a href="<?php echo esc_url( home_url( '/about-us/community/' ) ); ?>">Community</a></li>
			<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact us</a></li>
			<li><a href="<?php echo esc_url( home_url( '/our-people/' ) ); ?>">Our people</a></li>
			<li><a href="<?php echo esc_url( home_url( '/testimonials/' ) ); ?>">Testimonials</a></li>
			<li><a href="<?php echo esc_url( home_url( '/ai-at-wrmk/' ) ); ?>">AI at WRMK</a></li>
			<li><a href="<?php echo esc_url( home_url( '/terms-of-engagement/' ) ); ?>">Terms of engagement</a></li>
			<li><a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms of service</a></li>
		</ul></div>
	</div>
	<div class="wrmk-v3-sitemap-grid" style="margin-top:16px;">
		<div><ul>
			<?php foreach ( $recent_news as $n ) : ?><li><a href="<?php echo esc_url( get_permalink( $n ) ); ?>"><?php echo esc_html( get_the_title( $n ) ); ?></a></li><?php endforeach; ?>
		</ul></div>
	</div>
</section>
<?php get_footer(); ?>
