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

	// Calculate timestamp for 7 days ago
	$seven_days_ago = time() - ( 7 * DAY_IN_SECONDS );
	$recently_updated = array();

	// Filter plugins updated within the last 7 days
	foreach ( $all_plugins as $plugin_file => $plugin_data ) {
		$plugin_path = WP_PLUGIN_DIR . '/' . $plugin_file;

		if ( file_exists( $plugin_path ) ) {
			$last_modified = filemtime( $plugin_path );

			if ( $last_modified >= $seven_days_ago ) {
				$recently_updated[ $plugin_file ] = $plugin_data;
			}
		}
	}

	// Display results
	if ( empty( $recently_updated ) ) {
		echo '<p>All quiet on the plugin front!</p>';
		return;
	}

	echo '<ul>';
	foreach ( $recently_updated as $plugin_file => $plugin_data ) {
		echo '<li>' . esc_html( $plugin_data['Name'] ) . '</li>';
	}
	echo '</ul>';
}
