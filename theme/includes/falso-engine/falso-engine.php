<?php
/**
 * Plugin Name: FALSO Community Engine
 * Plugin URI: https://falso.ly
 * Description: Core intelligence and community engine for FALSO 2.0 Libyan Fact-Checking Platform.
 * Version: 2.0.0
 * Author: Lead Technical Architect
 * Text Domain: falso-engine
 * Requires PHP: 8.2
 */

declare(strict_types=1);

namespace Falso\Engine;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'Falso\\Engine\\Plugin' ) ) {
	return;
}

require_once __DIR__ . '/includes/class-post-types.php';
require_once __DIR__ . '/includes/class-claim-api.php';
require_once __DIR__ . '/includes/class-ai-webhook.php';
require_once __DIR__ . '/includes/class-schema-claimreview.php';

final class Plugin {
	private static ?Plugin $instance = null;

	public static function get_instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __construct() {
		add_action( 'init', array( $this, 'bootstrap' ) );
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
		add_action( 'wp_head', array( $this, 'render_claimreview_schema' ) );
	}

	public function bootstrap(): void {
		Post_Types::register();
		self::register_roles();
	}

	public function register_rest_routes(): void {
		( new Claim_API() )->register_routes();
		( new AI_Webhook() )->register_routes();
	}

	public function render_claimreview_schema(): void {
		if ( is_singular( 'falso_investigation' ) ) {
			Schema_ClaimReview::render( get_the_ID() );
		}
	}

	private static function register_roles(): void {
		// Custom roles: Fact-checker / Investigator, Community Contributor.
		add_role(
			'falso_investigator',
			__( 'محقق فالصو', 'falso-engine' ),
			array(
				'read'                      => true,
				'edit_posts'                => true,
				'edit_falso_claims'         => true,
				'publish_falso_investigations' => true,
				'upload_files'              => true,
			)
		);

		add_role(
			'falso_contributor',
			__( 'مساهم مجتمعي', 'falso-engine' ),
			array(
				'read'              => true,
				'submit_evidence'   => true,
				'submit_claims'     => true,
			)
		);
	}
}

Plugin::get_instance();

// Automatically flush rewrite rules once after activation if claims rule is missing
add_action( 'init', function() {
	if ( ! get_option( 'falso_rewrite_flushed' ) ) {
		flush_rewrite_rules( false );
		update_option( 'falso_rewrite_flushed', '1' );
	}
}, 99 );
