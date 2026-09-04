(function () {
  "use strict";

  var root = document.querySelector('.wrmk-v3');
  if (!root) return;

  var DATA = window.WRMK_V3 || { offices: [], services: [], openMin: 510, closeMin: 1020 };

  /* ==== CONTACT DESTINATION ====
     The footer enquiry form ("Send enquiry") is not wired up to anything yet --
     paste the real WRMK contact address here (check the WordPress export, e.g.
     the Gravity Forms notification settings) and every copy of the form,
     sitewide, will start sending. Leave blank to keep the form inert, as now. */
  var WRMK_CONTACT_EMAIL = "";

  /* Staff profile breadcrumb: hardcoded as "Home / Our people / NAME", but if
     the visitor actually clicked through from a Services page, show that real
     path instead ("Home / Services / <the service> / NAME"). Services-page
     staff-card links carry `?from=services-SLUG` themselves (added at build
     time) since `document.referrer` is unreliable -- browsers omit it for
     file:// pages, and some block or strip it entirely. `document.referrer`
     is kept only as a fallback for links that don't carry that param. */
  (function () {
    var breadcrumb = document.querySelector('.wrmk-v3-breadcrumb');
    if (!breadcrumb) return;
    var links = breadcrumb.querySelectorAll('a');
    if (links.length !== 2) return;
    var ourPeopleLink = links[1];
    if (!/(^|\/)index\.html$/.test(ourPeopleLink.getAttribute('href') || '') || ourPeopleLink.textContent !== 'Our people') return;

    var slug = null;
    var fromParam = new URLSearchParams(location.search).get('from');
    if (fromParam && fromParam.indexOf('services-') === 0) {
      slug = fromParam.slice('services-'.length);
    } else if (document.referrer) {
      var refMatch = document.referrer.match(/\/services\/([a-z0-9-]+)\.html(?:[?#].*)?$/);
      if (refMatch) slug = refMatch[1];
    }
    if (!slug || slug === 'index') return;

    var SERVICE_NAMES = {
      'business': 'Business & commercial law',
      'criminal-law': 'Criminal law',
      'dispute-resolution': 'Dispute resolution',
      'employment': 'Employment',
      'property-lawyers': 'Property law',
      'property-development-subdivisions': 'Property development & subdivisions',
      'relationship-family-property': 'Relationship & family property',
      'trusts-asset-planning': 'Trusts & asset planning',
      'wills-estates-life-planning': 'Wills, estates & life planning',
      'construction': 'Construction law',
      'rural-lawyers': 'Rural',
      'notary-public': 'Notary Public'
    };
    var name = SERVICE_NAMES[slug];
    if (!name) return;

    var homeHref = links[0].getAttribute('href');
    var trailingName = breadcrumb.textContent.split('/').pop().trim();
    breadcrumb.innerHTML = '<a href="' + homeHref + '">Home</a> / ' +
      '<a href="../services/index.html">Services</a> / ' +
      '<a href="../services/' + slug + '.html">' + name + '</a> / ' + trailingName;
  })();

  /* Scroll progress bar */
  var progressEl = document.querySelector('.wrmk-v3-progress');
  function updateProgress() {
    if (!progressEl) return;
    var se = document.scrollingElement || document.documentElement;
    var top = se.scrollTop || window.scrollY || 0;
    var h = se.scrollHeight - se.clientHeight;
    progressEl.style.width = (h > 0 ? Math.min(1, top / h) * 100 : 0) + '%';
  }
  window.addEventListener('scroll', updateProgress, { passive: true });
  updateProgress();

  /* Clicking the progress bar jumps to the nearest section's start -- not to
     the raw proportional scroll position. E.g. on the homepage, clicking at
     50% across lands near the "AI at WRMK" section, so it snaps to the top
     of that section rather than stopping mid-paragraph inside it. */
  var progressTrackEl = document.querySelector('.wrmk-v3-progress-track');
  if (progressTrackEl) {
    var pageSections = document.querySelectorAll('.wrmk-v3-zoom > section');
    progressTrackEl.addEventListener('click', function (e) {
      var rect = progressTrackEl.getBoundingClientRect();
      var fraction = Math.min(1, Math.max(0, (e.clientX - rect.left) / rect.width));
      var se = document.scrollingElement || document.documentElement;
      var target = fraction * (se.scrollHeight - se.clientHeight);

      var scrollTop = target;
      if (pageSections.length) {
        var bestTop = null, bestDist = Infinity;
        pageSections.forEach(function (sec) {
          var secTop = sec.getBoundingClientRect().top + window.scrollY;
          var dist = Math.abs(secTop - target);
          if (dist < bestDist) { bestDist = dist; bestTop = secTop; }
        });
        if (bestTop !== null) scrollTop = Math.max(0, bestTop - 90);
      }
      window.scrollTo({ top: scrollTop, behavior: 'smooth' });
    });
  }

  /* Back-to-top button */
  var backToTopEl = document.querySelector('.wrmk-v3-backtotop');
  if (backToTopEl) {
    function updateBackToTop() {
      var se = document.scrollingElement || document.documentElement;
      var top = se.scrollTop || window.scrollY || 0;
      backToTopEl.classList.toggle('is-visible', top > 500);
    }
    window.addEventListener('scroll', updateBackToTop, { passive: true });
    updateBackToTop();
    backToTopEl.addEventListener('click', function () {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* Reveal-on-scroll */
  var revealEls = root.querySelectorAll('[data-reveal]');
  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if ('IntersectionObserver' in window && !reduceMotion) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-revealed');
          io.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -10% 0px' });
    revealEls.forEach(function (el) {
      io.observe(el);
      setTimeout(function () {
        if (!el.classList.contains('is-revealed')) el.classList.add('is-revealed');
      }, 1200);
    });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-revealed'); });
  }

  /* Live NZ clock + office-open status */
  var statusEl = document.querySelector('[data-status-line]');
  var dotEl = document.querySelector('[data-status-dot]');
  var clockEl = document.querySelector('[data-clock-line]');
  var officeStatusEls = root.querySelectorAll('[data-office-status]');

  function nzParts() {
    var d = new Date();
    try {
      var fmt = new Intl.DateTimeFormat('en-NZ', { timeZone: 'Pacific/Auckland', weekday: 'short', hour: '2-digit', minute: '2-digit', hour12: false });
      var parts = {};
      fmt.formatToParts(d).forEach(function (p) { parts[p.type] = p.value; });
      var wd = parts.weekday;
      var hh = parseInt(parts.hour, 10);
      var mm = parseInt(parts.minute, 10);
      var label = new Intl.DateTimeFormat('en-NZ', { timeZone: 'Pacific/Auckland', hour: 'numeric', minute: '2-digit', hour12: true }).format(d).replace(/\s?([ap])\.?m\.?/i, '$1m');
      var weekend = wd === 'Sat' || wd === 'Sun';
      var mins = hh * 60 + mm;
      var open = !weekend && mins >= DATA.openMin && mins < DATA.closeMin;
      return { mins: mins, weekend: weekend, open: open, label: label };
    } catch (e) {
      return { mins: 0, weekend: false, open: false, label: '' };
    }
  }

  function renderClock() {
    var t = nzParts();
    if (statusEl) {
      statusEl.textContent = t.open
        ? 'Offices open now'
        : (t.weekend ? 'Offices closed · open Monday 8:30am' : (t.mins < DATA.openMin ? 'Opening at 8:30am' : 'Closed · open again 8:30am'));
    }
    if (dotEl) dotEl.classList.toggle('is-open', t.open);
    if (clockEl) clockEl.textContent = t.label + ' in Northland';
    officeStatusEls.forEach(function (el) {
      el.classList.toggle('is-open', t.open);
      var text = el.querySelector('[data-office-status-text]');
      if (text) text.textContent = t.open ? 'Open until 5pm' : 'Closed';
    });
  }
  renderClock();
  setInterval(renderClock, 30000);

  /* Text size */
  var zoomWrap = document.querySelector('.wrmk-v3-zoom');
  document.querySelectorAll('[data-zoom-btn]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var z = parseFloat(btn.getAttribute('data-zoom-btn'));
      if (zoomWrap) zoomWrap.style.zoom = z;
      document.querySelectorAll('[data-zoom-btn]').forEach(function (b) { b.classList.toggle('is-active', b === btn); });
    });
  });

  /* Plain English / Legal wording toggle */
  document.querySelectorAll('[data-lang-btn]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var lang = btn.getAttribute('data-lang-btn');
      root.classList.toggle('lang-legal', lang === 'legal');
      document.querySelectorAll('[data-lang-btn]').forEach(function (b) { b.classList.toggle('is-active', b === btn); });
    });
  });

  /* Mobile nav toggle */
  var navToggle = document.querySelector('[data-nav-toggle]');
  var nav = document.querySelector('[data-nav]');
  if (navToggle && nav) {
    navToggle.addEventListener('click', function () { nav.classList.toggle('is-open'); });
  }

  /* Mobile nav dropdown sections: collapsed by default, tap the chevron to
     expand/collapse that one category (the top-level link still navigates). */
  document.querySelectorAll('.wrmk-v3-nav__dropdown-toggle').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      var li = btn.closest('.wrmk-v3-nav__has-dropdown');
      if (li) li.classList.toggle('is-open');
    });
  });

  /* Close a nav dropdown after clicking a link inside it -- otherwise the clicked
     link keeps focus (especially on same-page hash links like Our people's role
     filters) and :focus-within holds the dropdown open even after the mouse leaves. */
  document.querySelectorAll('.wrmk-v3-nav__dropdown a').forEach(function (link) {
    link.addEventListener('click', function () { link.blur(); });
  });

  /* "Show more" accordion boxes: opening one closes every other one on the page
     (even across separate .wrmk-v3-showmore-list groups, e.g. "What we help with"
     and "Questions people ask us" on the same page), then scrolls that box's own
     list into view so the opened box AND the remaining boxes below it are visible
     together (the opened box jumps to the top of its grid, which can otherwise
     land above/below the user's current scroll position). */
  var allShowmoreItems = document.querySelectorAll('.wrmk-v3-showmore');
  document.querySelectorAll('.wrmk-v3-showmore-list').forEach(function (list) {
    var heading = list.previousElementSibling;
    if (heading && /^H[1-6]$/.test(heading.tagName)) heading.style.scrollMarginTop = '100px';
  });
  allShowmoreItems.forEach(function (item) {
    item.addEventListener('toggle', function () {
      if (item.open) {
        allShowmoreItems.forEach(function (other) {
          if (other !== item) other.open = false;
        });
        requestAnimationFrame(function () {
          var list = item.closest('.wrmk-v3-showmore-list');
          if (!list) return;
          var heading = list.previousElementSibling;
          var scrollTarget = (heading && /^H[1-6]$/.test(heading.tagName)) ? heading : list;
          scrollTarget.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
      }
    });
  });

  /* Services: Grouped / All 12 tabs */
  var servicesEl = document.querySelector('[data-services]');
  document.querySelectorAll('[data-layout-btn]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var layout = btn.getAttribute('data-layout-btn');
      if (servicesEl) servicesEl.setAttribute('data-layout', layout);
      document.querySelectorAll('[data-layout-btn]').forEach(function (b) { b.classList.toggle('is-active', b === btn); });
    });
  });

  /* Offices + map */
  var mapFrame = document.querySelector('[data-map-frame]');
  var defaultMapSrc = mapFrame ? mapFrame.getAttribute('data-default-src') : '';
  var officeEls = root.querySelectorAll('[data-office]');

  function focusOffice(id) {
    var office = (DATA.offices || []).filter(function (o) { return o.id === id; })[0];
    officeEls.forEach(function (el) { el.classList.toggle('is-active', el.getAttribute('data-office') === id); });
    if (mapFrame && office) {
      mapFrame.src = 'https://www.google.com/maps?q=' + office.lat + ',' + office.lon + '&z=15&output=embed';
    }
  }

  officeEls.forEach(function (el) {
    var id = el.getAttribute('data-office');
    var goHref = el.getAttribute('data-office-href');
    el.addEventListener('click', function (e) {
      focusOffice(id);
      if (goHref && !e.target.closest('a')) window.location.href = goHref;
    });
    el.addEventListener('keydown', function (e) {
      if (goHref && (e.key === 'Enter' || e.key === ' ') && !e.target.closest('a')) {
        e.preventDefault();
        window.location.href = goHref;
      }
    });
    el.addEventListener('mouseenter', function () { focusOffice(id); });
  });

  function resetOffices() {
    officeEls.forEach(function (el) { el.classList.remove('is-active'); });
    if (mapFrame && defaultMapSrc) mapFrame.src = defaultMapSrc;
  }

  /* Hovering the footer strip (where the "Show all" link lives) resets the
     map/highlight to the default view, same as it did when that link was a
     dedicated reset button -- clicking it still navigates to the full
     offices page. */
  var officeFooter = document.querySelector('.wrmk-v3-office-list__footer');
  if (officeFooter) {
    officeFooter.addEventListener('mouseenter', resetOffices);
  }

  /* Geolocation-based "nearest office" panel */
  var geoKickerEl = document.querySelector('[data-geo-kicker]');
  var geoLineEl = document.querySelector('[data-geo-line]');
  var geoDistanceEl = document.querySelector('[data-geo-distance]');
  var geoDriveEl = document.querySelector('[data-geo-drive]');
  var geoDirectionsEl = document.querySelector('[data-geo-directions]');

  function haversineKm(lat1, lon1, lat2, lon2) {
    var rad = function (x) { return x * Math.PI / 180; };
    var dLat = rad(lat2 - lat1), dLon = rad(lon2 - lon1);
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(rad(lat1)) * Math.cos(rad(lat2)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    return 6371 * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  }

  fetch('https://ipapi.co/json/').then(function (r) { return r.json(); }).then(function (d) {
    if (typeof d.latitude !== 'number' || typeof d.longitude !== 'number') return;
    var offices = DATA.offices || [];
    var best = null, bestKm = Infinity;
    offices.forEach(function (o) {
      var km = haversineKm(d.latitude, d.longitude, o.lat, o.lon);
      if (km < bestKm) { bestKm = km; best = o; }
    });
    if (!best) return;
    var city = [d.city, d.region].filter(Boolean).join(', ') || d.country_name || '';
    var drive = Math.max(5, Math.round((bestKm / 65) * 60 / 5) * 5);
    if (geoKickerEl) geoKickerEl.textContent = city ? 'Your nearest office' : 'Head office';
    if (geoLineEl) {
      geoLineEl.textContent = city
        ? 'You appear to be in ' + city + ' — that puts ' + best.name + ', ' + best.address.replace('\n', ', ') + ' closest to you.'
        : 'We could not place you, so here is ' + best.name + ': ' + best.address + '. Call ' + best.phone + ' and we will point you to the right office.';
    }
    if (geoDistanceEl) geoDistanceEl.textContent = Math.round(bestKm) + ' km';
    if (geoDriveEl) geoDriveEl.textContent = '~' + drive + ' min';
    if (geoDirectionsEl) geoDirectionsEl.href = 'https://www.google.com/maps/dir/?api=1&destination=' + best.maps + '&origin=' + d.latitude + ',' + d.longitude;
    focusOffice(best.id);
    var bestGeoTag = root.querySelector('[data-office="' + best.id + '"] [data-geo-tag]');
    if (bestGeoTag) bestGeoTag.hidden = false;
  }).catch(function () { /* IP lookup blocked or unavailable; static fallback copy already in the markup */ });

  /* Fallback contact form (shown only when Gravity Forms hasn't been wired up yet).
     With WRMK_CONTACT_EMAIL set above, this opens the visitor's own email app with
     the enquiry pre-filled -- no server or third-party form service required. */
  document.querySelectorAll('[data-fallback-form]').forEach(function (fallbackForm) {
    fallbackForm.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!WRMK_CONTACT_EMAIL) return;
      var name = fallbackForm.querySelector('input[type="text"]').value;
      var email = fallbackForm.querySelector('input[type="email"]').value;
      var phone = fallbackForm.querySelector('input[type="tel"]').value;
      var message = fallbackForm.querySelector('textarea').value;
      var subject = 'Website enquiry from ' + (name || 'the website');
      var body = 'Name: ' + name + '\nEmail: ' + email + '\nPhone: ' + phone + '\n\n' + message;
      window.location.href = 'mailto:' + WRMK_CONTACT_EMAIL + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(body);
    });
  });

  /* View tabs (e.g. AI at WRMK: "How we use AI" / "How clients use AI") */
  var viewsEl = document.querySelector('[data-views]');
  function setActiveView(view) {
    if (viewsEl) viewsEl.setAttribute('data-active-view', view);
    document.querySelectorAll('[data-view-btn]').forEach(function (b) { b.classList.toggle('is-active', b.getAttribute('data-view-btn') === view); });
  }
  document.querySelectorAll('[data-view-btn]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var view = btn.getAttribute('data-view-btn');
      setActiveView(view);
      if (history.replaceState) history.replaceState(null, '', '#' + view);
    });
  });
  if (viewsEl) {
    var initialView = (location.hash || '').replace('#', '');
    if (initialView && document.querySelector('[data-view-btn="' + initialView + '"]')) setActiveView(initialView);
  }

  /* AI at WRMK: "try it yourself" before/after demo tabs */
  document.querySelectorAll('.wrmk-v3-aidemo__tab').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var demo = btn.closest('.wrmk-v3-aidemo');
      var i = btn.getAttribute('data-aidemo-btn');
      demo.querySelectorAll('.wrmk-v3-aidemo__tab').forEach(function (b) { b.classList.toggle('is-active', b === btn); });
      demo.querySelectorAll('.wrmk-v3-aidemo__panel').forEach(function (p) { p.classList.toggle('is-active', p.getAttribute('data-aidemo-panel') === i); });
    });
  });

  /* Our people: role / office / practice-area filters */
  var peopleGrid = document.querySelector('.wrmk-v3-staff-grid');
  if (peopleGrid) {
    var roleSelect = document.getElementById('people-filter-role');
    var officeSelect = document.getElementById('people-filter-office');
    var serviceLinks = document.querySelectorAll('.wrmk-v3-staff-filters a');
    var peopleCards = peopleGrid.querySelectorAll('.wrmk-v3-staff-card');
    var activeService = 'all';

    function slugify(str) {
      return (str || '').toLowerCase().trim()
        .replace(/[āăą]/g, 'a').replace(/[ēĕėęě]/g, 'e').replace(/[īĭįı]/g, 'i')
        .replace(/[ōŏő]/g, 'o').replace(/[ūŭůűų]/g, 'u')
        .replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
    }

    function cardRoleSlug(card) {
      var el = card.querySelector('.wrmk-v3-staff-card__role');
      var slug = slugify(el ? el.textContent : '');
      return slug.indexOf('legal-executive') !== -1 ? 'legal-executive' : slug;
    }

    function cardOfficeSlugs(card) {
      var el = card.querySelector('.wrmk-v3-staff-card__office');
      var text = el ? el.textContent : '';
      return text.split(',').map(slugify);
    }

    function applyPeopleFilters() {
      var role = roleSelect ? roleSelect.value : '';
      var office = officeSelect ? officeSelect.value : '';
      peopleCards.forEach(function (card) {
        var okRole = !role || cardRoleSlug(card) === role;
        var okOffice = !office || cardOfficeSlugs(card).indexOf(office) !== -1;
        var services = (card.getAttribute('data-services') || '').split(' ').filter(Boolean);
        var okService = activeService === 'all' || services.indexOf(activeService) !== -1;
        card.style.display = (okRole && okOffice && okService) ? '' : 'none';
      });
    }

    if (roleSelect) roleSelect.addEventListener('change', applyPeopleFilters);
    if (officeSelect) officeSelect.addEventListener('change', applyPeopleFilters);
    serviceLinks.forEach(function (link) {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        activeService = link.getAttribute('data-filter');
        serviceLinks.forEach(function (l) { l.classList.toggle('is-active', l === link); });
        applyPeopleFilters();
      });
    });

    function applyRoleFromHash() {
      var roleHashMatch = /role=([a-z-]+)/.exec(location.hash);
      if (roleSelect) {
        if (roleHashMatch && roleSelect.querySelector('option[value="' + roleHashMatch[1] + '"]')) {
          roleSelect.value = roleHashMatch[1];
        } else if (!roleHashMatch) {
          roleSelect.value = '';
        }
      }
      applyPeopleFilters();
    }

    window.addEventListener('hashchange', applyRoleFromHash);
    applyRoleFromHash();
  }

  /* Testimonials filter */
  document.querySelectorAll('[data-tfilter]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      document.querySelectorAll('[data-tfilter]').forEach(function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
    });
  });

  /* News archive: filter by category, year and month, then paginate the
     matching results at a visitor-chosen page size (10/30/100, default 10) --
     showing all ~300+ articles on one page at once was overwhelming. */
  var newsList = document.querySelector('.wrmk-v3-news-list');
  if (newsList) {
    var newsYearSelect = document.getElementById('news-filter-year');
    var newsMonthSelect = document.getElementById('news-filter-month');
    var newsPageSizeSelect = document.getElementById('news-page-size');
    var newsPaginationEl = document.getElementById('news-pagination');
    var newsCategoryLinks = document.querySelectorAll('.wrmk-v3-newscategories a');
    var newsItems = Array.prototype.slice.call(newsList.querySelectorAll('.wrmk-v3-news-item'));
    var activeNewsTag = 'all';
    var newsCurrentPage = 1;

    function matchingNewsItems() {
      var year = newsYearSelect ? newsYearSelect.value : '';
      var month = newsMonthSelect ? newsMonthSelect.value : '';
      return newsItems.filter(function (item) {
        var okTag = activeNewsTag === 'all' || item.getAttribute('data-tag') === activeNewsTag;
        var okYear = !year || item.getAttribute('data-year') === year;
        var okMonth = !month || item.getAttribute('data-month') === month;
        return okTag && okYear && okMonth;
      });
    }

    function renderNewsPage() {
      var matches = matchingNewsItems();
      var pageSize = newsPageSizeSelect ? parseInt(newsPageSizeSelect.value, 10) : 10;
      var totalPages = Math.max(1, Math.ceil(matches.length / pageSize));
      if (newsCurrentPage > totalPages) newsCurrentPage = totalPages;
      var start = (newsCurrentPage - 1) * pageSize;
      var visible = matches.slice(start, start + pageSize);

      newsItems.forEach(function (item) { item.style.display = 'none'; });
      visible.forEach(function (item) { item.style.display = ''; });

      if (newsPaginationEl) {
        if (totalPages <= 1) {
          newsPaginationEl.innerHTML = '';
        } else {
          var html = '';
          for (var p = 1; p <= totalPages; p++) {
            html += '<a href="#" data-news-page="' + p + '"' + (p === newsCurrentPage ? ' class="is-active"' : '') + '>' + p + '</a>';
          }
          newsPaginationEl.innerHTML = html;
        }
      }
    }

    function applyNewsFilters() {
      newsCurrentPage = 1;
      renderNewsPage();
    }

    if (newsYearSelect) newsYearSelect.addEventListener('change', applyNewsFilters);
    if (newsMonthSelect) newsMonthSelect.addEventListener('change', applyNewsFilters);
    if (newsPageSizeSelect) newsPageSizeSelect.addEventListener('change', applyNewsFilters);
    newsCategoryLinks.forEach(function (link) {
      link.addEventListener('click', function (e) {
        e.preventDefault();
        activeNewsTag = link.getAttribute('data-nfilter');
        newsCategoryLinks.forEach(function (l) { l.classList.toggle('is-active', l === link); });
        applyNewsFilters();
      });
    });
    if (newsPaginationEl) {
      newsPaginationEl.addEventListener('click', function (e) {
        var link = e.target.closest ? e.target.closest('[data-news-page]') : null;
        if (!link) return;
        e.preventDefault();
        newsCurrentPage = parseInt(link.getAttribute('data-news-page'), 10);
        renderNewsPage();
        newsList.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    }

    renderNewsPage();
  }
})();
