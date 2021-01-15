<?php
/**
 * This Component Renders the Contact Form.
 * @package xten
 */
function component_contact_form( $contact_form = null ) {
	// Enqueue Stylesheet.
	$handle             = 'contact-form';
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

	$styles       = '';
	$component_id = xten_register_component_id( $handle );

	if ( ! $contact_form ) :
		$contact_form = get_first_contact_form();
	endif;

	ob_start();
	?>
	<div id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?>">
		<?php echo $contact_form; ?>
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
