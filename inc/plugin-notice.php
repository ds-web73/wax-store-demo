<?php
/**
 * Recommends the Wax Store Catalog plugin: a dismissible notice on the
 * Dashboard and Themes screens, for administrators only.
 *
 * @package Wax_Store
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'waxstore_catalog_state' ) ) {
	/**
	 * State of the companion plugin: active, installed or missing.
	 */
	function waxstore_catalog_state() {
		if ( function_exists( 'waxsc' ) ) {
			return 'active';
		}

		return file_exists( WP_PLUGIN_DIR . '/wax-store-catalog/wax-store-catalog.php' ) ? 'installed' : 'missing';
	}
}

if ( ! function_exists( 'waxstore_catalog_notice' ) ) {
	/**
	 * Notice.
	 */
	function waxstore_catalog_notice() {
		$screen = get_current_screen();

		if ( ! $screen || ! in_array( $screen->id, array( 'dashboard', 'themes' ), true ) || ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$state = waxstore_catalog_state();

		if ( 'active' === $state || get_user_meta( get_current_user_id(), 'waxstore_dismiss_catalog_notice', true ) ) {
			return;
		}

		if ( 'installed' === $state ) {
			$url   = wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin=wax-store-catalog/wax-store-catalog.php' ), 'activate-plugin_wax-store-catalog/wax-store-catalog.php' );
			$label = __( 'Activate Wax Store Catalog', 'wax-store' );
		} else {
			$url   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=wax-store-catalog' ), 'install-plugin_wax-store-catalog' );
			$label = __( 'Install Wax Store Catalog', 'wax-store' );
		}

		$dismiss = wp_nonce_url( add_query_arg( 'waxstore-dismiss-catalog', '1' ), 'waxstore_dismiss_catalog' );
		?>
		<div class="notice notice-info">
			<p><strong><?php esc_html_e( 'Wax Store works best with the Wax Store Catalog plugin.', 'wax-store' ); ?></strong></p>
			<p><?php esc_html_e( 'It adds the record shop catalog: release pages with copies and grading, artist index, filters and search, Discogs import, reservations, alerts and labels. The theme displays it as it was designed for.', 'wax-store' ); ?></p>
			<p>
				<a class="button button-primary" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a>
				<a class="button" href="https://wordpress.org/plugins/wax-store-catalog/"><?php esc_html_e( 'More about the plugin', 'wax-store' ); ?></a>
				<a class="button button-link" href="<?php echo esc_url( $dismiss ); ?>"><?php esc_html_e( 'Dismiss', 'wax-store' ); ?></a>
			</p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'waxstore_catalog_notice' );

if ( ! function_exists( 'waxstore_dismiss_catalog_notice' ) ) {
	/**
	 * Dismisses the notice for the current user, for good.
	 */
	function waxstore_dismiss_catalog_notice() {
		if ( empty( $_GET['waxstore-dismiss-catalog'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- checked below.
			return;
		}

		check_admin_referer( 'waxstore_dismiss_catalog' );
		update_user_meta( get_current_user_id(), 'waxstore_dismiss_catalog_notice', 1 );
		wp_safe_redirect( remove_query_arg( array( 'waxstore-dismiss-catalog', '_wpnonce' ) ) );
		exit;
	}
}
add_action( 'admin_init', 'waxstore_dismiss_catalog_notice' );
