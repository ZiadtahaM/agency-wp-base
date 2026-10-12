<?php
/**
 * Render template for Art & Frame Visualizer ACF Block.
 *
 * @package AgencyBase
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$default_img = get_template_directory_uri() . '/assets/sample-art.webp';
$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => 'art-visualizer' ) );
?>

<div <?php echo wp_kses_data( $wrapper_attributes ); ?> data-component="art-visualizer">
	<div class="art-visualizer__grid">
		<div class="art-visualizer__stage">
			<div class="art-visualizer__frame art-visualizer__frame--black" data-frame-element>
				<img src="<?php echo esc_url( $default_img ); ?>" alt="<?php esc_attr_e( 'معاينة اللوحة الفنية', 'agency-base' ); ?>" class="art-visualizer__canvas-img" data-canvas-image>
			</div>
		</div>

		<div class="art-visualizer__controls">
			<h2><?php esc_html_e( 'تخصيص اللوحة الجدارية', 'agency-base' ); ?></h2>

			<div class="art-visualizer__control-group">
				<h3><?php esc_html_e( 'اختر المقاس:', 'agency-base' ); ?></h3>
				<div class="art-visualizer__options" data-size-selector>
					<button type="button" class="art-visualizer__btn is-active" data-size="40x60" data-price="290">40 × 60 سم</button>
					<button type="button" class="art-visualizer__btn" data-size="60x90" data-price="420">60 × 90 سم</button>
					<button type="button" class="art-visualizer__btn" data-size="80x120" data-price="650">80 × 120 سم</button>
					<button type="button" class="art-visualizer__btn" data-size="100x150" data-price="980">100 × 150 سم</button>
				</div>
			</div>

			<div class="art-visualizer__control-group">
				<h3><?php esc_html_e( 'نوع ولون الإطار:', 'agency-base' ); ?></h3>
				<div class="art-visualizer__options" data-frame-selector>
					<button type="button" class="art-visualizer__btn is-active" data-frame="black"><?php esc_html_e( 'أسود غير لامع', 'agency-base' ); ?></button>
					<button type="button" class="art-visualizer__btn" data-frame="natural-oak"><?php esc_html_e( 'خشب طبيعي', 'agency-base' ); ?></button>
					<button type="button" class="art-visualizer__btn" data-frame="gold"><?php esc_html_e( 'ذهبي ملكي', 'agency-base' ); ?></button>
					<button type="button" class="art-visualizer__btn" data-frame="borderless"><?php esc_html_e( 'كانفاس مشدود (بدون إطار)', 'agency-base' ); ?></button>
				</div>
			</div>

			<div class="art-visualizer__price-tag">
				<span data-price-display>290</span> <?php esc_html_e( 'ر.س', 'agency-base' ); ?>
			</div>
		</div>
	</div>
</div>
