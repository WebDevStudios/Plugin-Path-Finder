<?php
/**
 * Helper functions to extend WordPress's `plugin_dir_path` and `plugin_dir_url` methods.
 *
 * These functions can be called from any file inside of a WordPress plugin to get the plugin's root path or the
 * URL to a plugin asset. Functions must be called after the `plugins_loaded` event, or PHP will throw a fatal error.
 *
 * @author Jeremy Ward <jeremy.ward@webdevstudios.com>
 * @package WDS\Utils\PluginPathFinder
 */

namespace WDS\Utils\PluginPathFinder;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

require_once ABSPATH . 'wp-admin/includes/plugin.php';

if ( ! defined( 'DS' ) ) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

/**
 * Get the plugin directory root for any plugin.
 *
 * @param string $file_path The path of the file to parse.
 *
 * @return string
 */
function get_plugin_dir( $file_path ) {
	$file_path   = is_file( $file_path ) ? plugin_dir_path( $file_path ) : $file_path;
	$plugin_path = explode( DS, plugin_basename( $file_path ) );

	if ( empty( $plugin_path ) ) {
		return '';
	}

	// Get all of the installed plugin directories.
	$plugin_dirs = array_map( function ( $plugin ) {
		$parts = explode( DS, $plugin );

		return isset( $parts[1] ) ? $parts[0] : '';
	}, array_keys( get_plugins() ) );

	return in_array( $plugin_path[0], $plugin_dirs, true )
		? WP_PLUGIN_DIR . DS . $plugin_path[0] . DS
		: WP_PLUGIN_DIR . DS;
}

/**
 * Get the url of a plugin asset.
 *
 * @param string $file_path The path of the file to parse.
 *
 * @return string
 */
function get_plugin_url( $file_path ) {
	$relative_file_path = plugin_basename( $file_path );

	return plugin_dir_url( get_plugin_dir( $relative_file_path ) ) . $relative_file_path;
}
