<?php
/**
 * Front Page template for Agency Base Theme.
 *
 * @package AgencyBase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="falso-hero">
	<div class="falso-hero-container">
		<div class="hero-pill">
			<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
			<span>المرصد الليبي الموحد للتحقق ومكافحة التضليل الرقمي</span>
		</div>
		<h1 class="hero-title">
			نحارب التضليل <span class="hero-highlight">بالدليل القاطع</span> والحقيقة الميدانية
		</h1>
		<p class="hero-subtitle">
			منصة وطنية تشاركية تستعين بصحافة البيانات، التحليل الجنائي للصور، ومطابقة الرادارات الجوية والأقمار الصناعية لتفنيد الشائعات وحماية المجتمع الليبي من الحملات الموجهة.
		</p>

		<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="max-width:620px; margin:0 auto 1.5rem; display:flex; gap:0.5rem; background:#0f172a; border:1px solid #1e293b; border-radius:12px; padding:0.4rem 0.5rem;">
			<input type="text" name="s" placeholder="ابحث عن أي خبر أو ادعاء متداول للتحقق من صحته..." style="flex:1; background:transparent; border:none; color:#fff; font-size:0.95rem; font-family:inherit; padding:0.6rem 1rem; outline:none;" />
			<button type="submit" style="background:#2563eb; color:#fff; border:none; border-radius:8px; padding:0.6rem 1.4rem; font-weight:700; font-family:inherit; cursor:pointer;">تحقق الآن</button>
		</form>

		<div class="falso-stats-grid">
			<div class="stat-card">
				<div class="stat-num">1,482</div>
				<div class="stat-label">ادعاء تم فحصه وتوثيقه</div>
			</div>
			<div class="stat-card">
				<div class="stat-num" style="color:#ef4444;">89.4%</div>
				<div class="stat-label">نسبة الأخبار الزائفة المرصودة</div>
			</div>
			<div class="stat-card">
				<div class="stat-num" style="color:#10b981;">14 دقيقة</div>
				<div class="stat-label">متوسط سرعة الاستجابة والتفنيد</div>
			</div>
			<div class="stat-card">
				<div class="stat-num">38</div>
				<div class="stat-label">شريك مدني وصحفي في ليبيا</div>
			</div>
		</div>
	</div>
</section>

<main class="falso-container">
	<?php
	// Dynamic Query for Featured Investigation
	$featured_query = new WP_Query(
		array(
			'post_type'      => 'falso_investigation',
			'posts_per_page' => 1,
			'post_status'    => 'publish',
		)
	);

	if ( $featured_query->have_posts() ) :
		while ( $featured_query->have_posts() ) :
			$featured_query->the_post();
			$verdict       = get_post_meta( get_the_ID(), '_falso_verdict', true ) ?: 'fake';
			$region        = get_post_meta( get_the_ID(), '_falso_region', true ) ?: 'طرابلس';
			$claim_summary = get_post_meta( get_the_ID(), '_falso_claim_summary', true );

			$verdict_label = 'زائف قاطعاً';
			$verdict_class = 'fake';
			if ( 'misleading' === $verdict ) {
				$verdict_label = 'مضلل جزئياً';
				$verdict_class = 'misleading';
			} elseif ( 'verified' === $verdict ) {
				$verdict_label = 'صحيح ومثبت';
				$verdict_class = 'verified';
			}
			?>
			<div class="section-head">
				<div>
					<h2 class="section-title">التحقيق الاستقصائي الرئيسي</h2>
					<p class="section-desc">أبرز الشائعات انتشاراً خلال الـ 24 ساعة الماضية مدعومة بالأدلة الجنائية</p>
				</div>
			</div>

			<article class="featured-card">
				<div class="featured-badge-bar">
					<span class="badge-featured">تحقيق مميز</span>
					<span class="verdict-tag <?php echo esc_attr( $verdict_class ); ?>">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
						<span>الحكم النهائي: <?php echo esc_html( $verdict_label ); ?></span>
					</span>
					<span style="color:#64748b; font-size:0.85rem; margin-inline-start:auto;">رقم التحقيق: #INV-<?php echo esc_html( get_the_ID() ); ?></span>
				</div>

				<h3 class="featured-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>

				<p class="featured-excerpt">
					<?php
					if ( has_excerpt() ) {
						the_excerpt();
					} elseif ( $claim_summary ) {
						echo esc_html( $claim_summary );
					} else {
						echo esc_html( wp_trim_words( get_the_content(), 40 ) );
					}
					?>
				</p>

				<div class="featured-footer">
					<div>
						<span>المنطقة: <strong><?php echo esc_html( $region ); ?></strong></span> · 
						<span>تاريخ النشر: <strong><?php echo esc_html( get_the_date() ); ?></strong></span>
					</div>
					<a href="<?php the_permalink(); ?>" class="btn-read-deep">
						<span>قراءة التحقيق والأدلة</span>
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
					</a>
				</div>
			</article>
			<?php
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<div class="section-head">
		<div>
			<h2 class="section-title">أحدث التحقيقات والشائعات المرصودة</h2>
			<p class="section-desc">متابعة يومية لمختلف الادعاءات في المدن الليبية</p>
		</div>
		<div class="filter-tabs" style="margin-bottom:0;">
			<button class="filter-btn active">الكل</button>
			<button class="filter-btn">سياسة وأمن</button>
			<button class="filter-btn">اقتصاد ومالية</button>
			<button class="filter-btn">طرابلس</button>
			<button class="filter-btn">بنغازي</button>
		</div>
	</div>

	<div class="investigations-grid">
		<?php
		// Query Recent Investigations
		$grid_query = new WP_Query(
			array(
				'post_type'      => 'falso_investigation',
				'posts_per_page' => 6,
				'post_status'    => 'publish',
				'offset'         => 0,
			)
		);

		if ( $grid_query->have_posts() ) :
			while ( $grid_query->have_posts() ) :
				$grid_query->the_post();
				$v = get_post_meta( get_the_ID(), '_falso_verdict', true ) ?: 'fake';
				$r = get_post_meta( get_the_ID(), '_falso_region', true ) ?: 'ليبيا';
				$s = get_post_meta( get_the_ID(), '_falso_claim_summary', true );

				$v_label = 'زائف';
				if ( 'misleading' === $v ) {
					$v_label = 'مضلل';
				} elseif ( 'verified' === $v ) {
					$v_label = 'صحيح';
				}
				?>
				<div class="investigation-card">
					<div>
						<div class="card-header">
							<span class="card-region"><?php echo esc_html( $r ); ?></span>
							<span class="verdict-tag <?php echo esc_attr( $v ); ?>" style="font-size:0.75rem; padding:0.2rem 0.55rem;">
								<?php echo esc_html( $v_label ); ?>
							</span>
						</div>
						<h4 class="card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h4>
						<p class="card-summary">
							<?php
							if ( $s ) {
								echo esc_html( wp_trim_words( $s, 22 ) );
							} else {
								echo esc_html( wp_trim_words( get_the_excerpt() ?: get_the_content(), 22 ) );
							}
							?>
						</p>
					</div>
					<div class="card-meta">
						<span><?php echo esc_html( get_the_date() ); ?></span>
						<a href="<?php the_permalink(); ?>" style="font-weight:700;">عرض التقرير &larr;</a>
					</div>
				</div>
				<?php
			endwhile;
			wp_reset_postdata();
		else :
			?>
			<p style="color:var(--text-muted); grid-column: 1 / -1; text-align:center; padding:3rem 0;">
				لا توجد تحقيقات منشورة حالياً. استخدم لوحة التحكم لإضافة أول تحقيق.
			</p>
			<?php
		endif;
		?>
	</div>

	<section class="falso-cta-banner">
		<h3 class="cta-title">هل رصدت خبراً أو منشوراً مشبوهاً؟</h3>
		<p class="cta-text">
			ساعدنا في حماية المجتمع الليبي من الشائعات. أرسل رابط المنشور أو نص الادعاء وسيتولى فريق التحقق فحصه بأحدث تقنيات التحليل الجنائي الرقمي ومصادر البيانات الرسمية.
		</p>
		<a href="<?php echo esc_url( home_url( '/submit/' ) ); ?>" class="btn-cta-submit">
			<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
			<span>تقديم بلاغ عن شائعة الآن</span>
		</a>
	</section>
</main>

<?php
get_footer();
