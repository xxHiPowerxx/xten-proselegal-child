<?php
/**
 * This Component Renders one or more Service Categories.
 * @package xten
 */
function component_service_categories_list( $terms = null ) {
	$handle             = 'service-categories-list';
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
	$terms = get_terms( array(
		'taxonomy'   => 'service-categories',
		'hide_empty' => false,
	) );
	foreach ( $terms as $term ) :
		$html .= xten_render_component( 'service-category', $term );
	endforeach;

	if ( $html !== '' ) :
		$component_id = xten_register_component_id( $handle );
		$start_tag    = '<div id="' . $component_id . '" class="component-service-categories-list">';
		$end_tag      = '</div>';
		$html         = $start_tag . $html . $end_tag;
		return $html;
	endif;
}
