<?php

/** prevent direct access */
defined( 'ABSPATH' ) || exit();

if ( ! function_exists( 'wp_dark_mode_get_settings' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param           $section
	 * @param           $key
	 * @param   string  $default
	 *
	 * @return string
	 */
	function wp_dark_mode_get_settings( $section = 'wp_dark_mode_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return ! empty( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'wp_dark_mode_color_presets' ) ) {
	function wp_dark_mode_color_presets() {
		$preset = wp_dark_mode_get_settings( 'wp_dark_mode_color', 'color_preset', 0 );

		$presets = apply_filters( 'wp_dark_mode/color_presets', [
			[
				'bg'   => '#000',
				'text' => '#dfdedb',
				'link' => '#e58c17',
			],
			[
				'bg'   => '#1B2836',
				'text' => '#fff',
				'link' => '#459BE6',
			],
			[
				'bg'   => '#1E0024',
				'text' => '#fff',
				'link' => '#E251FF',
			],
		] );

		return ! empty( $presets[ $preset ] ) ? $presets[ $preset ] : $presets['0'];
	}
}

if ( ! function_exists( 'wp_dark_mode_exclude_pages' ) ) {
	/**
	 * @return string|array
	 */
	function wp_dark_mode_exclude_pages() {
		return  wp_dark_mode_get_settings( 'wp_dark_mode_includes_excludes', 'exclude_pages', [] );
	}
}

if ( ! function_exists( 'wp_dark_mode_enabled' ) ) {
	function wp_dark_mode_enabled() {
		$frontend_enable = 'on' == wp_dark_mode_get_settings( 'wp_dark_mode_general', 'enable_frontend', 'on' );


		if ( ! $frontend_enable ) {
			return false;
		}

		if ( wp_dark_mode()->is_pro_active() || wp_dark_mode()->is_ultimate_active() ) {
			$specific_category = 'on' == wp_dark_mode_get_settings( 'wp_dark_mode_includes_excludes', 'specific_category', 'off' );

			if ( $specific_category ) {

				$categories = wp_dark_mode_get_settings( 'wp_dark_mode_includes_excludes', 'specific_categories', [] );

				if(!is_single() && !is_page()){
					return false;
				}

				global $post_id;
				if ( ! in_category( $categories, $post_id ) ) {
					return false;
				}
			}
		}

		return true;

	}
}

function wp_dark_mode_is_gutenberg_page(){
	global $current_screen;

	if (!isset($current_screen)) {
		$current_screen = get_current_screen();
	}

	if ( ( method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor() )
	     || ( function_exists('is_gutenberg_page') && is_gutenberg_page() ) ) {
		return true;
	}

	return false;
}