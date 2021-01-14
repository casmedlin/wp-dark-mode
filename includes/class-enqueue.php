<?php

/** block direct access */
defined( 'ABSPATH' ) || exit();

/** check if class `WP_Dark_Mode_Enqueue` not exists yet */
if ( ! class_exists( 'WP_Dark_Mode_Enqueue' ) ) {
	class WP_Dark_Mode_Enqueue {

		/**
		 * @var null
		 */
		private static $instance = null;

		/**
		 * WP_Dark_Mode_Enqueue constructor.
		 */
		public function __construct() {
			add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
		}

		/**
		 * Frontend Scripts
		 *
		 * @param $hook
		 *
		 * @return boolean|void
		 */
		public function frontend_scripts( $hook ) {

			if ( ! wp_dark_mode_enabled() ) {
				return false;
			}

			/** wp-dark-mode frontend css */
			wp_enqueue_style( 'wp-dark-mode-frontend', WP_DARK_MODE_ASSETS . '/css/frontend.css', false, WP_DARK_MODE_VERSION );

			/** wp-dark-mode frontend js */
			wp_enqueue_script( 'wp-dark-mode-frontend', WP_DARK_MODE_ASSETS . '/js/frontend.min.js', [ 'jquery', 'wp-util' ],
				WP_DARK_MODE_VERSION, true );

			if ( ! isset( $_REQUEST['elementor-preview'] ) ) {
				/** dark-reader js */
				wp_enqueue_script( 'wp-dark-mode-dark-reader', WP_DARK_MODE_ASSETS . '/vendor/dark-reader.js', [ 'jquery' ], '4.9.26', true );
			}

			$this->frontend_localize();

		}

		public function frontend_localize() {
			global $post, $current_screen;

			$is_excluded = isset( $post->ID ) && in_array( $post->ID, wp_dark_mode_exclude_pages() );

			$excludes = wp_dark_mode_get_settings( 'wp_dark_mode_includes_excludes', 'excludes' );
			$includes = wp_dark_mode_get_settings( 'wp_dark_mode_includes_excludes', 'includes' );


			$pro_version = 0;

			if ( defined( 'WP_DARK_MODE_ULTIMATE_VERSION' ) ) {
				$pro_version = WP_DARK_MODE_ULTIMATE_VERSION;
			} elseif ( defined( 'WP_DARK_MODE_PRO_VERSION' ) ) {
				$pro_version = WP_DARK_MODE_PRO_VERSION;
			}

			wp_localize_script( 'wp-dark-mode-frontend', 'wpDarkMode', [
				'config'              => [
					'brightness' => wp_dark_mode_get_settings( 'wp_dark_mode_color', 'brightness', 100 ),
					'contrast'   => wp_dark_mode_get_settings( 'wp_dark_mode_color', 'contrast', 90 ),
					'sepia'      => wp_dark_mode_get_settings( 'wp_dark_mode_color', 'sepia', 10 ),
				],

				'enable_preset'     => 'on' == wp_dark_mode_get_settings( 'wp_dark_mode_color', 'enable_preset', 'on' ),
				'colors'            => wp_dark_mode_color_presets(),
				'enable_frontend'   => wp_dark_mode_enabled(),
				'enable_os_mode'    => 'on' == wp_dark_mode_get_settings( 'wp_dark_mode_general', 'enable_os_mode', 'on' ),
				'excludes'          => apply_filters( 'wp_dark_mode/excludes', trim( $excludes, ',' ) ),
				'includes'          => apply_filters( 'wp_dark_mode/includes', trim( $includes, ',' ) ),
				'is_excluded'       => $is_excluded,
				'remember_darkmode' => 'on' == wp_dark_mode_get_settings( 'wp_dark_mode_advanced', 'remember_darkmode', 'off' ),
				'default_mode'        => 'on' == wp_dark_mode_get_settings( 'wp_dark_mode_advanced', 'default_mode', 'off' ),
				'images'              => get_option( 'wp_dark_mode_image_settings' ),
				'is_pro_active'       => wp_dark_mode()->is_pro_active(),
				'is_ultimate_active'  => wp_dark_mode()->is_ultimate_active(),
				'pro_version'         => $pro_version,
				'is_elementor_editor' => class_exists( '\Elementor\Plugin' ) && Elementor\Plugin::$instance->editor->is_edit_mode(),
				'is_block_editor'   => is_object($current_screen) && method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor(),

			] );
		}

		/**
		 * Admin scripts
		 *
		 * @param $hook
		 */
		public function admin_scripts( $hook ) {

			wp_enqueue_style( 'wp-dark-mode-admin', WP_DARK_MODE_ASSETS . '/css/admin.css', false, WP_DARK_MODE_VERSION );
			wp_enqueue_script( 'jquery.syotimer', WP_DARK_MODE_ASSETS . '/vendor/jquery.syotimer.min.js', [ 'jquery' ], '2.1.2', true );

			wp_enqueue_script( 'wp-dark-mode-admin', WP_DARK_MODE_ASSETS . '/js/admin.min.js', [ 'wp-util' ], WP_DARK_MODE_VERSION, true );


			if ( 'wp-dark-mode_page_wp-dark-mode-settings' != $hook ) {
				return;
			}

			wp_enqueue_style( 'select2', WP_DARK_MODE_ASSETS . '/vendor/select2.css' );
			wp_enqueue_script( 'select2', WP_DARK_MODE_ASSETS . '/vendor/select2.min.js', [ 'jquery' ], false, true );
			wp_enqueue_script( 'wp-dark-mode-dark-reader', WP_DARK_MODE_ASSETS . '/vendor/dark-reader.js', [ 'jquery' ], '4.9.26', true );


			$cm_settings = [];
			$cm_settings['codeEditor'] = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );

			wp_enqueue_script( 'wp-theme-plugin-editor' );
			wp_enqueue_style( 'wp-codemirror' );

			wp_localize_script( 'wp-dark-mode-admin', 'wpDarkMode', [
				'pluginUrl'          => WP_DARK_MODE_URL,

				'config' => [
					'brightness' => wp_dark_mode_get_settings( 'wp_dark_mode_color', 'brightness', 100 ),
					'contrast'   => wp_dark_mode_get_settings( 'wp_dark_mode_color', 'contrast', 90 ),
					'sepia'      => wp_dark_mode_get_settings( 'wp_dark_mode_color', 'sepia', 10 ),
				],

				'colors'          => wp_dark_mode_color_presets(),
				'enable_frontend' => wp_dark_mode_enabled(),
				'includes'        => '.filter-preview',
				'excludes'        => 'body',

				'is_pro_active'      => wp_dark_mode()->is_pro_active(),
				'is_ultimate_active' => wp_dark_mode()->is_ultimate_active(),
				'cm_settings'        => $cm_settings,
				'is_settings_page'   => 'wp-dark-mode_page_wp-dark-mode-settings' == $hook,
				'enable_backend'     => 'on' == wp_dark_mode_get_settings( 'wp_dark_mode_general', 'enable_backend', 'off' ),

				'pro_version' => defined( 'WP_DARK_MODE_PRO_VERSION' ) ? WP_DARK_MODE_PRO_VERSION : 0,
			] );


		}

		/**
		 * @return WP_Dark_Mode_Enqueue|null
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

	}
}

WP_Dark_Mode_Enqueue::instance();





