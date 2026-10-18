<?php
/**
 * Header template for Agency Base Theme.
 *
 * @package AgencyBase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="falso-header">
	<div class="falso-header-inner">
		<div class="falso-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="falso-logo">
				<span>فالصو</span>
				<span class="falso-logo-badge">2.0 V</span>
			</a>
			<span class="falso-tagline"><?php bloginfo( 'description' ); ?></span>
		</div>
		<nav>
			<ul class="falso-nav">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo is_front_page() ? 'class="active"' : ''; ?>>الرئيسية</a></li>
				<li><a href="<?php echo esc_url( home_url( '/investigations/' ) ); ?>">التحقيقات</a></li>
				<li><a href="<?php echo esc_url( home_url( '/submit/' ) ); ?>">تقديم بلاغ</a></li>
				<li><a href="<?php echo esc_url( home_url( '/automat-me/' ) ); ?>">التحليل الآلي</a></li>
			</ul>
		</nav>
		<div>
			<a href="<?php echo esc_url( home_url( '/submit/' ) ); ?>" class="btn-report-header">
				<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
				<span>بلّغ عن شائعة</span>
			</a>
		</div>
	</div>
</header>

<div class="falso-ticker">
	<div class="falso-ticker-inner">
		<span class="ticker-badge">رصد حي متواصل</span>
		<span style="color:#e2e8f0; font-weight:500;">
			تنبيه أمني رقم 412: نفي رسمي لتعليق الرحلات في مطار معيتيقة · رصد حسابات موجهة تروج وثائق مزورة للبنك المركزي · فحص وتفنيد 4 شائعات في طرابلس وبنغازي اليوم
		</span>
	</div>
</div>
