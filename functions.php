<?php
/*This file is part of the XTen Child Theme.

All functions of this file will be loaded before of parent theme functions.
Learn more at https://codex.wordpress.org/Child_Themes.
*/

function priority_enqueues() {
	$google_font_css_path = 'https://fonts.googleapis.com/css2?family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap';
	wp_enqueue_style( 'google-font-css', $google_font_css_path, array(), '', 'all' );
}
add_action( 'wp_enqueue_scripts', 'priority_enqueues', 1 );


// Note: this function loads the parent stylesheet before, then child theme stylesheet
// (leave it in place unless you know what you are doing.)
function enqueue_child_styles() {
	$parent_style = 'parent-style';
		wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array( 'xten-vendor-bootstrap-css' ) );
		wp_enqueue_style(
			'child-style',
			get_stylesheet_directory_uri() . '/style.css',
			array( $parent_style, 'xten-base-style' ),
			filemtime( get_stylesheet_directory() . '/style.css' ) 
		);

		// Register Styles
		$child_theme_css_path = '/assets/css/child-theme.min.css';
		wp_register_style( 'child-theme-css', get_stylesheet_directory_uri() . $child_theme_css_path, array( 'xten-base-style' ), filemtime( get_stylesheet_directory() . $child_theme_css_path ), 'all' );

		// Register Scripts
		$child_theme_js_path = '/assets/js/child-theme.min.js';
		wp_register_script( 'child-theme-js', get_stylesheet_directory_uri() . $child_theme_js_path, array(), filemtime( get_stylesheet_directory() . $child_theme_js_path ), true );

		// Enqueue Styles
		wp_enqueue_style( 'child-theme-css' );

		// Enqueue Scripts

}
add_action( 'wp_enqueue_scripts', 'enqueue_child_styles', 11 );
	
// IF ACF-JSON is a requirement create the acf-json folder and uncoment the following
// // Load fields.
add_filter('acf/settings/load_json', 'child_acf_json_load_point');

function child_acf_json_load_point( $paths ) {

    // remove original path (optional)
    unset($paths[0]);


    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';


    // return
    return $paths;

}

/**
 * Get Option from Site Settings Page and save ACF to Child if Set.
 * Check to see if xten Save fields file exsists and adds save point if it does.
 * 
 */
function save_acf_fields_to_child_theme() {
	$save_acf_fields_to_child_theme = get_field('save_acf_fields_to_child_theme', 'options');
	// If not set, default to true.
	$save_acf_fields_to_child_theme = $save_acf_fields_to_child_theme !== null ? $save_acf_fields_to_child_theme : true;
	$select_where_to_save_acf_field_groups = get_field('select_where_to_save_acf_field_groups', 'options');
	if (
		$select_where_to_save_acf_field_groups === 'child' ||
		(
			$select_where_to_save_acf_field_groups === null &&
			$save_acf_fields_to_child_theme
		)
	) :
		$save_acf_fields = get_stylesheet_directory() . '/acf/save-acf-fields.php';
		if ( file_exists( $save_acf_fields ) ) {
			require $save_acf_fields;
		}
	endif;
}
add_action( 'acf/init', 'save_acf_fields_to_child_theme' );

/* for Contact-Form-7 */
add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Custom Post Types.
 */
require get_stylesheet_directory() . '/inc/custom-post-types.php';

/**
 * Utility Functions
 */
require get_stylesheet_directory() . '/inc/utility-functions.php';

/**
 * Shortcodes
 */
require get_stylesheet_directory() . '/inc/shortcodes.php';

/**
 * Widgets.
 */
require get_stylesheet_directory() . '/inc/widgets/offices-widget.php';