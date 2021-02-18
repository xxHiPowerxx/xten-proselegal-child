<?php
/**
 * Render Template for Service Categories Block
 *
 * @link https://www.advancedcustomfields.com/resources/acf_register_block_type/
 *
 * @package xten-sections
 */

$handle                     = 'service-categories';
$section_name               = 'xten-section-' . $handle;
$section_attrs              = array();
$section_attrs['data-s-id'] = $section_name . '-' . $block['id'];
$s_id                       = $section_attrs['data-s-id'];
$section_attrs['id']        = $block['anchor'];
$section_attrs['class']     = '';
$section_attrs['class'] .= 'xten-section xten-section-' . $handle;
$section_attrs['class'] .= $block['className'] ?
	' ' . $block['className'] :
	null;

$styles        = '';

$section_container = get_field( 'section_container' ); // DV = true (Fixed Width).
$container_class   = $section_container ? esc_attr( 'container container-ext' ) : esc_attr( 'container-fluid' );

$title                      = xten_kses_post( get_field( 'title', false, false ) );
$include_cta_button         = get_field( 'include_cta_button' );
$args                       = array();
$args['terms']              = get_field( 'service_categories' );
// var_dump($args);
// die;

// Render Section
$section_attrs_s = xten_stringify_attrs( $section_attrs );

?>
<section <?php echo $section_attrs_s; ?>>
	<div class="<?php echo $container_class; ?> container-<?php echo esc_attr( $section_name ); ?>">
		<div class="xten-content">
			<?php if ( $title ) : ?>
				<h2 class="xten-section-heading"><?php echo $title; ?></h2>
			<?php endif; ?>
			<?php echo xten_render_component( 'service-categories-list', $args ); ?>
			<?php
			if ( $include_cta_button ) :
				$services_url = get_permalink( get_page_by_title( 'Services' ) ) ? : get_home_url( null, '/services' );
				?>
				<div class="anchor-btn-cta-wrapper">
					<a class="anchor-btn-cta" href="<?php echo esc_url( $services_url ); ?>">
						<button class="btn btn-theme-style btn-cta btn-large" type="button">See All Services</button>
					</a>
				</div>
			<?php endif; ?>
		</div><!-- /.xten-content -->
	</div><!-- /.container-<?php echo esc_attr( $section_name ); ?> -->
</section><!-- /#<?php echo $s_id; ?> -->

<?php
xten_section_boilerplate( $s_id, $section_name, $styles );