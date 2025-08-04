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
    add_image_size( '200X250', 200, 250, true );

    // Crop images to 400px by 500px
    add_image_size( '400X500', 400, 500, true );
});

// Add image sizes to the back-end
add_filter("image_size_names_choose", function($size_names) {
    $new_sizes = array(
        '200X250' => esc_html__( '200X250', 'uyu-theme' ),
		'400X500' => esc_html__( '400X500', 'uyu-theme' ),
	);
	return array_merge( $size_names, $new_sizes );
});

// Custom Post Types and Taxonomies
require get_template_directory() . "/inc/post-types-taxonomies.php";

// Remove unused admin menus
function valora_remove_admin_links() {
    remove_menu_page( 'edit.php' );           // Remove Posts link
    remove_menu_page( 'edit-comments.php' );  // Remove Comments link
}
add_action( 'admin_menu', 'valora_remove_admin_links' );

// Load custom blocks.
require get_theme_file_path() . '/uyu-blocks/uyu-blocks.php';