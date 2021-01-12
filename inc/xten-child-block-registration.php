<?php
/**
 * File used for Registering Section Blocks
 *
 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/
 *
 * @package xten
 */

/**
 * Register Custom Block Category.
 */
function xten_child_block_category( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug'  => 'xten-child',
				'title' => __( 'XTen Child', 'xten' ),
				'icon'  => $GLOBALS['xten-section-icon']['xten-sections'],
			),
		),
		$categories
	);
}
add_filter( 'block_categories', 'xten_child_block_category', 10, 2);

function xten_child_acf_blocks_init() {

	// Check function exists.
	if( function_exists('acf_register_block_type') ) {

		// Accordion - xten-section-accordion.
		$handle       = 'accordion';
		$section_name = 'xten-section-' . $handle;
		acf_register_block_type(
			array(
				'name'              => $section_name,
				'title'             => __('Accordion'),
				'description'       => __('Collapsable content in an accordion layout.'),
				'icon'              => xten_get_icon($section_name),
				'render_template'   => get_stylesheet_directory() . '/template-parts/block/' . $section_name . '.php',
				'keywords'          => array(
																'xten',
																'section',
																'accordion',
																'collapse',
																'toggle',
																'open',
																'close',
															),
				'supports'          => array(
					'anchor' => true,
				),
				'category'          => 'xten-child',
				'enqueue_assets'    => function ($block) {
																	$section_name = str_replace( 'acf/', '', $block['name'] );
																	xten_enqueue_assets( $section_name );
																}
			)
		);
	}
}
add_action('acf/init', 'xten_child_acf_blocks_init');
