<?php
/**
 * This Component renders ONE Footnote.
 * @package xten
 */
function component_footnote( $args = null ) {

	if ( ! $args['name'] || ! $args['description'] ) :
		return false;
	endif;
	// Enqueue Stylesheet.
	$handle             = 'footnote';
	$component_handle   = 'component-' . $handle;
	$component_css_path = '/assets/css/' . $component_handle . '.min.css';
	$component_css_file = get_stylesheet_directory() . $component_css_path;
	if ( file_exists( $component_css_file ) ) :
		wp_register_style(
			$component_handle . '-css',
			get_theme_file_uri( $component_css_path ),
			array(
				'child-style',
			),
			filemtime( $component_css_file ),
			'all'
		);
		wp_enqueue_style( $component_handle . '-css' );
	endif;

	$styles = '';

	$component_id = xten_register_component_id( $handle );

	$component_attrs = array();

	// $name                            = xten_kses_post( $args['name'] );
	$name                            = '<span class="fa fa-asterisk"></span>';
	$component_attrs['data-tooltip'] = esc_attr( $args['description'] );
	$component_attrs['tabindex'] = 0;

	$component_attrs_s = xten_stringify_attrs( $component_attrs );
	ob_start();
	?>
	<span id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?>" <?php echo $component_attrs_s; ?>>
		<span class="footnote-name"><?php echo $name; ?></span>
	</span>
	<?php
	$html = ob_get_clean();

	if ( $styles !== '' ) :
		wp_register_style( $component_id, false );
		wp_enqueue_style( $component_id );
		wp_add_inline_style( $component_id, $styles );
	endif;

	return $html;

}
