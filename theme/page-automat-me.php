<?php
/**
 * Template Name: Automat-Me Workbench
 *
 * @package AgencyBase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="falso-container">
	<div style="max-width:850px; margin:0 auto 2rem; text-align:center;">
		<div class="hero-pill" style="margin-bottom:0.75rem;">
			<span>محرك الذكاء الاصطناعي والاستدلال الجنائي</span>
		</div>
		<h1 style="font-size:2.3rem; font-weight:800; margin-bottom:0.5rem;">مختبر الفحص الآلي للشائعات (Automat-Me)</h1>
		<p style="color:var(--text-muted); font-size:1.05rem;">
			منظومة معالجة اللغة الطبيعية والتحليل الجنائي للصور، لمطابقة الادعاءات مع قواعد بيانات الرصد المفتوح في أقل من دقيقة.
		</p>
	</div>

	<div class="workbench-wrapper">
		<div class="workbench-grid">
			<div class="workbench-panel">
				<h3 style="margin-top:0; margin-bottom:1.25rem; font-size:1.2rem; border-bottom:1px solid var(--border-subtle); padding-bottom:0.75rem;">
					خطوات خط المعالجة الذكي (Verification Pipeline)
				</h3>

				<div class="pipeline-step">
					<div class="pipeline-icon done">&#10003;</div>
					<div class="pipeline-content">
						<h4>1. تجريد الكيانات والمطابقة الجغرافية (NER Extraction)</h4>
						<p>استخراج أسماء المدن والمؤسسات الرسمية الليبية المذكورة في نص الادعاء بدقة 97%.</p>
					</div>
				</div>

				<div class="pipeline-step">
					<div class="pipeline-icon done">&#10003;</div>
					<div class="pipeline-content">
						<h4>2. الفحص العكسي للصور والبيانات الوصفية (Metadata EXIF)</h4>
						<p>فحص تواريخ التقاط الصور ومطابقتها لمنع إعادة تدوير الأحداث القديمة كأخبار عاجلة.</p>
					</div>
				</div>

				<div class="pipeline-step">
					<div class="pipeline-icon done">&#10003;</div>
					<div class="pipeline-content">
						<h4>3. مطابقة الرادارات والملاحة المفتوحة (ADS-B FlightRadar)</h4>
						<p>التحقق اللحظي من حركة المطارات الليبية والمنافذ الحدودية عبر أنظمة التتبع الفضائي.</p>
					</div>
				</div>

				<div class="pipeline-step">
					<div class="pipeline-icon done">&#10003;</div>
					<div class="pipeline-content">
						<h4>4. توليد وسم Schema.org ClaimReview المعياري</h4>
						<p>نشر البيانات الوصفية المهيكلة مباشرة لمحركات البحث لإظهار شارة "Fact-Check" في Google.</p>
					</div>
				</div>
			</div>

			<div class="workbench-panel" style="text-align:center;">
				<h3 style="margin-top:0; font-size:1.15rem; color:var(--text-muted); margin-bottom:1rem;">
					مؤشر موثوقية الرصد اليومي
				</h3>
				<div class="meter-container">
					<div class="meter-score">94.8%</div>
					<div style="font-weight:700; color:#34d399; font-size:0.95rem;">دقة تصنيف عالية للمصادر</div>
				</div>
				<p style="color:var(--text-muted); font-size:0.85rem; line-height:1.7; margin-top:1.5rem; text-align:right;">
					المحرك متصل بقاعدة بيانات ليبية تضم أكثر من 1,400 شائعة موثقة منذ 2020، ويجري تحديث خوارزميات الاستدلال يومياً لمنع حملات التضليل الممنهجة.
				</p>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
