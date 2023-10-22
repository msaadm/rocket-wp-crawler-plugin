<?php

namespace ROCKET_WP_CRAWLER\Classes;

class Rocket_Wpc_Cron_Class {
	const ROCKET_WPC_CRON_HOOK = 'rocket_wpc_cron_hook';

	/**
	 * Register Cron
	 *
	 * @return void
	 */
	public static function register_cron() {
		if ( ! self::is_cron_scheduled() ) {
			wp_schedule_event( time(), 'hourly', self::ROCKET_WPC_CRON_HOOK );
		}
	}

	/**
	 * Deactivate Cron
	 *
	 * @return void
	 */
	public static function deactivate_cron() {
		$timestamp = wp_next_scheduled( self::ROCKET_WPC_CRON_HOOK );
		wp_unschedule_event( $timestamp, self::ROCKET_WPC_CRON_HOOK );
	}

	/**
	 * Check is cron scheduled
	 *
	 * @return bool
	 */
	public static function is_cron_scheduled() {
		return ! ( false === wp_next_scheduled( self::ROCKET_WPC_CRON_HOOK ) );
	}
}
