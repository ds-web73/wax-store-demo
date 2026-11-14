<?php
/**
 * Wax Store functions and definitions.
 *
 * @package Wax_Store
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'waxstore_setup' ) ) {
	/**
	 * Editor styles and translations.
	 */
	function waxstore_setup() {
		add_editor_style( 'style.css' );
		load_theme_textdomain( 'wax-store', get_template_directory() . '/languages' );
	}
}
add_action( 'after_setup_theme', 'waxstore_setup' );

if ( ! function_exists( 'waxstore_enqueue_styles' ) ) {
	/**
	 * Front-end stylesheet.
	 */
	function waxstore_enqueue_styles() {
		wp_enqueue_style( 'wax-store', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
	}
}
add_action( 'wp_enqueue_scripts', 'waxstore_enqueue_styles' );

if ( ! function_exists( 'waxstore_block_styles' ) ) {
	/**
	 * "Bin divider" style for groups: the first block becomes a tab on a bar.
	 */
	function waxstore_block_styles() {
		register_block_style(
			'core/group',
			array(
				'name'  => 'wax-store-divider',
				'label' => __( 'Bin divider', 'wax-store' ),
			)
		);
	}
}
add_action( 'init', 'waxstore_block_styles' );

if ( ! function_exists( 'waxstore_pattern_categories' ) ) {
	/**
	 * Pattern category.
	 */
	function waxstore_pattern_categories() {
		register_block_pattern_category(
			'wax-store',
			array(
				'label'       => __( 'Record shop', 'wax-store' ),
				'description' => __( 'Sections for a record shop: welcome, practical information, bin dividers.', 'wax-store' ),
			)
		);
	}
}
add_action( 'init', 'waxstore_pattern_categories' );

if ( is_admin() ) {
	require get_template_directory() . '/inc/plugin-notice.php';
}

if ( ! function_exists( 'waxstore_in_post_template' ) ) {
	/**
	 * Whether a Post Template block (the loop of a Query) is being rendered.
	 *
	 * @param int $change 1 when a loop starts, -1 when it ends, 0 to read.
	 * @return bool
	 */
	function waxstore_in_post_template( $change = 0 ) {
		static $depth = 0;

		$depth = max( 0, $depth + $change );

		return $depth > 0;
	}
}

if ( ! function_exists( 'waxstore_track_post_template' ) ) {
	/**
	 * Marks the start of a Post Template block.
	 *
	 * @param string|null $pre    Short-circuited output.
	 * @param array       $parsed Parsed block.
	 * @return string|null
	 */
	function waxstore_track_post_template( $pre, $parsed ) {
		if ( null === $pre && isset( $parsed['blockName'] ) && 'core/post-template' === $parsed['blockName'] ) {
			waxstore_in_post_template( 1 );
		}

		return $pre;
	}
}
add_filter( 'pre_render_block', 'waxstore_track_post_template', 10, 2 );

if ( ! function_exists( 'waxstore_end_post_template' ) ) {
	/**
	 * Marks the end of a Post Template block.
	 *
	 * @param string $content Rendered block.
	 * @return string
	 */
	function waxstore_end_post_template( $content ) {
		waxstore_in_post_template( -1 );

		return $content;
	}
}
add_filter( 'render_block_core/post-template', 'waxstore_end_post_template' );

if ( ! function_exists( 'waxstore_featured_image_placeholder' ) ) {
	/**
	 * Post grids: a post without a featured image shows a stylized record with
	 * the same ratio and radius as a real image, so the cards stay even.
	 * Only inside a Post Template loop; single posts and pages show nothing, as usual.
	 *
	 * @param string   $content Rendered block.
	 * @param array    $parsed  Parsed block.
	 * @param WP_Block $block   Block instance.
	 * @return string
	 */
	function waxstore_featured_image_placeholder( $content, $parsed, $block ) {
		if ( '' !== trim( $content ) || ! waxstore_in_post_template() || empty( $block->context['postId'] ) ) {
			return $content;
		}

		$post_id = (int) $block->context['postId'];
		$attrs   = $parsed['attrs'] ?? array();
		$ratio   = isset( $attrs['aspectRatio'] ) && 'auto' !== $attrs['aspectRatio'] ? $attrs['aspectRatio'] : '3/2';
		$classes = 'wp-block-post-featured-image wax-store-placeholder';

		if ( ! empty( $attrs['align'] ) ) {
			$classes .= ' align' . sanitize_html_class( $attrs['align'] );
		}

		$record = '<span class="wax-store-placeholder__record"></span>';

		if ( ! empty( $attrs['isLink'] ) ) {
			// The title link right below names the post: this one stays out of the tab order.
			$record = sprintf(
				'<a href="%1$s" tabindex="-1" aria-hidden="true"%2$s>%3$s</a>',
				esc_url( get_permalink( $post_id ) ),
				! empty( $attrs['linkTarget'] ) && '_blank' === $attrs['linkTarget'] ? ' target="_blank"' : '',
				$record
			);
		}

		return sprintf(
			'<figure class="%1$s" style="aspect-ratio:%2$s">%3$s</figure>',
			esc_attr( $classes ),
			esc_attr( $ratio ),
			$record
		);
	}
}
add_filter( 'render_block_core/post-featured-image', 'waxstore_featured_image_placeholder', 10, 3 );
