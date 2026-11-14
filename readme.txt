=== Wax Store ===
Contributors: dsweb73
Requires at least: 6.7
Tested up to: 7.1
Requires PHP: 7.4
Version: 1.0.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A block theme for record shops: covers first, bin dividers for sections and the artist index, round price stickers.

== Description ==

Wax Store is made for record shops and second-hand music dealers selling vinyl, CDs, cassettes and merchandise.

* Covers take center stage, square and uncropped.
* Section titles look like the plastic dividers of a record bin ("Bin divider" style for the Group block).
* Prices sit on round stickers, like the ones on the shrink wrap.
* Posts without a featured image show a stylized record in the post grids (blog, archives, search), with the same shape as a real image. With the Wax Store Catalog plugin, releases without a photo get the same record.
* Two style variations: Default (light, sleeve grey) and Vinyl (dark).
* Patterns: shop welcome, bin divider, practical information.

The theme works on its own for a shop blog and pages. For the catalog (releases, copies for sale, Goldmine grading, format and genre filters, A to Z artist index), install the free Wax Store Catalog plugin.

== Frequently Asked Questions ==

= How do I change colors and fonts? =

Go to Appearance > Editor > Styles. The palette and both font families can be changed there, or switch to the Vinyl style variation.

== Recommended plugin ==

Wax Store is designed together with the Wax Store Catalog plugin, which adds the record shop catalog: release pages with copies and grading, artist index, filters and search, Discogs import, reservations, alerts and labels. The theme works without it as a regular block theme; a dismissible notice in the Dashboard suggests installing it.

== Privacy ==

Wax Store does not collect, store or send any personal data, and makes no request to external services: fonts and images are bundled with the theme.

The only data the theme stores is a user meta flag, waxstore_dismiss_catalog_notice, saved when an administrator dismisses the notice recommending the Wax Store Catalog plugin. It stays in the site database and never leaves the site.

== Fonts and languages ==

The fonts are bundled as subsets, each declared with its own unicode-range, so browsers only download the subsets a page needs:

* Archivo: Latin, Latin Extended and Vietnamese, upright and italic. Archivo has no Cyrillic or Greek characters; text in these scripts falls back to Archivo Narrow, Roboto Condensed, Arial Narrow, Helvetica Neue or Arial, whichever is installed.
* Source Serif 4: Latin, Latin Extended, Cyrillic, Cyrillic Extended, Greek and Vietnamese, upright and italic.

== Upgrade Notice ==

= 1.0.6 =
The header menu button now shows on tablets, phones held sideways and touch screens, where submenus could not open. Long preformatted text no longer widens the page.

= 1.0.5 =
Posts without a featured image show a stylized record in the grids; styled pagination; a lighter header and footer; pages and posts line up with the site title on wide screens.

= 1.0.4 =
The "Bin divider" block style gets a prefixed name; sections created with earlier versions keep their look. No other visual change.

= 1.0.3 =
Adds the copyright notice to the stylesheet header. No visual change.

= 1.0.2 =
New theme screenshot. No visual change.

= 1.0.1 =
Fonts now cover Latin Extended, Vietnamese, and for Source Serif 4 Cyrillic and Greek; Archivo italic added. Better contrast in the Vinyl style variation.

== Changelog ==

= 1.0.6 =
* Header menu: the menu button is used up to 1200px wide and on every touch screen, where hover menus cannot open submenus. The menu panel takes the colors of the style variation.
* Preformatted text, code and tables scroll inside their own box instead of widening the page on phones; long words and links break in posts and comments.

= 1.0.5 =
* Post grids (blog, archives, search): posts without a featured image show a stylized record with the same ratio, radius and link as a real image. Its colors follow the style variation.
* Pagination of post lists and comments: spacing, gap between items, clear current page, hover and focus states, wraps on phones.
* Header: site title and tagline grouped, a thin line under the header, the menu wraps from the left edge when it is too long.
* Footer: its own short navigation (home and privacy policy page) and a search field, instead of repeating the header menu or listing every page.
* Single posts, pages and 404: the reading column starts on the left edge of the wide area, in line with the site title; wide and full blocks keep their alignment.
* Archive descriptions and the search field on search results keep a reading width.
* Comments: author and date on one line, a separator between comments.
* Short pages: the footer stays at the bottom of the window.

= 1.0.4 =
* Copyright notice in the stylesheet header in the standard form.
* Font licence files replaced by the upstream OFL texts (Omnibus-Type/Archivo and adobe-fonts/source-serif); readme copyright lines match them.
* Block style renamed from "divider" to "wax-store-divider"; the old class keeps its styles for content saved earlier.
* Translations: load_theme_textdomain() added; translation template regenerated.
* readme: upgrade notice headings fixed, changelog completed.

= 1.0.3 =
* Copyright notice added to the stylesheet header.
* "custom-colors" tag removed.

= 1.0.2 =
* New screenshot: the theme alone, with fictional content.

= 1.0.1 =
* Fonts: every Fontsource subset bundled with its unicode-range (Latin Extended, Vietnamese, and Cyrillic and Greek for Source Serif 4); Archivo italic added; stronger fallback fonts.
* Vinyl style variation: sold sticker text and invalid field borders meet WCAG contrast.
* Direct access guard in pattern files; no inline style in the admin notice; translation template regenerated.
* readme: privacy, upgrade notice and detailed resources.

= 1.0.0 =
* First release on WordPress.org.
* The plugin notice links to the Wax Store Catalog page on WordPress.org.
* Translations come from WordPress.org language packs; bundled translation files removed.
* New screenshot.

= 0.2.2 =
* Fix: wide sections in pages (home page catalog, hero) were held in the reading column; they now extend to the wide size, aligned with the header.

= 0.2.1 =
* Fix: header and footer side margins, which some setups did not apply.

= 0.2.0 =
* Dismissible notice recommending the Wax Store Catalog plugin (Dashboard and Themes screens, administrators only).

= 0.1.12 =
* WordPress.org contributor.

= 0.1.11 =
* Theme and author addresses.

= 0.1.10 =
* Tested up to WordPress 7.1.

= 0.1.9 =
* The catalog plugin now draws its own stickers and placeholders; the theme sets their colors through the --waxsc-* variables.

= 0.1.8 =
* Styles for the catalog keyword search field.

= 0.1.7 =
* Styles for the add-to-cart form of the catalog plugin (WooCommerce mode).

= 0.1.6 =
* Styles for the shop opening status block of the catalog plugin.

= 0.1.5 =
* Styles for the reservation form and the per-copy Reserve buttons of the catalog plugin.

= 0.1.4 =
* Price stickers stay round: fixed size, "From" in small type above the amount.

= 0.1.3 =
* French translation included: patterns, palette, templates and style variation names.

= 0.1.2 =
* Fix: catalog blocks, headings and artist names inside page content use Archivo; only long text uses the serif.
* Fix: bin divider tabs stay left-aligned in centered layouts.
* New "Page without title" template, for a home page built with blocks.

= 0.1.1 =
* The record placeholder for releases without a photo now comes from the catalog plugin and works in every query loop; the theme gives it its colors.

= 0.1.0 =
* First development version.

== Copyright ==

Wax Store WordPress Theme, Copyright 2026 DS-Web.
Wax Store is distributed under the terms of the GNU General Public License v2 or later.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

== Resources ==

Fonts. The .woff2 files are unmodified copies of the subset files published by Fontsource (https://fontsource.org), which builds them from the upstream font repositories. No subsetting or other change was made by DS-Web.

* Archivo
  Files: assets/fonts/archivo-latin-ext-standard-italic.woff2, assets/fonts/archivo-latin-ext-standard-normal.woff2, assets/fonts/archivo-latin-standard-italic.woff2, assets/fonts/archivo-latin-standard-normal.woff2, assets/fonts/archivo-vietnamese-standard-italic.woff2, assets/fonts/archivo-vietnamese-standard-normal.woff2
  Author: The Archivo Project Authors (Omnibus-Type)
  Copyright notice: Copyright 2020 The Archivo Project Authors (https://github.com/Omnibus-Type/Archivo)
  License: SIL Open Font License, Version 1.1 (https://openfontlicense.org), full text in assets/fonts/OFL-Archivo.txt
  Upstream source: https://github.com/Omnibus-Type/Archivo
  Package: @fontsource-variable/archivo 5.3.0, https://www.npmjs.com/package/@fontsource-variable/archivo (files from https://github.com/fontsource/font-files)

* Source Serif 4
  Files: assets/fonts/source-serif-4-cyrillic-ext-standard-italic.woff2, assets/fonts/source-serif-4-cyrillic-ext-standard-normal.woff2, assets/fonts/source-serif-4-cyrillic-standard-italic.woff2, assets/fonts/source-serif-4-cyrillic-standard-normal.woff2, assets/fonts/source-serif-4-greek-standard-italic.woff2, assets/fonts/source-serif-4-greek-standard-normal.woff2, assets/fonts/source-serif-4-latin-ext-standard-italic.woff2, assets/fonts/source-serif-4-latin-ext-standard-normal.woff2, assets/fonts/source-serif-4-latin-standard-italic.woff2, assets/fonts/source-serif-4-latin-standard-normal.woff2, assets/fonts/source-serif-4-vietnamese-standard-italic.woff2, assets/fonts/source-serif-4-vietnamese-standard-normal.woff2
  Author: Frank Grießhammer, Adobe
  Copyright notice: Copyright 2014 - 2023 Adobe (http://www.adobe.com/), with Reserved Font Name ‘Source’. All Rights Reserved. Source is a trademark of Adobe in the United States and/or other countries.
  License: SIL Open Font License, Version 1.1 (https://openfontlicense.org), full text in assets/fonts/OFL-Source-Serif-4.txt
  Upstream source: https://github.com/adobe-fonts/source-serif
  Package: @fontsource-variable/source-serif-4 5.3.1, https://www.npmjs.com/package/@fontsource-variable/source-serif-4 (files from https://github.com/fontsource/font-files)

* License files
  assets/fonts/OFL-Archivo.txt: copy of OFL.txt from https://github.com/Omnibus-Type/Archivo
  assets/fonts/OFL-Source-Serif-4.txt: copy of LICENSE.md from https://github.com/adobe-fonts/source-serif (release branch)

* Screenshot
  File: screenshot.png
  Author and copyright: DS-Web, 2026
  License: GPLv2 or later, same as the theme
  Content: the theme with fictional content created by DS-Web; the images are abstract illustrations generated by DS-Web, not real album art or photographs.
