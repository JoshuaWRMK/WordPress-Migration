<?php
/**
 * Shared header: topbar, logo, main nav. Markup matches the wrmk-v3 static
 * design 1:1 -- only the hrefs and the "current section" logic are dynamic.
 */

function wrmk_v3_nav_section() {
	if ( is_singular( 'staff' ) || is_post_type_archive( 'staff' ) || is_page( 'our-people' ) ) return 'our-people';
	if ( is_page( 'services' ) || ( is_page() && wrmk_v3_is_descendant_of( 'services' ) ) ) return 'services';
	if ( is_page( 'about-us' ) || is_page( 'careers' ) || is_page( 'community' ) || ( is_page() && wrmk_v3_is_descendant_of( 'about-us' ) ) ) return 'about-us';
	if ( is_page( 'do-it-online' ) || ( is_page() && wrmk_v3_is_descendant_of( 'do-it-online' ) ) ) return 'do-it-online';
	if ( is_page( 'ai-at-wrmk' ) ) return 'ai';
	if ( is_home() || is_singular( 'post' ) || is_category() || is_tag() ) return 'news';
	if ( is_page( 'contact-us' ) || ( is_page() && wrmk_v3_is_descendant_of( 'contact-us' ) ) ) return 'contact-us';
	return '';
}

function wrmk_v3_is_descendant_of( $ancestor_slug ) {
	$ancestor = get_page_by_path( $ancestor_slug );
	if ( ! $ancestor ) return false;
	return in_array( $ancestor->ID, get_post_ancestors( get_the_ID() ), true );
}

$wrmk_section = wrmk_v3_nav_section();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon-32x32.png' ); ?>" />
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_template_directory_uri() . '/assets/images/favicon-180x180.png' ); ?>" />
<style>html,body{margin:0;}</style>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'wrmk-v3-page' ); ?>>
<div class="wrmk-v3">

	<div class="wrmk-v3-progress-track" data-progress-track><div class="wrmk-v3-progress"></div></div>
	<button type="button" class="wrmk-v3-backtotop" data-backtotop aria-label="Back to top">&#8593;</button>

	<div class="wrmk-v3-topbar">
		<div class="wrmk-v3-topbar__inner">
			<div class="wrmk-v3-topbar__left">
				<span class="wrmk-v3-topbar__status">
					<span class="wrmk-v3-topbar__dot" data-status-dot></span>
					<span data-status-line>Checking office hours&hellip;</span>
				</span>
				<span class="wrmk-v3-topbar__sep">/</span>
				<span class="wrmk-v3-topbar__clock" data-clock-line>Northland time</span>
			</div>
			<div class="wrmk-v3-topbar__right">
				<div class="wrmk-v3-textsize">
					<span class="wrmk-v3-textsize__label">Text size</span>
					<span class="wrmk-v3-textsize__btns">
						<button type="button" class="wrmk-v3-textsize__btn is-active" data-zoom-btn="1">A</button>
						<button type="button" class="wrmk-v3-textsize__btn" data-zoom-btn="1.15">A+</button>
						<button type="button" class="wrmk-v3-textsize__btn" data-zoom-btn="1.3">A++</button>
					</span>
				</div>
				<a href="tel:+6494702400">09 470 2400</a>
				<a href="<?php echo esc_url( home_url( '/pay-online/' ) ); ?>">Pay online</a>
			</div>
		</div>
	</div>

	<header class="wrmk-v3-header">
		<div class="wrmk-v3-header__inner">
			<div class="wrmk-v3-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/wrmk-COL-RGB.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
					<?php endif; ?>
				</a>
			</div>
			<button type="button" class="wrmk-v3-nav-toggle" data-nav-toggle>Menu</button>
			<nav class="wrmk-v3-nav" data-nav>
				<ul>
					<li class="wrmk-v3-nav__has-dropdown<?php echo $wrmk_section === 'services' ? ' is-active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>">Services</a>
						<button type="button" class="wrmk-v3-nav__dropdown-toggle" aria-label="Toggle submenu">&#9662;</button>
						<ul class="wrmk-v3-nav__dropdown">
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'business' ) ); ?>">Business &amp; commercial law</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'criminal-law' ) ); ?>">Criminal law</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'dispute-resolution' ) ); ?>">Dispute resolution</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'employment' ) ); ?>">Employment</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'property-lawyers' ) ); ?>">Property law</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'property-development-subdivisions' ) ); ?>">Property development &amp; subdivisions</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'relationship-family-property' ) ); ?>">Relationship &amp; family property</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'trusts-asset-planning' ) ); ?>">Trusts &amp; asset planning</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'wills-estates-life-planning' ) ); ?>">Wills, estates &amp; life planning</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'construction' ) ); ?>">Construction law</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'rural-lawyers' ) ); ?>">Rural</a></li>
							<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( 'notary-public' ) ); ?>">Notary Public</a></li>
						</ul>
					</li>
					<li class="wrmk-v3-nav__has-dropdown<?php echo $wrmk_section === 'our-people' ? ' is-active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/our-people/' ) ); ?>">Our people</a>
						<button type="button" class="wrmk-v3-nav__dropdown-toggle" aria-label="Toggle submenu">&#9662;</button>
						<ul class="wrmk-v3-nav__dropdown">
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=managing-director' ) ); ?>">Managing Directors</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=director' ) ); ?>">Directors</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=consultant' ) ); ?>">Consultants</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=associate' ) ); ?>">Associates</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=senior-lawyer' ) ); ?>">Senior Lawyers</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=lawyer' ) ); ?>">Lawyers</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=legal-executive' ) ); ?>">Legal Executives</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=law-clerk' ) ); ?>">Law Clerks</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=general-manager' ) ); ?>">General Manager</a></li>
							<li><a href="<?php echo esc_url( home_url( '/our-people/?role=assistant-manager' ) ); ?>">Assistant Manager</a></li>
						</ul>
					</li>
					<li class="wrmk-v3-nav__has-dropdown<?php echo $wrmk_section === 'about-us' ? ' is-active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>">About us</a>
						<button type="button" class="wrmk-v3-nav__dropdown-toggle" aria-label="Toggle submenu">&#9662;</button>
						<ul class="wrmk-v3-nav__dropdown">
							<li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Offices</a></li>
							<li><a href="<?php echo esc_url( home_url( '/about-us/careers/' ) ); ?>">Careers</a></li>
							<li><a href="<?php echo esc_url( home_url( '/about-us/community/' ) ); ?>">Community</a></li>
							<li><a href="<?php echo esc_url( home_url( '/scholarships/' ) ); ?>">Scholarships</a></li>
						</ul>
					</li>
					<li class="<?php echo $wrmk_section === 'news' ? 'is-active' : ''; ?>"><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a></li>
					<li class="wrmk-v3-nav__has-dropdown<?php echo $wrmk_section === 'do-it-online' ? ' is-active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/do-it-online/' ) ); ?>">Do it online</a>
						<button type="button" class="wrmk-v3-nav__dropdown-toggle" aria-label="Toggle submenu">&#9662;</button>
						<ul class="wrmk-v3-nav__dropdown">
							<li><a href="<?php echo esc_url( home_url( '/pay-online/' ) ); ?>">Pay online</a></li>
							<li><a href="<?php echo esc_url( home_url( '/do-it-online/make-an-appointment/' ) ); ?>">Make an appointment</a></li>
							<li><a href="<?php echo esc_url( home_url( '/wrmk-client-information-form/' ) ); ?>">New client information</a></li>
							<li><a href="<?php echo esc_url( home_url( '/do-it-online/subscribe/' ) ); ?>">Subscribe to updates</a></li>
							<li class="wrmk-v3-nav__dropdown-divider" role="presentation"></li>
							<li><a href="<?php echo esc_url( home_url( '/do-it-online/start-your-rpa-online/' ) ); ?>">Relationship property agreement</a></li>
							<li><a href="<?php echo esc_url( home_url( '/do-it-online/property-purchase-fees/' ) ); ?>">Property purchase fees</a></li>
							<li><a href="<?php echo esc_url( home_url( '/do-it-online/property-sale-fees/' ) ); ?>">Property sale fees</a></li>
							<li class="wrmk-v3-nav__dropdown-divider" role="presentation"></li>
							<li><a href="<?php echo esc_url( home_url( '/do-it-online/trust-circumstances-review/' ) ); ?>">Trust circumstances review</a></li>
							<li><a href="<?php echo esc_url( home_url( '/do-it-online/will-instructions/' ) ); ?>">Start your will online</a></li>
							<li class="wrmk-v3-nav__dropdown-divider" role="presentation"></li>
							<li><a href="<?php echo esc_url( home_url( '/do-it-online/register-now/' ) ); ?>">Employment Law Drop-In Clinic</a></li>
							<li><a href="<?php echo esc_url( home_url( '/services/employment/health-check/' ) ); ?>">Employment Health Check</a></li>
						</ul>
					</li>
					<li class="wrmk-v3-nav__has-dropdown<?php echo $wrmk_section === 'ai' ? ' is-active' : ''; ?>">
						<a href="<?php echo esc_url( home_url( '/ai-at-wrmk/' ) ); ?>">AI</a>
						<button type="button" class="wrmk-v3-nav__dropdown-toggle" aria-label="Toggle submenu">&#9662;</button>
						<ul class="wrmk-v3-nav__dropdown">
							<li><a href="<?php echo esc_url( home_url( '/ai-at-wrmk/#firm' ) ); ?>">How we use AI</a></li>
							<li><a href="<?php echo esc_url( home_url( '/ai-at-wrmk/#client' ) ); ?>">How clients use AI</a></li>
						</ul>
					</li>
				</ul>
				<button type="button" class="wrmk-v3-lang-toggle" aria-label="Switch the wording on this page">
					<span class="wrmk-v3-lang-toggle__opt is-active" data-lang-btn="plain">Plain English</span>
					<span class="wrmk-v3-lang-toggle__opt" data-lang-btn="legal">Legal</span>
				</button>
				<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="wrmk-v3-nav__cta">Contact us</a>
			</nav>
		</div>
	</header>

	<div class="wrmk-v3-zoom">
