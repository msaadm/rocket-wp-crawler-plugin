<?php
/**
 * Plugin Template
 *
 * @package     RocketWPCrawler
 * @author      Mathieu Lamiot, Muhammad Saad Mateen
 * @copyright   2023
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Rocket WP Crawler
 * Version:     0.1
 * Description: Crawls the homepage and find the internal links.
 * Author:      Mathieu Lamiot, Muhammad Saad Mateen
 */

namespace ROCKET_WP_CRAWLER;

global $rocket_crwl_db_version;
$rocket_crwl_db_version = '0.1';

define( 'ROCKET_CRWL_PLUGIN_FILENAME', __FILE__ ); // Filename of the plugin, including the file.

if ( ! defined( 'ABSPATH' ) ) { // If WordPress is not loaded.
	exit( 'WordPress not loaded. Can not load the plugin' );
}

// Load the dependencies installed through composer.
require_once __DIR__ . '/src/plugin.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/support/exceptions.php';

// Plugin initialization.
/**
 * Creates the plugin object on plugins_loaded hook
 *
 * @return void
 */
function wpc_crawler_plugin_init() {
	$wpc_crawler_plugin = new Rocket_Wpc_Plugin_Class();

	add_action( 'admin_menu', __NAMESPACE__ . '\Classes\Rocket_Wpc_Admin_Page_Class::add_menu' );
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\wpc_crawler_plugin_init' );

register_activation_hook( __FILE__, __NAMESPACE__ . '\Rocket_Wpc_Plugin_Class::wpc_activate' );
register_uninstall_hook( __FILE__, __NAMESPACE__ . '\Rocket_Wpc_Plugin_Class::wpc_uninstall' );
