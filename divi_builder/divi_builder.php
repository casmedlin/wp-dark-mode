<?php
/*
Plugin Name: Divi Builder
Plugin URI:  
Description: 
Version:     1.0.0
Author:      WPPOOL
Author URI:  
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: divi-divi_builder
Domain Path: /languages

Divi Builder is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Divi Builder is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Divi Builder. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'divi_initialize_extension' ) ):
/**
 * Creates the extension's main class instance.
 *
 * @since 1.0.0
 */
function divi_initialize_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/DiviBuilder.php';
}
add_action( 'divi_extensions_init', 'divi_initialize_extension' );
endif;
