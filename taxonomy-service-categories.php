<?php
/**
 * The template for displaying archive of the Service Category taxonomy.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @link https://developer.wordpress.org/themes/template-files-section/taxonomy-templates/
 * 
 * @package xten
 */

// TODO: Use XTen Hero Section to Render this Taxonomy's header.
// We will need to pull variables here and pass them in a render function.
// EX: xten_render_component('xten-hero-section', $args['content'=>$tax_title])
get_header();
?>
<div class="sizeContent page-full-width">
	<div id="primary">
		<?php
		$queried_object = get_queried_object();
		echo render_hero_banner( $queried_object );

		$section_id = 'services';
		$args = array(
			'parent' => $section_id,
		);
		?>
		<div class="alt-bg-spacer d-none"></div>
		<section id="<?php echo $section_id; ?>" class="services-section section alt-bg">
			<div class="container container-ext container-services-section">
				<div class="services-list">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content-archive', get_post_type(), $args );
						endwhile; // End of the loop.
					else:
						get_template_part( 'template-parts/content', 'none' );
					endif; // endif ( have_posts() ) :
					?>
				</div><!-- /.services-list -->
			</div><!-- /.container-services-section -->
		</section><!-- /#services -->
		<?php
		echo xten_get_reuseable_block( 'Service Categories Section RB' );
		echo xten_get_reuseable_block( 'Contact Section RB' );
		?>
	</div><!-- #primary -->
</div>
<?php
get_footer();
