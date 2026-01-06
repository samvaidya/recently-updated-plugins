<?php
/**
 * Plugin Name: Recently Updated Plugins
 * Description: Adds a dashboard widget displaying recently updated plugins
 * Version: 1.0.0
 * Author: Sam Vaidya & Claude
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: recently-updated-plugins
 */

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the dashboard widget
 */
function rup_register_dashboard_widget() {
	wp_add_dashboard_widget(
		'recently_updated_plugins_widget',
		'Recently Updated Plugins',
		'rup_display_dashboard_widget'
	);
}
add_action( 'wp_dashboard_setup', 'rup_register_dashboard_widget' );

/**
 * Display the dashboard widget content
 */
function rup_display_dashboard_widget() {
	echo '<p>Plugin updates will appear here.</p>';
}
