<?php
/**
 * This Component Renders ONE Accordion.
 * @package xten
 */
function component_accordion( $args ) {
	$parent = $args['parent'];
	$open   = $args['open'];
	// Enqueue Stylesheet.
	$handle             = 'accordion';
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

	$content = xten_kses_post( $args['content'] );
	if ( $content ) :
		$styles                             = '';
		$component_id                       = xten_register_component_id( $handle );

		$component_attrs_array              = array();
		$component_attrs_array['data-c-id'] = $component_id;
		$component_attrs_array['class']     = "component-$handle";

		$component_selector                 = "[data-c-id='{$component_attrs_array['data-c-id']}'].{$component_attrs_array['class']}";

		$title            = xten_kses_post( $args['title'] );
		$target           = "$component_id-collapse";
		$color            = esc_attr( $args['color'] );
		if ( $color ) :
			$styles .= xten_add_inline_style(
				$component_selector,
				array(
					'color' => $color,
				)
			);
		endif;
		$background_color = esc_attr( $args['background_color'] );
		if ( $background_color ) :
			$styles .= xten_add_inline_style(
				$component_selector,
				array(
					'background-color' => $background_color,
				)
			);
		endif;

		$icon = $args['icon'];

		$control_attrs_a                     = array();
		$control_attrs_a['id']               = "$component_id-control";
		$control_attrs_a['class']            = "accordion-control";
		$control_attrs_a['data-toggle']      = 'collapse';
		$control_attrs_a['aria-controls']    = $target;
		$control_attrs_a['data-target']      = "#$target";
		$control_attrs_a['aria-expanded']    = $open ? 'true' : 'false';
		$control_attrs_a['aria-label']       = 'Toggle ' . wp_strip_all_tags( $title );
		$control_attrs_a['tabindex']         = '0';

		$collapse_attrs_a                    = array();
		$collapse_attrs_a['id']              = $target;
		$collapse_attrs_a['data-labelledby'] = $control_attrs_a['id'];
		$open_class                          = $open === true ? ' show' : null;
		$collapse_attrs_a['class']           = "accordion-content collapse$open_class";
		
		if ( $parent ) :
			$collapse_attrs_a['data-parent']   = "#$parent";
		endif;

		$component_attrs_s = xten_stringify_attrs( $component_attrs_array );
		$control_attrs_s   = xten_stringify_attrs( $control_attrs_a );
		$collapse_attrs_s  = xten_stringify_attrs( $collapse_attrs_a );

		ob_start();
		?>
		<div <?php echo $component_attrs_s; ?>>
			<div <?php echo $control_attrs_s; ?>>
				<?php if ( $icon ) : ?>
					<span class="collapse-control-icon">
						<?php echo $icon; ?>
					</span>
				<?php endif; ?>
				<?php if ( $title ) : ?>
					<h3 class="accordion-title"><?php echo $title; ?></h3>
				<?php endif; ?>
				<span class="collapse-control-indicator fa fa-minus"></span>
			</div>
			<div <?php echo $collapse_attrs_s; ?>>
				<?php echo $content; ?>
			</div>
		</div>

		<?php
		$html = ob_get_clean();

		if ( $styles !== '' ) :
			wp_register_style( $component_id, false );
			wp_enqueue_style( $component_id );
			wp_add_inline_style( $component_id, $styles );
		endif;

		return $html;
	endif; // endif ( $content ) :
}
