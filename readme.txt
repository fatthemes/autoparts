=== Autoparts ===

Contributors: limestreet
Requires at least: 7.1
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: e-commerce, full-site-editing, block-patterns, custom-colors, featured-images, translation-ready, wide-blocks

A modern, accessible, block-based WordPress theme with native WooCommerce support, built for the automotive parts industry.

== Description ==

Autoparts is a full site editing block theme designed for automotive parts retailers. It includes native WooCommerce support with styled templates for the shop, single product, cart, checkout and account pages, along with block patterns for building a store homepage.

The theme uses WooCommerce blocks throughout rather than classic templates, and all styling is applied through CSS files and theme.json presets.

== Installation ==

1. In your WordPress admin, go to Appearance > Themes and click Add New.
2. Click Upload Theme and select the theme zip file.
3. Click Install Now, then Activate.
4. Install and activate WooCommerce to enable the shop templates.

== Recommended Plugins ==

WooCommerce is required for the shop, cart, checkout, product and account templates to function.

Contact Form 7 is recommended if you wish to add a newsletter signup form to the footer or a contact form to your pages. The theme includes styles for Contact Form 7 forms.

== Frequently Asked Questions ==

= How do I add the newsletter form to the footer? =

1. Install and activate Contact Form 7. The theme recommends it under Appearance > Install Plugins.
2. Go to Contact > Add New and replace the form template with this code, all on one line:
`<label for="newsletter-email" class="screen-reader-text">Email address</label> [email* your-email id:newsletter-email autocomplete:email placeholder "example@gmail.com"] [submit "Submit"]`
3. Save the form and copy its shortcode.
4. Go to Appearance > Editor > Patterns > Template Parts > Footer. In the Newsletter column, add a Shortcode block after the "Stay updated on new arrivals." paragraph, paste the shortcode and save.

The theme styles this form as a single email field and button bar.

= Does this theme require WooCommerce? =

The theme works without WooCommerce, but the shop, cart, checkout, single product and account templates require it. Block patterns that display products or product categories will not appear unless WooCommerce is active.

= How do I change the colours? =

Go to Appearance > Editor > Styles > Colors to edit the theme palette.

== Changelog ==

= 1.0.0 =
* First stable release.

= 0.1.0 =
* Initial release.

== Copyright ==

Autoparts WordPress Theme, (C) 2026 Lime Street
Autoparts is distributed under the terms of the GNU GPL v2 or later.

This theme bundles the following third-party resources:

Inter font
Copyright (c) 2016-2020 The Inter Project Authors
License: SIL Open Font License, 1.1
License URI: https://scripts.sil.org/OFL
Source: https://fonts.google.com/specimen/Inter

TGM Plugin Activation, by Thomas Griffin, Gary Jones, Juliette Reinders Folmer
Copyright (c) 2011 Thomas Griffin
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Source: https://github.com/TGMPA/TGM-Plugin-Activation

Space Grotesk font
Copyright (c) 2020 Florian Karsten
License: SIL Open Font License, 1.1
License URI: https://scripts.sil.org/OFL
Source: https://fontsource.org/fonts/space-grotesk

hero.png
"Gears on Tide Predicting Machine No. 2" by scattered1
License: CC0 1.0 Universal
License URI: https://creativecommons.org/publicdomain/zero/1.0/
Source: https://openverse.org/image/b599eef7-03de-4a39-a432-ff2a3f41cd29

Buick 8 Engine (used in screenshot only)
"Buick 8 Engine Hirschaid-20220709-RM-104058" by Reinhold Möller
License: CC BY-SA 4.0
License URI: https://creativecommons.org/licenses/by-sa/4.0/
Source: https://commons.wikimedia.org/wiki/File:Buick_8_Engine_Hirschaid-20220709-RM-104058.jpg

Disc Brake, Honda CBR 1000 (used in screenshot only)
"Disc brake of motorbike Honda CBR 1000 (2023)" by Reinhold Möller
License: CC BY-SA 4.0
License URI: https://creativecommons.org/licenses/by-sa/4.0/
Source: https://commons.wikimedia.org/wiki/File:Disc_brake_of_motorbike_Honda_CBR_1000_(2023).jpg

Ford Mustang Engine, 1968 (used in screenshot only)
"Ford Mustang engine 1968 Hirschaid 2022-20220709-RM-105733" by Reinhold Möller
License: CC BY-SA 4.0
License URI: https://creativecommons.org/licenses/by-sa/4.0/
Source: https://commons.wikimedia.org/wiki/File:Ford_Mustang_engine_1968_Hirschaid_2022-20220709-RM-105733.jpg

The following assets are original works created for this theme by Lime Street,
and are licensed under the GNU General Public License v2 or later:

assets/images/404-image.png
assets/images/cta-pattern.png
assets/images/icons/search.svg
assets/images/icons/dashboard.png
assets/images/icons/orders.png
assets/images/icons/download.png
assets/images/icons/address.png
assets/images/icons/account.png
assets/images/icons/logout.png
