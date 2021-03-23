<?php
/**
 * File that includes shortcode functions.
 *
 *
 * @package xten
 */

/**
 * Offices Shortcode
 * Renders Offices
 */
function offices_list_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'offices-list' );
}
add_shortcode( 'offices_list', 'offices_list_shortcode' );

/**
 * Social Media Icons List Shortcode
 * Renders ALL Social Media Icons Configured on "Site Settings Page"
 */
function social_media_icons_list_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'social-media-icons-list' );
}
add_shortcode( 'social_media_icons_list', 'social_media_icons_list_shortcode' );

/**
 * Service Categories Shortcode
 * Renders List of ALL Service Categories.
 */
function service_categories_list_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'service-categories-list' );
}
add_shortcode( 'service_categories_list', 'service_categories_list_shortcode' );

/**
 * Accordions Shortcode
 * Renders Accordions.
 */
function accordions_list_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'accordions-list' );
}
add_shortcode( 'accordions_list', 'accordions_list_shortcode' );

/**
 * Contact Section Shortcode
 * Renders Contact Section.
 */
function contact_section_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'contact-section' );
}
add_shortcode( 'contact_section', 'contact_section_shortcode' );

/**
 * Footnote Shortcode
 * Renders a Footnote.
 */
function footnote_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'footnote', $atts );
}
add_shortcode( 'footnote', 'footnote_shortcode' );

/**
 * Staff Shortcode
 * Renders Staff.
 */
function staff_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'staff-list' );
}
add_shortcode( 'staff', 'staff_shortcode' );

/**
 * Office Locations Shortcode
 * Renders Office Locations.
 */
function office_locations_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'office-locations' );
}
add_shortcode( 'office_locations', 'office_locations_shortcode' );

/**
 * Hero Content Shortcode
 * Renders Post Title, and posted on if Single Post.
 */
function xten_hero_content_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	$html = '';
	$post_title = get_the_title();
	ob_start();
	?>
	<h1 class="post-title"><?php echo $post_title; ?></h1>
	<?php
	if ( is_single() ) :
		$date = xten_posted_on();
		ob_start();
		?>
		<h2 class="post-date xten-h5"><?php echo xten_posted_on(); ?></h2>
		<?php
		$html .= ob_get_clean();
	endif; // endif ( is_single() ) :
	return $html;
}
add_shortcode( 'xten_hero_content', 'xten_hero_content_shortcode' );

/**
 * Office Locations Shortcode
 * Renders Office Locations.
 */
function xten_button_shortcode( $atts = '', $content = null ) {
	if ( $content ) :
		// When Shortcode is used $atts defaults to ''.
		// Ensure that this gets converted to an array.
		$atts = $atts === '' ? array() : $atts;
		ob_start();
		?>
		<button class="btn btn-theme-style" type="button"><?php echo $content; ?></button>
		<?php
		return trim(ob_get_clean());
	endif; // endif( $content ) :
}
add_shortcode( 'xten_button', 'xten_button_shortcode' );

/**
 * Google Reviews Place
 * Renders Google Reviews Place Clone.
 */
function google_review_place_shortcode( $atts = '', $content = null ) {

	if ( ! $atts['place_photo'] ) :
		$google_reviews_place_image = get_field( 'google_reviews_place_image', 'options' );
		$atts['place_photo'] = wp_get_attachment_image_url( $google_reviews_place_image, array( 160, null ) );
	endif;

	$atts['place_id'] = $atts['place_id'] ? : get_field( 'google_reviews_place_id', 'options' );

	// Ensure that grw_place function from Google Reviews Widget exists.
	$wp_google_place;
	if ( ! function_exists( 'grw_place' ) ) :
		if ( ! function_exists( 'grw_shortcode' ) ) :
			return;
		endif;
		$shortcode = grw_shortcode($atts);
		// disable errors because $service_category_html may contain SVG code.
		libxml_use_internal_errors(true);
		$doc = DOMDocument::loadHTML($shortcode);
		// renable errors.
		libxml_clear_errors();

		$xpath            = new DOMXPath($doc);
		$query            = "//*[contains(@class, 'wp-google-place')]";
		$dom_nodes        = $xpath->query($query);

		$temp_dom = new DOMDocument();
		if ( $dom_nodes[0] ) :
			$temp_dom->appendChild( $temp_dom->importNode( $dom_nodes[0], true ) );
			$wp_google_place = $temp_dom->saveHTML();
		else:
			$wp_google_place = false;
		endif;
	endif;

	// Enqueue Google Reviews Slider Stylesheet.
	// if ( ! wp_style_is( $handle, 'enqueued' ) ) :
		$handle = 'xten-component-google-review-slider-css';
		wp_enqueue_style($handle);
	// endif;

	if ( $wp_google_place === false ) :
		return;
	elseif ( $wp_google_place !== null ) :
		return $wp_google_place;
	else:
		$atts = $atts === '' ? array() : $atts;

		global $wpdb;
		// Taken from widget-google-reviews/grw.php
		$place_ids = $wpdb->get_col("SELECT place_id FROM " . $wpdb->prefix . "grp_google_place WHERE rating > 0 LIMIT 5");
		$place_id = $place_ids[0];

		// Taken from widget-google-reviews/grw-reviews.php
		$reviews_where = ' AND hide = \'\'';
		if (strlen($reviews_lang) > 0) {
				$reviews_where = $reviews_where . ' AND language = \'' . $reviews_lang . '\'';
		}

		$place = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "grp_google_place WHERE place_id = %s", $place_id));

		$reviews = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix . "grp_google_review WHERE google_place_id = %d" . $reviews_where . " ORDER BY time DESC", $place->id));

		$rating = 0;
		if ($place->rating > 0) {
				$rating = $place->rating;
		} else if (count($reviews) > 0) {
				foreach ($reviews as $review) {
						$rating = $rating + $review->rating;
				}
				$rating = round($rating / count($reviews), 1);
		}

		$rating = number_format((float)$rating, 1, '.', '');

		// Replaced $place_photo (generated in widget) with an passed $atts;
		$place_img = $atts['place_photo'] ?
		$atts['place_photo'] :
		($place_image_from_settings ?
			$place_image_from_settings :
			(strlen($place->photo) > 0 ?
					$place->photo :
					$place->icon));
		$star_svg = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="17" height="17" viewBox="0 0 1792 1792"><path d="M1728 647q0 22-26 48l-363 354 86 500q1 7 1 20 0 21-10.5 35.5t-30.5 14.5q-19 0-40-12l-449-236-449 236q-22 12-40 12-21 0-31.5-14.5t-10.5-35.5q0-6 2-20l86-500-364-354q-25-27-25-48 0-37 56-46l502-73 225-455q19-41 49-41t49 41l225 455 502 73q56 9 56 46z" fill="#e7711b"></path></svg>';

		// /Taken from widget-google-reviews/grw-reviews.php

		$home_url = is_front_page() ?
			null :
			get_home_url();
		$hide_based_on = true;

		ob_start();
		?>
		<div class="google-reviews-place-clone wpac">
			<div class="wp-google-place">
				<?php grw_place($rating, $place, $place_img, $reviews, $dark_theme, $hide_based_on); ?>
			</div>
		</div>
		<?php

		return trim(ob_get_clean());

	endif; // endif ( $wp_google_place ) :
}
add_shortcode( 'google_review_place', 'google_review_place_shortcode' );

/**
 * Social Media Icons with Google Reviews Place
 */
function social_media_google_reviews_shortcode( $atts = '', $content = null ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	ob_start();
	?>
	<div class="social-media-google-reviews-wrapper wpac">
		<?php
		echo google_review_place_shortcode( $atts );
		echo social_media_icons_list_shortcode();
		?>
	</div>
	<?php
	return trim(ob_get_clean());
}
add_shortcode( 'social_media_google_reviews', 'social_media_google_reviews_shortcode' );
