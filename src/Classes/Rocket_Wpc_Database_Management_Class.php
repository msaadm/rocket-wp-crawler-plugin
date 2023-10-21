<?php

namespace ROCKET_WP_CRAWLER\Classes;

class Rocket_Wpc_Database_Management_Class {

	/**
	 * Get table name
	 *
	 * @return string
	 */
	public static function get_table_name() {
		global $wpdb;

		return $wpdb->prefix . 'rocket_crwl_links';
	}

	/**
	 * Check is plugin table exists
	 *
	 * @return bool
	 */
	public static function is_table_exist() {
		global $wpdb;
		$table_name = self::get_table_name();

		$exist = wp_cache_get( 'rocket_wp_crawler_table_exists' );
		if ( false === $exist ) {
			$result = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
			// Set cache.
			wp_cache_set( 'rocket_wp_crawler_table_exists', $result );
			// Check if the table exists.
			if ( $result !== $table_name ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Create plugin table in database
	 *
	 * @return void
	 */
	public static function install_table() {
		global $wpdb;
		$table_name = self::get_table_name();

		// Check if the table exists.
		if ( false === self::is_table_exist() ) {
			global $rocket_crwl_db_version;

			// Table not exists, so create it.
			$charset_collate = $wpdb->get_charset_collate();

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			// Creating temporary table.
			dbDelta(
				$wpdb->prepare(
					'CREATE TABLE %1s (' . // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
					' id int(9) NOT NULL AUTO_INCREMENT,' .
					' link text NOT NULL,' .
					' link_text text NOT NULL,' .
					' PRIMARY KEY (id) ) %2s;', // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
					$table_name,
					$charset_collate
				)
			);

			add_option( 'rocket_crwl_db_version', $rocket_crwl_db_version );
		}
	}

	/**
	 * Remove plugin table in database
	 *
	 * @return void
	 */
	public static function uninstall_table() {
		global $wpdb;
		$table_name = self::get_table_name();

		// Clear cache.
		wp_cache_delete( 'rocket_wp_crawler_table_exists' );

		// Check if the table exists.
		if ( true === self::is_table_exist() ) {
			// Table exists, so drop it.
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			// Creating temporary table.
			dbDelta(
				$wpdb->prepare(
					'DROP TABLE %1s', // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnquotedComplexPlaceholder
					$table_name
				)
			);

			delete_option( 'rocket_crwl_db_version' );
		}
	}
}
