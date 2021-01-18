<?php

class WP_Dark_Mode_Update_2_0_0 {

	private static $instance = null;

	public function __construct() {
		$this->update_switch_settings();
		$this->update_includes_excludes();
		$this->update_advanced_settings();
		$this->update_color_settings();
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

				if ( empty( $settings[ $key ] ) ) {
					continue;
				}

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

	private function update_advanced_settings() {
		$general_settings  = get_option( 'wp_dark_mode_general', [] );
		$advanced_settings = get_option( 'wp_dark_mode_advanced', [] );

		if ( empty( $advanced_settings ) ) {
			$advanced_settings = [];
		}


		$default_setting = $general_settings['default_mode'] ?? 'off';

		$advanced_settings['default_mode'] = $default_setting;

		update_option( 'wp_dark_mode_advanced', $advanced_settings );
	}

	private function update_color_settings() {
		$color_settings = get_option( 'wp_dark_mode_color', [] );
		if ( empty( $color_settings ) ) {
			$color_settings = [];
		}

		$color_settings['enable_preset'] = 'on';

		update_option( 'wp_dark_mode_color', $color_settings );

	}

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}


WP_Dark_Mode_Update_2_0_0::instance();