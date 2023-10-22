<?php

namespace ROCKET_WP_CRAWLER\Classes;

class Rocket_Wpc_Files_Management_Class {

	/**
	 * Save Homepage
	 *
	 * @param String $content Homepage HTML.
	 *
	 * @return void
	 */
	public static function save_homepage( $content ) {
		$path = ABSPATH . '/homepage.html';

		if ( file_exists( $path ) ) {
			self::delete_file( $path );
		}

		self::save_file( $path, $content );
	}

	/**
	 * Delete Homepage
	 *
	 * @return void
	 */
	public static function delete_homepage() {
		self::delete_file( ABSPATH . '/homepage.html' );
	}

	/**
	 * Save Sitemap
	 *
	 * @param \stdClass[] $links Data to generate sitemap.
	 *
	 * @return void
	 */
	public static function save_sitemap( $links ) {
		$content = '<html lang="en">
					<head>
						<meta charset="UTF-8">
						<meta name="viewport" content="width=device-width, initial-scale=1.0">
						<title>' . esc_html( get_bloginfo( 'name' ) ) . ' - Sitemap</title>
					</head>
					<body>
						<h1>Sitemap</h1>
						<ul>';

		// Sort links by href in ascending.
		$href_values = array_column( $links, 'href' );
		array_multisort( $href_values, SORT_ASC, $links );

		foreach ( $links as $link ) {
			$content .= "<li><a href='" . $link['href'] . "'>" . $link['text'] . '</a></li>';
		}
		$content .= '</ul>
					</body>
					</html>';

		$path = ABSPATH . '/sitemap.html';

		if ( file_exists( $path ) ) {
			self::delete_file( $path );
		}
		self::save_file( $path, $content );
	}

	/**
	 * Delete Sitemap
	 *
	 * @return void
	 */
	public static function delete_sitemap() {
		self::delete_file( ABSPATH . '/sitemap.html' );
	}

	/**
	 * Save file on the given path with the given content
	 *
	 * @param String $path Path of file to Save.
	 * @param String $content Page HTML Content.
	 *
	 * @return void
	 */
	protected static function save_file( $path, $content ) {
		global $wp_filesystem;
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();

		$wp_filesystem->put_contents( $path, $content, FS_CHMOD_FILE );
	}

	/**
	 * Delete file on the given path
	 *
	 * @param String $path Path of file to delete.
	 *
	 * @return void
	 */
	protected static function delete_file( $path ) {
		global $wp_filesystem;
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();

		$wp_filesystem->delete( $path );
	}
}
