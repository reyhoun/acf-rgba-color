<?php
/*
 * Plugin Name: Advanced Custom Fields: RGBA Color
 * Plugin URI: https://github.com/reyhoun/acf-rgba-color
 * Description: RGBA Color field type for Advanced Custom Field plugin.
 * Version: 1.3.1
 * Author: Reyhoun
 * Author URI: http://reyhoun.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/




// 1. set text domain
// Reference: https://codex.wordpress.org/Function_Reference/load_plugin_textdomain
load_plugin_textdomain( 'advanced-custom-fields-rgba-color', false, dirname( plugin_basename(__FILE__) ) . '/lang/' ); 




// 2. Include field type for ACF5
// $version = 5 and can be ignored until ACF6 exists
function include_field_types_rgba_color( $version ) {
	
	include_once('acf-rgba-color-v5.php');
	
}

add_action('acf/include_field_types', 'include_field_types_rgba_color');	
?>
