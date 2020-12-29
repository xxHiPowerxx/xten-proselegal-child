<?php
/**
 * File that includes shortcode functions.
 *
 *
 * @package xten
 */

/**
 * Contact Section Shortcode
 * Renders Offices Locations
 */
function offices_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'offices' );
}
add_shortcode( 'offices', 'offices_shortcode' );