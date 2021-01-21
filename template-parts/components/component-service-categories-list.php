<?php
/**
 * This Component Renders one or more Service Categories.
 * @package xten
 */
function component_service_categories_list( $args ) {
	$terms = $args['terms'];
	if ( ! $terms ) :
		$terms = get_terms( array(
			'taxonomy'   => 'service-categories',
			'hide_empty' => false,
		) );
	endif;

	if ( ! $terms ) :
		return false;
	endif;

	$handle = 'service-categories-list';

	$html = '';

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
