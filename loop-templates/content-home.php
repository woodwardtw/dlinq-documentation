<?php
/**
 * Partial template for content in home.php
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title home-title">', '</h1>' ); ?>

	</header><!-- .entry-header -->

	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">
		<div class="row">
			<div class="col-md-6 offset-md-3">
				<?php get_search_form();?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 offset-md-2 home-description">
				<?php the_content();?>
			</div>
		</div>
		<div class="row highlights justify-content-center">
			<?php echo dlinq_highlight_repeater();?>
		</div>
		<div class="row">
				<div class="col-md-6 offset-md-3 all-tools">
					<h2>All Tools</h2>
					<?php dlinq_doc_list_top_articles();?>
				</div>
		</div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_edit_post_link(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
