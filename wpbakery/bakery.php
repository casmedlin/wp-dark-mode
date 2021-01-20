<?php

defined('ABSPATH') || die('access denied');

class Bakery {
    public function __construct() {
        add_shortcode('wpDarkModeBakery', [$this, 'dark_mode_element_in_bakery']);

        add_action('vc_before_init', [$this, 'initialize_darkmode_element']);
        vc_add_shortcode_param('wp_dark_mode_switch', [$this, 'dark_mode_custom_field']);
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
                    "type" => "wp_dark_mode_switch",
                    "holder" => "div",
                    "class" => "",
                    "heading" => __("Style 1", "wp-dark-mode"),
                    "param_name" => "swtich_1",
                    "value" => 'Style 1',
                    "description" => __("Description for foo param.", "my-text-domain"),
                    'group' => __('Choose Switch Style', 'wp-dark-mode'),
                )
            )
        ));
    }
    public function dark_mode_element_in_bakery($atts) {
        // $val = 4;
        // if ($atts) {
        //     if ($atts['swtich_1']) {
        //     }
        // }
        print_r($atts);
        // return do_shortcode("[wp_dark_mode style=" . $val . "]");
    }

    public function dark_mode_custom_field($settings, $value) {
        return '<div class="my_param_block">
                        <input value="true_yes" class="wpb_vc_param_value ' . $settings['param_name'] . ' checkbox" type="checkbox" name="' . $settings['param_name'] . '">
                    </div>';
    }
}

new Bakery;
