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
	// Ensure get_plugins() function is available
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	// Get all installed plugins
	$all_plugins = get_plugins();

	if ( empty( $all_plugins ) ) {
		echo '<p>No plugins found.</p>';
		return;
	}

	echo '<ul>';
	foreach ( $all_plugins as $plugin_file => $plugin_data ) {
		echo '<li>' . esc_html( $plugin_data['Name'] ) . '</li>';
	}
	echo '</ul>';
}
