<?php
/**
 * Wax Store demo with WooCommerce: light configuration for WordPress
 * Playground, selling mode switched to WooCommerce, products created.
 * Run after setup.php.
 *
 * @package WaxStoreDemo
 */

if ( ! class_exists( 'WooCommerce' ) || ! class_exists( \WaxStore\Catalog\Commerce\WooSync::class ) ) {
	return;
}

wp_set_current_user( 1 );

// A must-use plugin keeps WooCommerce light in the browser: no modern admin
// screens, no marketplace or remote suggestions, no calls to outside services.
$waxsc_mu = WP_CONTENT_DIR . '/mu-plugins';
wp_mkdir_p( $waxsc_mu );
file_put_contents( // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents -- demo setup.
	$waxsc_mu . '/waxsc-demo-light.php',
	<<<'PHP'
<?php
/**
 * Plugin Name: Wax Store demo – light WooCommerce
 * Description: Keeps WooCommerce light in WordPress Playground (demo only).
 */
add_filter( 'woocommerce_admin_disabled', '__return_true' );
add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );
add_filter( 'woocommerce_show_admin_notice', '__return_false' );
add_filter( 'woocommerce_background_image_regeneration', '__return_false' );
// Playground runs on SQLite: the stock hold during checkout uses a MySQL-only
// query. Stock is still decreased when the order is placed.
add_filter( 'woocommerce_hold_stock_for_checkout', '__return_false' );
add_filter(
	'pre_http_request',
	static function ( $pre, $args, $url ) {
		$host = (string) wp_parse_url( $url, PHP_URL_HOST );
		$home = (string) wp_parse_url( home_url(), PHP_URL_HOST );

		if ( '' === $host || $host === $home || preg_match( '/(^|\.)(wordpress\.org|w\.org)$/', $host ) ) {
			return $pre;
		}

		return new WP_Error( 'waxsc_demo_offline', 'External services are disabled in the demo.' );
	},
	10,
	3
);
PHP
);

// Store basics, without the setup wizard.
$waxsc_wc_options = array(
	'woocommerce_currency'                     => 'EUR',
	'woocommerce_default_country'              => 'FR:*',
	'woocommerce_price_thousand_sep'           => ' ',
	'woocommerce_price_decimal_sep'            => ',',
	'woocommerce_currency_pos'                 => 'right_space',
	'woocommerce_calc_taxes'                   => 'no',
	'woocommerce_coming_soon'                  => 'no',
	'woocommerce_store_pages_only'             => 'no',
	'woocommerce_onboarding_profile'           => array( 'skipped' => true ),
	'woocommerce_task_list_hidden'             => 'yes',
	'woocommerce_task_list_complete'           => 'yes',
	'woocommerce_extended_task_list_hidden'    => 'yes',
	'woocommerce_show_marketplace_suggestions' => 'no',
	'woocommerce_allow_tracking'               => 'no',
	'woocommerce_enable_guest_checkout'        => 'yes',
	'woocommerce_cod_settings'                 => array(
		'enabled'      => 'yes',
		'title'        => 'Paiement en boutique',
		'description'  => 'Réglez votre commande au moment du retrait au magasin.',
		'instructions' => 'Votre commande est mise de côté : réglez-la au moment du retrait.',
	),
);

foreach ( $waxsc_wc_options as $waxsc_option => $waxsc_value ) {
	update_option( $waxsc_option, $waxsc_value );
}

// Shop page separate from the home page.
$waxsc_shop = get_page_by_path( 'boutique' );

if ( ! $waxsc_shop ) {
	$waxsc_shop_id = wp_insert_post(
		array(
			'post_type'   => 'page',
			'post_status' => 'publish',
			'post_title'  => 'Boutique',
			'post_name'   => 'boutique',
		)
	);
} else {
	$waxsc_shop_id = $waxsc_shop->ID;
}

update_option( 'woocommerce_shop_page_id', (int) $waxsc_shop_id );
update_option( 'waxsc_shop_page_checked', '1' );

// Selling mode, then one product per release right away.
update_option( 'waxsc_commerce_provider', 'woocommerce' );

$waxsc_ids = get_posts(
	array(
		'post_type'      => 'waxsc_release',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	)
);

foreach ( $waxsc_ids as $waxsc_id ) {
	\WaxStore\Catalog\Commerce\WooSync::sync( (int) $waxsc_id );

	if ( ! get_post_meta( (int) $waxsc_id, '_waxsc_wc_product', true ) ) {
		update_post_meta( (int) $waxsc_id, '_waxsc_wc_product', 0 );
	}
}

update_option( 'waxsc_wc_deduplicated', '1' );
delete_transient( 'waxsc_wc_pending' );

flush_rewrite_rules();
