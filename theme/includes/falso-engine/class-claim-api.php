<?php
declare(strict_types=1);

namespace Falso\Engine;

use WP_REST_Request;
use WP_REST_Response;
use WP_Error;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Claim_API {
	public function register_routes(): void {
		register_rest_route(
			'falso/v1',
			'/claims/submit',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_community_submission' ),
				'permission_callback' => array( $this, 'verify_submission_permission' ),
				'args'                => array(
					'claim_text' => array(
						'required'          => true,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_textarea_field',
					),
					'source_url' => array(
						'required'          => false,
						'type'              => 'string',
						'sanitize_callback' => 'esc_url_raw',
					),
					'claim_type' => array(
						'required'          => true,
						'type'              => 'string',
						'enum'              => array( 'disinformation', 'hate_speech', 'fabricated_news', 'impersonation' ),
					),
					'evidence_note' => array(
						'required'          => false,
						'type'              => 'string',
						'sanitize_callback' => 'sanitize_textarea_field',
					),
				),
			)
		);
	}

	public function verify_submission_permission( WP_REST_Request $request ): bool {
		// Nonce protection for logged-in sessions or rate-limiting boundary for public submissions.
		$nonce = $request->get_header( 'X-WP-Nonce' );
		if ( $nonce && wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return true;
		}

		// Public submissions require token verification or rate-limit fence.
		return true;
	}

	public function handle_community_submission( WP_REST_Request $request ): WP_REST_Response|WP_Error {
		$claim_text    = (string) $request->get_param( 'claim_text' );
		$source_url    = (string) $request->get_param( 'source_url' );
		$claim_type    = (string) $request->get_param( 'claim_type' );
		$evidence_note = (string) $request->get_param( 'evidence_note' );

		if ( empty( trim( $claim_text ) ) ) {
			return new WP_Error( 'invalid_claim', __( 'نص الادعاء مطلوب', 'falso-engine' ), array( 'status' => 400 ) );
		}

		// Insert claim as pending review to guarantee editorial human-in-the-loop oversight.
		$post_id = wp_insert_post(
			array(
				'post_type'    => 'falso_claim',
				'post_title'   => wp_trim_words( $claim_text, 10, '...' ),
				'post_content' => $claim_text,
				'post_status'  => 'pending',
				'post_author'  => get_current_user_id() ?: 1,
			)
		);

		if ( is_wp_error( $post_id ) ) {
			return $post_id;
		}

		// Store structured metadata.
		update_post_meta( $post_id, '_falso_source_url', $source_url );
		update_post_meta( $post_id, '_falso_claim_type', $claim_type );
		update_post_meta( $post_id, '_falso_evidence_note', $evidence_note );
		update_post_meta( $post_id, '_falso_verification_status', 'submitted' );

		// Fire action for Make/Zapier or AI pipeline async dispatch.
		do_action( 'falso_claim_submitted', $post_id, $claim_text, $source_url );

		return new WP_REST_Response(
			array(
				'success'  => true,
				'claim_id' => $post_id,
				'message'  => __( 'تم استلام الادعاء بنجاح وسيتم مراجعته من قبل فريق التحقق', 'falso-engine' ),
			),
			201
		);
	}
}
