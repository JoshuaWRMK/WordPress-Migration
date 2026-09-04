<?php
/**
 * Homepage. Structure/copy mirrors the wrmk-v3 static design; the
 * testimonials and news bands pull real, live content.
 */
get_header();

$staff_count = wp_count_posts( 'staff' )->publish;
?>

<section id="top" class="wrmk-v3-hero">
	<div class="wrmk-v3-hero__glow"></div>
	<div class="wrmk-v3-hero__inner">
		<div class="wrmk-v3-hero__meta">
			<span class="wrmk-v3-hero__badge"><span class="wrmk-v3-hero__badge-dot"></span>Since the 1930s &middot; Northland's largest law firm</span>
			<span>Whangarei &middot; Dargaville &middot; Kerikeri &middot; Warkworth</span>
		</div>
		<div class="wrmk-v3-hero__grid">
			<div>
				<h1 class="wrmk-v3-hero__title" data-lang="plain">Whatever you're dealing with, <span class="wrmk-v3-hero__title-mark"><span class="wrmk-v3-hero__title-sweep"></span><span class="wrmk-v3-hero__title-text">we're here to help.</span></span></h1>
				<h1 class="wrmk-v3-hero__title" data-lang="legal">Comprehensive legal representation across all principal areas of practice.</h1>
				<div class="wrmk-v3-hero__ctas">
					<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--orange">Talk to us</a>
					<a href="<?php echo esc_url( home_url( '/do-it-online/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--ghost">Start online</a>
				</div>
			</div>
			<div class="wrmk-v3-hero__side">
				<p class="wrmk-v3-hero__lead" data-lang="plain">A full range of legal services from four Northland offices.</p>
				<p class="wrmk-v3-hero__lead" data-lang="legal">Instructions are accepted at any of our four permanent Northland offices, covering the complete range of the firm's principal areas of practice.</p>
				<div class="wrmk-v3-hero__facts">
					<div class="wrmk-v3-fact"><div class="wrmk-v3-fact__num">4</div><div class="wrmk-v3-fact__label">Permanent Northland offices</div></div>
					<div class="wrmk-v3-fact"><div class="wrmk-v3-fact__num">12</div><div class="wrmk-v3-fact__label">Areas of practice</div></div>
					<div class="wrmk-v3-fact"><div class="wrmk-v3-fact__num"><?php echo (int) $staff_count; ?></div><div class="wrmk-v3-fact__label">People across the firm</div></div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="services" class="wrmk-v3-section">
	<div class="wrmk-v3-section__head" data-reveal>
		<div>
			<div class="wrmk-v3-kicker">01 &mdash; What we do</div>
			<h2 class="wrmk-v3-h2">Find the right help, fast.</h2>
		</div>
		<div class="wrmk-v3-tabs">
			<button type="button" class="wrmk-v3-tabs__btn is-active" data-layout-btn="groups">Grouped</button>
			<button type="button" class="wrmk-v3-tabs__btn" data-layout-btn="all">All 12</button>
		</div>
	</div>
	<?php
	$wrmk_services = array(
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
	$wrmk_groups = array(
		array( 'tag' => '01 / Personal', 'title' => 'You &amp; your family', 'blurb' => 'The decisions that protect the people you care about.', 'items' => array( 'wills-estates-life-planning', 'trusts-asset-planning', 'relationship-family-property', 'criminal-law' ) ),
		array( 'tag' => '02 / Property', 'title' => 'Property &amp; land', 'blurb' => 'Buying, selling, subdividing and building in Northland.', 'items' => array( 'property-lawyers', 'property-development-subdivisions', 'construction', 'rural-lawyers' ) ),
		array( 'tag' => '03 / Business', 'title' => 'Your business', 'blurb' => 'Structure, contracts and the people you employ.', 'items' => array( 'business', 'employment', 'construction', 'notary-public' ) ),
		array( 'tag' => '04 / Disputes', 'title' => 'When things go wrong', 'blurb' => 'Resolving matters early, and holding the line when needed.', 'items' => array( 'dispute-resolution', 'employment', 'criminal-law', 'construction' ) ),
	);
	$wrmk_by_slug = array();
	foreach ( $wrmk_services as $s ) { $wrmk_by_slug[ $s['slug'] ] = $s; }
	?>
	<div class="wrmk-v3-services" data-services data-layout="groups">
		<div class="wrmk-v3-grid wrmk-v3-groups" data-panel="groups">
			<?php foreach ( $wrmk_groups as $g ) : ?>
			<div class="wrmk-v3-group-card" data-reveal>
				<div class="wrmk-v3-group-card__tag"><?php echo esc_html( $g['tag'] ); ?></div>
				<h3 class="wrmk-v3-group-card__title"><a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php echo wp_kses_post( $g['title'] ); ?></a></h3>
				<p class="wrmk-v3-group-card__blurb"><?php echo esc_html( $g['blurb'] ); ?></p>
				<ul class="wrmk-v3-group-card__items">
					<?php foreach ( $g['items'] as $slug ) : $s = $wrmk_by_slug[ $slug ]; ?>
					<li><a href="<?php echo esc_url( wrmk_v3_page_permalink( $slug ) ); ?>"><?php echo wp_kses_post( $s['title'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="wrmk-v3-grid wrmk-v3-all" data-panel="all">
			<?php foreach ( $wrmk_services as $i => $s ) : ?>
			<a href="<?php echo esc_url( wrmk_v3_page_permalink( $s['slug'] ) ); ?>" class="wrmk-v3-all__item"><span class="wrmk-v3-all__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><span><span class="wrmk-v3-all__title"><?php echo wp_kses_post( $s['title'] ); ?></span><span class="wrmk-v3-all__desc"><?php echo esc_html( $s['desc'] ); ?></span></span></a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section id="offices" class="wrmk-v3-section wrmk-v3-section--tight">
	<div class="wrmk-v3-section__head" data-reveal>
		<div>
			<div class="wrmk-v3-kicker">02 &mdash; Where we are</div>
			<h2 class="wrmk-v3-h2">One region, four offices.</h2>
		</div>
		<p style="font-size:17px;line-height:1.6;color:var(--grey);max-width:40ch;margin:0;">Lawyers who live in the communities they act for.</p>
	</div>
	<div class="wrmk-v3-geo" data-reveal>
		<div class="wrmk-v3-geo__left">
			<span class="wrmk-v3-geo__dot"></span>
			<div>
				<div class="wrmk-v3-geo__kicker" data-geo-kicker>Head office</div>
				<div class="wrmk-v3-geo__line" data-geo-line>We could not place you, so here is Whang&#257;rei: 9 Hunt Street. Call 09 470 2400 and we will point you to the right office.</div>
			</div>
		</div>
		<div class="wrmk-v3-geo__right">
			<div class="wrmk-v3-geo__stats">
				<div><div class="wrmk-v3-geo__stat-num" data-geo-distance>&mdash;</div><div class="wrmk-v3-geo__stat-label">Distance</div></div>
				<div><div class="wrmk-v3-geo__stat-num" data-geo-drive>&mdash;</div><div class="wrmk-v3-geo__stat-label">Approx. drive</div></div>
			</div>
			<a href="https://www.google.com/maps/dir/?api=1&destination=9+Hunt+Street,+Whangarei" target="_blank" rel="noopener" class="wrmk-v3-btn wrmk-v3-btn--dark" data-geo-directions>Get directions &rarr;</a>
		</div>
	</div>
	<div class="wrmk-v3-map-panel" data-reveal>
		<div class="wrmk-v3-map">
			<iframe data-map-frame data-default-src="https://www.google.com/maps?q=Northland,+New+Zealand&z=8&output=embed" src="https://www.google.com/maps?q=Northland,+New+Zealand&z=8&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="WRMK office locations"></iframe>
		</div>
		<div class="wrmk-v3-office-list">
			<?php
			$wrmk_offices = array(
				array( 'id' => 'whangarei', 'name' => 'Whang&#257;rei', 'address' => 'Legal House, 9 Hunt Street', 'phone' => '09 470 2400', 'tel' => '+6494702400' ),
				array( 'id' => 'dargaville', 'name' => 'Dargaville', 'address' => '118 Victoria Street', 'phone' => '09 439 8001', 'tel' => '+6494398001' ),
				array( 'id' => 'kerikeri', 'name' => 'Kerikeri', 'address' => 'John Butler Centre, 60 Kerikeri Road', 'phone' => '09 401 6354', 'tel' => '+6494016354' ),
				array( 'id' => 'warkworth', 'name' => 'Warkworth', 'address' => 'The Oaks on Neville, 9 Queen Street', 'phone' => '09 470 2459', 'tel' => '+6494702459' ),
			);
			foreach ( $wrmk_offices as $o ) :
			?>
			<div class="wrmk-v3-office" data-office="<?php echo esc_attr( $o['id'] ); ?>" tabindex="0">
				<div class="wrmk-v3-office__row">
					<h3 class="wrmk-v3-office__name"><?php echo $o['name']; ?></h3>
					<span class="wrmk-v3-office__status" data-office-status><span class="wrmk-v3-office__status-dot"></span><span data-office-status-text>Closed</span></span>
				</div>
				<div class="wrmk-v3-office__address"><?php echo esc_html( $o['address'] ); ?></div>
				<div class="wrmk-v3-office__contact">
					<a href="tel:<?php echo esc_attr( $o['tel'] ); ?>" class="wrmk-v3-office__phone"><?php echo esc_html( $o['phone'] ); ?></a>
					<a href="<?php echo esc_url( wrmk_v3_office_permalink( $o['id'] ) ); ?>" class="wrmk-v3-office__hint">Details &rarr;</a>
				</div>
			</div>
			<?php endforeach; ?>
			<div class="wrmk-v3-office-list__footer">
				<span>Hover an office to locate it</span>
				<a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="wrmk-v3-office-reset">Show all &rarr;</a>
			</div>
		</div>
	</div>
</section>

<section id="ai" class="wrmk-v3-ai" data-reveal>
	<div class="wrmk-v3-ai__inner">
		<div class="wrmk-v3-kicker">03 &mdash; AI at WRMK</div>
		<div class="wrmk-v3-ai__grid">
			<div>
				<h2 class="wrmk-v3-ai__title" data-lang="plain">We build our own AI tools, so your matter costs less to run.</h2>
				<h2 class="wrmk-v3-ai__title" data-lang="legal">Proprietary AI systems, deployed to reduce the cost of your matter.</h2>
				<p class="wrmk-v3-ai__lead">WRMK is building custom internal AI tools inside our own secure environment. Not public chatbots &mdash; purpose-built systems that take the repetitive work out of a file so our lawyers spend their time on judgement, strategy and you.</p>
				<p class="wrmk-v3-ai__lead" style="margin-bottom:34px;">Every output is reviewed by the lawyer responsible for your matter. Your information never leaves our secure environment.</p>
				<a href="<?php echo esc_url( home_url( '/ai-at-wrmk/#firm' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--orange">How we use AI, in full &rarr;</a>
			</div>
			<div>
				<div class="wrmk-v3-ai-card"><span class="wrmk-v3-ai-card__num">01</span><span><span class="wrmk-v3-ai-card__title">Built in-house, kept in-house</span><span class="wrmk-v3-ai-card__body">Our tools run inside WRMK's own secure environment. Client information is never fed into public AI models.</span></span></div>
				<div class="wrmk-v3-ai-card"><span class="wrmk-v3-ai-card__num">02</span><span><span class="wrmk-v3-ai-card__title">Time back on the routine work</span><span class="wrmk-v3-ai-card__body">Document review, summarising, first drafts and file admin move faster &mdash; so the hours you're charged for are the ones that need a lawyer.</span></span></div>
				<div class="wrmk-v3-ai-card"><span class="wrmk-v3-ai-card__num">03</span><span><span class="wrmk-v3-ai-card__title">A lawyer signs off on everything</span><span class="wrmk-v3-ai-card__body">AI never gives advice. The lawyer responsible for your matter reviews every output before it reaches you.</span></span></div>
				<div class="wrmk-v3-ai__client-box">
					<div class="wrmk-v3-kicker wrmk-v3-kicker--deep" style="margin-bottom:14px;">For clients</div>
					<h3>Using AI yourself? Here's how to do it well.</h3>
					<p>Used properly, AI can cut hours off your legal bill. Used badly, it creates problems we then have to fix. Our guide covers both &mdash; what to bring to a meeting, what to never put into a public tool, and where a lawyer is still non-negotiable.</p>
					<a href="<?php echo esc_url( home_url( '/ai-at-wrmk/#client' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--dark">Read the client guide to AI &rarr;</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="online" class="wrmk-v3-section">
	<div style="margin-bottom:36px;" data-reveal>
		<div class="wrmk-v3-kicker">04 &mdash; Do it online</div>
		<h2 class="wrmk-v3-h2">Start without picking up the phone.</h2>
	</div>
	<div class="wrmk-v3-grid wrmk-v3-toolgrid">
		<?php
		$wrmk_tools = array(
			array( 'href' => '/pay-online/', 'title' => 'Pay online', 'desc' => 'Settle your account by card or bank transfer.' ),
			array( 'href' => '/do-it-online/make-an-appointment/', 'title' => 'Make an appointment', 'desc' => 'Pick a time at the office nearest you, or by video.' ),
			array( 'href' => '/wrmk-client-information-form/', 'title' => 'New client information', 'desc' => 'Complete your ID and details before you come in.' ),
			array( 'href' => '/do-it-online/start-your-rpa-online/', 'title' => 'Relationship property agreement', 'desc' => 'Start your agreement online, at your own pace.' ),
			array( 'href' => '/do-it-online/trust-circumstances-review/', 'title' => 'Trust circumstances review', 'desc' => "Answer a few questions and we'll flag the risks." ),
			array( 'href' => '/do-it-online/subscribe/', 'title' => 'Subscribe to updates', 'desc' => 'Plain-English law changes, a few times a year.' ),
		);
		foreach ( $wrmk_tools as $i => $t ) :
		?>
		<a href="<?php echo esc_url( home_url( $t['href'] ) ); ?>" class="wrmk-v3-toolcard" data-reveal><span class="wrmk-v3-toolcard__num"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><h3 class="wrmk-v3-toolcard__title"><?php echo esc_html( $t['title'] ); ?></h3><p class="wrmk-v3-toolcard__desc"><?php echo esc_html( $t['desc'] ); ?></p><span class="wrmk-v3-toolcard__cta">Start now <span class="wrmk-v3-toolcard__cta-arrow">&rarr;</span></span></a>
		<?php endforeach; ?>
	</div>
</section>

<section id="whatson" class="wrmk-v3-section wrmk-v3-section--tight">
	<div class="wrmk-v3-section__head" data-reveal>
		<div>
			<div class="wrmk-v3-kicker">05 &mdash; Community</div>
			<h2 class="wrmk-v3-h2">Scholarships, and giving back to Northland.</h2>
		</div>
		<a href="<?php echo esc_url( home_url( '/about-us/community/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--outline">Community &rarr;</a>
	</div>
	<div class="wrmk-v3-grid wrmk-v3-promos">
		<a href="<?php echo esc_url( home_url( '/scholarships/' ) ); ?>" class="wrmk-v3-promo-card" data-reveal>
			<div class="wrmk-v3-promo-card__meta"><span class="wrmk-v3-promo-card__kind">Scholarships</span></div>
			<h3 class="wrmk-v3-promo-card__title">WRMK Law Scholarships</h3>
			<p class="wrmk-v3-promo-card__desc">Supporting Northland students through law school.</p>
			<span class="wrmk-v3-promo-card__cta">Learn more &rarr;</span>
		</a>
		<a href="<?php echo esc_url( home_url( '/scholarship-alumni/' ) ); ?>" class="wrmk-v3-promo-card" data-reveal>
			<div class="wrmk-v3-promo-card__meta"><span class="wrmk-v3-promo-card__kind">Alumni</span></div>
			<h3 class="wrmk-v3-promo-card__title">Scholarship Alumni</h3>
			<p class="wrmk-v3-promo-card__desc">Where our past scholarship recipients are now.</p>
			<span class="wrmk-v3-promo-card__cta">Meet them &rarr;</span>
		</a>
		<a href="<?php echo esc_url( home_url( '/graduate-recruitment/' ) ); ?>" class="wrmk-v3-promo-card" data-reveal>
			<div class="wrmk-v3-promo-card__meta"><span class="wrmk-v3-promo-card__kind">Careers</span></div>
			<h3 class="wrmk-v3-promo-card__title">Graduate recruitment</h3>
			<p class="wrmk-v3-promo-card__desc">Start your legal career with WRMK Lawyers.</p>
			<span class="wrmk-v3-promo-card__cta">Find out more &rarr;</span>
		</a>
	</div>
</section>

<section class="wrmk-v3-quotes" data-reveal>
	<div class="wrmk-v3-quotes__inner">
		<div class="wrmk-v3-kicker wrmk-v3-kicker--deep">06 &mdash; What our clients say</div>
		<div class="wrmk-v3-grid wrmk-v3-quotes__grid">
			<?php
			$wrmk_testimonial_count = wp_count_posts( 'testimonial' )->publish;
			$testimonials = get_posts( array(
				'post_type'      => 'testimonial',
				'posts_per_page' => 4,
				'orderby'        => 'rand',
			) );
			foreach ( $testimonials as $t ) :
				$quote = wp_strip_all_tags( apply_filters( 'the_content', $t->post_content ) );
			?>
			<figure class="wrmk-v3-quote-card">
				<blockquote><?php echo esc_html( $quote ); ?></blockquote>
				<figcaption><div class="wrmk-v3-quote-card__name"><?php echo esc_html( $t->post_title ); ?></div></figcaption>
			</figure>
			<?php endforeach; ?>
		</div>
		<div style="text-align:center;margin-top:30px;"><a href="<?php echo esc_url( home_url( '/testimonials/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--outline">Read all <?php echo (int) $wrmk_testimonial_count; ?> testimonials &rarr;</a></div>
	</div>
</section>

<section id="news" class="wrmk-v3-section">
	<div class="wrmk-v3-grid wrmk-v3-news-grid">
		<div class="wrmk-v3-news-intro" data-reveal>
			<div class="wrmk-v3-kicker">07 &mdash; Latest news</div>
			<h2 class="wrmk-v3-h2 wrmk-v3-h2--sm">Plain-English updates on the law that affects you.</h2>
			<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="wrmk-v3-btn wrmk-v3-btn--outline">All articles &rarr;</a>
		</div>
		<div>
			<?php
			$latest_news = get_posts( array( 'post_type' => 'post', 'posts_per_page' => 3 ) );
			foreach ( $latest_news as $n ) :
				$tags = get_the_tags( $n->ID );
				$tag_name = $tags && ! is_wp_error( $tags ) ? $tags[0]->name : '';
			?>
			<a href="<?php echo esc_url( get_permalink( $n ) ); ?>" class="wrmk-v3-news-item" data-reveal>
				<span class="wrmk-v3-news-item__date"><?php echo esc_html( get_the_date( 'j F Y', $n ) ); ?></span>
				<span><span class="wrmk-v3-news-item__title"><?php echo esc_html( get_the_title( $n ) ); ?></span></span>
				<?php if ( $tag_name ) : ?><span class="wrmk-v3-news-item__tag"><?php echo esc_html( $tag_name ); ?></span><?php endif; ?>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
