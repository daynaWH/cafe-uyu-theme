<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function uyu_register_post_types() {
    // Register Menu CPT
    $labels = array(
        'name'                  => _x( 'Menu Items', 'post type general name', 'uyu-theme' ),
        'singular_name'         => _x( 'Menu Item', 'post type singular name', 'uyu-theme' ),
        'menu_name'             => _x( 'Menu Items', 'admin menu', 'uyu-theme' ),
        'add_new'               => _x( 'Add New', 'Menu Item', 'uyu-theme' ),
        'add_new_item'          => __( 'Add New Menu Item', 'uyu-theme' ),
        'new_item'              => __( 'New Menu Item', 'uyu-theme' ),
        'edit_item'             => __( 'Edit Menu Item', 'uyu-theme' ),
        'view_item'             => __( 'View Menu Item', 'uyu-theme'  ),
        'all_items'             => __( 'All Menu Items', 'uyu-theme' ),
        'search_items'          => __( 'Search Menu Items', 'uyu-theme' ),
        'not_found'             => __( 'No Menu Items found.', 'uyu-theme' ),
        'not_found_in_trash'    => __( 'No Menu Items found in Trash.', 'uyu-theme' ),
        'item_link'             => __( 'Menu Item link.', 'uyu-theme' ),
        'item_link_description' => __( 'A link to a Menu Item.', 'uyu-theme' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'menu-items' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-coffee',
        'supports'           => array( 'title', 'editor' ),
        'template'           => array( array( 'core/image' )),
    );

    register_post_type( 'uyu-menu', $args );

    // Register Location CPT
    $labels = array(
        'name'                  => _x( 'Locations', 'post type general name', 'uyu-theme' ),
        'singular_name'         => _x( 'Location', 'post type singular name', 'uyu-theme' ),
        'menu_name'             => _x( 'Locations', 'admin menu', 'uyu-theme' ),
        'add_new'               => _x( 'Add New', 'Location', 'uyu-theme' ),
        'add_new_item'          => __( 'Add New Location', 'uyu-theme' ),
        'new_item'              => __( 'New Location', 'uyu-theme' ),
        'edit_item'             => __( 'Edit Location', 'uyu-theme' ),
        'view_item'             => __( 'View Location', 'uyu-theme'  ),
        'all_items'             => __( 'All Locations', 'uyu-theme' ),
        'search_items'          => __( 'Search Locations', 'uyu-theme' ),
        'not_found'             => __( 'No Locations found.', 'uyu-theme' ),
        'not_found_in_trash'    => __( 'No Locations found in Trash.', 'uyu-theme' ),
        'featured_image'        => __( 'Location featured image', 'uyu-theme' ),
        'set_featured_image'    => __( 'Set location featured image', 'uyu-theme' ),
        'remove_featured_image' => __( 'Remove location featured image', 'uyu-theme' ),
        'use_featured_image'    => __( 'Use as featured image', 'uyu-theme' ),
        'item_link'             => __( 'Location link.', 'uyu-theme' ),
        'item_link_description' => __( 'A link to a Location.', 'uyu-theme' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'locations' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-location-alt',
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
    );

    register_post_type( 'uyu-location', $args );
}
add_action( 'init', 'uyu_register_post_types' );

function uyu_register_taxonomies() {
    // Menu Taxonomy
    $labels = array(
        'name'                  => _x( 'Menu Categories', 'taxonomy general name', 'uyu-theme' ),
        'singular_name'         => _x( 'Menu Category', 'taxonomy singular name', 'uyu-theme' ),
        'search_items'          => __( 'Search Menu Categories', 'uyu-theme' ),
        'all_items'             => __( 'All Menu Category', 'uyu-theme' ),
        'parent_item'           => __( 'Parent Menu Category', 'uyu-theme' ),
        'parent_item_colon'     => __( 'Parent Menu Category:', 'uyu-theme' ),
        'edit_item'             => __( 'Edit Menu Category', 'uyu-theme' ),
        'view_item'             => __( 'View Menu Category', 'uyu-theme' ),
        'update_item'           => __( 'Update Menu Category', 'uyu-theme' ),
        'add_new_item'          => __( 'Add New Menu Category', 'uyu-theme' ),
        'new_item_name'         => __( 'New Menu Category Name', 'uyu-theme' ),
        'template_name'         => __( 'Menu Category Archives', 'uyu-theme' ),
        'menu_name'             => __( 'Menu Category', 'uyu-theme' ),
        'not_found'             => __( 'No Menu Categories found.', 'uyu-theme' ),
        'no_terms'              => __( 'No Menu Categories', 'uyu-theme' ),
        'items_list_navigation' => __( 'Menu Categories list navigation', 'uyu-theme' ),
        'items_list'            => __( 'Menu Categories list', 'uyu-theme' ),
        'item_link'             => __( 'Menu Category Link', 'uyu-theme' ),
        'item_link_description' => __( 'A link to a Menu category.', 'uyu-theme' ),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_nav_menu'  => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'menu-category' ),
    );
    register_taxonomy( 'uyu-menu-category', array( 'uyu-menu' ), $args );

    // Add Featured taxonomy
    $labels = array(
        'name'                  => _x( 'Featured', 'taxonomy general name', 'uyu-theme' ),
        'singular_name'         => _x( 'Featured', 'taxonomy singular name', 'uyu-theme' ),
        'search_items'          => __( 'Search Featured', 'uyu-theme' ),
        'all_items'             => __( 'All Featured', 'uyu-theme' ),
        'parent_item'           => __( 'Parent Featured', 'uyu-theme' ),
        'parent_item_colon'     => __( 'Parent Featured:', 'uyu-theme' ),
        'edit_item'             => __( 'Edit Featured', 'uyu-theme' ),
        'view_item'             => __( 'View Featured', 'uyu-theme' ),
        'update_item'           => __( 'Update Featured', 'uyu-theme' ),
        'add_new_item'          => __( 'Add New Featured', 'uyu-theme' ),
        'new_item_name'         => __( 'New Work Featured', 'uyu-theme' ),
        'menu_name'             => __( 'Featured', 'uyu-theme' ),
        'template_name'         => __( 'Featured Archives', 'uyu-theme' ),
        'menu_name'             => __( 'Featured', 'uyu-theme' ),
        'not_found'             => __( 'No featured found.', 'uyu-theme' ),
        'no_terms'              => __( 'No featured', 'uyu-theme' ),
        'items_list_navigation' => __( 'Featured list navigation', 'uyu-theme' ),
        'items_list'            => __( 'Featured list', 'uyu-theme' ),
        'item_link'             => __( 'Featured Link', 'uyu-theme' ),
        'item_link_description' => __( 'A link to a featured.', 'uyu-theme' ),
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'featured' ),
    );
    
    register_taxonomy( 'uyu-featured', array( 'uyu-menu'), $args );
}
add_action( 'init', 'uyu_register_taxonomies' );

// Flush Rewrite Rules
function uyu_rewrite_flush() {
    uyu_register_post_types();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'uyu_rewrite_flush' );
