<?php
declare(strict_types=1);

namespace Falso\Engine;

use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class AI_Webhook {
	public function register_routes(): void {
		register_rest_route(
			'falso/v1',
			'/integrations/ai-analysis',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_ai_enrichment' ),
				'permission_callback' => array( $this, 'verify_webhook_signature' ),
				'args'                => array(
					'claim_id' => array(
						'required'          => true,
						'type'              => 'integer',
						'sanitize_callback' => 'absint',
					),
					'sentiment' => array(
						'required'          => false,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_text_field',
					),
					'hate_speech_score' => array(
						'required'          => false,
						'type'              => 'number',
					),
					'extracted_entities' => array(
						'required' => false,
						'type'     => 'array',
					),
					'summary_ar' => array(
						'required'          => false,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_textarea_field',
					),
				),
			)
		);
	}

	public function verify_webhook_signature( WP_REST_Request $request ): bool {
		$secret = defined( 'FALSO_MAKE_WEBHOOK_SECRET' ) ? FALSO_MAKE_WEBHOOK_SECRET : '';
		if ( empty( $secret ) ) {
			return false;
		}

		$signature = (string) $request->get_header( 'X-Falso-Signature' );
		$payload   = $request->get_body();
		$expected  = hash_hmac( 'sha256', $payload, $secret );

		return hash_equals( $expected, $signature );
	}

	public function handle_ai_enrichment( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$claim_id           = (int) $request->get_param( 'claim_id' );
		$hate_speech_score  = (float) $request->get_param( 'hate_speech_score' );
		$sentiment          = (string) $request->get_param( 'sentiment' );
		$extracted_entities = (array) $request->get_param( 'extracted_entities' );
		$summary_ar         = (string) $request->get_param( 'summary_ar' );

		if ( 'falso_claim' !== get_post_type( $claim_id ) ) {
			return new WP_Error( 'invalid_claim_id', __( 'معرف الادعاء غير صحيح', 'falso-engine' ), array( 'status' => 404 ) );
		}

		// Store AI analysis as assistant metadata for human fact-checkers.
		update_post_meta( $claim_id, '_falso_ai_hate_score', $hate_speech_score );
		update_post_meta( $claim_id, '_falso_ai_sentiment', $sentiment );
		update_post_meta( $claim_id, '_falso_ai_entities', $extracted_entities );
		update_post_meta( $claim_id, '_falso_ai_summary', $summary_ar );
		update_post_meta( $claim_id, '_falso_ai_processed_at', current_time( 'mysql' ) );

		return new WP_REST_Response(
			array(
				'success'  => true,
				'claim_id' => $claim_id,
				'message'  => __( 'تم تسجيل نتائج التحليل الآلي كمسودة مساعدة للمحقق البشري', 'falso-engine' ),
			),
			200
		);
	}
}
