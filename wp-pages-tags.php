<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/Orinwebsolutions
 * @since             1.0.0
 * @package           Wp_Pages_Tags
 *
 * @wordpress-plugin
 * Plugin Name:       Wordpress tags for pages
 * Plugin URI:        https://github.com/Orinwebsolutions
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Amila Priyankara
 * Author URI:        https://github.com/Orinwebsolutions
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-pages-tags
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_PAGES_TAGS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-pages-tags-activator.php
 */
function activate_wp_pages_tags() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-pages-tags-activator.php';
	Wp_Pages_Tags_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-pages-tags-deactivator.php
 */
function deactivate_wp_pages_tags() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-pages-tags-deactivator.php';
	Wp_Pages_Tags_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_pages_tags' );
register_deactivation_hook( __FILE__, 'deactivate_wp_pages_tags' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-pages-tags.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_pages_tags() {

	$plugin = new Wp_Pages_Tags();
	$plugin->run();

}
run_wp_pages_tags();
