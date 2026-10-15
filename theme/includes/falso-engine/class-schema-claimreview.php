<?php
declare(strict_types=1);

namespace Falso\Engine;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Schema_ClaimReview {
	public static function render( int $post_id ): void {
		$verdict_terms = get_the_terms( $post_id, 'falso_verdict' );
		$verdict_name  = ( ! empty( $verdict_terms ) && ! is_wp_error( $verdict_terms ) )
			? $verdict_terms[0]->name
			: 'False';

		$claim_reviewed = get_post_meta( $post_id, '_falso_claim_reviewed', true ) ?: get_the_title( $post_id );
		$appearance_url = get_post_meta( $post_id, '_falso_appearance_url', true ) ?: '';

		$schema = array(
			'@context'          => 'https://schema.org',
			'@type'             => 'ClaimReview',
			'url'               => get_permalink( $post_id ),
			'claimReviewed'     => esc_html( (string) $claim_reviewed ),
			'datePublished'     => get_the_date( 'c', $post_id ),
			'itemReviewed'      => array(
				'@type'          => 'Claim',
				'appearance'     => $appearance_url ? array( '@type' => 'CreativeWork', 'url' => esc_url( (string) $appearance_url ) ) : null,
			),
			'author'            => array(
				'@type' => 'Organization',
				'name'  => 'FALSO.LY',
				'url'   => 'https://falso.ly',
				'logo'  => array(
					'@type' => 'ImageObject',
					'url'   => 'https://falso.ly/wp-content/uploads/logo.png',
				),
			),
			'reviewRating'      => array(
				'@type'             => 'Rating',
				'ratingValue'       => self::map_verdict_to_value( $verdict_name ),
				'bestRating'        => '5',
				'worstRating'       => '1',
				'alternateName'     => esc_html( $verdict_name ),
			),
		);

		// Output clean, un-sloped JSON-LD graph.
		printf(
			'<script type="application/ld+json">%s</script>' . "\n",
			wp_json_encode( array_filter( $schema ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		);
	}

	private static function map_verdict_to_value( string $verdict ): string {
		return match ( $verdict ) {
			'صحيح'           => '5',
			'صحيح جزئياً'    => '3',
			'سياق مضلل'      => '2',
			'زائف', 'مضلل'   => '1',
			default          => '1',
		};
	}
}
