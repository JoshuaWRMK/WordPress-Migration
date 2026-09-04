<?php
/**
 * "Services" index (page slug: services). Flat list of the 12 real
 * service child-pages, in the fixed editorial order the firm uses.
 */
get_header();

$order = array(
	array( 'slug' => 'business', 'title' => 'Business &amp; commercial law', 'desc' => 'Structuring, contracts, sales and purchases.' ),
	array( 'slug' => 'criminal-law', 'title' => 'Criminal law', 'desc' => 'First appearance through to trial and sentencing.' ),
	array( 'slug' => 'dispute-resolution', 'title' => 'Dispute resolution', 'desc' => 'Negotiation, mediation and litigation.' ),
	array( 'slug' => 'employment', 'title' => 'Employment', 'desc' => 'For employers and employees.' ),
	array( 'slug' => 'property-lawyers', 'title' => 'Property law', 'desc' => 'Buying, selling, refinancing, settlement.' ),
	array( 'slug' => 'property-development-subdivisions', 'title' => 'Property development &amp; subdivisions', 'desc' => 'Consents, subdivision and unit titles.' ),
	array( 'slug' => 'relationship-family-property', 'title' => 'Relationship &amp; family property', 'desc' => 'Agreements, separation and care.' ),
	array( 'slug' => 'trusts-asset-planning', 'title' => 'Trusts &amp; asset planning', 'desc' => 'Setting up, reviewing and winding up trusts.' ),
	array( 'slug' => 'wills-estates-life-planning', 'title' => 'Wills, estates &amp; life planning', 'desc' => 'Wills, EPAs and estate administration.' ),
	array( 'slug' => 'construction', 'title' => 'Construction law', 'desc' => 'Contracts, disputes and retentions.' ),
	array( 'slug' => 'rural-lawyers', 'title' => 'Rural', 'desc' => 'Farm transactions and succession planning.' ),
	array( 'slug' => 'notary-public', 'title' => 'Notary Public', 'desc' => 'Documents for use overseas.' ),
);
?>
<section class="wrmk-v3-innerhero">
	<div class="wrmk-v3-innerhero__inner">
		<div class="wrmk-v3-breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> / Services</div>
		<h1 class="wrmk-v3-innerhero__title">Areas of practice</h1>
		<p class="wrmk-v3-innerhero__lead">Twelve areas of practice, from personal matters to business and disputes.</p>
	</div>
</section>
<section class="wrmk-v3-section">
	<div class="wrmk-v3-grid wrmk-v3-all">
		<?php foreach ( $order as $i => $s ) : ?>
		<a href="<?php echo esc_url( wrmk_v3_page_permalink( $s['slug'] ) ); ?>" class="wrmk-v3-all__item"><span class="wrmk-v3-all__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><span><span class="wrmk-v3-all__title"><?php echo wp_kses_post( $s['title'] ); ?></span><span class="wrmk-v3-all__desc"><?php echo esc_html( $s['desc'] ); ?></span></span></a>
		<?php endforeach; ?>
	</div>
</section>
<?php get_footer(); ?>
