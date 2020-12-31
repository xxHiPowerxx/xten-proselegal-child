<?php
/**
 * Utility Functions
 *
 * @package xten
 */

/**
 * XTen Child Utilities
 * Makes Utility functions available throughout theme.
 */
class XTenChildUtilities {
	/**
	 * Global Utilites
	 * Calls functions to be used globally throughout theme.
	 */
	public function global_utilities() {

		/**
		 * Render Markup for Component.
		 * Function will attempt to get required file to render Component
		 * 
		 * @param string $handle name of handle will be used to find correct file.
		 * @param mixed array|string $post_id optional post or array of posts of data being passed.
		 * @return string rendered markup as string.
		 */
		function xten_render_component( $handle, $post_id = null ) {
			$file_path = get_stylesheet_directory() . '/template-parts/components/';
			$file_name = 'component-' . $handle . '.php';
			$file_path = $file_path . $file_name;
			if ( file_exists( $file_path ) ) :
				require_once( $file_path );
				$handle_snake_case = str_replace('-', '_', $handle );
				$component_func = 'component_' . $handle_snake_case;
				if ( function_exists( $component_func ) ) :
					return $component_func( $post_id );
				endif;
			endif;
		}

		/**
		 * Create Component ID
		 * Function Increments Id based on handle
		 * @param string $handle name of handle.
		 * @return int component id.
		 */
		function xten_register_component_id( $handle ) {
			$GLOBALS['component_ids'][$handle] = $GLOBALS['component_ids'][$handle] !== null ?
				$GLOBALS['component_ids'][$handle] :
				0;
				$GLOBALS['component_ids'][$handle] ++;
				$component_id = $handle . '-' . $GLOBALS['component_ids'][$handle];

			return  $component_id;
		}
	}
}

$ob = new XTenChildUtilities();
$ob->global_utilities();
