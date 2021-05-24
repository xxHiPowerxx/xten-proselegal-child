<?php
/**
 * This Component Renders ONE Service Category.
 * @package xten
 */
function component_service_category( $term = null ) {
	// Enqueue Stylesheet.
	$handle             = 'service-category';
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
	$component_attrs_array = array();
	$styles                = '';

	$component_id   = xten_register_component_id( $handle );
	$featured_image = get_field( 'featured_image', $term );
	if ( $featured_image ) :
		$image_size = 'large';
		$featured_image_src = wp_get_attachment_image_url( $featured_image['id'], $image_size );
		if ( $featured_image_src ) :
			$styles .= xten_add_inline_style(
				'[data-c-id="' . $component_id . '"] .flip-card-front,' .
				'[data-c-id="' . $component_id . '"] .flip-card-back',
				array(
					'background-image' => 'url(' . $featured_image_src . ')',
				)
			);
		endif;
	endif; // endif ( $featured_image ) :

	$icon = null;
	if ( have_rows( 'icon_fc', $term ) ) :
		while ( have_rows( 'icon_fc', $term ) ) :
			the_row();
			$row_layout                              = get_row_layout();
			$component_attrs_array['data-icon-type'] = str_replace( '_', '-', $row_layout );
			$icon                                    = xten_get_icon_fc( $row_layout );
		endwhile;
	endif;

	$title                         = esc_attr( $term->name );
	if ( $title ) :
		$stripped_title = trim( str_replace( array('services','Services'), '', $title ) );
		$component_attrs_array['title'] = "See $stripped_title Services";
	endif;
	$description                   = wp_trim_excerpt( wp_kses_post( $term->description ) );
	$url                           = esc_url( get_term_link( $term ) );
	$component_attrs_array['href'] = $url;

	$id_val = preg_replace( '/[^A-Za-z0-9\-]/', '', str_replace( ' ', '-', str_replace( '&amp', 'and', strtolower( $title ) ) ) );

	$component_attrs = xten_stringify_attrs( $component_attrs_array );

	ob_start();
	?>
	<a <?php echo $component_attrs; ?> id="<?php echo $id_val; ?>" data-c-id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?> flip-card scrollSpy scrollToCenter touchSolutionToHover">
		<div class="flip-card-front">
			<div class="flip-card-inner">
				<?php if ( $icon || $title ) : ?>
					<?php if ( $icon ) : ?>
						<div class="<?php echo $handle; ?>-icon">
							<?php echo $icon; ?>
						</div>
					<?php endif; ?>
					<?php if ( $title ) : ?>
						<h3 class="<?php echo $handle; ?>-title">
							<?php echo $title; ?>
						</h3>
					<?php endif; ?>
					<button type="button" class="btn btn-theme-style btn-flip-card-cta hide-if-mouse hoverTrigger">Read More <span class="fa fa-chevron-right"></span></button>
				<?php endif; // endif ( $icon || $title ) : ?>
			</div>
		</div>
		<div class="flip-card-back">
			<div class="flip-card-inner">
				<?php if ( $icon || $title ) : ?>
					<?php if ( $title ) : ?>
						<h4 class="<?php echo $handle; ?>-title">
							<?php echo $title; ?>
						</h4>
					<?php endif; ?>
					<?php if ( $description ) : ?>
						<p class="<?php echo $handle; ?>-description">
							<?php echo $description; ?>
						</p>
					<?php endif; ?>
					<button type="button" class="btn btn-theme-style btn-flip-card-cta hide-if-mouse clickTrigger">See These Services</button>
				<?php endif; // endif ( $icon || $title ) : ?>
			</div>
		</div>
	</a>

	<?php
	$html = ob_get_clean();

	wp_register_style( $component_id, false );
	wp_enqueue_style( $component_id );
	wp_add_inline_style( $component_id, $styles );

	return $html;

}
