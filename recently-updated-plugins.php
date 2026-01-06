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

	// Output widget styles
	?>
	<style>
		.rup-widget-content {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
		}
		.rup-plugin-list {
			margin: 0;
			padding: 0;
			list-style: none;
		}
		.rup-plugin-item {
			padding: 12px;
			margin-bottom: 8px;
			background: #f6f7f7;
			border-radius: 4px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			transition: background 0.2s ease;
		}
		.rup-plugin-item:hover {
			background: #e8eaeb;
		}
		.rup-plugin-name {
			font-weight: 500;
			color: #1d2327;
			font-size: 14px;
		}
		.rup-version-badge {
			display: inline-block;
			padding: 4px 10px;
			background: #2271b1;
			color: #fff;
			border-radius: 12px;
			font-size: 11px;
			font-weight: 600;
			letter-spacing: 0.3px;
		}
		.rup-empty-message {
			text-align: center;
			color: #646970;
			font-style: italic;
			padding: 20px;
			margin: 0;
		}
		.rup-manage-link {
			margin-top: 15px;
			padding-top: 12px;
			border-top: 1px solid #dcdcde;
			text-align: center;
		}
		.rup-manage-link a {
			text-decoration: none;
			color: #2271b1;
			font-weight: 500;
		}
		.rup-manage-link a:hover {
			color: #135e96;
		}
	</style>
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
				$recently_updated[ $plugin_file ] = $plugin_data;
			}
		}
	}

	// Display results
	if ( empty( $recently_updated ) ) {
		echo '<p class="rup-empty-message">All quiet on the plugin front!</p>';
	} else {
		echo '<ul class="rup-plugin-list">';
		foreach ( $recently_updated as $plugin_file => $plugin_data ) {
			$plugin_name = esc_html( $plugin_data['Name'] );
			$plugin_version = esc_html( $plugin_data['Version'] );

			echo '<li class="rup-plugin-item">';
			echo '<span class="rup-plugin-name">' . $plugin_name . '</span>';
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
