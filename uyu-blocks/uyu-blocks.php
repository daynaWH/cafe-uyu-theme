<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function uyu_blocks_init() {
	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
	 * based on the registered block metadata.
	 * Added in WordPress 6.8 to simplify the block metadata registration process added in WordPress 6.7.
	 *
	 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
	 */

	register_block_type( __DIR__ . '/build/menu-posts', array(
		"render_callback" => "render_menu_items"
	));

	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
		return;
	}

	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` file.
	 * Added to WordPress 6.7 to improve the performance of block type registration.
	 *
	 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
	 */
	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	}
	/**
	 * Registers the block type(s) in the `blocks-manifest.php` file.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/build/{$block_type}" );
	}
}
add_action( 'init', 'uyu_blocks_init' );

function render_menu_items($attributes) {
	ob_start();
	?>
	<div class="menu-wrapper">
			<!-- Menu - Navigation -->
			<nav class="menu-nav">
				<ul>
					<?php
					// Get all parent taxonomy terms (drinks and desserts)
					$parent_terms = get_terms(
						array(
							"taxonomy" => "uyu-menu-category",
							"parent" => 0,
							"orderby" => "date",
							"order" => "DESC",
						)
					);

					if ($parent_terms && !is_wp_error($parent_terms)) {
						foreach ($parent_terms as $parent) {
							echo "<li><a href='#" . esc_attr($parent->slug) . "'>" . esc_html($parent->name) . "</a>";

							// Get child taxonomy terms for each parent
							$child_terms = get_terms(
								array(
									"taxonomy" => "uyu-menu-category",
									"parent" => $parent->term_id,
									"orderby" => "date",
									"order" => "ASC",
								)
							);

							if ($child_terms && !is_wp_error($child_terms)) {
								echo "<ul>";
								foreach ($child_terms as $child) {
									echo "<li><a href='#" . esc_attr($child->slug) . "'>" . esc_html($child->name) . "</a></li>";
								}
								echo "</ul>";
							}
							echo "</li>"; // Close the parent list item
						}
						wp_reset_postdata();
					}
					?>
				</ul>
			</nav>

			<!-- Menu - Content -->
			<div class="menu-content">
			<?php
			// Menu items by parent taxonomy terms (drinks and desserts)
			$parent_terms = get_terms(
				array(
					"taxonomy" => "uyu-menu-category",
					"parent" => 0,
					"orderby" => "date",
					"order" => "DESC",
				)
			);

			if ($parent_terms && !is_wp_error($parent_terms)) {
				foreach ($parent_terms as $parent) {
					echo "<section class='menu-parent-category'>";
					echo "<h2 id='" . esc_html($parent->slug) . "'>" . esc_html($parent->name) . "</h2>";

					// Menu items by child taxonomy terms (drinks and desserts)
					$child_terms = get_terms(
						array(
							"taxonomy" => "uyu-menu-category",
							"parent" => $parent->term_id,
							"orderby" => "date",
							"order" => "ASC",
						)
					);

					if ($child_terms && !is_wp_error($child_terms)) {
						foreach ($child_terms as $child) {
							echo "<h3 id='" . esc_html($child->slug) . "'>" . esc_html($child->name) . "</h3>";
							echo "<p class='menu-child-description'>" . esc_html($child->description) . "</p>";
							echo "<section class='menu-child-category'>";

							$args = array(
								"post_type" => "uyu-menu",
								"posts_per_page" => -1,
								"orderby" => "date",
								"order" => "ASC",
								"tax_query" => array(
									array(
										"taxonomy" => "uyu-menu-category",
										"field" => "slug",
										"terms" => $child->slug,
									),
								),
							);

							$query = new WP_Query($args);

							if ($query -> have_posts()) {
								while ($query -> have_posts()) {
									$query ->the_post();
									echo "<article id='post-" . esc_attr(get_the_ID()) . "'>";
									the_content();
									echo "<p>" . esc_html(get_the_title()) . "</p>";
									echo "</article>";
								}
								wp_reset_postdata();
							}
							echo "</section>"; // Close the child category article
						}
					}
					echo "</section>"; // Close the parent category section
				}
				wp_reset_postdata();
			}
		?>
		</div> <!-- Close Menu - Content -->
	</div> <!-- Close Menu Wrapper -->
	<?php
	return ob_get_clean();
}