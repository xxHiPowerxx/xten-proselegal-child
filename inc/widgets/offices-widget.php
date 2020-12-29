<?php
/*
	Plugin Name: Offices Widget
	Plugin URI: https://github.com/xxHiPowerxx/xten-proselegal-child
	Description: Offices with phone numbers and Addresses
	Author: Ricky Adams
	Author URI: https://rickyradams.com
 */

/**
 * Adds XTen_Offices widget.
 */
class XTen_Offices extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'XTen_Offices',
				__('Offices', 'xten'), // Name
				array('description' => __('Offices with phone numbers and Addresses', 'xten'),)
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget($args, $instance) {

			$facebook  = $instance['facebook'];
			// Field Id of offices.
			$field_id = 'field_5fea27a18a30b';
			$post_ids = $instance['acf'][$field_id];
			$html     = null;
			// var_dump(	get_field_object('offices'), ' foobar!');
			// var_dump(	$post_ids, ' foobar 1');

			ob_start();
			// foreach ( $post_ids as $post_id ) :
				// xten_render_component( 'offices', 'dookie' );
			// endforeach;
			$html = ob_get_clean();
			

			// social profile link
			$facebook_profile  = '<a class="facebook" target="_blank" aria-label="Visit Our Facebook Page" href="' . $facebook . '"><i aria-hidden="true" class="fab fa-facebook-square" title="Visit Our Facebook Page"></i><span class="sr-only">Visit Our Facebook Page</span></a>';

			echo $args['before_widget'];

				echo xten_render_component( 'offices-list', $post_ids );

			echo $args['after_widget'];
		}
	}

// register XTen_Offices widget
function register_xten_offices_widget() {
		register_widget('XTen_Offices');
}

add_action('widgets_init', 'register_xten_offices_widget');