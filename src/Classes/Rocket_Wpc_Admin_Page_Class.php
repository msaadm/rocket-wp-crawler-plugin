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
		$links = array();
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
			<button type="button" class="button">Crawl Now!</button>
			<h3>Crawled Links</h3>
			<table class="table">
				<thead>
				<tr>
					<th>S No.</th>
					<th>Link</th>
					<th>Link Text(s)</th>
					<th>Count</th>
				</tr>
				</thead>
				<tbody>
				<?php if ( count( $links ) > 0 ) { ?>
					<tr></tr>
				<?php } else { ?>
					<tr>
						<td colspan="4" style="text-align: center; font-weight: bold">No data</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<?php
	}
}
