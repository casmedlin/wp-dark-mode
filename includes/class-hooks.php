<?php

/** Block direct access */
defined( 'ABSPATH' ) || exit();

/** check if class `WP_Dark_Mode_Hooks` not exists yet */
if ( ! class_exists( 'WP_Dark_Mode_Hooks' ) ) {
	class WP_Dark_Mode_Hooks {

		/**
		 * @var null
		 */
		private static $instance = null;

		/**
		 * WP_Dark_Mode_Hooks constructor.
		 */
		public function __construct() {

			add_filter( 'wp_dark_mode/excludes', [ $this, 'excludes' ] );

			add_action( 'admin_footer', [$this, 'display_promo']);
			add_action( 'wppool_after_settings', [ $this, 'pro_promo' ] );

			//display the dark mode switcher if the dark mode enabled on frontend
            add_action( 'wp_footer', [ $this, 'display_widget' ] );

			//declare custom color css variables
			add_action( 'wp_head', [ $this, 'header_scripts' ], 10 );


		}

		/**
		 * declare custom color css variables
		 */
		public function header_scripts() {

			if ( ! wp_dark_mode_enabled() ) {
				return;
			}

			$colors = wp_dark_mode_color_presets();

			$colors = [
				'bg'   => apply_filters( 'wp_dark_mode/bg_color', $colors['bg'] ),
				'text' => apply_filters( 'wp_dark_mode/text_color', $colors['text'] ),
				'link' => apply_filters( 'wp_dark_mode/link_color', $colors['link'] ),
			];

			?>
			<style>
				:root {
					--wp-dark-mode-bg: <?php echo $colors['bg']; ?>;
					--wp-dark-mode-text: <?php echo $colors['text']; ?>;
					--wp-dark-mode-link: <?php echo $colors['link']; ?>;
				}
			</style>

			<?php
			if ( ! isset( $_REQUEST['elementor-preview'] ) ) { ?>
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
                    (function () {
                        const is_saved = localStorage.getItem('wp_dark_mode_active');

                        if ((is_saved && is_saved != 0) || (!is_saved && wpDarkMode.default_mode)) {
                            document.querySelector('html').classList.add('wp-dark-mode-active');
                            DarkMode.enable();
                        }
                    })();
                </script>
				<?php
			}
		}

		/**
		 * display promo popup
		 */
		public function display_promo(){

			if ( wp_dark_mode()->is_pro_active() || wp_dark_mode()->is_ultimate_active() ) {
				return;
			}

		    if(wp_dark_mode_is_gutenberg_page()){
			    wp_dark_mode()->get_template( 'admin/promo' );
		    }
        }

		/**
		 * Exclude elements
		 *
		 * @param $excludes
		 *
		 * @return string
		 */
		public function excludes( $excludes ) {

		    /** exclude rev slider */
		    if(class_exists('RevSliderFront')){
		        $excludes .= ', rs-fullwidth-wrap';
            }

			if ( wp_dark_mode()->is_pro_active() || wp_dark_mode()->is_ultimate_active() ) {
				$selectors = wp_dark_mode_get_settings( 'wp_dark_mode_display', 'excludes', '' );

				if ( ! empty( $selectors ) ) {
					$excludes .= ", $selectors";
				}
			}

			return $excludes;
		}

		/**
		 * display the footer widget
		 */
		public function display_widget() {

			if ( ! wp_dark_mode_enabled() ) {
				return false;
			}


			if ( 'on' != wp_dark_mode_get_settings( 'wp_dark_mode_switch', 'show_switcher', 'on' ) ) {
				return false;
			}


			$style = wp_dark_mode_get_settings( 'wp_dark_mode_switch', 'switch_style', 1 );

			global $wp_dark_mode_license;
			if ( ! $wp_dark_mode_license || ! $wp_dark_mode_license->is_valid() ) {
				$style = $style > 2 ? 1 : $style;
			}


			echo do_shortcode( '[wp_dark_mode floating="yes" style="' . $style . '"]' );
		}

		/**
		 * Display promo popup to upgrade to PRO
		 *
		 * @param $section - setting section
		 */
		public function pro_promo(  ) {
			wp_dark_mode()->get_template( 'admin/promo' );
		}

		/**
		 * @return WP_Dark_Mode_Hooks|null
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}

WP_Dark_Mode_Hooks::instance();

