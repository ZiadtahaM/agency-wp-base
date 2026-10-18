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
 * Setup theme features.
 */
function agency_base_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary Navigation', 'agency-base' ),
			'footer'  => __( 'Footer Navigation', 'agency-base' ),
		)
	);
}
add_action( 'after_setup_theme', 'agency_base_setup' );

/**
 * Enqueue scripts and styles.
 */
function agency_base_enqueue_assets(): void {
	wp_enqueue_style(
		'agency-base-fonts',
		'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'agency-base-style',
		get_stylesheet_uri(),
		array( 'agency-base-fonts' ),
		'2.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'agency_base_enqueue_assets' );

/**
 * Enqueue editor styles for Gutenberg canvas.
 */
function agency_base_block_editor_assets(): void {
	wp_enqueue_style(
		'agency-base-editor-fonts',
		'https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'agency-base-editor-canvas',
		get_template_directory_uri() . '/style.css',
		array( 'agency-base-editor-fonts' ),
		'2.0.0'
	);
}
add_action( 'enqueue_block_editor_assets', 'agency_base_block_editor_assets' );

/**
 * Register custom post types for investigations and claims.
 */
function agency_base_register_post_types(): void {
	register_post_type(
		'falso_investigation',
		array(
			'labels'       => array(
				'name'          => 'التحقيقات',
				'singular_name' => 'تحقيق استقصائي',
				'add_new'       => 'إضافة تحقيق جديد',
				'edit_item'     => 'تعديل التحقيق',
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-shield',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
			'rewrite'      => array( 'slug' => 'investigations' ),
		)
	);

	register_post_type(
		'falso_claim',
		array(
			'labels'       => array(
				'name'          => 'سجل الادعاءات',
				'singular_name' => 'ادعاء مرصود',
				'add_new'       => 'تسجيل ادعاء جديد',
				'edit_item'     => 'تعديل الادعاء',
			),
			'public'       => true,
			'has_archive'  => true,
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-warning',
			'supports'     => array( 'title', 'editor', 'custom-fields' ),
			'rewrite'      => array( 'slug' => 'claims' ),
		)
	);
}
add_action( 'init', 'agency_base_register_post_types' );

/**
 * Register custom blocks from block.json manifests.
 */
function agency_base_register_blocks(): void {
	$blocks = array();
	foreach ( $blocks as $block ) {
		$block_dir = __DIR__ . '/blocks/' . $block;
		if ( file_exists( $block_dir . '/block.json' ) ) {
			register_block_type( $block_dir );
		}
	}
}
add_action( 'init', 'agency_base_register_blocks' );

/**
 * Bootstrap embedded FALSO intelligence and community engine.
 */
if ( file_exists( __DIR__ . '/includes/falso-engine/falso-engine.php' ) ) {
	require_once __DIR__ . '/includes/falso-engine/falso-engine.php';
}
