<?php
/**
 * Footer template for Agency Base Theme.
 *
 * @package AgencyBase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<footer class="falso-footer">
	<div class="falso-footer-inner">
		<div class="footer-col">
			<div class="falso-logo" style="margin-bottom:1rem;">
				<span>فالصو</span>
				<span class="falso-logo-badge">2.0 V</span>
			</div>
			<p style="color:var(--text-muted); font-size:0.9rem; line-height:1.8; margin-bottom:1.5rem;">
				المرصد الليبي المستقل لتدقيق المعلومات ومكافحة الأخبار الزائفة وخطاب الكراهية. نعمل بأحدث منهجيات التحقق المفتوح المصدر (OSINT) والتحليل الجنائي للبيانات الرقمية.
			</p>
			<div style="color:var(--text-dim); font-size:0.8rem;">
				مرخص بموجب المشاع الإبداعي (CC BY-NC 4.0) للصحافة الحرة
			</div>
		</div>

		<div class="footer-col">
			<h5>أقسام المنصة</h5>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">الرئيسية</a></li>
				<li><a href="<?php echo esc_url( home_url( '/investigations/' ) ); ?>">التحقيقات الاستقصائية</a></li>
				<li><a href="<?php echo esc_url( home_url( '/submit/' ) ); ?>">تقديم بلاغ عن شائعة</a></li>
				<li><a href="<?php echo esc_url( home_url( '/automat-me/' ) ); ?>">مختبر التحليل الآلي</a></li>
			</ul>
		</div>

		<div class="footer-col">
			<h5>التغطية الجغرافية</h5>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/?region=tripoli' ) ); ?>">طرابلس الكبرى</a></li>
				<li><a href="<?php echo esc_url( home_url( '/?region=benghazi' ) ); ?>">بنغازي والشرق</a></li>
				<li><a href="<?php echo esc_url( home_url( '/?region=misrata' ) ); ?>">مصراتة والوسطى</a></li>
				<li><a href="<?php echo esc_url( home_url( '/?region=derna' ) ); ?>">درنة والجبل الأخضر</a></li>
			</ul>
		</div>

		<div class="footer-col">
			<h5>منهجية العمل</h5>
			<ul>
				<li><a href="#">ميثاق الشرف الصحفي</a></li>
				<li><a href="#">معايير شبكة تدقيق الحقائق (IFCN)</a></li>
				<li><a href="#">سياسة تصحيح الأخطاء</a></li>
				<li><a href="#">حماية سرية المبلّغين</a></li>
			</ul>
		</div>
	</div>

	<div class="footer-bottom">
		<div>
			&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. جميع الحقوق محفوظة لفرق التحقق الميداني.
		</div>
		<div style="direction:ltr; font-family:'JetBrains Mono', monospace; font-size:0.8rem;">
			Engine: Classic PHP 8.2 &middot; Clean Architecture
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
