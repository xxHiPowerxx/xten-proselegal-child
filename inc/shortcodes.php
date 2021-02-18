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