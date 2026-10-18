<?php
/**
 * Single Investigation Template.
 *
 * @package AgencyBase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$verdict       = get_post_meta( get_the_ID(), '_falso_verdict', true ) ?: 'fake';
	$region        = get_post_meta( get_the_ID(), '_falso_region', true ) ?: 'ليبيا';
	$claim_summary = get_post_meta( get_the_ID(), '_falso_claim_summary', true );

	$verdict_title = 'زائف بالكامل';
	$verdict_color = '#ef4444';
	$rating_value  = 1;
	if ( 'misleading' === $verdict ) {
		$verdict_title = 'مضلل / خارج السياق';
		$verdict_color = '#f59e0b';
		$rating_value  = 3;
	} elseif ( 'verified' === $verdict ) {
		$verdict_title = 'صحيح ومثبت رسمياً';
		$verdict_color = '#10b981';
		$rating_value  = 5;
	}

	// Schema.org ClaimReview JSON-LD
	$schema = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'ClaimReview',
		'datePublished' => get_the_date( 'c' ),
		'url'           => get_permalink(),
		'claimReviewed' => $claim_summary ?: get_the_title(),
		'author'        => array(
			'@type' => 'Organization',
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url(),
		),
		'reviewRating'  => array(
			'@type'               => 'Rating',
			'ratingValue'         => $rating_value,
			'bestRating'          => 5,
			'worstRating'         => 1,
			'alternateName'       => $verdict_title,
		),
	);
	?>
	<script type="application/ld+json">
	<?php echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ); ?>
	</script>

	<main class="falso-container">
		<div class="investigation-header-block">
			<div style="margin-bottom:1rem; font-size:0.85rem; color:var(--text-dim);">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">الرئيسية</a> / 
				<a href="<?php echo esc_url( home_url( '/investigations/' ) ); ?>">التحقيقات</a> / 
				<span>تحقيق #<?php echo esc_html( get_the_ID() ); ?></span>
			</div>

			<h1 style="font-size:2.2rem; font-weight:800; line-height:1.35; margin:0 0 1.25rem;">
				<?php the_title(); ?>
			</h1>

			<div style="display:flex; gap:1.5rem; color:var(--text-muted); font-size:0.9rem; margin-bottom:2rem; border-bottom:1px solid var(--border-subtle); padding-bottom:1.25rem;">
				<span>المنطقة: <strong><?php echo esc_html( $region ); ?></strong></span>
				<span>تاريخ الرصد: <strong><?php echo esc_html( get_the_date() ); ?></strong></span>
				<span>الناشر: <strong>فريق تدقيق البيانات</strong></span>
			</div>

			<div class="verdict-banner-large" style="border-color:<?php echo esc_attr( $verdict_color ); ?>;">
				<div class="verdict-info">
					<h3 style="color:<?php echo esc_attr( $verdict_color ); ?>;">
						النتيجة: <?php echo esc_html( $verdict_title ); ?>
					</h3>
					<p>تم استكمال الفحص الجنائي الرقمي ومطابقة الوثائق الرسمية والبيانات المفتوحة.</p>
				</div>
				<div style="font-family:'JetBrains Mono', monospace; font-size:1.8rem; font-weight:800; color:<?php echo esc_attr( $verdict_color ); ?>;">
					VERDICT: <?php echo esc_html( strtoupper( $verdict ) ); ?>
				</div>
			</div>

			<?php if ( $claim_summary ) : ?>
				<div class="claim-summary-box">
					<h4>نص الادعاء أو الشائعة المتداولة:</h4>
					<p><?php echo esc_html( $claim_summary ); ?></p>
				</div>
			<?php endif; ?>

			<div class="evidence-card">
				<div class="evidence-card-title">
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
					<span>تقرير التحقيق الجنائي والأدلة الميدانية</span>
					<span class="evidence-tag">موثق بالبيانات</span>
				</div>
				<div style="line-height:1.9; font-size:1.05rem; color:#e2e8f0;">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</main>
	<?php
endwhile;

get_footer();
