<?php
/**
 * Template Name: Submit Claim
 *
 * @package AgencyBase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$success_msg = '';
$error_msg   = '';

if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['falso_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['falso_nonce'] ), 'submit_claim_action' ) ) {
	$title   = sanitize_text_field( wp_unslash( $_POST['claim_title'] ?? '' ) );
	$details = sanitize_textarea_field( wp_unslash( $_POST['claim_text'] ?? '' ) );
	$source  = esc_url_raw( wp_unslash( $_POST['claim_source_url'] ?? '' ) );
	$region  = sanitize_text_field( wp_unslash( $_POST['claim_region'] ?? '' ) );

	if ( empty( $title ) || empty( $details ) ) {
		$error_msg = 'يرجى كتابة عنوان الادعاء وتفاصيل المنشور للتمكن من فحصه.';
	} else {
		$claim_id = wp_insert_post(
			array(
				'post_title'   => $title,
				'post_content' => $details,
				'post_type'    => 'falso_claim',
				'post_status'  => 'pending',
			)
		);

		if ( $claim_id && ! is_wp_error( $claim_id ) ) {
			update_post_meta( $claim_id, '_falso_source_url', $source );
			update_post_meta( $claim_id, '_falso_region', $region );
			update_post_meta( $claim_id, '_falso_status', 'submitted' );
			$success_msg = 'تم استلام بلاغك بنجاح وقيده برقم #' . $claim_id . '. سيتولى فريق التدقيق فحصه والتحقق من مصادره.';
		} else {
			$error_msg = 'حدث خطأ أثناء حفظ البلاغ، يرجى المحاولة لاحقاً.';
		}
	}
}

get_header();
?>

<main class="falso-container">
	<div style="max-width:820px; margin:0 auto 1.5rem; text-align:center;">
		<h1 style="font-size:2.2rem; font-weight:800; margin-bottom:0.5rem;">تقديم بلاغ عن شائعة أو خبر مشبوه</h1>
		<p style="color:var(--text-muted); font-size:1rem;">
			ساهم في حماية المجتمع الليبي. أرسل نص الادعاء أو رابط المنشور وسيتم تحويله فوراً لمختبر التحقق المفتوح.
		</p>
	</div>

	<div class="submission-wrapper">
		<?php if ( $success_msg ) : ?>
			<div class="alert-box alert-success" style="display:block;">
				<?php echo esc_html( $success_msg ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $error_msg ) : ?>
			<div class="alert-box alert-error" style="display:block;">
				<?php echo esc_html( $error_msg ); ?>
			</div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( get_permalink() ); ?>">
			<?php wp_nonce_field( 'submit_claim_action', 'falso_nonce' ); ?>

			<div class="form-group">
				<label class="form-label">
					عنوان الادعاء أو الشائعة المختصر <span class="req">*</span>
				</label>
				<input type="text" name="claim_title" class="form-control" required placeholder="مثال: وثيقة تزعم إغلاق منفذ رأس جدير الحدودي" />
				<div class="form-help">اكتب ملخصاً موجزاً للخبر أو الإشاعة كما تداولتها المنصات.</div>
			</div>

			<div class="form-group">
				<label class="form-label">
					نص المنشور أو التفاصيل المتداولة <span class="req">*</span>
				</label>
				<textarea name="claim_text" class="form-control" required placeholder="انسخ نص المنشور أو صف الصورة/الفيديو المرفق مع الادعاء..."></textarea>
			</div>

			<div class="form-grid-2">
				<div class="form-group">
					<label class="form-label">رابط المنشور (Facebook / Twitter / TikTok)</label>
					<input type="url" name="claim_source_url" class="form-control" placeholder="https://facebook.com/..." />
				</div>
				<div class="form-group">
					<label class="form-label">المنطقة الجغرافية ذات الصلة</label>
					<select name="claim_region" class="form-control">
						<option value="طرابلس">طرابلس الكبرى</option>
						<option value="بنغازي">بنغازي والمنطقة الشرقية</option>
						<option value="مصراتة">مصراتة والمنطقة الوسطى</option>
						<option value="الجنوب">سبها والمنطقة الجنوبية</option>
						<option value="الجبل الأخضر">درنة والجبل الأخضر</option>
						<option value="عام">عموم ليبيا</option>
					</select>
				</div>
			</div>

			<button type="submit" class="btn-submit-form">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
				<span>إرسال البلاغ لفريق التحقق</span>
			</button>
		</form>
	</div>
</main>

<?php
get_footer();
