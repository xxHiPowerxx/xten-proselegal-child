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
		$image_size         = xten_get_optimal_image_size(
			$featured_image['id'],
			array( 415, null),
			array( 415, 279 )
		);
		$featured_image_src = wp_get_attachment_image_src( $featured_image['id'], $image_size );
		if ( $featured_image_src[0] ) :
			$styles .= xten_add_inline_style(
				'#' . $component_id . ' .flip-card-front,' .
				'#' . $component_id . ' .flip-card-back',
				array(
					'background-image' => 'url(' . $featured_image_src[0] . ')',
				)
			);
		endif;
	endif; // endif ( $featured_image ) :

	$icon = null;
	if ( have_rows( 'icon_fc', $term ) ) :
		while ( have_rows( 'icon_fc', $term ) ) :
			the_row();
			$row_layout = get_row_layout();
			$component_attrs_array['data-icon-type'] = str_replace( '_', '-', $row_layout );
			if ( $row_layout === 'font_awesome_icon' ) :
				
				$fa_handle = esc_attr( get_sub_field( 'font_awesome_icon_handle' ) );
				if ( $fa_handle ) :
					$icon = '<i class="fa fa-' . $fa_handle . '"></i>';
				endif;
			endif; // endif ( $row_layout === 'font_awesome_icon' ) :
			if ( $row_layout === 'svg' ) :
				$svg_path = get_sub_field( 'svg_path' );
				if ( $svg_path ) :
					$whole_path = get_stylesheet_directory() . $svg_path;

					if ( file_exists( $whole_path ) ) :
						$icon = file_get_contents( $whole_path );
					endif;
				endif;
			endif; // endif ( $row_layout === 'svg' ) :
			if ( $row_layout === 'bitmap' ) :
				$image = get_sub_field( 'image' );
				if ( $image ) :
					$icon = wp_get_attachment_image(
						$image['id'],
						xten_get_optimal_image_size(null, 70), true
					);
				endif;
			endif; // endif ( $row_layout === 'bitmap' ) :
		endwhile;
	endif;

	// var_dump( $term );
	$title                         = esc_attr( $term->name );
	$description                   = wp_trim_excerpt( wp_kses_post( $term->description ) );
	$url                           = esc_url( get_term_link( $term ) );
	$component_attrs_array['href'] = $url;

	$component_attrs = '';
	foreach ($component_attrs_array as $key => $value) :
		$space = $key !== $component_attrs_array[0] ?
			' ' :
			null;
		$component_attrs.= "$space$key=$value";
	endforeach;

	ob_start();
	?>
	<a id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?> flip-card" <?php echo esc_attr( $component_attrs ); ?>>
		<div class="flip-card-front">
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
		</div>
		<div class="flip-card-back">
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
		</div>
	</a>

	<?php
	$html = ob_get_clean();

	wp_register_style( $component_id, false );
	wp_enqueue_style( $component_id );
	wp_add_inline_style( $component_id, $styles );

	return $html;

}
