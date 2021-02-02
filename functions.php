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
	$css_dependancies   = array();
	$css_dependancies[] = 'xten-base-style';
	// TODO: Figure out how to make Child Stylesheet load AFTER ALL xten-sections stylesheets for overrides.
	$handle = 'xten-component-hero-css';
	if ( wp_style_is( $handle, 'registered' ) ) :
		$css_dependancies[] = $handle;
	endif;
	$child_theme_css_path = '/assets/css/child-theme.min.css';
	wp_register_style( 'child-theme-css', get_stylesheet_directory_uri() . $child_theme_css_path, $css_dependancies, filemtime( get_stylesheet_directory() . $child_theme_css_path ), 'all' );

	// Register Scripts
	$child_theme_js_path = '/assets/js/child-theme.min.js';
	wp_register_script( 'child-theme-js', get_stylesheet_directory_uri() . $child_theme_js_path, array(), filemtime( get_stylesheet_directory() . $child_theme_js_path ), true );

	// Enqueue Styles
	wp_enqueue_style( 'child-theme-css' );

	// Enqueue Scripts
	wp_enqueue_script( 'child-theme-js' );

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
 * Custom Taxonomies.
 */
require get_stylesheet_directory() . '/inc/custom-taxonomies.php';

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

/**
 * Inline Styles.
 */
require get_stylesheet_directory() . '/inc/inline-styles.php';

/**
 * Block Registration.
 */
require get_stylesheet_directory() . '/inc/xten-child-block-registration.php';

/**
 * Convert Post Taxonomy Checkboxes to Radio so only one value can be selected.
 */
function convert_post_tax_checkboxes_to_radio() {
	global $post_type;
	$p_t = 'services';
	if ($p_t == $post_type) :
		$tax = 'service-categories';
		?>
		<script type="text/javascript">
			jQuery('#<?php echo $tax; ?>checklist>li>label input, #<?php echo $tax; ?>checklist>li>ul>li>label input').each(function() {
				this.type = 'radio';
			});
			jQuery('#<?php echo $tax; ?>-tabs .hide-if-no-js').remove();
		</script>
		<?php
	endif;
}
add_action('admin_footer-post.php', 'convert_post_tax_checkboxes_to_radio');
add_action('admin_footer-post-new.php', 'convert_post_tax_checkboxes_to_radio');

/**
 * Set Services order to ASC on Service Category Taxonomy Page.
 */
function mod_service_categories_order( $query ) {
	if(
		$query->is_main_query() &&
		! is_admin() &&
		$query->is_archive() &&
		$query->is_tax( 'service-categories' )
	) :
		// Set parameters to modify the query
		$query->set( 'posts_per_page', -1 );
		$query->set( 'orderby', 'date' );
		$query->set( 'order', 'ASC' );
		$query->set( 'suppress_filters', 'true' );
	endif;
}
 
// Hook our custom query function to the pre_get_posts 
add_action( 'pre_get_posts', 'mod_service_categories_order' );

/**
 * Redirect Staff Member to Staff Section on About Us Page.
 */
function redirect_staff() {
	$post_type = 'staff';
	if ( is_singular( $post_type ) ) :
		$link = get_page_by_title( 'About' );
		// var_dump($link->guid);
		// die;
    wp_redirect( $link->guid . '#staff', 301 );
    exit;
	endif;
}
add_action( 'template_redirect', 'redirect_staff' );

function tag_manager_head() {
	?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-FVT3DGN');</script>
	<!-- End Google Tag Manager -->
	<?php
}
add_action('wp_head','tag_manager_head', 20);

function tag_manager_body(){
	?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-FVT3DGN"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php
}
add_action('__before_header','tag_manager_body', 20);