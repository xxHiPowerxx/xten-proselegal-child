<?php
/**
 * This Component renders ONE or MORE Staff Members.
 * @package xten
 */
function component_staff_list( $args = null ) {
	// Enqueue Stylesheet.
	$handle             = 'staff-list';
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

	$post_ids = $args['post_ids'];

	if ( ! $post_ids ) :
		$post_args = array(
			'numberposts' => -1,
			'post_type'   => 'staff',
			'order'       => 'ASC',
			'orderby'     => array(
				'menu_order',
				'date'
			),
		);
		$post_ids = get_posts( $post_args );
	endif;

	ob_start();
	?>
	<div id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?>">
		<?php
		if ( ! empty( $post_ids ) ) :
			foreach ( $post_ids as $post_id ) :
				$_args = array(
					'post_id' => $post_id,
				);
				echo xten_render_component( 'staff-member', $_args );
			endforeach;
		endif;
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
