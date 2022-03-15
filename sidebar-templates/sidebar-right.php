<?php
/**
 * The right sidebar containing the main widget area
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! is_active_sidebar( 'right-sidebar' ) ) {
	return;
}

// when both sidebars turned on reduce col size to 3 from 4.
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>

<?php if ( 'both' === $sidebar_pos ) : ?>
	<div class="col-md-3 widget-area" id="right-sidebar">
<?php else : ?>
	<div class="col-md-4 widget-area" id="right-sidebar">
<?php endif; ?>
<?php dynamic_sidebar( 'right-sidebar' ); ?>
<?php echo dlinq_canvas_integration();?>
<?php echo dlinq_teaching();?>
<?php echo dlinq_video_playlists();?>
<?php echo dlinq_extra_links();?>
</div><!-- #right-sidebar -->
