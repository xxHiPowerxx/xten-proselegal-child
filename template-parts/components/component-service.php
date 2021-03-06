<?php
/**
 * This Component renders one Service.
 * @package xten
 */
function component_service( $args = null ) {
	// Enqueue Stylesheet.
	$handle             = 'service';
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

	$styles          = '';
	$component_id    = xten_register_component_id( $handle );

	$post_id         = $args['post_id'];
	$_args           = array();
	$_args['title']  = get_the_title( $post_id );
	$_args['open']   = $args['open'];
	// $_args['parent'] = $args['parent'];
	$description     = xten_kses_post( get_the_content( $post_id ) );
	$content         = null;
	if ( $description ) :
		$queried_object   = get_queried_object();
		$service_category = get_class($queried_object) === 'WP_Term' ?
			$queried_object->name :
			null;
		$pre_fill        = esc_attr( get_field( 'pre_fill_message_default', 'options', false ) );
		if ( $pre_fill ) :
			$pre_fill = str_replace('${service-category}', $service_category, $pre_fill );
			$pre_fill = str_replace('${service}', $_args['title'], $pre_fill );
		endif;
		ob_start();
		?>
		<div class="accordion-content-inner">
			<span class='service-description'><?php echo $description; ?></span>
			<?php
			$fee = esc_attr( get_field( 'fee', $post_id ) );
			if ( $fee ) :
				$footnotes_array = get_the_terms( $post_id, 'footnotes' );
				$footnotes_args  = array( 'footnotes' => $footnotes_array );
				$footnotes       = xten_render_component( 'footnotes-list', $footnotes_args );
				?>
				<span class='service-fee'>
					<span class='fee-label'>Fee:</span> <span class='fee-price'>$<?php echo $fee; ?></span>
					<?php echo '&nbsp;' . $footnotes; ?>
				</span>
			<?php endif; ?>
		</div>
		<button type="button" class="btn btn-theme-style btn-color-primary btn-large btn-show-contact preFillContactForm" data-toggle="modal" data-target="#site-wide-contact-form-modal" data-pre-fill="<?php echo $pre_fill; ?>" data-service-category="<?php echo $service_category; ?>">Get Started</button>
		<?php
		$content = ob_get_clean();
	endif;
	$_args['content'] = $content;
	if ( is_object( $post_id ) && get_class( $post_id ) === 'WP_Post' ) :
		$post = $post_id;
	else:
		global $post;
	endif;
	$component_attrs_array = array(
		'id' => $post->post_name,
		'c-id' => $component_id,
		'class' => "component-$handle activateOnHash",
	);
	$component_attrs = xten_stringify_attrs( $component_attrs_array );

	ob_start();
	?>
	<div <?php echo $component_attrs; ?>>
		<?php echo xten_render_component( 'accordion', $_args ); ?>
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
