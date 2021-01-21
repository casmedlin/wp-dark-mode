<?php

defined('ABSPATH') || die('access denied');

class Bakery {
    public function __construct() {
        add_shortcode('wpDarkModeBakery', [$this, 'dark_mode_element_in_bakery']);

        add_action('vc_before_init', [$this, 'initialize_darkmode_element']);
    }
    public function initialize_darkmode_element() {
        vc_map(array(
            "name" => __("WP Dark Mode", "wp-dark-mode"),
            "base" => "wpDarkModeBakery",
            "class" => "",
            "category" => __("WPPOOL", "wp-dark-mode"),
            "icon" => wp_dark_mode()->plugin_url('assets/images/button-presets/1.svg'),
            // 'admin_enqueue_js' => array(get_template_directory_uri() . '/vc_extend/bartag.js'),
            // 'admin_enqueue_css' => array(get_template_directory_uri() . '/vc_extend/bartag.css'),
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "class" => "bakery_wp_dark_mode",
                    "heading" => __("Style 1", "wp-dark-mode"),
                    "param_name" => "swtich",
                    "value" => array(
                        __('Switch 1',  "wp-dark-mode") => '1',
                        __('Switch 2',  "wp-dark-mode") => '2',
                        __('Switch 3',  "wp-dark-mode") => '3',
                        __('Switch 4',  "wp-dark-mode") => '4',
                        __('Switch 5',  "wp-dark-mode") => '5',
                        __('Switch 6',  "wp-dark-mode") => '6',
                        __('Switch 7',  "wp-dark-mode") => '7',
                    ),
                    "description" => __("Select the switch button style.", "wp-dark-mode"),
                    'group' => __('Choose Switch Style', 'wp-dark-mode'),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "class" => "bakery_wp_dark_mode",
                    "heading" => __("Choose Switch Position", "wp-dark-mode"),
                    "param_name" => "align",
                    "value" => array(
                        __('Left',  "wp-dark-mode") => 'left',
                        __('Center',  "wp-dark-mode") => 'center',
                        __('Right',  "wp-dark-mode") => 'right',
                    ),
                    "description" => __("Select the switch postion.", "wp-dark-mode"),
                    'group' => __('Switch Position', 'wp-dark-mode'),
                )
            )
        ));
    }
    public function dark_mode_element_in_bakery($atts) {

        $switch = 1;
        $align = 'left';

        if (isset($atts['swtich'])) {
            $switch = intval($atts['swtich']);
        }
        if (isset($atts['align'])) {
            $align = $atts['align'];
        }

        return do_shortcode("[wp_dark_mode style=" . $switch . " align=" . $align . "]");
    }

    public function dark_mode_custom_field($settings, $value) {
        return '<div class="my_param_block">
                        <input id="swtich-true" value="true" class="wpb_vc_param_value ' . $settings['param_name'] . ' checkbox" type="checkbox" name="' . $settings['param_name'] . '">
                        <img src=' . wp_dark_mode()->plugin_url('assets/images/button-presets/1.svg') . ' alt="' . $value . '" />
                    </div>';
    }
}

new Bakery;
