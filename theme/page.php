<?php
/**
 * Generic Page template.
 *
 * @package AgencyBase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<main class="falso-container">
		<article id="page-<?php the_ID(); ?>" class="workbench-panel" style="max-width:900px; margin:2rem auto;">
			<h1 style="font-size:2.2rem; font-weight:800; margin-bottom:1.5rem; border-bottom:1px solid var(--border-subtle); padding-bottom:1rem;">
				<?php the_title(); ?>
			</h1>
			<div style="line-height:1.9; font-size:1.05rem; color:#e2e8f0;">
				<?php the_content(); ?>
			</div>
		</article>
	</main>
	<?php
endwhile;

get_footer();
