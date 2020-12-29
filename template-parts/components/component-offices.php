<?php
/**
 * This Component Renders one or more Offices.
 * @package xten
 */
function component_offices( $post_ids = null ) {
	// var_dump($post_ids, 'foobar 3');
	// Enqueue Stylesheet.
	/*$component_css_path = '/assets/' . $handle . '-css.css';
	wp_register_style(
		$handle . '-css',
		get_theme_file_uri( $component_css_path ),
		array(
			'child-style',
		),
		filemtime( get_template_directory() . $component_css_path ),
		'all'
	);
	wp_enqueue_style( $handle . '-css' );*/
	$styles = '';

	if ( ! function_exists( 'render_office' ) ) :
		function render_office( $post_id ) {
			$handle       = 'office';
			$component_id = $post_id;
			if ( $post_id === null ) :
				global $post;
				if ( $post ) :
					$component_id = $post->ID;
				endif;
			endif;
			$component_id        = $handle . '-' . $component_id;
			$office_title        = get_the_title( $post_id );
			$office_address      = get_field( 'office_address', $post_id );
			$address_line_1      = esc_attr( $office_address['address_line_1'] );
			$address_line_2      = esc_attr( $office_address['address_line_2'] );
			$city                = esc_attr( $office_address['city'] );
			$state               = esc_attr( $office_address['state'] );
			$zip_code            = esc_attr( $office_address['zip_code'] );
			$office_phone_number = esc_attr( get_field( 'office_phone_number', $post_id ) );
			$google_maps_link    = esc_url( get_field( 'google_maps_link', $post_id ) );
			$google_maps_attrs   = $google_maps_link ?
				'href=' . $google_maps_link . ' target="_blank" title="View on Google Maps (opens in a new tab)"' :
				null;
			$office_open         = $office_phone_number !== '';
			$has_address         = false;
				foreach ( $office_address as $address_item ) :
					if ( $address_item !== '' ) :
						if ( $office_open === false ) :
							$office_open = true;
						endif; // endif ( $office_open === false ) :
						$has_address = true;
					break;
					endif;
				endforeach;
			ob_start();
			?>
			<div id="<?php echo $component_id; ?>" class="component-<?php echo $handle; ?>">
				<div class="office-content">
					<?php if ( $office_title ) : ?>
						<h4 class="office-title"><?php echo $office_title; ?></h4>
					<?php endif; ?>
					<?php if ( $office_open ) : ?>
						<?php if ( $office_phone_number !== '' ) : ?>
							<a class="office-phone-number" href="tel:<?php echo $office_phone_number; ?>"><?php echo $office_phone_number; ?></a>
						<?php endif; ?>
						<?php if ( $has_address ) : ?>
							<a class="anchor-office-address" <?php echo $google_maps_attrs; ?>>
								<?php if ( $address_line_1 !== '' || $address_line_2 !== '' ) : ?>
									<?php if ( $address_line_1 ) : ?>
										<span class="office-address-line-1"><?php echo $address_line_1; ?></span>
									<?php endif;?>
									<?php if ( $address_line_2 ) : ?>
										<span class="office-address-line-2"><?php echo $address_line_2; ?></span>
									<?php endif;?>
								<?php endif; // endif ( $address_line_1 !== '' || $address_line_2 !== '' ?>
								<?php if ( $city !== '' ) : ?>
									<span class="office-city" href="tel:<?php echo $city; ?>"><?php echo $city; ?></a>
								<?php endif; ?>
								<?php if ( $state !== '' ) : ?>
									<span class="office-state" href="tel:<?php echo $state; ?>"><?php echo $state; ?></a>
								<?php endif; ?>
								<?php if ( $zip_code !== '' ) : ?>
									<span class="office-zip-code" href="tel:<?php echo $zip_code; ?>"><?php echo $zip_code; ?></a>
								<?php endif; ?>
							</a>
						<?php endif; // endif ( $has_address ) : ?>
					<?php else : ?>
						<div class="office-coming-soon">
							<span class="office-coming-soon-text">Comming Soon!</span>
						</div>
					<?php endif; // endif ( ! $office_open ) : ?>
				</div>
			</div>

			<?php
			$html = ob_get_clean();
			return $html;
		}
	endif;

	$html = '';
	if ( is_array( $post_ids ) ) :
		foreach ( $post_ids as $post_id ) :
			// var_dump($post_ids);
			$html .= render_office( $post_id );
		endforeach;
	else:
		$html .= render_office( $post_id );
	endif;

	return $html;
}
