<?php
/**
 * Title: Bin divider
 * Slug: wax-store/divider-section
 * Categories: wax-store, text
 * Description: A section title on a bin divider tab, followed by a short text.
 *
 * @package Wax_Store
 */

defined( 'ABSPATH' ) || exit;

?>
<!-- wp:group {"className":"is-style-wax-store-divider","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-wax-store-divider">
<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'New arrivals', 'wax-store' ); ?></h2>
<!-- /wp:heading -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph -->
<p><?php esc_html_e( 'Fresh from the latest collections we bought. First come, first served.', 'wax-store' ); ?></p>
<!-- /wp:paragraph -->
