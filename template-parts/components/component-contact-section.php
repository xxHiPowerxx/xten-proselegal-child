<?php
/**
 * This Component Renders the Contact Section
 * w/ Offices List and a Contact Form.
 * @package xten
 */
function component_contact_section( $args = null ) {
	$handle             = 'contact-section';
	$component_handle   = 'component-' . $handle;

	// Enqueue Stylesheet.
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
		<div class="offices-list-wrapper">
			<?php if ( $args['offices_list_title'] ) : ?>
				<h3 class="offices-list-title xten-section-heading"><?php echo esc_attr( $args['offices_list_title'] ); ?></h3>
			<?php endif; ?>
			<?php
			echo xten_render_component( 'offices-list', array(
				'post_ids'           => $args['offices_list'],
				'inc_featured_image' => true,
			) ); ?>
		</div>
		<div class="contact-form-wrapper">
			<?php if ( $args['contact_form_title'] ) : ?>
				<h3 class="contact-form-title"><?php echo esc_attr( $args['contact_form_title'] ); ?></h3>
			<?php endif; ?>
			<?php echo xten_render_component( 'contact-form', $args['contact_form'] ); ?>
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
