<?php
/**
 * This Component Renders one or more Service Categories.
 * @package xten
 */
function component_service_categories_list( $args ) {

	$handle = 'service-categories-list';

	$terms = $args['terms'];
	if ( ! $terms ) :
		$terms = get_terms( array(
			'taxonomy'   => 'service-categories',
			'hide_empty' => false,
		) );
	endif;

	if ( ! $terms ) :
		return false;
	endif;

	$styles = '';

	$component_id = xten_register_component_id( $handle );
	$service_categories_html = '';
	$scroll_nav_html         = '';
	if ( ! empty( $terms ) ) :
		foreach ( $terms as $term ) :
			$term_name             = esc_attr( $term->name );
			$service_category_html = xten_render_component( 'service-category', $term );
			// disable errors because $service_category_html may contain SVG code.
			libxml_use_internal_errors(true);
			$doc = DOMDocument::loadHTML($service_category_html);
			// renable errors.
			libxml_clear_errors();
			$xpath = new DOMXPath($doc);
			$query = "//*[contains(@class, 'component-service-category')]";
			$entries = $xpath->query($query);
			foreach ($entries as $entry) :
				$service_category_id = $entry->getAttribute("id");
				$scroll_nav_html    .= "<a class='nav-link' href='#$service_category_id'>$term_name</a>";
			endforeach;

			// Add to Service Categories HTML
			$service_categories_html .= $service_category_html;
		endforeach; // endforeach ( $terms as $term ) :
	endif; // endif ( ! empty( $terms ) ) :

	ob_start();
	?>
	<div id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?>">
		<nav id="xten-scroll-nav" class="navbar service-categories-list-scroll-nav xten-scroll-nav">
			<div class="nav nav-pills">
				<?php echo $scroll_nav_html; ?>
			</div>
		</nav>
		<div class="service-categories-wrapper">
			<?php echo $service_categories_html; ?>
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
}