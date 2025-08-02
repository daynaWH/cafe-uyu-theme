<?php

add_action("wp_enqueue_scripts", function() {
    // Load normalize.css
    wp_enqueue_style("normalize", get_theme_file_uri("/assets/css/normalize.css"), [], "8.0.1");
    // Load main stylesheet on the front end
    wp_enqueue_style("uyu-style", get_stylesheet_uri());
});

add_action("after_setup_theme",function() {
    // Load stylesheet on the back-end editor
	add_editor_style( get_stylesheet_uri() );

    // Add image sizes
    // Crop images to 200px by 250px
    add_image_size( '200X250', 200, 250, true );

    // Crop images to 400px by 500px
    add_image_size( '400X500', 400, 500, true );
});

add_filter("image_size_names_choose", function($size_names) {
    $new_sizes = array(
        '200X250' => esc_html__( '200X250', 'uyu-theme' ),
		'400X500' => esc_html__( '400X500', 'uyu-theme' ),
	);
	return array_merge( $size_names, $new_sizes );
})




?>
