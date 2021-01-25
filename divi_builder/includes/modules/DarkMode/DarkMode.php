<?php

class DIVI_DarkMode extends ET_Builder_Module {

	public $slug       = 'divi_dark_mode';
	public $vb_support = 'on';

	protected $module_credits = array(
		'module_uri' => '',
		'author'     => 'WPPOOL',
		'author_uri' => '',
	);

	public function init() {
		$this->name = esc_html__('WP Dark Mode', 'wp-dark-mode');
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'choose_switch' => et_builder_i18n('Choose Switch Style'),
					'switch_position'     => et_builder_i18n('Choose Switch Position'),
				),
			),
		);
		$this->advanced_fields = array(
			'background'   => false,
			'fonts'        => false,
			'text'         => false,
			'button'       => false,
			'link_options' => false,
		);
	}

	public function get_fields() {
		return array(
			'switch_style'     => array(
				'label'           => esc_html__('Switch Style', 'wp-dark-mode'),
				'type'            => 'select',
				'options'          => array(
					'1'  => esc_html__('Style 1', '1'),
					'2' => esc_html__('Style 2', '2'),
					'3' => esc_html__('Style 3', '3'),
					'4' => esc_html__('Style 4', '4'),
					'5' => esc_html__('Style 5', '5'),
					'6' => esc_html__('Style 6', '6'),
					'7' => esc_html__('Style 7', '7'),
				),
				'option_category' => 'basic_option',
				'description'     => esc_html__('Choose the switch style of dark mode button.', 'wp-dark-mode'),
				'toggle_slug'     => 'choose_switch',
			),
			'switch_postion'     => array(
				'label'           => esc_html__('Switch Position', 'wp-dark-mode'),
				'type'            => 'select',
				'options'          => array(
					'left'  => esc_html__('Left', 'left'),
					'center' => esc_html__('Center', 'center'),
					'right' => esc_html__('Right', 'right'),

				),
				'option_category' => 'basic_option',
				'description'     => esc_html__('Choose the postion of the dark mode switch.', 'wp-dark-mode'),
				'toggle_slug'     => 'switch_position',
			),
		);
	}

	public function render($attrs, $content = null, $render_slug) {
		return do_shortcode("[wp_dark_mode style=" . $this->props['switch_style'] . " align=" . $this->props['switch_postion'] . "]");
	}
}

new DIVI_DarkMode;
