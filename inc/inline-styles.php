<?php
/**
 * Process Inline CSS
 */
function xten_child_process_inline_css() {
	// Get the Stylesheet Directory.
	$root_dir = get_template_directory_uri();
	$heading_default_font = json_decode( get_theme_mod( 'font_pairings', '{"heading":"roboto", "heading_fallback":"Arial, sans-serif"}' ) );

	// Begin Style Tag.
	$styles     = '';

	// Load Fonts Used.
	$primary_font             = 'roboto';
	$prmary_font_w_fallback   = $primary_font . 'helvetica,arial,sans';
	$font_weight = '-medium.ttf';
	$styles .= '@font-face{' .
			'font-family:' . $primary_font . ';' .
			'font-weight:500;' .
			'src:url(' . $root_dir . '/assets/fonts/' . $primary_font . '/' . $primary_font . $font_weight . ');' .
		'}';
	wp_register_style( 'xten-child-inline-style', false );
	wp_enqueue_style( 'xten-child-inline-style', '', 'xten-content-css' );
	wp_add_inline_style( 'xten-child-inline-style', $styles );
}

add_action( 'wp_enqueue_scripts', 'xten_child_process_inline_css' );
