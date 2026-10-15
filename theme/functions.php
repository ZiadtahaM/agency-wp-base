<?php
/**
 * Functions and definitions for Agency Base Theme.
 *
 * @package AgencyBase
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register custom ACF Pro blocks from block.json manifests.
 */
function agency_base_register_blocks(): void {
	$blocks = array(
		'bilingual-hero',
		'art-visualizer',
	);

	foreach ( $blocks as $block ) {
		$block_dir = __DIR__ . '/blocks/' . $block;
		if ( file_exists( $block_dir . '/block.json' ) ) {
			register_block_type( $block_dir );
		}
	}
}
add_action( 'init', 'agency_base_register_blocks' );

/**
 * Enqueue block theme styles and Arabic typography.
 */
function agency_base_enqueue_assets(): void {
	wp_enqueue_style(
		'agency-base-style',
		get_stylesheet_uri(),
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'agency_base_enqueue_assets' );

/**
 * Bootstrap embedded FALSO intelligence and community engine.
 */
if ( file_exists( __DIR__ . '/includes/falso-engine/falso-engine.php' ) ) {
	require_once __DIR__ . '/includes/falso-engine/falso-engine.php';
}
