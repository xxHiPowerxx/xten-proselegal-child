<?php
/**
 * This Component Renders Multiple Accordions.
 * @package xten
 */
function component_accordions_list( $post_id = null ) {
	// Enqueue Stylesheet.
	$handle             = 'accordions-list';
	// $component_handle   = 'component-' . $handle;
	// $component_css_path = '/assets/css/' . $component_handle . '.min.css';
	// wp_register_style(
	// 	$component_handle . '-css',
	// 	get_theme_file_uri( $component_css_path ),
	// 	array(
	// 		'child-style',
	// 	),
	// 	filemtime( get_stylesheet_directory() . $component_css_path ),
	// 	'all'
	// );
	// wp_enqueue_style( $component_handle . '-css' );
	$styles = '';

	$component_id    = xten_register_component_id( $handle );

	$html            = '';
	if ( have_rows( 'accordions_repeater', $post_id ) ) :
		$parent = get_field( 'open_multiple', $post_id ) === true ? null : $component_id;
		while ( have_rows( 'accordions_repeater', $post_id ) ) :
			the_row();
			$args           = array();
			$args['parent'] = $parent;
			$args['open']   = get_row_index() === 1 ? true : false;

			$html          .= xten_render_component( 'accordion', $args );
		endwhile;

		if ( $html !== '' ) :
			// $component_id = xten_register_component_id( $handle );
			$start_tag    = '<div id="' . $component_id . '"  class="component-' . $handle .'">';
			$end_tag      = '</div>';
			$html         = $start_tag . $html . $end_tag;
			return $html;
		endif;
	endif; // endif ( have_rows( 'accordions_repeater' ) ) :
}
