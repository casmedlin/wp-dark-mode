<?php

defined('ABSPATH') || exit;

$style = 1;
$align = 'left';
if ($settings->switch_selector) {
    $style = intval($settings->switch_selector);
}
if ($settings->switch_postion) {
    $align = $settings->switch_postion;
}
echo do_shortcode("[wp_dark_mode style=" . $style . " align=" . $align . "]");
// print_r($settings);
