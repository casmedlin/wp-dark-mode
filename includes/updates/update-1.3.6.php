<?php

class WP_Dark_Mode_Update_1_3_6 {

	private static $instance = null;

	public function __construct() {
		$this->update_switch_settings();
	}

	private function update_switch_settings() {
		$settings     = get_option( 'wp_dark_mode_display', [] );
		$new_settings = [];

		$keys = [
			'show_switcher',
			'switch_style',
			'switcher_position',
			'enable_menu_switch',
			'switch_menus',
			'custom_switch_icon',
			'switch_icon_light',
			'switch_icon_dark',
			'custom_switch_text',
			'switch_text_light',
			'switch_text_dark',
			'show_above_post',
			'show_above_page',
		];

		foreach ( $keys as $key ) {
			if ( ! empty( $settings[ $key ] ) ) {
				$new_settings[ $key ] = $settings[ $key ];
			}
		}

		update_option( 'wp_dark_mode_switch', $settings );
	}

	private function update_includes_excludes(){
		$settings     = get_option( 'wp_dark_mode_display', [] );
		$new_settings = [];

		$keys = [
			'includes',
			'excludes',
			'exclude_pages',
		];

		foreach ( $keys as $key ) {
			if ( ! empty( $settings[ $key ] ) ) {
				$new_settings[ $key ] = $settings[ $key ];
			}
		}

		update_option( 'wp_dark_mode_includes_excludes', $settings );
	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}


WP_Dark_Mode_Update_1_0_9::instance();