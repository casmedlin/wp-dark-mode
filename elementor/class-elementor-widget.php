<?php

use Elementor\Controls_Manager;

defined('ABSPATH') || exit();

if (!class_exists('WP_Dark_Mode_Elementor_Widget')) {
	class WP_Dark_Mode_Elementor_Widget extends \Elementor\Widget_Base {

		public function get_name() {
			return 'wp_dark_mode_switch';
		}

		public function get_title() {
			return __('Dark Mode Switch', 'wp-dark-mode');
		}

		public function get_icon() {
			return 'eicon-adjust';
		}

		public function get_categories() {
			return ['basic'];
		}

		public function get_keywords() {
			return ['wp dark mode', 'switch', 'night mode'];
		}

		public function _register_controls() {

			$this->start_controls_section('_section_alignment', [
				'label' => __('Alignment', 'wp-dark-mode'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]);

			//switch style
			$this->add_control('_switch_style_heading', [
				'label' => __('Layout', 'wp-dark-mode'),
				'type'  => Controls_Manager::HEADING,
			]);

			$this->add_control('switch_style', [
				'label'       => __('Switch Style', 'wp-dark-mode'),
				'type'        => WP_Dark_Mode_Controls_Manager::IMAGE_CHOOSE,
				'description' => 'Select the switch button style',
				'separator'   => 'after',
				'options'     => [
					'1' => [
						'title'       => 'Style 1',
						'image_small' => wp_dark_mode()->plugin_url('assets/images/button-presets/1.svg'),
						'image_large' => '',
					],
					'2' => [
						'title'       => 'Style 2',
						'image_small' => wp_dark_mode()->plugin_url('assets/images/button-presets/2.svg'),
						'image_large' => '',
					],
					'3' => [
						'title'       => 'Style 3',
						'image_small' => wp_dark_mode()->plugin_url('assets/images/button-presets/3.svg'),
						'image_large' => '',
					],
					'4' => [
						'title'       => 'Style 4',
						'image_small' => wp_dark_mode()->plugin_url('assets/images/button-presets/4.svg'),
						'image_large' => '',
					],
					'5' => [
						'title'       => 'Style 5',
						'image_small' => wp_dark_mode()->plugin_url('assets/images/button-presets/5.svg'),
						'image_large' => '',
					],
					'6' => [
						'title'       => 'Style 6',
						'image_small' => wp_dark_mode()->plugin_url('assets/images/button-presets/6.svg'),
						'image_large' => '',
					],
					'7' => [
						'title'       => 'Style 7',
						'image_small' => wp_dark_mode()->plugin_url('assets/images/button-presets/7.svg'),
						'image_large' => '',
					],
				],
				'default'     => '1',
			]);

			$this->add_responsive_control('align', [
				'label'     => __('Alignment', 'wp-dark-mode'),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'wp-dark-mode'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'wp-dark-mode'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'wp-dark-mode'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]);

			$this->end_controls_section();
		}

		public function render() {

			if (!wp_dark_mode_enabled()) {
				return;
			}

			$settings = $this->get_settings_for_display();
			extract($settings);
			echo do_shortcode("[wp_dark_mode style={$switch_style}]");
		}
	}
}
