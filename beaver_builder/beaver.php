<?php

defined('ABSPATH') || exit;

if (!class_exists('FLBuilderModule')) {
    return;
}

class Beaver_Dark_Mode extends FLBuilderModule {

    public function __construct() {
        parent::__construct(array(
            'name'            => __('WP Dark Mode', 'wp-dark-mode'),
            'description'     => __('WP Dark Mode Module', 'wp-dark-mode'),
            'category'        => __('Basic', 'wp-dark-mode'),
            'editor_export'   => true, // Defaults to true and can be omitted.
            'enabled'         => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ));
    }
}

add_action('init', 'load_dark_mode_module');

function load_dark_mode_module() {
    if (class_exists('FLBuilder')) {
        FLBuilder::register_module('Beaver_Dark_Mode', array(
            'wp_dark_mode'      => array(
                'title'         => __('Switch Settings', 'wp-dark-mode'),
                'sections'      => array(
                    'wp_dark_mode_sec-1'  => array(
                        'title'         => __('Switch Settings', 'wp-dark-mode'),
                        'fields'        => array(
                            'switch_selector'     => array(
                                'type'          => 'select',
                                'default'       => '1',
                                'options'       => array(
                                    '1'      => __('Style 1', 'wp-dark-mode'),
                                    '2'      => __('Style 2', 'wp-dark-mode'),
                                    '3'      => __('Style 3', 'wp-dark-mode'),
                                    '4'      => __('Style 4', 'wp-dark-mode'),
                                    '5'      => __('Style 5', 'wp-dark-mode'),
                                    '6'      => __('Style 6', 'wp-dark-mode'),
                                    '7'      => __('Style 7', 'wp-dark-mode'),
                                ),
                                'label'         => __('Choose Switch Style', 'wp-dark-mode'),
                            ),
                            'switch_postion'     => array(
                                'type'          => 'align',
                                'default' => 'left',
                                'values'  => array(
                                    'left'   => 'left',
                                    'center' => 'center',
                                    'right'  => 'right',
                                ),
                                'label'         => __('Choose Switch Position', 'wp-dark-mode'),
                            ),
                        )
                    )
                )
            )
        ));
    }
}
