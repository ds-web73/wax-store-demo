<?php
/**
 * Wax Store theme screenshot: the theme alone (no plugin), in English,
 * with fictional shop, artists and posts. Run by blueprint-theme.json.
 *
 * @package WaxStoreDemo
 */

require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

wp_set_current_user( 1 );

update_option( 'blogname', 'Northside Records' );
update_option( 'blogdescription', 'Independent record shop since 1998' );
update_option( 'permalink_structure', '/%postname%/' );

$waxsc_dir = __DIR__;

$waxsc_image = static function ( string $file, int $post_id, string $alt ) use ( $waxsc_dir ): int {
	$tmp = wp_tempnam( $file );
	copy( $waxsc_dir . '/covers/' . $file, $tmp );
	$id = media_handle_sideload( array( 'name' => sanitize_title( $alt ) . '.jpg', 'tmp_name' => $tmp ), $post_id, $alt );

	return is_wp_error( $id ) ? 0 : (int) $id;
};

// Default content of a fresh install has no place in the screenshot.
foreach ( array( get_page_by_path( 'hello-world', OBJECT, 'post' ), get_page_by_path( 'sample-page' ) ) as $waxsc_default ) {
	if ( $waxsc_default ) {
		wp_delete_post( $waxsc_default->ID, true );
	}
}

// Fictional posts, newest first in the grid.
$waxsc_posts = array(
	array( 'How we grade a record before it reaches the bins', 'Every copy is cleaned, played and graded on the Goldmine scale. Here is what Mint, Very Good Plus and Good mean in our shop.', '16.jpg' ),
	array( 'A box of 1970s funk from a collector in Lyon', 'Forty records, most of them first pressings, including three albums by The Velvet Lanterns.', '19.jpg' ),
	array( 'Meet Mira Okafor, our new jazz buyer', 'Mira spent ten years behind the counter of a Paris shop. She now picks every jazz record we sell.', '02.jpg' ),
	array( 'The listening corner is open', 'Two turntables, good headphones and a sofa: listen before you buy, as long as you like.', '08.jpg' ),
	array( 'Five records we keep restocking', 'From the debut of Harbor Static to the last live album of the Lumen Quartet, the records that never stay long in the bins.', '22.jpg' ),
	array( 'Inside a Saturday crate dig', 'Three hundred bins, one afternoon, and the joy of finding the record you did not know you were looking for.', '04.jpg' ),
);

foreach ( array_reverse( $waxsc_posts ) as $i => $post ) {
	if ( get_posts( array( 'title' => $post[0], 'post_type' => 'post', 'numberposts' => 1 ) ) ) {
		continue;
	}

	$id = wp_insert_post(
		array(
			'post_title'   => $post[0],
			'post_excerpt' => $post[1],
			'post_content' => '<!-- wp:paragraph --><p>' . esc_html( $post[1] ) . '</p><!-- /wp:paragraph -->',
			'post_status'  => 'publish',
			'post_date'    => gmdate( 'Y-m-d H:i:s', time() - ( 6 - $i ) * 3 * DAY_IN_SECONDS ),
		)
	);
	$thumb = $waxsc_image( $post[2], (int) $id, $post[0] );

	if ( $thumb ) {
		set_post_thumbnail( (int) $id, $thumb );
	}
}

// Home page: shop welcome pattern, bin divider tab, blog grid.
$waxsc_home = get_page_by_path( 'home' );

if ( ! $waxsc_home ) {
	$waxsc_home_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_content' => '<!-- wp:pattern {"slug":"wax-store/shop-intro"} /-->'
				. '<!-- wp:group {"align":"wide","layout":{"type":"default"}} --><div class="wp-block-group alignwide">'
				. '<!-- wp:group {"className":"is-style-divider","layout":{"type":"default"}} --><div class="wp-block-group is-style-divider"><!-- wp:heading --><h2 class="wp-block-heading">From the shop journal</h2><!-- /wp:heading --></div><!-- /wp:group -->'
				. '<!-- wp:query {"queryId":1,"query":{"perPage":6,"postType":"post","order":"desc","orderBy":"date","inherit":false}} --><div class="wp-block-query">'
				. '<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->'
				. '<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1"} /-->'
				. '<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"medium"} /-->'
				. '<!-- wp:post-date {"fontSize":"small"} /-->'
				. '<!-- /wp:post-template -->'
				. '</div><!-- /wp:query -->'
				. '</div><!-- /wp:group -->',
		)
	);
	update_post_meta( $waxsc_home_id, '_wp_page_template', 'page-no-title' );
} else {
	$waxsc_home_id = $waxsc_home->ID;
}

$waxsc_about = get_page_by_path( 'about' );
$waxsc_about = $waxsc_about ? $waxsc_about->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'About', 'post_name' => 'about', 'post_content' => '<!-- wp:paragraph --><p>An independent record shop since 1998.</p><!-- /wp:paragraph -->' ) );
$waxsc_visit = get_page_by_path( 'visit' );
$waxsc_visit = $waxsc_visit ? $waxsc_visit->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Visit us', 'post_name' => 'visit', 'post_content' => '<!-- wp:pattern {"slug":"wax-store/practical-info"} /-->' ) );
$waxsc_blog  = get_page_by_path( 'journal' );
$waxsc_blog  = $waxsc_blog ? $waxsc_blog->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Journal', 'post_name' => 'journal' ) );

update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', (int) $waxsc_home_id );
update_option( 'page_for_posts', (int) $waxsc_blog );

// Our menu replaces the default one WordPress may have created (a bare page list).
foreach ( get_posts( array( 'post_type' => 'wp_navigation', 'post_status' => 'any', 'numberposts' => -1 ) ) as $waxsc_nav ) {
	if ( 'Main menu' !== $waxsc_nav->post_title ) {
		wp_delete_post( $waxsc_nav->ID, true );
	}
}

if ( ! get_posts( array( 'post_type' => 'wp_navigation', 'title' => 'Main menu', 'post_status' => 'any', 'numberposts' => 1 ) ) ) {
	$link = static function ( string $label, int $page ): string {
		return '<!-- wp:navigation-link {"label":"' . $label . '","type":"page","id":' . $page . ',"url":"' . esc_url( get_permalink( $page ) ) . '","kind":"post-type"} /-->';
	};
	wp_insert_post(
		array(
			'post_type'    => 'wp_navigation',
			'post_status'  => 'publish',
			'post_title'   => 'Main menu',
			'post_content' => $link( 'Home', (int) $waxsc_home_id ) . $link( 'Journal', (int) $waxsc_blog ) . $link( 'Visit us', (int) $waxsc_visit ) . $link( 'About', (int) $waxsc_about ),
		)
	);
}

flush_rewrite_rules();
