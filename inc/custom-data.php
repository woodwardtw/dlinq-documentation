<?php
/**
 * custom data
 *
 * @package UnderStrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

//article custom post type

// Register Custom Post Type article
// Post Type Key: article

function create_article_cpt() {

  $labels = array(
    'name' => __( 'Articles', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Article', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Article', 'textdomain' ),
    'name_admin_bar' => __( 'Article', 'textdomain' ),
    'archives' => __( 'Article Archives', 'textdomain' ),
    'attributes' => __( 'Article Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Article:', 'textdomain' ),
    'all_items' => __( 'All Articles', 'textdomain' ),
    'add_new_item' => __( 'Add New Article', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Article', 'textdomain' ),
    'edit_item' => __( 'Edit Article', 'textdomain' ),
    'update_item' => __( 'Update Article', 'textdomain' ),
    'view_item' => __( 'View Article', 'textdomain' ),
    'view_items' => __( 'View Articles', 'textdomain' ),
    'search_items' => __( 'Search Articles', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into article', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this article', 'textdomain' ),
    'items_list' => __( 'Article list', 'textdomain' ),
    'items_list_navigation' => __( 'Article list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Article list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'article', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail','page-attributes'),
    'taxonomies' => array('category', 'post_tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 7,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => true,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-clipboard',
  );
  register_post_type( 'article', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_article_cpt', 0 );

// Register Custom Post Type people
// Post Type Key: playlist
function create_playlist_cpt() {
$labels = array(
    'name' => __( 'playlist', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'playlist', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'playlist', 'textdomain' ),
    'name_admin_bar' => __( 'playlist', 'textdomain' ),
    'archives' => __( 'playlist Archives', 'textdomain' ),
    'attributes' => __( 'playlist Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'playlist:', 'textdomain' ),
    'all_items' => __( 'All playlists', 'textdomain' ),
    'add_new_item' => __( 'Add New playlist', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New playlist', 'textdomain' ),
    'edit_item' => __( 'Edit playlist', 'textdomain' ),
    'update_item' => __( 'Update playlist', 'textdomain' ),
    'view_item' => __( 'View playlist', 'textdomain' ),
    'view_items' => __( 'View playlists', 'textdomain' ),
    'search_items' => __( 'Search playlists', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into playlist', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this playlist', 'textdomain' ),
    'items_list' => __( 'People list', 'textdomain' ),
    'items_list_navigation' => __( 'playlist list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter playlist list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'playlist', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail',),
    'taxonomies' => array('category', 'post_tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 8,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-format-video',
  );
  register_post_type( 'playlist', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_playlist_cpt', 0 );