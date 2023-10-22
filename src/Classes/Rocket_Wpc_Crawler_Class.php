<?php

namespace ROCKET_WP_CRAWLER\Classes;

use function Patchwork\Stack\push;

class Rocket_Wpc_Crawler_Class {
	/**
	 * Fetch home page and parse it
	 */
	public static function fetch_page() {
		$response = wp_remote_get( site_url() );
		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Parse HTML and find internal links
	 *
	 * @param String $page Fetched page HTML.
	 *
	 * @return array
	 */
	public static function parse_html_and_get_links( $page ) {
		// Create a DOM parser object.
		$dom = new \DOMDocument();

		// Temporary disable warnings.
		libxml_use_internal_errors( true );
		// Parse the HTML.
		$dom->loadHTML( $page );
		// Enable warnings.
		libxml_use_internal_errors( false );

		$_links = array();

		foreach ( $dom->getElementsByTagName( 'a' ) as $link ) {
			$href = $link->getAttribute( 'href' );
			$text = $link->nodeValue; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

			if ( $href && str_starts_with( $href, site_url() ) ) {
				$_links[] = array(
					'text' => $text,
					'href' => $href,
				);
			}
		}

		return $_links;
	}
}
