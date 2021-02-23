<?php
/**
 * This Component Renders ONE Staff Member.
 * @package xten
 */
function component_staff_member( $args = null ) {
	// Enqueue Stylesheet.
	$handle             = 'staff-member';
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

	$styles         = '';

	$component_id   = xten_register_component_id( $handle );

	$post_id        = $args['post_id'];
	$image_id       =	get_post_thumbnail_id( $post_id );
	$image_size     = xten_get_optimal_image_size( $image_id, array(415, 415), array( 1, 1 ) );
	// var_dump($image_size);
	$portrait       = get_the_post_thumbnail( $post_id, $image_size );
	$name           = get_the_title( $post_id );
	$position_title = esc_attr( get_field( 'position_title', $post_id ) );
	$office         = get_field( 'office', $post_id );
	$office_name    = esc_attr( $office->post_title );
	$bio            = get_the_content( null, false, $post_id );

	$component_attrs = array(
		'id'        => $post_id->post_name,
		'data-c-id' => $component_id,
		'class'     => "component-$handle",
	);
	$component_attrs_s = xten_stringify_attrs( $component_attrs );

	ob_start();
	?>
	<div <?php echo $component_attrs_s; ?>>
		<?php if ( $portrait ) : ?>
			<div class="staff-member-portrait"><?php echo $portrait; ?></div>
		<?php endif; ?>
		<?php if ( $name ) : ?>
			<h3 class="staff-member-name"><?php echo $name; ?></h3>
		<?php endif; ?>
		<?php if ( $position_title ) : ?>
			<h4 class="staff-member-position-title"><?php echo $position_title; ?></h4>
		<?php endif; ?>
		<?php if ( $office_name ) : ?>
			<h4 class="staff-member-office"><?php echo $office_name; ?> Office</h4>
		<?php endif; ?>
		<?php
		if ( $bio ) :
			$target                              = "$component_id-collapse";
			$control_attrs_a                     = array();
			$control_attrs_a['id']               = "$component_id-collapse-control";
			$control_attrs_a['class']            = "btn btn-theme-style btn-large staff-bio-collapse-control collapse-control";
			$control_attrs_a['type']             = 'button';
			$control_attrs_a['role']             = 'button';
			$control_attrs_a['data-toggle']      = 'collapse';
			$control_attrs_a['aria-controls']    = $target;
			$control_attrs_a['data-target']      = "#$target";
			$control_attrs_a['aria-expanded']    = false;
			$control_attrs_a['aria-label']       = 'Toggle ' . wp_strip_all_tags( $name ) . '\'s Bio';
			$control_attrs_a['tabindex']         = '0';

			$collapse_attrs_a                    = array();
			$collapse_attrs_a['id']              = $target;
			$collapse_attrs_a['data-labelledby'] = $control_attrs_a['id'];
			$collapse_attrs_a['class']           = "collapse collapse-content staff-bio-collapse";

			$control_attrs_s   = xten_stringify_attrs( $control_attrs_a );
			$collapse_attrs_s  = xten_stringify_attrs( $collapse_attrs_a );

			?>
			<div class="staff-bio-wrapper collapse-wrapper">
				<button <?php echo $control_attrs_s; ?>>Read Bio <span class="fa fa-chevron-down collapse-control-indicator"></span></button>
				<div <?php echo $collapse_attrs_s; ?>>
					<p class="staff-bio"><?php echo $bio; ?></p>
				</div>
			</div>
		<?php endif; ?>
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
