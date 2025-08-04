<?php

// Load stylesheet on the front end
add_action("wp_enqueue_scripts", function() {
    // Load normalize.css
    wp_enqueue_style("normalize", get_theme_file_uri("/assets/css/normalize.css"), [], "8.0.1");
    // Load main stylesheet on the front end
    wp_enqueue_style("uyu-style", get_stylesheet_uri());
});

// Load stylesheet on the back-end editor
add_action("after_setup_theme",function() {
	add_editor_style( get_stylesheet_uri() );

    // Add image sizes
    // Crop images to 200px by 250px
    add_image_size( "200X250", 200, 250, true );

    // Crop images to 400px by 500px
    add_image_size( "400X500", 400, 500, true );
});

// Add image sizes to the back-end
add_filter("image_size_names_choose", function($size_names) {
    $new_sizes = array(
        "200X250" => esc_html__( "200X250", "uyu-theme" ),
		"400X500" => esc_html__( "400X500", "uyu-theme" ),
	);
	return array_merge( $size_names, $new_sizes );
});

// Custom Post Types and Taxonomies
require get_template_directory() . "/inc/post-types-taxonomies.php";

// Remove unused admin menus
function valora_remove_admin_links() {
    remove_menu_page( "edit.php" );           // Remove Posts link
    remove_menu_page( "edit-comments.php" );  // Remove Comments link
}
add_action( "admin_menu", "valora_remove_admin_links" );

// Load custom blocks
require get_theme_file_path() . "/uyu-blocks/uyu-blocks.php";

// Add Google Maps API key for ACF Google Map field
function acf_google_map_api( $api ){
    $api["key"] = GOOGLE_MAPS_API_KEY;;
    return $api;
}
add_filter("acf/fields/google_map/api", "acf_google_map_api");

// Enqueue Google Maps script for location post
function enqueue_acf_map_scripts() {
    // Register Google Maps API script
    wp_register_script(
        'google-maps-api',
        'https://maps.googleapis.com/maps/api/js?key=' . esc_attr(GOOGLE_MAPS_API_KEY),
        array(),
        null,
        true
    );

    // Enqueue ACF Google Map script
    wp_enqueue_script(
        'acf-google-map',
        get_template_directory_uri() . '/assets/js/acf-map.js',
        array('jquery', 'google-maps-api'),
        null,
        true
    );

    // Enqueue Google Maps API script
    wp_enqueue_script('google-maps-api');
}
add_action('wp_enqueue_scripts', 'enqueue_acf_map_scripts');
