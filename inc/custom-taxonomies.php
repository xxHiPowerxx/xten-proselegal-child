<?php
/**
 * File included in functions for Creating Custom Taxonomies.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 *
 * @package xten
 */

/**
 * Utility function to create Taxonomy Labels.
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/#arguments
 * 
 * @param string $plural = 'tags' by default.
 * @param string $singular = 'tag' by default.
 * @return array Array of labels assembled using $plural and $singular names given.
 */
function create_tax_labels( $plural = 'tags', $singular = 'tag' ) {
	$names = array(
		'p' => strtolower( $plural ),
		's' => strtolower( $singular ),
		'P' => ucwords( $plural ),
		'S' => ucwords( $singular ),
	);
	$labels = array(
		'name'                       => _x( $names['P'], 'taxonomy general name' ),
		'singular_name'              => _x( $names['S'] . ' ', 'taxonomy singular name' ),
		'menu_name'                  => __( $names['P'] ),
		'all_items'                  => __( 'All ' . $names['P'] ),
		'edit_item'                  => __( 'Edit ' . $names['S'] ), 
		'view_item'                  => __( 'View Tag' ),
		'update_item'                => __( 'Update ' . $names['S'] ),
		'add_new_item'               => __( 'Add New ' . $names['S'] ),
		'new_item_name'              => __( 'New ' . $names['S'] . '  Name' ),
		'parent_item'                => __( 'Parent ' . $names['S'] ),
		'parent_item_colon'          => __( 'Parent ' . $names['S'] . ' :' ),
		'search_items'               => __( 'Search ' . $names['P'] ),
		'popular_items'              => __( 'Popular ' . $names['P'] ),
		'separate_items_with_commas' => __( 'Separate ' . $names['P'] . ' with commas' ),
		'add_or_remove_items'        => __( 'Add or remove ' . $names['P'] ),
		'choose_from_most_used'      => __( 'Choose from the most used ' . $names['P'] ),
		'not_found'                  => __( 'No ' . $names['P'] . ' found.' ),
		'back_to_items'              => __( '← Back to ' . $names['P'] ),
	);
	return $labels;
}

/**
 * A Function that will render our Custom Taxonomies.
 */
function xten_child_custom_taxonomies() {

	$labels = create_tax_labels( 'service categories', 'service category' );

	// Now register the taxonomy
  register_taxonomy(
		'service-categories',
		array(
			'services',
		),
		array(
			'public'             => true,
			'publicly_queryable' => true,
			'hierarchical'       => false,
			'meta_box_cb'        => 'post_categories_meta_box',
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => true,
			'show_admin_column'  => true,
			'query_var'          => true,
			'show_in_rest'       => true,
			'rewrite'            => array(
				'slug'       => 'services',
				'with_front' => false,
			),
			// 'rewrite'           => false,
		)
	);

	$labels = create_tax_labels( 'footnotes', 'footnote' );

	// Now register the taxonomy
  register_taxonomy(
		'footnotes',
		array(
			'services',
		),
		array(
			'public'             => false,
			'publicly_queryable' => false,
			'hierarchical'       => false,
			'meta_box_cb'        => 'post_categories_meta_box',
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_nav_menus'  => false,
			'show_admin_column'  => true,
			'query_var'          => true,
			'show_in_rest'       => true,
			'rewrite'           => false,
		)
	);

}
	 
	/**
	 * Hook into the 'init' action so that the function
	 * Containing our taxonomy registration is not
	 * unnecessarily executed.
	 */
	 
	add_action( 'init', 'xten_child_custom_taxonomies', 0 );
