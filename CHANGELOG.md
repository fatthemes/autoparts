# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Changed

- Renamed the theme from Autoparts to PartsStop; theme name, slug and text domain are now `partsstop`.
- PHP function prefix changed to `partsstop_`, constants to `PARTSSTOP_*`, script/style handles to `partsstop-*`, and the localized JS object to `partsstopData`.
- Block pattern namespace and category changed to `partsstop/`, and the copyright block binding source to `partsstop/copyright`.
- My Account login/register toggle classes renamed from `lime-account-toggle` to `partsstop-account-toggle`.
- TGM Plugin Activation library regenerated for the `partsstop` slug, with updated config id and menu slug.

## [1.0.0] - 2026-09-21

### Added

- Initial release.
- Full Site Editing (FSE) block theme with native WooCommerce support.
- Responsive header with mobile hamburger menu and search toggle.
- Homepage template with hero section, category grid, dealer banner, and featured products.
- Core templates: page, home, archive, single post with sidebar, search results, 404.
- WooCommerce templates: shop with filter sidebar, product archive, single product, cart, checkout, my account.
- Product search results template with filter sidebar.
- Block patterns: hero, category tile grid, CTA banner, featured products.
- Conditionally enqueued shop.css for WooCommerce pages.
- Mobile-first responsive design across all templates.
- WCAG 2.1 AA accessibility: skip link, keyboard navigation.
- Space Grotesk and Inter font families via local woff2 files.
- WooCommerce product filters: price, category, availability.
