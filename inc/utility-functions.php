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
				$featured_image_size = array(2560, null );
				if (
					is_object( $queried_object ) &&
					get_class( $queried_object ) === 'WP_Term'
				) :
					$title          = esc_attr( $queried_object->name );
					$featured_image = get_field( 'featured_image', $queried_object );
					if ( ! $featured_image ) :
						$page_for_posts = get_option( 'page_for_posts' );
						$thumbnail_id   = get_post_thumbnail_id( $page_for_posts );
						$featured_image = array(
							'id'  => $thumbnail_id,
							'url' => get_the_post_thumbnail_url(
								$page_for_posts,
								$featured_image_size
							),
						);
					endif;
					$description    = get_field( 'long_description', $queried_object, false ) ? :
							$queried_object->description;
					$anchor_href    = '#services';
					$button_text    = "<span>See</span> <span>$title<span> <span>Services</span>";
				else:
					$title          = esc_attr( $queried_object->post_title );
					$thumbnail_id   = get_post_thumbnail_id( $queried_object );
					$featured_image = array(
						'id'  => $thumbnail_id,
						'url' => get_the_post_thumbnail_url(
							$queried_object,
							$featured_image_size
						),
					);
					$meta_id        = 'metadescription_17587';
					$description    = get_post_meta( $queried_object->ID, $meta_id, true );
					$anchor_href    = '#main';
					$button_text    = "<span>See</span> <span>$title<span>";
				endif; // endif ( get_class( $queried_object ) === 'WP_Term' ) :
				if ( is_home() ) :
					$title = get_bloginfo() . ' ' . $title;
					$button_text    = "Read Our Blog";
				endif;

				$half_banner_class   = ! $description ?
					'half-banner' :
					null;
				$date_posted_h2      = null;
				if ( is_single() ) :
					$date_posted_h2 = '<h2 class="post-date xten-h5">' . xten_posted_on() . '</h2>';
				endif;
				$google_reviews_place_image  = get_field( 'google_reviews_place_image', 'options' );
				$place_image                 = wp_get_attachment_image_url( $google_reviews_place_image, array( 160, null ) );
				$google_reviews_place_id     = get_field( 'google_reviews_place_id', 'options' );
				$social_media_google_reviews = social_media_google_reviews_shortcode( array(
					'place_photo'         => $place_image,
					'place_name'          => 'ProSe Legal',
					'place_id'            => $google_reviews_place_id,
					'pagination'          => '0',
					'text_size'           => '120',
					'refresh_reviews'     => 'true',
					'hide_based_on'       => 'true',
					'reduce_avatars_size' => 'true',
					'open_link'           => 'true',
					'nofollow_link'       => 'true',
				));
				$hero_content   = "<div class='xten-content-inner'><h1>$title</h1>$date_posted_h2</div>$social_media_google_reviews";
				$banner_background_position_x = esc_attr( get_field( 'banner_background_position_x', $featured_image['id'] ) );
				$banner_background_position_y = esc_attr( get_field( 'banner_background_position_y', $featured_image['id'] ) );
				$args = array(
					'c_attrs' => array(
						'class' => 'xten-hero-banner',
					),
					'minimum_height_group' => array (
						'minimum_height'      => 56.203,
						'minimum_height_unit' => '%',
					),
					'slides' => array( 
						array(
							// Move into Slides
							'background_image_group' => array(
								'background_image'      => $featured_image,
								'background_image_size' => 'cover',
								'background_image_position_x' => $banner_background_position_x,
								'background_image_position_y' => $banner_background_position_y,
							),
							'background_overlay_group' => array(
								'background_overlay_color'   => '#203046',
								'background_overlay_opacity' => 40,
							),
							'content' => $hero_content,
							'content_location_group' => array(
								'content_horizontal_location' => 'left',
							),
						),
					),
					'slide_method' => 'default',
					// /Move into Slides
				);
				ob_start();
				?>
				<div class="xten-hero-banner-w-divider <?php echo $half_banner_class; ?>">
					<div class="xten-hero-banner-w-divider-inner">
						<div class="xten-section-hero">
							<?php echo xten_sections_render_component( 'hero', $args ); ?>
						</div>
						<?php
						$html = ob_get_clean();
						/*   /Hero Banner   */

						/*   Hero Banner Divider   */

						if ( $description !== '' ) :
							ob_start();
							?>
							<div class="xten-banner-divider">
								<div class="container container-ext">
									<div class="xten-content">
										<p class="prominent-p"><?php echo xten_kses_post( $description ); ?></p>
										<a class="anchor-btn-cta" href=<?php echo $anchor_href; ?>><button class="btn btn-theme-style btn-cta btn-large nowrap-parent" type="button"><?php echo $button_text; ?></button></a>
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

		if ( ! function_exists( 'xten_split_office_title' ) ) :
			function xten_split_office_title( $office_title ) {
				$seperator = '/';
				$office_titles = preg_split("#$seperator#", $office_title);
				$_office_title_s = '';
				foreach ( $office_titles as $_office_title ) :
					$_seperator = $office_titles[0] === $_office_title ?
						null :
						"<span>$seperator</span>";
					$_office_title_s .= " $_seperator <span>$_office_title</span>";
				endforeach;
				return $_office_title_s;
			}
		endif; // endif ( ! function_exists( 'xten_split_office_title' ) ) :
	}
}

$ob = new XTenChildUtilities();
$ob->global_utilities();
