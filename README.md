# WRMK Lawyers — "v3" WordPress Theme

## What this is

A custom WordPress theme that implements the firm's new "v3" design (the
redesigned homepage, services pages, staff directory, news, AI page, etc.)
as a **drop-in replacement theme** for the existing wrmk.co.nz WordPress
install.

This is **not** a content migration. The theme contains no client data of
its own — it queries whatever is already in the site's live database
(staff profiles, news posts, testimonials, service pages, offices) using
standard WordPress functions. Activate it on the real site and it renders
the real, current content in the new design automatically.

It was built and tested against a full local copy of the real WordPress
database (imported from an export of the live site) to make sure every
page type renders correctly against real content before hand-off — not
against placeholder/lorem-ipsum content.

## What's in this repo

```
wp-content/themes/wrmk-v3/
```

That's it. Copy this one folder into `wp-content/themes/` on the target
WordPress install. There is nothing else to install — no plugins were
added, no database changes are required by the theme itself (see
"Known data clean-ups" below for a few *optional*, already-applied
database tweaks).

## What's deliberately **not** in this repo

- **WordPress core.** Standard, unmodified, not needed here.
- **The database, or any real client data.** The theme was developed
  against a local copy of the real database for testing, but that copy —
  and everything in it (staff records, client testimonials, emails) —
  stays local and is not part of this handover. This repo is safe to be
  public or shared freely; it contains only template code, CSS/JS, and
  the firm's own logo/favicon.
- **The local PHP/MariaDB test environment.** Development-only tooling,
  not needed to run the theme on a real WordPress install (which already
  has PHP + MySQL/MariaDB running).

## Deployment steps

1. **Back up the target site first** (files + database) — standard
   practice before any theme change.
2. **Test on a staging copy, not production.** Copy
   `wp-content/themes/wrmk-v3/` into the staging site's
   `wp-content/themes/` folder.
3. In **wp-admin → Appearance → Themes**, activate **"WRMK v3"**.
4. Go to **Settings → Permalinks** and click **Save Changes** once, even
   without changing anything. This flushes WordPress's rewrite rules,
   which is required for the Staff post type's URLs
   (`/our-people/<name>/`) to resolve correctly.
5. Spot-check: homepage, a staff profile, a service page (e.g.
   `/services/property-lawyers/`), `/our-people/`, `/news/`, an
   individual news article, `/contact-us/`, `/ai-at-wrmk/`.
6. If everything looks right on staging, repeat on production during a
   low-traffic window, with the same backup-first precaution.

## Page types covered

| URL pattern | Template file | Notes |
|---|---|---|
| `/` | `front-page.php` | Homepage — hero, services, offices, AI band, do-it-online, community, testimonials, news |
| `/our-people/` | `archive-staff.php` | Staff directory with role/office/practice-area filters |
| `/our-people/<slug>/` | `single-staff.php` | Individual staff profile — pulls all real ACF fields (phone, email, qualifications, bio, etc.) |
| `/services/` | `page-services.php` | Flat list of the 12 practice areas |
| `/services/<slug>/` (any depth) | `page.php` | Service detail page — real content + a live "Our team" grid of matching staff |
| `/do-it-online/` | `page-do-it-online.php` | Grouped self-service tool cards |
| `/contact-us/` | `page-contact-us.php` | Office cards + "nearest office" geolocation + contact form |
| `/news/` | `page-news.php` | Full filterable archive (all real articles) |
| `/news/<slug>/` (single articles) | `single.php` | Individual news article |
| `/ai-at-wrmk/` | `page-ai-at-wrmk.php` | New content (see below) — firm/client tabs + interactive demo |
| `/testimonials/` | `page-testimonials.php` | All real client testimonials |
| `/sitemap/` | `page-sitemap.php` | Real page/post counts and links |
| Everything else (About us, Careers, Community, legal pages, resource guides, do-it-online sub-pages) | `page.php` (generic branch) | Plain title + content layout |

Shared on every page: `header.php` (topbar, logo, nav, mobile menu,
Plain English/Legal toggle) and `footer.php` (contact band + enquiry
form + site links). `functions.php` registers the `staff` and
`testimonial` post types/taxonomies (see below) and holds the helper
functions the templates use to resolve real permalinks safely.

## Things worth knowing about the real data

These are genuine characteristics of the current database, discovered
while building and testing this theme — not caused by the theme, but
important for whoever maintains the site next:

- **`staff` and `testimonial` are custom post types that aren't
  registered anywhere in this database export.** They were presumably
  registered by a plugin that wasn't included in the export used for
  local testing, or historically lived in the previous theme. This new
  theme registers them itself (in `functions.php`), using the *exact*
  same slugs the existing data already uses, so no data needs to move.
  **If the live site already has these post types registered by an
  active plugin, that's fine — WordPress just uses one registration —
  but it's worth confirming there's no conflicting plugin still active.**
- **Pages are nested more deeply/inconsistently than you'd expect in a
  few places** — e.g. "Criminal law" is a *child of* "Dispute
  resolution" (not a direct child of "Services"), and "Employment Health
  Check" is a child of "Employment". The theme resolves every internal
  link by looking up the real page by its slug rather than assuming a
  URL shape, so this doesn't cause broken links — just flagging it in
  case anyone restructures the URLs later.
- **The "Kerikeri office" page is filed under "Services" instead of
  "Contact us"** in the real data (the other three office pages are
  correctly under Contact us). Harmless, but worth tidying up in
  wp-admin if you'd like the page hierarchy to be fully consistent.
- **The "News" page's slug was `blog`.** It's been renamed to `news` (a
  one-field database change) so the URL matches the rest of the site's
  navigation and language. If anything external links to `/blog/`,
  consider adding a redirect.
- **Two long-orphaned pages ("Our People: Business" and "Our People:
  Property") plus a leftover test page ("PageZERO") were set to Draft**
  during testing. They used the same URL slugs as real, live service
  pages ("business" and "property"), which was silently hijacking the
  navigation links to those service pages. They're not deleted — just
  drafted — in case there's content worth recovering; otherwise they're
  safe to delete permanently.
- **Three pages don't exist in the original site at all** and were
  created fresh as part of this project: **"AI at WRMK"**, **"Sitemap"**,
  and **"Testimonials"**. These host genuinely new content pieces from
  the v3 redesign (the AI page in particular is new copy, not migrated
  from anywhere).
- A handful of internal links baked into old article text use shortened
  slugs (e.g. `/services/property/` instead of the real
  `/services/property-lawyers/`). WordPress's own canonical redirect
  handles these correctly (visitors still land on the right page), so
  it's cosmetic, not a bug — just means a couple of internal links do an
  extra redirect hop.

## Contact form

The enquiry form in the footer automatically uses the site's real
**Gravity Forms** form (matching `WRMK_CONTACT_FORM_ID`, which was `1` in
the previous theme) *if* Gravity Forms is active on the target site —
see `footer.php`. If Gravity Forms isn't active, it falls back to a
plain HTML form with no submission handling, purely so the page doesn't
look broken.

**Before launch: confirm the real Gravity Forms ID is still `1`** (or
update the constant/fallback in `footer.php` if it's changed), and do a
real test submission on staging.

## Known limitations / suggested follow-ups

- The contact form's real submission path hasn't been tested end-to-end
  (Gravity Forms isn't installed in the local test environment this
  theme was built against) — please verify on staging.
- Consider the small database clean-ups above (Kerikeri office
  location, the 3 drafted pages) at your convenience — none are
  blocking.
- Only a subset of the media library was available locally during
  development (just the images already used in an earlier static
  prototype of this design), so a few staff profiles showed a
  placeholder logo instead of a photo *during local testing only*. On
  the real site, with its full media library, this will not be an
  issue — every `wp_get_attachment`/featured-image call in the theme
  works exactly as it does anywhere else in WordPress.

## Design source

The visual design and all copy originate from a fully-built static
HTML/CSS/JS prototype (453 pages) that was used as the reference while
writing these templates — every template reproduces that design exactly,
just wired to live WordPress data instead of hand-written HTML.
