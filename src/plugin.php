<?php
/**
 * Plugin main class
 *
 * @package     RocketWPCrawler
 * @since       2023
 * @author      Mathieu Lamiot, Muhammad Saad Mateen
 * @license     GPL-2.0-or-later
 */

namespace ROCKET_WP_CRAWLER;

use ROCKET_WP_CRAWLER\Classes\Rocket_Wpc_Cron_Class;
use ROCKET_WP_CRAWLER\Classes\Rocket_Wpc_Database_Management_Class;

/**
 * Main plugin class. It manages initialization, install, and activations.
 */
class Rocket_Wpc_Plugin_Class {
	/**
	 * Manages plugin initialization
	 *
	 * @return void
	 */
	public function __construct() {

		// Register plugin lifecycle hooks.
		register_deactivation_hook( ROCKET_CRWL_PLUGIN_FILENAME, array( $this, 'wpc_deactivate' ) );
	}

	/**
	 * Handles plugin activation:
	 *
	 * @return void
	 */
	public static function wpc_activate() {
		// Security checks.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$plugin = isset( $_REQUEST['plugin'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['plugin'] ) ) : '';
		check_admin_referer( "activate-plugin_{$plugin}" );

		Rocket_Wpc_Database_Management_Class::install_table();
	}

	/**
	 * Handles plugin deactivation
	 *
	 * @return void
	 */
	public function wpc_deactivate() {
		// Security checks.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}
		$plugin = isset( $_REQUEST['plugin'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['plugin'] ) ) : '';
		check_admin_referer( "deactivate-plugin_{$plugin}" );

		// Clear cache.
		wp_cache_delete( 'rocket_wp_crawler_table_exists' );

		// Deactivate Cron.
		Rocket_Wpc_Cron_Class::deactivate_cron();

		// Delete all Links.
		Rocket_Wpc_Database_Management_Class::delete_all_rows();
	}

	/**
	 * Handles plugin uninstall
	 *
	 * @return void
	 */
	public static function wpc_uninstall() {

		// Security checks.
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		Rocket_Wpc_Database_Management_Class::uninstall_table();
	}
}
