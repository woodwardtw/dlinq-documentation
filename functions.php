<?php
/**
 * UnderStrap functions and definitions
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// UnderStrap's includes directory.
$understrap_inc_dir = 'inc';

// Array of files to include.
$understrap_includes = array(
	'/theme-settings.php',                  // Initialize theme default settings.
	'/setup.php',                           // Theme setup and custom theme supports.
	'/widgets.php',                         // Register widget area.
	'/enqueue.php',                         // Enqueue scripts and styles.
	'/template-tags.php',                   // Custom template tags for this theme.
	'/pagination.php',                      // Custom pagination for this theme.
	'/hooks.php',                           // Custom hooks.
	'/extras.php',                          // Custom functions that act independently of the theme templates.
	'/customizer.php',                      // Customizer additions.
	'/custom-comments.php',                 // Custom Comments file.
	'/class-wp-bootstrap-navwalker.php',    // Load custom WordPress nav walker. Trying to get deeper navigation? Check out: https://github.com/understrap/understrap/issues/567.
	'/editor.php',                          // Load Editor functions.
	'/block-editor.php',                    // Load Block Editor functions.
	'/acf.php',                    			// Load ACF functions.
	'/custom-data.php',						//various custom posts and taxonomies
	'/deprecated.php',                      // Load deprecated functions.
);

// Load WooCommerce functions if WooCommerce is activated.
if ( class_exists( 'WooCommerce' ) ) {
	$understrap_includes[] = '/woocommerce.php';
}

// Load Jetpack compatibility file if Jetpack is activiated.
if ( class_exists( 'Jetpack' ) ) {
	$understrap_includes[] = '/jetpack.php';
}

// Include files.
foreach ( $understrap_includes as $file ) {
	require_once get_theme_file_path( $understrap_inc_dir . $file );
}

//https://www.relevanssi.com/knowledge-base/multisite-search/
add_action( 'the_post', 'rlv_switch_blog' );
/**
 * Switches the blog if necessary.
 *
 * If the current post blog is different than the current blog, switches the blog.
 * If the blog has been switched, makes sure it's restored first to keep the switch
 * stack clean.
 *
 * @param WP_Post $post The post object.
 */
function rlv_switch_blog( $post ) {
	global $relevanssi_blog_id, $relevanssi_original_blog_id;
    
    if ( ! isset( $post->blog_id ) ) {
    	return;
    }

	if ( ! isset( $relevanssi_original_blog_id ) ) {
		$relevanssi_original_blog_id = get_current_blog_id();
	}

	if ( $post->blog_id !== get_current_blog_id() ) {
		if ( isset( $relevanssi_blog_id ) && $relevanssi_blog_id !== $post->blog_id ) {
			restore_current_blog();
		}
		switch_to_blog( $post->blog_id );
		$relevanssi_blog_id = $post->blog_id;
	}
}

add_filter( 'relevanssi_post_ok', 'rlv_no_past_events', 10, 2 );
add_filter( 'relevanssi_indexing_restriction', 'rlv_exclude_past_events' );

/**
 * Blocks past events from search results.
 *
 * @param boolean $status  Should the post be searched or not?
 * @param int     $post_id The post ID.
 *
 * @return boolean Return false if the event has passed.
 */
function rlv_no_past_events( $status, $post_id ) {
	$end_date = get_post_meta( $post_id, '_EventEndDate', true );
	if ( $end_date ) {
		if ( strtotime( $end_date ) < time() ) {
			$status = false;
		}
	}
	return $status;
}

/**
 * Removes past events from indexing.
 *
 * @param array $restriction The MySQL restriction and an explanation.
 *
 * @return array The restriction set with event restriction included.
 */
function rlv_exclude_past_events( $restriction ) {
	global $wpdb;
	$restriction['mysql']  .= " AND post.ID NOT IN (SELECT post_id FROM $wpdb->postmeta WHERE meta_key = '_EventEndDate' AND meta_value < NOW())";
	$restriction['reason'] .= ' Past event';
	return $restriction;
}