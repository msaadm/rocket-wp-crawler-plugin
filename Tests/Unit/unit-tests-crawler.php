<?php
/**
 *  Implements the Unit test set for the Rocket WPC Crawler class.
 *
 * @package     RocketWPCrawler
 * @since       2023
 * @author      Mathieu Lamiot, Muhammad Saad Mateen
 * @license     GPL-2.0-or-later
 */

namespace WPMedia\PHPUnit;

use ROCKET_WP_CRAWLER\Classes\Rocket_Wpc_Crawler_Class;
use WPMedia\PHPUnit\Unit\TestCase;


/**
 * Unit test set for the Rocket WPC Crawler data class.
 */
class Test_Rocket_Wpc_Crawler_Class extends TestCase {
	protected $page;

	function set_up() {
		parent::set_up();

		$this->page = '<html lang="en">
						<head>
							<meta charset="UTF-8">
							<meta name="viewport" content="width=device-width, initial-scale=1.0">
							<title>Wordpress</title>
						</head>
						<body>
							<header>
								<div>
									Wordpress Blog
								</div>
								<nav>
								<ul>
									<li><a href="http://example.org">Home</a></li>
									<li><a href="http://example.org/about">About</a></li>
									<li><a href="http://example.org/contact">Contact Us</a></li>
								</ul>
								</nav>
							</header>
							<section>
							 	<div class="post">
							 		<h3><a href="http://example.org/test-post-2">Test Post 2</h3>
							 		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci amet harum illum quo quod ratione voluptatem voluptatibus! Ab amet aspernatur, commodi doloribus ducimus ea, officia quasi quisquam tenetur ut voluptatibus!</p>
								</div>
								<div class="post">
							 		<h3><a href="http://example.org/test-post-1">Test Post 1</h3>
							 		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci amet harum illum quo quod ratione voluptatem voluptatibus! Ab amet aspernatur, commodi doloribus ducimus ea, officia quasi quisquam tenetur ut voluptatibus!</p>
								</div>
					         </section>
							<footer>
								<a href="https://wordpress.org">Wordpress</a>
							</footer>
						</body>
						</html>';
	}

	function test_parse_html_and_get_links() {
		$links = Rocket_Wpc_Crawler_Class::parse_html_and_get_links($this->page);

		$expected_count = 5;

		$this->assertCount($expected_count, $links);
	}
}
