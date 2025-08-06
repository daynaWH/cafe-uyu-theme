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
	register_block_type( __DIR__ . '/build/locations', array(
		"render_callback" => "render_locations"
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

// Render Menu Items Block
function render_menu_items($attributes) {
	ob_start();
	?>
	<div class="menu-wrapper">
		<?php if (is_page(50)) { ?>
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

	<!-- Menu item display in the front page -->
	<?php } else if (is_front_page()) { ?>
		<?php 
		// Menu items filtered by featured taxonomy
		$featured_items = get_terms(
			array(
				"taxonomy" => "uyu-featured",
				"hide_empty" => false,
				"terms" => "front-page",
			)
		);

		if ($featured_items && !is_wp_error($featured_items)) {
			foreach ($featured_items as $item) {
				echo "<section class='featured-item-wrapper'>";
				$args = array(
					"post_type" => "uyu-menu",
					"posts_per_page" => -1,
					"tax_query" => array(
						array(
							"taxonomy" => "uyu-featured",
							"field" => "term_id",
							"terms" => $item->term_id,
						),
					),
				);
		
				$query = new WP_Query($args);

				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						echo "<div class='menu-item'>";
						the_content();
						
						// Show category and name
						$categories = get_the_terms(get_the_ID(), 'uyu-menu-category');
						if (!empty($categories) && !is_wp_error($categories)) {
							echo "<div class='menu-item-info'>";
							echo "<p class='menu-name'>" . esc_html(get_the_title()) . "</p>";
							echo "<p class='menu-category'>" . esc_html($categories[0]->name) . "</p></div>";
						}
						echo "</div>";
					}
					wp_reset_postdata();
				}
			}
			echo "</section>"; // Close the featured item wrapper
		}
	} ?>
	</div> <!-- Close Menu Wrapper -->
	<?php
	return ob_get_clean();
}

// Render Locations Block
function render_locations($attributes, $content, $block) {
    ob_start();

	// Get the post ID from block context
    $post_id = $block->context['postId'] ?? get_the_ID();
    if (!$post_id) return '';
    ?>

	<div class="branch-info-wrapper">
		<!-- Branch Image -->
		<div class="branch-image">
        <?php
        $branch_image = get_field('branch_image', $post_id);
        if ($branch_image) {
			echo '<img src="' . esc_url($branch_image['url'] ?? '') . '" alt="' . esc_attr($branch_image['alt']) . '">';
		}
		?>
		</div>

		<!-- Branch Details -->
        <div class="branch-details">
			<div class="branch-details-left">
				<!-- Business Hours -->
				<div class="business-hours">
				<?php
				$business_hours = get_field('business_hours', $post_id);
				if ($business_hours) {
					echo '<h3>Business Hours</h3>';
					echo '<ul>';
					foreach ($business_hours as $hours) {
						$day = $hours['day'] ?? '';
                        $closed = $hours['closed'] ?? false;
                        $opening_time = $hours['opening_time'] ?? '';
                        $closing_time = $hours['closing_time'] ?? '';

						echo '<li><p><span class="business-day bold-font">' . esc_html($day) . ':</span> ';
						if ($closed) {
							echo 'Closed';
						} else {
							echo esc_html($opening_time . ' - ' . $closing_time);
						}
						echo '</p></li>';      
					}
				}
				echo '</ul>';
				?>
				</div>

				<!-- Contact Info -->
				<div class="branch-contact-info">
					<h3>Contact Information</h3>
					<?php
					$phone = get_field('phone_number', $post_id);
					$email = get_field('branch_email_address', $post_id);

					if ($phone) {
						echo '<p><span class="bold-font">Phone:</span> <a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a></p>';
					}

					if ($email) {
						echo '<p><span class="bold-font">Email:</span> <a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a></p>';
					}
					?>
				</div>
			</div> <!-- Close Branch Details Left -->

			<div class="branch-details-right">
				<!-- Branch Location -->
				<div class="branch-location">
				<?php
				$branch_location = get_field('google_map_location');
				$address = get_field('branch_address', $post_id);

				if ($branch_location) {
					echo '<div class="acf-map">';
					echo '<div class="marker" data-lat="' . esc_attr($branch_location['lat']) . '" data-lng="' . esc_attr($branch_location['lng']) . '"></div>';
					echo '</div>';
				}

				if ($address) {
					echo '<p class="address">' . esc_html($address) . '</p>';
				}
				?>
				</div> <!-- Close Branch Location -->
			</div> <!-- Close Branch Details Right -->
        </div> <!-- Close Branch Details -->
    </div> <!-- Close Branch Info Wrapper -->
    <?php
    return ob_get_clean();
}
?>