<?php
/**
 * Main index fallback template for Agency Base Theme.
 *
 * @package AgencyBase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main class="falso-container">
	<div class="section-head">
		<div>
			<h1 class="section-title"><?php single_post_title(); ?></h1>
		</div>
	</div>

	<?php if ( have_posts() ) : ?>
		<div class="investigations-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" class="investigation-card">
					<div>
						<h3 class="card-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<p class="card-summary">
							<?php the_excerpt(); ?>
						</p>
					</div>
					<div class="card-meta">
						<span><?php echo esc_html( get_the_date() ); ?></span>
						<a href="<?php the_permalink(); ?>">قراءة المزيد &larr;</a>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>
		<?php the_posts_navigation(); ?>
	<?php else : ?>
		<p style="color:var(--text-muted); text-align:center; padding:3rem 0;">
			لا يوجد محتوى لعرضه في الوقت الحالي.
		</p>
	<?php endif; ?>
</main>

<?php
get_footer();
