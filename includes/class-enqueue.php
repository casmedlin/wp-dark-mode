<?php

namespace WPDM\includes;

/** block direct access */
defined('ABSPATH') || exit();


/** check if class `WP_Dark_Mode_Enqueue` not exists yet */
if (!class_exists('WP_Dark_Mode_Enqueue')) {
	class WP_Dark_Mode_Enqueue {

		/**
		 * WP_Dark_Mode_Enqueue constructor.
		 */
		public function __construct() {
			add_action('wp_enqueue_scripts', [$this, 'frontend_scripts']);
			add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
		}

		/**
		 * Frontend Scripts
		 *
		 * @param $hook
		 */
		public function frontend_scripts($hook) {

			if (!wp_dark_mode_enabled()) {
				return;
			}

			$suffix = defined('WP_DEBUG') && WP_DEBUG === true ? '.min' : '';

			/** wp-dark-mode frontend css */
			wp_enqueue_style(
				'wp-dark-mode-frontend',
				WPDM_BASE_URL . 'assets/css/frontend.css',
				false,
				wp_dark_mode()->version
			);

			/** wp-dark-mode frontend js */
			wp_enqueue_script(
				'wp-dark-mode-frontend',
				WPDM_BASE_URL . 'assets/js/frontend.min.js',
				['jquery', 'wp-util'],
				wp_dark_mode()->version,
				true
			);

			wp_localize_script('wp-dark-mode-frontend', 'wpDarkModeFrontend', [
				'is_elementor_editor' => class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode(),
			]);

			/** woocommerce style*/
			if (class_exists('WooCommerce')) {
				//if ( wp_dark_mode()->is_pro_active() || wp_dark_mode()->is_ultimate_active() ) {
				wp_enqueue_style('wp-dark-mode-woocommerce', WPDM_BASE_URL . 'assets/css/woocommerce.css');
				//}
			}

			/** buddypress style*/
			if (class_exists('BuddyPress')) {
				wp_enqueue_style('wp-dark-mode-buddypress', WPDM_BASE_URL . 'assets/css/buddypress.css');
			}

			$this->frontend_localize();
		}

		public function frontend_localize() {
			global $post, $current_screen;

			$is_excluded = isset($post->ID) && in_array($post->ID, wp_dark_mode_exclude_pages());

			$excludes = '.wp-dark-mode-ignore, .wp-dark-mode-ignore *, .video-js, .select2';

			wp_localize_script('wp-dark-mode-frontend', 'wpDarkModeFrontend', [
				'excludes'            => apply_filters('wp_dark_mode/excludes', trim($excludes, ',')),
				'is_excluded'         => $is_excluded,
				'enable_frontend'     => wp_dark_mode_enabled(),
				'enable_os_mode'      => 'on' == wp_dark_mode_get_settings('wp_dark_mode_general', 'enable_os_mode', 'on'),
				'is_elementor_editor' => class_exists('\Elementor\Plugin') && \Elementor\Plugin::$instance->editor->is_edit_mode(),
				'is_pro_active'       => wp_dark_mode()->is_pro_active(),
				'is_ultimate_active'  => wp_dark_mode()->is_ultimate_active(),
				'enable_backend'      => 'on' == wp_dark_mode_get_settings('wp_dark_mode_general', 'enable_backend', 'off'),
				'is_block_editor'     => method_exists($current_screen, 'is_block_editor') && $current_screen->is_block_editor(),

				'pro_version' => (defined('WP_DARK_MODE_ULTIMATE_VERSION') ? WP_DARK_MODE_ULTIMATE_VERSION : defined('WP_DARK_MODE_PRO_VERSION')) ? WP_DARK_MODE_PRO_VERSION : 0,
			]);
		}

		/**
		 * Admin scripts
		 *
		 * @param $hook
		 */
		public function admin_scripts($hook) {

			if ('settings_page_wp-dark-mode-settings' == $hook) {

				wp_enqueue_style('select2', WPDM_BASE_URL . 'assets/vendor/select2.css');

				wp_enqueue_script(
					'jquery.syotimer',
					WPDM_BASE_URL . 'assets/vendor/jquery.syotimer.min.js',
					['jquery'],
					'2.1.2',
					true
				);

				wp_enqueue_script('select2', WPDM_BASE_URL . 'assets/vendor/select2.min.js', ['jquery'], false, true);
			}

			wp_enqueue_style('wp-dark-mode-admin', WPDM_BASE_URL . 'assets/css/admin.css', false, wp_dark_mode()->version);


			/** wp-dark-mode admin js */
			wp_enqueue_script('wp-dark-mode-admin', WPDM_BASE_URL . 'assets/js/admin.min.js', false, wp_dark_mode()->version, true);


			/** frontend scripts for gutenberg */
			if (
				'post.php' == $hook
				|| 'on' == wp_dark_mode_get_settings('wp_dark_mode_general', 'enable_backend', 'off')
			) {
				/** wp-dark-mode frontend css */
				wp_enqueue_style(
					'wp-dark-mode-frontend',
					WPDM_BASE_URL . 'assets/css/frontend.css',
					false,
					wp_dark_mode()->version
				);

				/** wp-dark-mode frontend js */
				wp_enqueue_script(
					'wp-dark-mode-frontend',
					WPDM_BASE_URL . 'assets/js/frontend.min.js',
					['jquery', 'wp-util'],
					wp_dark_mode()->version,
					true
				);
			}

			$cm_settings = [];
			if ('settings_page_wp-dark-mode-settings' == $hook) {
				$cm_settings['codeEditor'] = wp_enqueue_code_editor(array('type' => 'text/css'));

				wp_enqueue_script('wp-theme-plugin-editor');
				wp_enqueue_style('wp-codemirror');
			}

			wp_localize_script('wp-dark-mode-admin', 'wpDarkModeAdmin', [
				'pluginUrl'          => WPDM_BASE_URL,
				'is_pro_active'      => wp_dark_mode()->is_pro_active(),
				'is_ultimate_active' => wp_dark_mode()->is_ultimate_active(),
				'cm_settings'        => $cm_settings,
				'is_settings_page'   => 'settings_page_wp-dark-mode-settings' == $hook,
				'enable_backend'     => 'on' == wp_dark_mode_get_settings('wp_dark_mode_general', 'enable_backend', 'off'),

				'pro_version' => defined('WP_DARK_MODE_PRO_VERSION') ? WP_DARK_MODE_PRO_VERSION : 0,
			]);
		}
	}
}
