<?php
/*
Plugin Name: Bike-Coop Site Plugin
Description: A plugin for all the Bike Co-op Functionality that shouldn't be in a theme
Version: 0.1.0
Author: Code for Fort Collins
Author URI: http://codeforfoco.org/
Text Domain: coop-plugin
Domain Path: /languages
*/

add_shortcode( 'fcbc_volunteer_form', 'fcbc_volunteer_form' );
function fcbc_volunteer_form() {
	ob_start();
	include 'volunteer_form.php';
	return ob_get_clean();
}