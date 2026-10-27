<?php
/**
 * Wax Store demo: shop settings, pages and about thirty releases.
 * Run once by the Playground blueprint (runPHP step), after the theme and
 * the Wax Store Catalog plugin are installed and active.
 *
 * Covers are abstract images generated for this demo: no artwork of real
 * releases is used.
 *
 * @package WaxStoreDemo
 */

use WaxStore\Catalog\Alerts\Alerts;
use WaxStore\Catalog\Buying\Offers;
use WaxStore\Catalog\Content\Taxonomies;
use WaxStore\Catalog\Reservation\Requests;

if ( ! class_exists( Taxonomies::class ) ) {
	return;
}

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

wp_set_current_user( 1 );

$waxsc_demo_dir = __DIR__;

update_option( 'permalink_structure', '/%postname%/' );
update_option( 'blogname', 'Le Bac à Vinyles' );
update_option( 'blogdescription', 'Disquaire indépendant – démonstration de Wax Store' );
update_option( 'timezone_string', 'Europe/Paris' );

/* Pages ------------------------------------------------------------------ */

$waxsc_demo_page = static function ( string $title, string $slug, string $content, int $order ): int {
	$existing = get_page_by_path( $slug );

	if ( $existing ) {
		return (int) $existing->ID;
	}

	return (int) wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'menu_order'   => $order,
		)
	);
};

$waxsc_home = $waxsc_demo_page(
	'Accueil',
	'accueil',
	'<!-- wp:pattern {"slug":"wax-store/shop-intro"} /-->' . "\n"
	. '<!-- wp:pattern {"slug":"wax-store-catalog/latest-arrivals"} /-->' . "\n"
	. '<!-- wp:group {"className":"is-style-divider","layout":{"type":"constrained"}} --><div class="wp-block-group is-style-divider">'
	. '<!-- wp:heading --><h2 class="wp-block-heading">Venir à la boutique</h2><!-- /wp:heading -->'
	. '<!-- wp:columns --><div class="wp-block-columns">'
	. '<!-- wp:column --><div class="wp-block-column"><!-- wp:waxsc/shop-status {"showWeek":true} /--></div><!-- /wp:column -->'
	. '<!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Vendre vos disques</h3><!-- /wp:heading -->'
	. '<!-- wp:paragraph --><p>Nous rachetons les collections de toutes tailles. Apportez-les, ou décrivez-les-nous avec quelques photos.</p><!-- /wp:paragraph -->'
	. '<!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="' . esc_url( home_url( '/vendez-nous-vos-disques/' ) ) . '">Proposer mes disques</a></div><!-- /wp:button --></div><!-- /wp:buttons -->'
	. '</div><!-- /wp:column --></div><!-- /wp:columns --></div><!-- /wp:group -->',
	0
);
update_post_meta( $waxsc_home, '_wp_page_template', 'page-no-title' );
$waxsc_reserve = $waxsc_demo_page( 'Réserver un disque', 'reserver', '<!-- wp:paragraph --><p>Un disque vous intéresse ? Réservez-le, nous le gardons de côté 7 jours.</p><!-- /wp:paragraph -->' . "\n" . '<!-- wp:waxsc/reservation-form /-->', 3 );
$waxsc_sell    = $waxsc_demo_page( 'Vendez-nous vos disques', 'vendez-nous-vos-disques', '<!-- wp:paragraph --><p>Nous rachetons disques et collections de toutes tailles. Parlez-nous des vôtres : nous répondons à chaque proposition.</p><!-- /wp:paragraph -->' . "\n" . '<!-- wp:waxsc/sell-form /-->', 4 );
$waxsc_info    = $waxsc_demo_page( 'Infos pratiques', 'infos-pratiques', '<!-- wp:waxsc/shop-status {"showWeek":true} /-->', 5 );
$waxsc_legal   = $waxsc_demo_page( 'Mentions légales', 'mentions-legales', '<!-- wp:shortcode -->[waxsc_legal_notice]<!-- /wp:shortcode -->', 9 );

// Menu: the catalog archive is not a page, so it needs an explicit link.
if ( ! get_posts( array( 'post_type' => 'wp_navigation', 'numberposts' => 1, 'post_status' => 'publish' ) ) ) {
	$waxsc_link = static function ( string $label, int $page ): string {
		return '<!-- wp:navigation-link {"label":"' . $label . '","type":"page","id":' . $page . ',"url":"' . esc_url( get_permalink( $page ) ) . '","kind":"post-type"} /-->';
	};

	wp_insert_post(
		array(
			'post_type'    => 'wp_navigation',
			'post_status'  => 'publish',
			'post_title'   => 'Menu principal',
			'post_content' => $waxsc_link( 'Accueil', $waxsc_home )
				. '<!-- wp:navigation-link {"label":"Catalogue","url":"' . esc_url( (string) get_post_type_archive_link( 'waxsc_release' ) ) . '","kind":"custom"} /-->'
				. $waxsc_link( 'Réserver', $waxsc_reserve )
				. $waxsc_link( 'Vendre vos disques', $waxsc_sell )
				. $waxsc_link( 'Infos pratiques', $waxsc_info ),
		)
	);
}

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $waxsc_home );
update_option( 'waxsc_reserve_page', $waxsc_reserve );
update_option( 'waxsc_sell_page', $waxsc_sell );

/* Shop settings ------------------------------------------------------------ */

update_option(
	'waxsc_shop',
	array(
		'identity' => array(
			'owner_type' => 'pro',
			'shop_name'  => 'Le Bac à Vinyles',
			'owner_name' => 'Camille Démo',
			'legal_name' => 'Le Bac à Vinyles SARL',
			'legal_form' => 'SARL',
		),
		'contact'  => array(
			'street'      => '12 rue des Microsillons',
			'postal_code' => '75011',
			'city'        => 'Paris',
			'country'     => 'FR',
			'phone'       => '01 23 45 67 89',
			'email'       => 'contact@example.com',
			'hours'       => array(
				'mon' => '',
				'tue' => '11:00-19:00',
				'wed' => '11:00-19:00',
				'thu' => '11:00-19:00',
				'fri' => '11:00-19:30',
				'sat' => '10:00-13:00,14:00-20:00',
				'sun' => '',
			),
		),
		'legal'    => array(
			'registration_number'  => '000 000 000',
			'registry'             => 'RCS Paris',
			'publication_director' => 'Camille Démo',
			'legal_page'           => $waxsc_legal,
		),
		'host'     => array(
			'host_name' => 'Hébergeur de démonstration',
		),
	)
);

update_option( 'waxsc_commerce_provider', 'showcase' );
update_option( 'waxsc_sold_items', 'show' );
update_option( 'waxsc_grading', 'goldmine' );

/* Releases ------------------------------------------------------------------ */

/**
 * Term ID of a reference term (format, condition, edition, feature) by key.
 */
$waxsc_key = static function ( string $taxonomy, string $key ): int {
	return Taxonomies::find_by_key( $taxonomy, $key );
};

/**
 * Genre, and style as a child genre.
 */
$waxsc_genre = static function ( string $genre, string $style = '' ): array {
	$parent = term_exists( $genre, Taxonomies::GENRE, 0 );
	$parent = $parent ? (int) $parent['term_id'] : (int) wp_insert_term( $genre, Taxonomies::GENRE )['term_id'];

	if ( '' === $style ) {
		return array( $parent );
	}

	$child = term_exists( $style, Taxonomies::GENRE, $parent );
	$child = $child ? (int) $child['term_id'] : (int) wp_insert_term( $style, Taxonomies::GENRE, array( 'parent' => $parent ) )['term_id'];

	return array( $parent, $child );
};

/**
 * Attachment from a demo cover file.
 */
$waxsc_image = static function ( string $file, int $post_id, string $alt ) use ( $waxsc_demo_dir ): int {
	$source = $waxsc_demo_dir . '/covers/' . $file;

	if ( ! file_exists( $source ) ) {
		return 0;
	}

	$tmp = wp_tempnam( $file );
	copy( $source, $tmp );
	$id = media_handle_sideload(
		array(
			'name'     => sanitize_title( $alt ) . '.jpg',
			'tmp_name' => $tmp,
		),
		$post_id,
		$alt
	);

	if ( is_wp_error( $id ) ) {
		return 0;
	}

	update_post_meta( $id, '_wp_attachment_image_alt', $alt );

	return (int) $id;
};

$waxsc_find = static function ( string $title ) {
	$found = get_posts(
		array(
			'post_type'   => 'waxsc_release',
			'post_status' => 'any',
			'title'       => $title,
			'numberposts' => 1,
		)
	);

	return $found ? $found[0] : null;
};

$waxsc_tracks = static function ( array $lines ): array {
	$tracks = array();

	foreach ( $lines as $line ) {
		$tracks[] = array_combine( array( 'position', 'title', 'duration' ), $line );
	}

	return $tracks;
};

// artist, title, format, year, country, label, catno, genre, style, condition, edition, features, copies, cover, extras.
$waxsc_releases = array(
	array( 'Pink Floyd', 'Meddle', 'vinyl-lp', 1971, 'UK', 'Harvest', 'SHVL 795', 'Rock', 'Rock psychédélique', 'used', 'original', array( 'gatefold' ), array( array( 'VG+', 'VG+', '35' ), array( 'G+', 'VG', '25', 'in_stock', 1, 'Sticker de prix au dos' ) ), '01.jpg', array(
		'pressing' => 'Pressage UK 1971, pochette ouvrante texturée',
		'tracks'   => array( array( 'A1', 'One Of These Days', '5:57' ), array( 'A2', 'A Pillow Of Winds', '5:10' ), array( 'A3', 'Fearless', '6:08' ), array( 'A4', 'San Tropez', '3:43' ), array( 'A5', 'Seamus', '2:15' ), array( 'B1', 'Echoes', '23:31' ) ),
		'gallery'  => array( '02-back.jpg', '02-label.jpg' ),
	) ),
	array( 'Miles Davis', 'Kind Of Blue', 'vinyl-lp', 1959, 'US', 'Columbia', '', 'Jazz', 'Jazz modal', 'used', 'original', array(), array( array( 'VG', 'VG', '45' ) ), '02.jpg', array(
		'tracks' => array( array( 'A1', 'So What', '9:22' ), array( 'A2', 'Freddie Freeloader', '9:46' ), array( 'A3', 'Blue In Green', '5:37' ), array( 'B1', 'All Blues', '11:33' ), array( 'B2', 'Flamenco Sketches', '9:26' ) ),
	) ),
	array( 'Serge Gainsbourg', 'Histoire de Melody Nelson', 'vinyl-lp', 2011, 'France', 'Mercury', '', 'Chanson', '', 'new', 'reissue', array( '180g', 'gatefold' ), array( array( 'M', 'M', '29', 'in_stock', 3 ) ), '03.jpg' ),
	array( 'Daft Punk', 'Homework', 'vinyl-lp', 1997, 'France', 'Virgin', '', 'Électronique', 'House', 'used', 'original', array(), array( array( 'NM', 'VG+', '60' ) ), '04.jpg' ),
	array( 'Air', 'Moon Safari', 'cd', 1998, 'France', 'Source', '', 'Électronique', 'Downtempo', 'used', 'original', array(), array( array( 'VG+', 'VG+', '8' ) ), '05.jpg' ),
	array( 'Nirvana', 'Nevermind', 'cd', 1991, 'US', 'DGC', '', 'Rock', 'Grunge', 'used', 'original', array(), array( array( 'VG', 'VG', '6', 'sold', 0 ) ), '06.jpg' ),
	array( 'Bob Marley & The Wailers', 'Exodus', 'vinyl-lp', 1977, 'UK', 'Island Records', '', 'Reggae', 'Roots', 'used', 'original', array(), array( array( 'VG+', 'VG', '30', 'reserved', 1 ) ), '07.jpg' ),
	array( 'Kraftwerk', 'Autobahn', 'vinyl-lp', 1974, 'Allemagne', 'Philips', '', 'Électronique', 'Krautrock', 'used', 'original', array(), array( array( 'VG', 'VG-', '40' ) ), '08.jpg' ),
	array( 'Massive Attack', 'Mezzanine', 'vinyl-lp', 2018, 'UK', 'Virgin', '', 'Électronique', 'Trip hop', 'new', 'reissue', array( 'colored', 'limited' ), array( array( 'M', 'M', '32', 'in_stock', 2 ) ), '09.jpg' ),
	array( 'Portishead', 'Dummy', 'cassette', 1994, 'UK', 'Go! Beat', '', 'Électronique', 'Trip hop', 'used', 'original', array(), array( array( 'VG+', '', '12' ) ), '10.jpg' ),
	array( 'Téléphone', 'Dure limite', 'vinyl-lp', 1982, 'France', 'Pathé Marconi EMI', '', 'Rock', 'Rock français', 'used', 'original', array(), array( array( 'VG', 'VG', '15' ) ), '11.jpg' ),
	array( 'Noir Désir', 'Tostaky', 'cd', 1992, 'France', 'Barclay', '', 'Rock', 'Rock français', 'used', 'original', array(), array( array( 'VG+', 'VG+', '7' ) ), '12.jpg' ),
	array( 'IAM', "L'École du micro d'argent", 'vinyl-lp', 1997, 'France', 'Delabel', '', 'Hip-hop', '', 'used', 'original', array(), array( array( 'VG+', 'VG+', '90' ) ), '13.jpg' ),
	array( 'Françoise Hardy', 'Tous les garçons et les filles', 'vinyl-single', 1962, 'France', 'Disques Vogue', '', 'Chanson', 'Yéyé', 'used', 'original', array(), array( array( 'VG', 'G+', '18' ) ), '14.jpg' ),
	array( 'Jacques Brel', 'Les Marquises', 'vinyl-lp', 1977, 'France', 'Barclay', '', 'Chanson', '', 'used', 'original', array(), array( array( 'VG+', 'VG+', '20' ) ), '15.jpg' ),
	array( 'David Bowie', 'The Rise And Fall Of Ziggy Stardust And The Spiders From Mars', 'vinyl-lp', 1972, 'UK', 'RCA Victor', '', 'Rock', 'Glam rock', 'used', 'original', array(), array( array( 'VG', 'VG', '55' ) ), '16.jpg' ),
	array( 'Led Zeppelin', 'Led Zeppelin IV', 'vinyl-lp', 1971, 'UK', 'Atlantic', '', 'Rock', 'Hard rock', 'used', 'original', array(), array( array( 'G+', 'G+', '22' ) ), '17.jpg' ),
	array( 'Fleetwood Mac', 'Rumours', 'vinyl-lp', 1977, 'US', 'Warner Bros. Records', '', 'Rock', 'Pop rock', 'used', 'original', array(), array( array( 'VG+', 'VG+', '25' ), array( 'VG', 'VG', '18' ) ), '18.jpg' ),
	array( 'Marvin Gaye', "What's Going On", 'vinyl-lp', 1971, 'US', 'Tamla', '', 'Funk / Soul', 'Soul', 'used', 'original', array( 'gatefold' ), array( array( 'VG', 'VG', '40' ) ), '19.jpg' ),
	array( 'Björk', 'Homogenic', 'cd', 1997, 'UK', 'One Little Indian', '', 'Électronique', '', 'used', 'original', array(), array( array( 'NM', 'NM', '10' ) ), '20.jpg' ),
	array( 'Radiohead', 'OK Computer', 'vinyl-lp', 1997, 'UK', 'Parlophone', '', 'Rock', 'Rock alternatif', 'used', 'original', array( 'gatefold' ), array( array( 'VG+', 'VG+', '120' ) ), '21.jpg' ),
	array( 'Nina Simone', 'Pastel Blues', 'vinyl-lp', 1965, 'US', 'Philips', '', 'Jazz', 'Soul jazz', 'used', 'original', array(), array( array( 'VG', 'VG', '35' ) ), '22.jpg' ),
	array( 'The Clash', 'London Calling', 'vinyl-lp', 1979, 'UK', 'CBS', '', 'Rock', 'Punk', 'used', 'original', array(), array( array( 'VG+', 'VG', '38' ) ), '23.jpg' ),
	array( 'Daft Punk', 'Around The World', 'vinyl-maxi', 1997, 'France', 'Virgin', '', 'Électronique', 'House', 'used', 'original', array(), array( array( 'VG+', 'VG', '15' ) ), '24.jpg' ),
	array( 'Serge Gainsbourg & Jane Birkin', "Je t'aime... moi non plus", 'vinyl-single', 1969, 'France', 'Fontana', '', 'Chanson', '', 'used', 'original', array(), array( array( 'VG', 'VG', '12' ) ), '25.jpg' ),
	array( 'Miles Davis', 'Bitches Brew', 'vinyl-lp', 1970, 'US', 'Columbia', '', 'Jazz', 'Jazz fusion', 'used', 'original', array( 'gatefold' ), array( array( 'VG', 'VG', '50', 'sold', 0 ) ), '26.jpg' ),
	array( 'The Cure', 'Disintegration', 'vinyl-lp', 1989, 'UK', 'Fiction Records', '', 'Rock', 'New wave', 'used', 'original', array(), array( array( 'VG', 'VG', '35' ) ), '' ),
	array( 'Joy Division', 'Unknown Pleasures', 'vinyl-lp', 2015, 'UK', 'Factory', '', 'Rock', 'Post-punk', 'new', 'reissue', array( '180g' ), array( array( 'M', 'M', '27', 'in_stock', 2 ) ), '' ),
	array( 'Kraftwerk', 'Trans Europa Express', 'cd', 2009, 'Allemagne', 'Kling Klang', '', 'Électronique', 'Synth-pop', 'used', 'reissue', array(), array( array( 'NM', 'NM', '9' ) ), '27.jpg' ),
	array( 'Le Bac à Vinyles', 'T-shirt du magasin', 'merch-tshirt', 2026, 'France', '', '', '', '', 'new', '', array(), array( array( '', '', '20', 'in_stock', 4, '', 'Taille M' ), array( '', '', '20', 'in_stock', 2, '', 'Taille L' ) ), '28.jpg' ),
);

foreach ( $waxsc_releases as $index => $waxsc_r ) {
	list( $artist, $title, $format, $year, $country, $label, $catno, $genre, $style, $condition, $edition, $features, $copies, $cover ) = $waxsc_r;
	$extras = $waxsc_r[14] ?? array();

	if ( $waxsc_find( $title ) ) {
		continue;
	}

	$id = wp_insert_post(
		array(
			'post_type'    => 'waxsc_release',
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_content' => $extras['content'] ?? '',
			'post_date'    => gmdate( 'Y-m-d H:i:s', time() - ( count( $waxsc_releases ) - $index ) * 6 * HOUR_IN_SECONDS ),
		)
	);

	if ( ! $id || is_wp_error( $id ) ) {
		continue;
	}

	if ( '' !== $artist ) {
		wp_set_object_terms( $id, array( $artist ), Taxonomies::ARTIST );
	}

	if ( '' !== $label ) {
		wp_set_object_terms( $id, array( $label ), Taxonomies::LABEL );
	}

	wp_set_object_terms( $id, array( $country ), Taxonomies::COUNTRY );
	wp_set_object_terms( $id, array( $waxsc_key( Taxonomies::FORMAT, $format ) ), Taxonomies::FORMAT );
	wp_set_object_terms( $id, array( $waxsc_key( Taxonomies::CONDITION, $condition ) ), Taxonomies::CONDITION );

	if ( '' !== $edition ) {
		wp_set_object_terms( $id, array( $waxsc_key( Taxonomies::EDITION, $edition ) ), Taxonomies::EDITION );
	}

	if ( '' !== $genre ) {
		wp_set_object_terms( $id, $waxsc_genre( $genre, $style ), Taxonomies::GENRE );
	}

	if ( $features ) {
		wp_set_object_terms(
			$id,
			array_map(
				static function ( $feature ) use ( $waxsc_key ) {
					return $waxsc_key( Taxonomies::FEATURE, $feature );
				},
				$features
			),
			Taxonomies::FEATURE
		);
	}

	update_post_meta( $id, '_waxsc_year', $year );

	if ( '' !== $catno ) {
		update_post_meta( $id, '_waxsc_catalog_number', $catno );
	}

	if ( ! empty( $extras['pressing'] ) ) {
		update_post_meta( $id, '_waxsc_pressing_details', $extras['pressing'] );
	}

	if ( ! empty( $extras['tracks'] ) ) {
		update_post_meta( $id, '_waxsc_tracklist', $waxsc_tracks( $extras['tracks'] ) );
	}

	$items = array();

	foreach ( $copies as $copy ) {
		$items[] = array(
			'media'   => $copy[0],
			'sleeve'  => $copy[1],
			'price'   => $copy[2],
			'status'  => $copy[3] ?? 'in_stock',
			'qty'     => $copy[4] ?? 1,
			'note'    => $copy[5] ?? '',
			'variant' => $copy[6] ?? '',
		);
	}

	update_post_meta( $id, '_waxsc_copies', \WaxStore\Catalog\Content\Copies::sanitize( $items ) );

	$alt = trim( $artist . ' – ' . $title, ' –' );

	if ( '' !== $cover ) {
		$thumb = $waxsc_image( $cover, $id, $alt . ', pochette' );

		if ( $thumb ) {
			set_post_thumbnail( $id, $thumb );
		}
	}

	if ( ! empty( $extras['gallery'] ) ) {
		$gallery = array();

		foreach ( $extras['gallery'] as $photo ) {
			$gallery[] = $waxsc_image( $photo, $id, $alt . ', photo' );
		}

		update_post_meta( $id, '_waxsc_gallery', array_values( array_filter( $gallery ) ) );
	}

	wp_update_post( array( 'ID' => $id ) );
}

/* Customer requests, so the admin screens are not empty -------------------- */

$waxsc_meddle = $waxsc_find( 'Meddle' );

if ( $waxsc_meddle && ! get_posts( array( 'post_type' => Requests::POST_TYPE, 'numberposts' => 1, 'post_status' => 'any' ) ) ) {
	$waxsc_copy = get_post_meta( $waxsc_meddle->ID, '_waxsc_copies', true )[0]['id'] ?? '';

	Requests::create(
		array(
			'name'    => 'Alex Martin',
			'email'   => 'alex@example.com',
			'phone'   => '06 00 00 00 00',
			'message' => 'Bonjour, je peux passer le chercher samedi après-midi ?',
			'release' => $waxsc_meddle->ID,
			'copy'    => $waxsc_copy,
		)
	);

	$waxsc_artist = get_term_by( 'name', 'Pink Floyd', Taxonomies::ARTIST );

	if ( $waxsc_artist ) {
		$waxsc_alert = Alerts::create( 'collectionneur@example.com', Taxonomies::ARTIST, (int) $waxsc_artist->term_id );
		wp_update_post( array( 'ID' => $waxsc_alert, 'post_status' => 'publish' ) );
	}

	Offers::create(
		array(
			'name'    => 'Dominique Leroy',
			'email'   => 'dominique@example.com',
			'phone'   => '',
			'city'    => 'Melun',
			'size'    => '200-1000',
			'formats' => array( 'vinyl', 'cd' ),
			'genres'  => 'Rock, jazz, chanson française',
			'message' => 'La collection de mon père, des années 60 à 80, en bon état général. Beaucoup de pressages originaux.',
		),
		array()
	);
}

flush_rewrite_rules();
