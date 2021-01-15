<?php
/**
 * This Component Renders one or more Offices.
 * @package xten
 */
function component_offices_list( $args = null ) {
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

	$post_ids = $args['post_ids'];

	$html = '';
	if ( is_numeric( $post_ids ) || is_object( $post_ids ) ) :
		$_args = array(
			'post_id'            => $post_ids,
			'inc_featured_image' => $args['inc_featured_image'],
		);
		$html .= xten_render_component( 'office', $args );
	else:
		if ( $post_ids === null ) :
			$post_ids = get_posts( array (
				'post_type'   => 'offices',
				'numberposts' => -1,
				'order'       => 'ASC'
			) );
		endif;
		foreach ( $post_ids as $post_id ) :
			$_args = array(
				'post_id'            => $post_id,
				'inc_featured_image' => $args['inc_featured_image'],
			);
			$html .= xten_render_component( 'office', $_args );
		endforeach;
	endif;

	if ( $html !== '' ) :
		$component_id = xten_register_component_id( $handle );
		$start_tag    = '<div id="' . $component_id . '" class="component-offices-list">';
		$end_tag      = '</div>';
		$html         = $start_tag . $html . $end_tag;
		return $html;
	endif;
}
