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