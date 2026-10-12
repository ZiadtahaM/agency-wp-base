<?php
/**
 * Render template for Bilingual Hero ACF Block.
 *
 * @package AgencyBase
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_badge    = get_field( 'hero_badge' ) ?: __( 'حصرياً في الخليج', 'agency-base' );
$hero_title    = get_field( 'hero_title' ) ?: __( 'لوحات جدارية فاخرة تُعبّر عن هويتك', 'agency-base' );
$hero_lead     = get_field( 'hero_lead' ) ?: __( 'تصاميم فنية سعودية وعربية مستوحاة من التراث والأصالة، مطبوعة على أفخر خامات الكانفاس وبإطارات خشبية متقنة.', 'agency-base' );
$primary_text  = get_field( 'primary_btn_text' ) ?: __( 'تصفح المجموعة', 'agency-base' );
$primary_url   = get_field( 'primary_btn_url' ) ?: '/shop/';
$whatsapp_num  = get_field( 'whatsapp_number' ) ?: '+966501234567';
$clean_phone   = preg_replace( '/[^0-9]/', '', (string) $whatsapp_num );
$whatsapp_url  = 'https://wa.me/' . $clean_phone . '?text=' . rawurlencode( __( 'مرحباً، أود الاستفسار عن تفاصيل اللوحات الجدارية والمقاسات الخاصة.', 'agency-base' ) );

$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'agency-hero' ) );
?>

<section <?php echo wp_kses_data( $wrapper_attributes ); ?>>
	<div class="agency-hero__container">
		<?php if ( ! empty( $hero_badge ) ) : ?>
			<div class="agency-hero__badge">
				<span><?php echo esc_html( (string) $hero_badge ); ?></span>
			</div>
		<?php endif; ?>

		<h1 class="agency-hero__title">
			<?php echo esc_html( (string) $hero_title ); ?>
		</h1>

		<p class="agency-hero__lead">
			<?php echo esc_html( (string) $hero_lead ); ?>
		</p>

		<div class="agency-hero__actions">
			<a href="<?php echo esc_url( (string) $primary_url ); ?>" class="agency-hero__btn agency-hero__btn--primary">
				<?php echo esc_html( (string) $primary_text ); ?>
			</a>

			<a href="<?php echo esc_url( $whatsapp_url ); ?>" class="agency-hero__btn agency-hero__btn--whatsapp" target="_blank" rel="noopener noreferrer">
				<span aria-hidden="true">&#x1F4AC;</span>
				<?php esc_html_e( 'طلب خاص عبر واتساب', 'agency-base' ); ?>
			</a>
		</div>
	</div>
</section>
