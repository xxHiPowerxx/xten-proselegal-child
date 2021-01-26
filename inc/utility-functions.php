<?php
/**
 * Utility Functions
 *
 * @package xten
 */

/**
 * XTen Child Utilities
 * Makes Utility functions available throughout theme.
 */
class XTenChildUtilities {
	/**
	 * Global Utilites
	 * Calls functions to be used globally throughout theme.
	 */
	public function global_utilities() {

		if ( ! function_exists( 'xten_render_component' ) ) :
			/**
			 * Render Markup for Component.
			 * Function will attempt to get required file to render Component
			 * 
			 * @param string $handle name of handle will be used to find correct file.
			 * @param mixed array|string $post_id optional post or array of posts of data being passed.
			 * @return string rendered markup as string.
			 */
			function xten_render_component( $handle, $post_id = null ) {
				$file_path = get_stylesheet_directory() . '/template-parts/components/';
				$file_name = 'component-' . $handle . '.php';
				$file_path = $file_path . $file_name;
				if ( file_exists( $file_path ) ) :
					require_once( $file_path );
					$handle_snake_case = str_replace('-', '_', $handle );
					$component_func = 'component_' . $handle_snake_case;
					if ( function_exists( $component_func ) ) :
						return $component_func( $post_id );
					endif;
				endif;
			}
		endif; // endif ( ! function_exists( 'xten_render_component' ) ) :

		if ( ! function_exists( 'xten_register_component_id' ) ) :
			/**
			 * Create Component ID
			 * Function Increments Id based on handle
			 * @param string $handle name of handle.
			 * @return int component id.
			 */
			function xten_register_component_id( $handle ) {
				$GLOBALS['component_ids'][$handle] = $GLOBALS['component_ids'][$handle] !== null ?
					$GLOBALS['component_ids'][$handle] :
					0;
					$GLOBALS['component_ids'][$handle] ++;
					$component_id = $handle . '-' . $GLOBALS['component_ids'][$handle];

				return  $component_id;
			}
		endif; // endif ( ! function_exists( 'xten_register_component_id' ) ) :

		if ( ! function_exists( 'get_first_contact_form' ) ) :
			/**
			 * Get First Contact Form.
			 * 
			 * @return string Contact Form 7 Markup.
			 */
			function get_first_contact_form() {
				$args = array(
					'numberposts' => 1,
					'order'       => 'ASC',
					'orderby'     => 'date',
					'post_type'   => 'wpcf7_contact_form',
				);
				$contact_forms_array = get_posts( $args );
				if ( is_array( $contact_forms_array ) ) :
					 $contact_form = $contact_forms_array[0];
					 return do_shortcode( '[contact-form-7 id="' . $contact_form->ID . '" title="' . $contact_form->post_title . '"]' );
				else:
					return false;
				endif;
			}
		endif; // endif ( ! function_exists( 'get_first_contact_form' ) ) :

		if ( ! function_exists( 'render_hero_banner' ) ) :
			/**
			 * Get Hero Banner and Divider.
			 * @param object $queried_object - The Queried Object
			 * @return string Hero Banner and Divider Markup.
			 */
			function render_hero_banner( $queried_object ) {

				/*   Hero Banner   */
				$term_title     = esc_attr( $queried_object->name );
				$featured_image = get_field( 'featured_image', $queried_object );
				$social_media   = xten_render_component( 'social-media-icons-list' );
				$hero_content   = "<div class='xten-content-inner'><h1>$term_title</h1></div>$social_media";
				$args = array(
					'c_attrs' => array(
						'class' => 'xten-hero-banner',
					),
					'minimum_height' => 56.203,
					'background_image_group' => array(
						'background_image' => $featured_image,
						'background_image_size' => 'cover',
					),
					'background_overlay_group' => array(
						'background_overlay_color'   => '#203046',
						'background_overlay_opacity' => 40,
					),
					'content' => $hero_content,
					'content_minimum_width_group' => array(
						'minimum_width' => 814,
					),
					'content_location_group' => array(
						'content_horizontal_location' => 'left',
					),
				);
				ob_start();
				?>
				<div class="xten-hero-banner-w-divider">
					<div class="xten-hero-banner-w-divider-inner">
						<div class="xten-section-hero">
							<?php echo xten_sections_render_component( 'hero', $args ); ?>
						</div>
						<?php
						$html = ob_get_clean();
						/*   /Hero Banner   */

						/*   Hero Banner Divider   */
						$description = get_field( 'long_description', $queried_object, false ) ? :
							$queried_object->description;

						if ( $description !== '' ) :
							ob_start();
							?>
							<div class="xten-banner-divider">
								<div class="container container-ext">
									<div class="xten-content">
										<p class="prominent-p"><?php echo xten_kses_post( $description ); ?></p>
										<a class="anchor-btn-cta" href="#services"><button class="btn btn-theme-style btn-cta btn-large nowrap-parent" type="button"><span>See</span> <span><?php echo $term_title; ?></span> <span>Services</span></button></a>
									</div>
								</div>
							</div>
							<?php
							$html .= ob_get_clean();
						endif; //if ( $description !== '' ) :
						/*   /Hero Banner Divider   */
						ob_start();
						?>
					</div><!-- /.xten-hero-banner-w-divider-inner -->
				</div><!-- /.xten-hero-banner-w-divider -->
				<?php
				$html .= ob_get_clean();
				return $html;
			}
		endif; // endif ( ! function_exists( 'render_hero_banner' ) ) :
	}
}

$ob = new XTenChildUtilities();
$ob->global_utilities();
