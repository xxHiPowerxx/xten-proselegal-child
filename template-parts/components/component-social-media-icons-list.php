<?php
/**
 * This Component Renders A list of Social Media Icons w/ Link.
 * @package xten
 */
function component_social_media_icons_list( $post_id = null ) {
	// Enqueue Stylesheet.
	$handle             = 'social-media-icons-list';
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
	$accounts        = get_field( 'social_media_accounts_repeater', 'options' );
	$html            = '';
	if ( $accounts ) :
		foreach ( $accounts as $account ) :
			$html .= xten_render_component( 'social-media-icon', $account );
		endforeach;

		if ( $html !== '' ) :
			$start_tag    = '<div id="' . $component_id . '"  class="component-' . $handle .'">';
			$end_tag      = '</div>';
			$html         = $start_tag . $html . $end_tag;
			return $html;
		endif;
	endif; // endif ( $accounts ) :

}
