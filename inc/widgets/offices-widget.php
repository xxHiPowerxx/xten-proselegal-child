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

				echo xten_render_component( 'offices', $post_ids );

			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form($instance) {
			/*
			$facebook  = isset($instance['facebook']) ? $instance['facebook'] : 'https://www.facebook.com/XTen/';
			$twitter   = isset($instance['twitter']) ? $instance['twitter'] : 'https://twitter.com/xten';
			$youtube   = isset($instance['youtube']) ? $instance['youtube'] : 'https://www.youtube.com/user/xtenPIO';
			$instagram = isset($instance['instagram']) ? $instance['instagram'] : 'https://www.instagram.com/xten/';
			$linkedin  = isset($instance['linkedin']) ? $instance['linkedin'] : 'https://www.linkedin.com/company/xten';
			?>
			<p>
				<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube:'); ?></label> 
				<input class="widefat foobar" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo esc_attr($youtube); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo esc_attr($instagram); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>">
			</p>

			<?php*/
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update($new_instance, $old_instance) {
				/*$instance = array();
				$instance['title']     = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
				$instance['facebook']  = (!empty($new_instance['facebook']) ) ? strip_tags($new_instance['facebook']) : '';
				$instance['twitter']   = (!empty($new_instance['twitter']) ) ? strip_tags($new_instance['twitter']) : '';
				$instance['youtube']   = (!empty($new_instance['youtube']) ) ? strip_tags($new_instance['youtube']) : '';
				$instance['instagram'] = (!empty($new_instance['instagram']) ) ? strip_tags($new_instance['instagram']) : '';
				$instance['linkedin']  = (!empty($new_instance['linkedin']) ) ? strip_tags($new_instance['linkedin']) : '';*/

				// return $instance;
				return $new_instance;
		}
	}

// register XTen_Offices widget
function register_xten_offices_widget() {
		register_widget('XTen_Offices');
}

add_action('widgets_init', 'register_xten_offices_widget');