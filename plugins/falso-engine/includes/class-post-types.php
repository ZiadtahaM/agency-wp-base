<?php
declare(strict_types=1);

namespace Falso\Engine;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Post_Types {
	public static function register(): void {
		// 1. Claims (الادعاءات المرصودة من الجمهور)
		register_post_type(
			'falso_claim',
			array(
				'labels' => array(
					'name'               => __( 'الادعاءات', 'falso-engine' ),
					'singular_name'      => __( 'ادعاء', 'falso-engine' ),
					'add_new_item'       => __( 'إضافة ادعاء جديد', 'falso-engine' ),
					'edit_item'          => __( 'تعديل الادعاء', 'falso-engine' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'author', 'custom-fields' ),
				'menu_icon'    => 'dashicons-warning',
				'rewrite'      => array( 'slug' => 'claims' ),
			)
		);

		// 2. Investigations & Reports (التحقيقات المنشورة مع التقييم النهائي)
		register_post_type(
			'falso_investigation',
			array(
				'labels' => array(
					'name'               => __( 'التحقيقات', 'falso-engine' ),
					'singular_name'      => __( 'تحقيق', 'falso-engine' ),
					'add_new_item'       => __( 'إضافة تحقيق جديد', 'falso-engine' ),
					'edit_item'          => __( 'تعديل التحقيق', 'falso-engine' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
				'menu_icon'    => 'dashicons-shield-alt',
				'rewrite'      => array( 'slug' => 'investigations' ),
			)
		);

		// 3. Taxonomies: Verdict / Rating (الحكم: مضلل، زائف، صحيح جزئياً، سياق ناقص)
		register_taxonomy(
			'falso_verdict',
			array( 'falso_investigation' ),
			array(
				'labels' => array(
					'name'          => __( 'حكم التحقق', 'falso-engine' ),
					'singular_name' => __( 'الحكم', 'falso-engine' ),
				),
				'public'       => true,
				'hierarchical' => true,
				'show_in_rest' => true,
				'rewrite'      => array( 'slug' => 'verdict' ),
			)
		);

		// 4. Taxonomy: Topic / Geography (المنطقة: طرابلس، بنغازي، سبها، عموم ليبيا)
		register_taxonomy(
			'falso_region',
			array( 'falso_claim', 'falso_investigation' ),
			array(
				'labels' => array(
					'name'          => __( 'المنطقة الجغرافية', 'falso-engine' ),
					'singular_name' => __( 'المنطقة', 'falso-engine' ),
				),
				'public'       => true,
				'hierarchical' => true,
				'show_in_rest' => true,
				'rewrite'      => array( 'slug' => 'region' ),
			)
		);
	}
}
