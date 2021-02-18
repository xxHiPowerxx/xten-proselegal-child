<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package xten
 */

get_header(); ?>

	<?php
	$sidebar_location = get_theme_mod( 'sidebar_location', 'sidebar_right' );
	$column           = '';
	if ( 'sidebar_none' !== $sidebar_location ) {
		$column = '-xl-8';
	};
	?>
	<div class="sizeContent container-fluid main-container">
		<div class="row">
			<header class="col xten-hero-banner-w-divider-wrapper p-0 entry-header">
				<?php
				$queried_object = get_queried_object();
				echo render_hero_banner( $queried_object );
				?>
			</header>
		</div>
		<div class="row">
			<div class="col<?php echo esc_attr( $column ); ?> order-xl-1" id="primary">
				<main id="main" class="site-main single-page">
					<div class="container container-post">
						<?php
						while ( have_posts() ) :
							the_post();

							/*
							* Include the component stylesheet for the content.
							* This call runs only once on index and archive pages.
							* At some point, override functionality should be built in similar to the template part below.
							*/
							wp_print_styles( array( 'xten-content-css' ) ); // Note: If this was already done it will be skipped.

							get_template_part( 'template-parts/content', get_post_type() );

						endwhile; // End of the loop.
						?>
					</div><!-- /.container-post -->
				</main><!-- /#main -->
			</div> <!-- /.col -->
			<?php
			/**
			 * Customizer Ordered sidebar.
			 */
			require get_template_directory() . '/inc/sidebar-display-order.php';
			?>
		</div> <!-- end row -->
		<div class="row sub-footer">
			<div class="alt-bg-spacer d-none"></div>
			<?php
			echo xten_get_reuseable_block( 'Service Categories Section RB' );
			echo xten_get_reuseable_block( 'Contact Section RB' );
			?>
		</div>
	</div> <!-- end sizeContent -->

<?php
get_footer();
