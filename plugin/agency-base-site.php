<?php
/**
 * Plugin Name: Agency Base Site Functionality
 * Plugin URI: https://example.com/agency-base-site
 * Description: Core functionality plugin handling custom post types, structured data, and integrations.
 * Version: 1.0.0
 * Author: Agency Engineering
 * Text Domain: agency-base-site
 * Requires PHP: 8.0
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/includes/lead-endpoint.php';
require_once __DIR__ . '/includes/schema-generator.php';

/**
 * Initialize core site functionality.
 */
function agency_base_site_init(): void {
	load_plugin_textdomain(
		'agency-base-site',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}
add_action( 'plugins_loaded', 'agency_base_site_init' );
