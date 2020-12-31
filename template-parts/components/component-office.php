<?php
/**
 * This Component Renders ONE Office.
 * @package xten
 */
function component_office( $post_id = null ) {
	// Enqueue Stylesheet.
	$handle             = 'office';
	$component_handle   = 'component-' . $handle;
	$component_css_path = '/assets/css/' . $component_handle . '.min.css';
	wp_register_style(
		$component_handle . '-css',
		get_theme_file_uri( $component_css_path ),
		array(
			'child-style',
		),
		filemtime( get_stylesheet_directory() . $component_css_path ),
		'all'
	);
	wp_enqueue_style( $component_handle . '-css' );
	$styles = '';

	// $component_id = $post_id;
	// if ( $post_id === null ) :
	// 	global $post;
	// 	if ( $post ) :
	// 		$component_id = $post->ID;
	// 	endif;
	// endif;
	$component_id        = xten_register_component_id( $handle );
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
		<?php if ( $office_title ) : ?>
			<h4 class="office-title"><?php echo $office_title; ?></h4>
		<?php endif; ?>
		<?php if ( $office_open ) : ?>
			<div class="office-content">
				<?php if ( $office_phone_number !== '' ) : ?>
					<a class="anchor-office-phone-number" href="tel:<?php echo $office_phone_number; ?>"><span class="office-icon fas fa-phone phone-icon-fix"></span><span class="office-phone-number"><?php echo $office_phone_number; ?></span></a>
				<?php endif; ?>
				<?php if ( $has_address ) : ?>
					<a class="anchor-office-address" <?php echo $google_maps_attrs; ?>>
						<span class="office-icon fas fa-map-marker-alt"></span>
						<div class="office-address-wrapper">
							<?php if ( $address_line_1 !== '' || $address_line_2 !== '' ) : ?>
								<?php if ( $address_line_1 ) : ?>
									<span class="office-address-line-1"><?php echo $address_line_1; ?></span>
								<?php endif;?>
								<?php if ( $address_line_2 ) : ?>
									<span class="office-address-line-2"><?php echo $address_line_2; ?></span>
								<?php endif;?>
							<?php endif; // endif ( $address_line_1 !== '' || $address_line_2 !== '' ?>
							<?php if ( $city !== '' ) : ?>
								<span class="office-city"><?php echo $city; ?></span>
							<?php endif; ?>
							<?php if ( $state !== '' ) : ?>
								<span class="office-state"><?php echo $state; ?></span>
							<?php endif; ?>
							<?php if ( $zip_code !== '' ) : ?>
								<span class="office-zip-code"><?php echo $zip_code; ?></span>
							<?php endif; ?>
						</div>
					</a>
				<?php endif; // endif ( $has_address ) : ?>
			</div>
		<?php else : ?>
			<div class="office-coming-soon">
				<span class="office-coming-soon-text">Coming Soon!</span>
			</div>
		<?php endif; // endif ( ! $office_open ) : ?>
	</div>

	<?php
	$html = ob_get_clean();
	return $html;

}
