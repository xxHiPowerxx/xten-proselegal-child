<?php
/**
 * This Component Renders ONE OR MORE Footnotes.
 * @package xten
 */
function component_footnotes_list( $args = null ) {

	$footnotes = $args['footnotes'];
	if ( ! $footnotes ) :
		return false;
	endif;

	// Enqueue Stylesheet.
	$handle             = 'footnotes-list';
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

	ob_start();
	?>
	<div id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?>">
		<?php
		foreach ( $footnotes as $footnote ) :
			$_args = array( 'footnote' => $footnote );
			echo xten_render_component( 'footnote', $_args );
		endforeach;
		?>
	</div>
	<?php
	$html = ob_get_clean();

	if ( $styles !== '' ) :
		wp_register_style( $component_id, false );
		wp_enqueue_style( $component_id );
		wp_add_inline_style( $component_id, $styles );
	endif;

	return $html;

}
