<?php
/**
 *  Implements the Unit test set for the Rocket WPC Files Management class.
 *
 * @package     RocketWPCrawler
 * @since       2023
 * @author      Mathieu Lamiot, Muhammad Saad Mateen
 * @license     GPL-2.0-or-later
 */

namespace WPMedia\PHPUnit;

use ROCKET_WP_CRAWLER\Classes\Rocket_Wpc_Files_Management_Class;
use WPMedia\PHPUnit\Unit\TestCase;


/**
 * Unit test set for the Rocket WPC Files Management data class.
 */
class Test_Rocket_Wpc_Files_Management_Class extends TestCase {
	protected $links;
	protected $html;

	function set_up() {
		parent::set_up();

		$this->links = [
			[ 'href' => 'https://wordpress.org', 'text' => 'Wordpress' ],
			[ 'href' => 'https://wordpress.org/first-post', 'text' => 'First Post' ],
			[ 'href' => 'https://wordpress.org/second-post', 'text' => 'Second Post' ],
		];

		$this->html = '<html lang="en">
						<head>
							<meta charset="UTF-8">
							<meta name="viewport" content="width=device-width, initial-scale=1.0">
							<title>Wordpress</title>
						</head>
						<body>
							<header>Wordpress</header>
							<div>
								Testing Data
							</div>
							<footer>Copyright</footer>
						</body>
						</html>';
	}

	/**
	 * Test save_homepage.
	 */
	public function test_save_homepage() {

		Rocket_Wpc_Files_Management_Class::save_homepage( $this->html );

		$this->assertFileExists( ABSPATH . '/homepage.html' );

	}

	/**
	 * Test delete_homepage.
	 */
	public function test_delete_homepage() {

		Rocket_Wpc_Files_Management_Class::delete_homepage();

		$this->assertFileDoesNotExist( ABSPATH . '/homepage.html' );
	}

	/**
	 * Test save_sitemap.
	 */
	public function test_save_sitemap() {

		Rocket_Wpc_Files_Management_Class::save_sitemap( $this->links );

		$this->assertFileExists( ABSPATH . '/sitemap.html' );

	}

	/**
	 * Test delete_sitemap.
	 */
	public function test_delete_sitemap() {

		Rocket_Wpc_Files_Management_Class::delete_sitemap();

		$this->assertFileDoesNotExist( ABSPATH . '/sitemap.html' );

	}
}
