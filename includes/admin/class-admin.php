<?php


if(!class_exists('WP_Dark_Mode_Admin')){
	class WP_Dark_Mode_Admin{
		/** @var null  */
		private static $instance = null;

		/**
		 * WP_Dark_Mode_Admin constructor.
		 */
		public function __construct() {
			add_action( 'admin_head', [ $this, 'header_scripts' ], 1 );
			add_action( 'admin_menu', array( $this, 'admin_menu' ) );
			add_action( 'admin_bar_menu', [ $this, 'render_admin_switcher_menu' ], 2000 );
		}

		public function header_scripts() {
			if ( ! wp_dark_mode_is_gutenberg_page() ) { ?>

				<script>
                    window.wpDarkMode = <?php echo json_encode( wp_dark_mode_localize_array() ); ?>;

                    //check if main element
                    window.wp_dark_mode_is_main_element = (tagName) => {
                        const elements = [
                            'MARK',
                            'CODE',
                            'PRE',
                            'INS',
                            'OPTION',
                            'INPUT',
                            'SELECT',
                            'TEXTAREA',
                            'BUTTON',
                            'A',
                            'VIDEO',
                            'CANVAS',
                            'PROGRESS',
                            'IFRAME',
                            'SVG',
                            'PATH',
                        ];

                        return !elements.includes(tagName);

                    };
				</script>

				<script src="<?php echo WP_DARK_MODE_ASSETS . '/js/dark-mode.js'; ?>"></script>
				<script>
                    const is_saved = localStorage.getItem('wp_dark_mode_admin_active');

                    if (is_saved && is_saved != 0) {
                        document.querySelector('html').classList.add('wp-dark-mode-active');

                        DarkMode.enable();

                    }
				</script>
				<?php
			}
		}

		/**
		 * display dark mode switcher button on the admin bar menu
		 */
		public function render_admin_switcher_menu() {

			if ( ! is_admin() || 'on' != wp_dark_mode_get_settings( 'wp_dark_mode_general', 'enable_backend', 'off' ) ) {
				return;
			}

			$light_text = wp_dark_mode_get_settings( 'wp_dark_mode_display', 'switch_text_light', 'Light' );
			$dark_text  = wp_dark_mode_get_settings( 'wp_dark_mode_display', 'switch_text_dark', 'Dark' );

			global $wp_admin_bar;
			$wp_admin_bar->add_menu( array(
				'id'    => 'wp-dark-mode',
				'title' => sprintf( '<input type="checkbox" id="wp-dark-mode-switch" class="wp-dark-mode-switch">
                            <div class="wp-dark-mode-switcher wp-dark-mode-ignore">
                            
                                <label for="wp-dark-mode-switch" class="wp-dark-mode-ignore">
                                    <div class="toggle wp-dark-mode-ignore"></div>
                                    <div class="modes wp-dark-mode-ignore">
                                        <p class="light wp-dark-mode-ignore">%s</p>
                                        <p class="dark wp-dark-mode-ignore">%s</p>
                                    </div>
                                </label>
                            
                            </div>', $light_text, $dark_text ),
				'href'  => '#',
			) );
		}

		public function admin_menu(){
			add_menu_page( __( 'WP Dark Mode', 'wp-dark-mode' ), __( 'WP Dark Mode', 'wp-dark-mode' ), 'manage_options',
				'wp-dark-mode', array( $this, 'getting_started' ), WP_DARK_MODE_ASSETS.'/images/moon.png', 40 );

		}

		public static function getting_started() {
			wp_dark_mode()->get_template('admin/get-started/index');
		}


		/**
		 * @return WP_Dark_Mode_Admin|null
		 */
		public static function instance(){
			if(is_null(self::$instance)){
				self::$instance = new self();
			}

			return self::$instance;
		}
	}

}

WP_Dark_Mode_Admin::instance();