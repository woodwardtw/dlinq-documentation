<?php
/**
 * Single article partial template
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">

			<?php //understrap_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<?php //echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php
		//the_content();
		echo dlinq_documentation_nav();
		echo dlinq_app_overview();
		echo dlinq_get_started();
		echo dlinq_section_repeater();
		echo dlinq_article_subpages();//maybe we don't need this at all
		echo dlinq_help_section();
		echo dlinq_internal_pages();
		echo dlinq_external_pages();
		gravity_form( 1, false, false, false, null, true );
		//understrap_link_pages();
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php understrap_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
