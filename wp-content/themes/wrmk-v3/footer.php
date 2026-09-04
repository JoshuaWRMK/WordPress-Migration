<?php
/**
 * Shared footer: contact/office band + enquiry form + bottom links.
 * The enquiry form renders the real Gravity Form (id 1, matching the
 * original site's WRMK_CONTACT_FORM_ID) when Gravity Forms is active;
 * otherwise it falls back to a plain mailto-based form, same as the
 * static wrmk-v3 test build.
 */
?>
	</div><!-- .wrmk-v3-zoom -->

	<footer id="contact" class="wrmk-v3-footer">
		<div class="wrmk-v3-footer__inner">
			<div class="wrmk-v3-footer__top">
				<div>
					<div class="wrmk-v3-footer__kicker"><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">Contact us</a></div>
					<h3 class="wrmk-v3-footer__heading">Have a question? We&rsquo;d love to help.</h3>
					<p class="wrmk-v3-footer__lead">Send us a note and the right person will come back to you &mdash; or call the office closest to you, above.</p>
					<div class="wrmk-v3-footer__quickfacts">
						<span class="wrmk-v3-footer__quickfacts-title">For all offices</span>
						<div class="wrmk-v3-footer__quickfacts-row">
							<div><span>Email</span><a href="mailto:info@wrmk.co.nz">info@wrmk.co.nz</a></div>
							<div><span>Postal address</span><strong>Private Bag 9012, Te Mai, Whangarei 0143</strong></div>
						</div>
					</div>
				</div>
				<?php if ( function_exists( 'gravity_form' ) ) : ?>
					<?php gravity_form( defined( 'WRMK_CONTACT_FORM_ID' ) ? WRMK_CONTACT_FORM_ID : 1, false, false, false, '', true, 0, false ); ?>
				<?php else : ?>
					<form class="wrmk-v3-form" data-fallback-form>
						<input type="text" placeholder="Your name*" required />
						<input type="email" placeholder="Email*" required />
						<input type="tel" placeholder="Phone" class="wrmk-v3-form__full" />
						<textarea rows="4" placeholder="How can we help?" class="wrmk-v3-form__full"></textarea>
						<button type="submit" class="wrmk-v3-btn wrmk-v3-btn--orange">Send enquiry</button>
						<p class="wrmk-v3-form__note">We aim to reply within one business day. Please don&rsquo;t include sensitive details in this form.</p>
					</form>
				<?php endif; ?>
			</div>
			<div class="wrmk-v3-footer__bottom">
				<div class="wrmk-v3-footer__logo">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/wrmk-COL-RGB.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
					</a>
				</div>
				<div class="wrmk-v3-footer__links">
					<a href="<?php echo esc_url( home_url( '/terms-of-engagement/' ) ); ?>">Terms of engagement</a>
					<a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>">Terms of service</a>
					<a href="<?php echo esc_url( home_url( '/about-us/careers/' ) ); ?>">Careers</a>
					<a href="<?php echo esc_url( home_url( '/sitemap/' ) ); ?>">Sitemap</a>
				</div>
			</div>
			<div class="wrmk-v3-footer__copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> WRMK. All rights reserved. WRMK Lawyers is the trading name for Webb Ross McNab Kilpatrick Limited.</div>
		</div>
	</footer>
</div><!-- .wrmk-v3 -->
<?php wp_footer(); ?>
</body>
</html>
