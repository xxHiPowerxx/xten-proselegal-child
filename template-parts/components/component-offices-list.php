<?php
/**
 * This Component Renders one or more Offices.
 * @package xten
 */
function component_offices_list( $post_ids = null ) {
	$handle             = 'offices-list';
	// Enqueue Stylesheet.
/*
	$component_handle   = 'component-' . $handle;
	$component_css_path = '/assets/css/' . $component_handle . '.css';
	wp_register_style(
		$component_handle . '-css',
		get_theme_file_uri( $component_css_path ),
		array(
			'child-style',
		),
		filemtime( get_stylesheet_directory() . $component_css_path ),
		'all'
	);
	wp_enqueue_style( $component_handle );
*/
	$styles = '';

	$html = '';
	if ( is_array( $post_ids ) ) :
		foreach ( $post_ids as $post_id ) :
			$html .= xten_render_component( 'office', $post_id );
		endforeach;
	else:
		$html .= xten_render_component( 'office', $post_id );
	endif;

	if ( $html !== '' ) :
		$component_id = xten_register_component_id( $handle );
		$start_tag    = '<div id="' . $component_id . '" class="component-offices-list">';
		$end_tag      = '</div>';
		$html         = $start_tag . $html . $end_tag;
		return $html;
	endif;
}
