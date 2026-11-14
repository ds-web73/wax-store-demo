<?php
/**
 * Title: Shop welcome
 * Slug: wax-store/shop-intro
 * Categories: wax-store, banner
 * Description: Shop name, what you sell and a link to the catalog.
 *
 * @package Wax_Store
 */

defined( 'ABSPATH' ) || exit;

$waxstore_catalog = post_type_exists( 'waxsc_release' ) ? get_post_type_archive_link( 'waxsc_release' ) : home_url( '/' );
?>
<!-- wp:group {"align":"wide","layout":{"type":"default"},"style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"}}}} -->
<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
<!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
<h1 class="wp-block-heading has-xx-large-font-size"><?php esc_html_e( 'New and second-hand records, dug out every week', 'wax-store' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"fontSize":"large"} -->
<p class="has-large-font-size"><?php esc_html_e( 'Vinyl, CDs and tapes, from rock to jazz. Every copy is checked and graded before it reaches the bins.', 'wax-store' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $waxstore_catalog ); ?>"><?php esc_html_e( 'Browse the catalog', 'wax-store' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
