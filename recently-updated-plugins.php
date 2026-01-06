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
 * Enqueue widget styles
 */
function rup_enqueue_styles() {
	wp_enqueue_style(
		'rup-widget-styles',
		plugin_dir_url( __FILE__ ) . 'assets/css/widget.css',
		array(),
		'1.0.0'
	);
}
add_action( 'admin_enqueue_scripts', 'rup_enqueue_styles' );

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
	?>
	<div class="rup-widget-content">
	<?php

	// Get all installed plugins
	$all_plugins = get_plugins();

	if ( empty( $all_plugins ) ) {
		echo '<p class="rup-empty-message">No plugins found.</p>';
		echo '</div>';
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
				$recently_updated[ $plugin_file ] = array(
					'data'      => $plugin_data,
					'timestamp' => $last_modified,
				);
			}
		}
	}

	// Display results
	if ( empty( $recently_updated ) ) {
		echo '<p class="rup-empty-message">All quiet on the plugin front!</p>';
	} else {
		echo '<p class="rup-description">Plugins updated in the last 7 days:</p>';
		echo '<ul class="rup-plugin-list">';
		foreach ( $recently_updated as $plugin_file => $plugin_info ) {
			$plugin_name = esc_html( $plugin_info['data']['Name'] );
			$plugin_version = esc_html( $plugin_info['data']['Version'] );
			$time_diff = human_time_diff( $plugin_info['timestamp'], current_time( 'timestamp' ) );

			echo '<li class="rup-plugin-item">';
			echo '<div class="rup-plugin-info">';
			echo '<div class="rup-plugin-name">' . $plugin_name . '</div>';
			echo '<div class="rup-update-time">Updated ' . esc_html( $time_diff ) . ' ago</div>';
			echo '</div>';
			echo '<span class="rup-version-badge">v' . $plugin_version . '</span>';
			echo '</li>';
		}
		echo '</ul>';
	}

	// Add Manage Plugins link
	$plugins_url = admin_url( 'plugins.php' );
	echo '<div class="rup-manage-link">';
	echo '<a href="' . esc_url( $plugins_url ) . '">Manage Plugins →</a>';
	echo '</div>';

	echo '</div>';
}
