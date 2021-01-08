<?php
/**
 * This Component boilerplate-description.
 * @package xten
 */
function component_service_category( $post_id = null ) {
	// Enqueue Stylesheet.
	$handle             = 'boilerplate';
	$component_handle   = 'component-' . $handle;
	$component_css_path = '/assets/css/' . $component_handle . '.min.css';
	wp_register_style(
		$component_handle . '-css',
		get_theme_file_uri( $component_css_path ),
		array(
			'child-style',
		),
		filemtime( get_stylesheet_directory() . $component_css_path ),
		'all'
	);
	wp_enqueue_style( $component_handle . '-css' );
	$styles = '';

	$component_id = xten_register_component_id( $handle );

	ob_start();
	?>
	<div id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?>">

	</div>

	<?php
	$html = ob_get_clean();
	return $html;

}
