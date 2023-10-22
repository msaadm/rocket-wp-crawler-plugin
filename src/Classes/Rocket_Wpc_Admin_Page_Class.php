<?php

namespace ROCKET_WP_CRAWLER\Classes;

class Rocket_Wpc_Admin_Page_Class {
	/**
	 * Add menu page in WP Admin
	 *
	 * @return void
	 */
	public static function add_menu() {
		add_menu_page(
			'Rocket WP Crawler',
			'Rocket WP Crawler',
			'manage_options',
			'rocket-wp-crawler',
			array( self::class, 'content' )
		);
	}

	/**
	 * Content for the WP admin page
	 *
	 * @return void
	 */
	public static function content() {
		// Fetch All links.
		$result = Rocket_Wpc_Database_Management_Class::get_all_rows();
		$nonce  = wp_create_nonce( 'handle_crawl_now_nonce' );
		?>
		<style>
			#rocket_wp_crawler_admin {
				font-family: Arial, Helvetica, sans-serif;
			}

			#rocket_wp_crawler_admin .button {
				background-color: #005BC6;
				border: none;
				color: white;
				padding: 8px 16px;
				text-align: center;
				text-decoration: none;
				display: inline-block;
				font-size: 16px;
				border-radius: 5px;
			}

			#rocket_wp_crawler_admin .table {
				border-collapse: collapse;
				width: 100%;
			}

			#rocket_wp_crawler_admin .table td, #rocket_wp_crawler_admin .table th {
				border: 1px solid #ddd;
				padding: 8px;
			}

			#rocket_wp_crawler_admin .table tr:nth-child(even) {
				background-color: #f2f2f2;
			}

			#rocket_wp_crawler_admin .table tr:hover {
				background-color: #ddd;
			}

			#rocket_wp_crawler_admin .table th {
				padding-top: 12px;
				padding-bottom: 12px;
				text-align: left;
				background-color: #005BC6;
				color: white;
			}
		</style>
		<div id="rocket_wp_crawler_admin" class="wrap">
			<h2>Rocket WP Crawler</h2>
			<div id="header">
				<?php $timestamp = wp_next_scheduled( Rocket_Wpc_Cron_Class::ROCKET_WPC_CRON_HOOK ); ?>
				<?php if ( false === $timestamp ) : ?>
					<button type="button" class="button" id="rocket_wpc_action_btn" data-action="crawl"
							data-nonce="<?php echo esc_html( $nonce ); ?>">
						Crawl Now!
					</button>
				<?php else : ?>
					<button type="button" class="button" id="rocket_wpc_action_btn" data-action="unscheduled"
							data-nonce="<?php echo esc_html( $nonce ); ?>">
						Remove Crawler Cron
					</button>
					<span>
				Crawler will run again at <?php echo esc_html( gmdate( 'd/m/Y\ H:i:s', $timestamp ) ); ?>
				</span>
				<?php endif; ?>
			</div>

			<h3>Crawled Links</h3>
			<table class="table">
				<thead>
				<tr>
					<th>S No.</th>
					<th>Link</th>
					<th>Link Text(s)</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if ( count( $result ) > 0 ) {
					$i = 1;
					foreach ( $result as $row ) {
						?>
						<tr>
							<td><?php echo esc_html( $i++ ); ?></td>
							<td><?php echo esc_html( $row->link ); ?></td>
							<td><?php echo esc_html( $row->link_text ); ?></td>
						</tr>
						<?php
					}
				} else {
					?>
					<tr>
						<td colspan="4" style="text-align: center; font-weight: bold">No data</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	/**
	 * Enqueue Javascript files and ajax endpoint
	 *
	 * @return void
	 */
	public static function enqueue_scripts() {

		// Register the JS file with a unique handle, file location, and an array of dependencies.
		wp_register_script(
			'rocket_wpc',
			plugin_dir_url( __FILE__ ) . '../js/rocket_wpc.js',
			array( 'jquery' ),
			'1.0',
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);

		// localize the script to your domain name, so that you can reference the url to admin-ajax.php file easily.
		wp_localize_script( 'rocket_wpc', 'rocketWpcAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		// enqueue jQuery library and the script you registered above.
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'rocket_wpc' );
	}

	/**
	 * Ajax action to Handle Click Event
	 *
	 * @return void
	 */
	public static function handle_crawl_now() {
		// nonce check for an extra layer of security, the function will exit if it fails.
		if ( isset( $_REQUEST['nonce'] )
			&& ! wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ),
				'handle_crawl_now_nonce'
			)
		) {
			exit( 'Error' );
		}

		try {
			if ( Rocket_Wpc_Cron_Class::is_cron_scheduled() ) {
				Rocket_Wpc_Cron_Class::deactivate_cron();
			} else {
				sleep( 5 ); // temp fix for first time.
				Rocket_Wpc_Cron_Class::register_cron();
			}
			exit( 'DONE' );
		} catch ( \Exception $ex ) {
			exit( esc_html( $ex->getMessage() ) );
		}
	}

	/**
	 * Wrapper function for crawler event
	 *
	 * @return void
	 */
	public static function do_crawler_process() {
		// Delete all Links.
		Rocket_Wpc_Database_Management_Class::delete_all_rows();

		// Fetch page and parse links.
		$page = Rocket_Wpc_Crawler_Class::fetch_page();

		// Save Homepage.
		Rocket_Wpc_Files_Management_Class::save_homepage( $page );

		// Parse the HTML and get Links.
		$links = Rocket_Wpc_Crawler_Class::parse_html_and_get_links( $page );

		// Insert Links.
		Rocket_Wpc_Database_Management_Class::insert_links( $links );

		// Generate Sitemap.
		Rocket_Wpc_Files_Management_Class::save_sitemap( $links );
	}
}
