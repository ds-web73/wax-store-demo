<?php
/**
 * Title: Footer
 * Slug: wax-store/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 *
 * @package Wax_Store
 */

defined( 'ABSPATH' ) || exit;

?>
<!-- wp:group {"className":"site-footer","layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group site-footer">
<!-- wp:columns {"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:site-title {"level":0} /-->
<!-- wp:site-tagline /-->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:navigation {"overlayMenu":"never","className":"site-footer-nav","layout":{"type":"flex","orientation":"vertical"}} -->
<!-- wp:home-link <?php echo wp_json_encode( array( 'label' => __( 'Home', 'wax-store' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block attributes, JSON-encoded. ?> /-->
<?php
if ( get_privacy_policy_url() ) :
	$waxstore_privacy_link = array(
		'label' => __( 'Privacy Policy', 'wax-store' ),
		'url'   => esc_url_raw( get_privacy_policy_url() ),
		'kind'  => 'custom',
	);
	?>
<!-- wp:navigation-link <?php echo wp_json_encode( $waxstore_privacy_link ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block attributes, JSON-encoded. ?> /-->
<?php endif; ?>
<!-- /wp:navigation -->
<?php
$waxstore_search = array(
	'label'         => __( 'Search', 'wax-store' ),
	'buttonText'    => __( 'Search', 'wax-store' ),
	'buttonUseIcon' => true,
);
?>
<!-- wp:search <?php echo wp_json_encode( $waxstore_search ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block attributes, JSON-encoded. ?> /-->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:paragraph {"fontSize":"small","textColor":"groove"} -->
<p class="has-groove-color has-text-color has-small-font-size">
<?php
/* translators: %s: WordPress link. */
printf( esc_html__( 'Record shop powered by %s', 'wax-store' ), '<a href="' . esc_url( __( 'https://wordpress.org', 'wax-store' ) ) . '">WordPress</a>' );
?>
</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
