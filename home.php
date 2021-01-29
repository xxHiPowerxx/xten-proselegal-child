<?php
/**
 * The template for displaying the Blog Overview page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

get_header(); ?>

<?php wp_print_styles( array( 'xten-archive-css' ) ); ?>

	<?php
	$sidebar_location = get_theme_mod( 'sidebar_location', 'sidebar_right' );
	$column           = '';
	$article_col_size = '3';
	if ( 'sidebar_none' !== $sidebar_location ) {
		$column           = '-xl-8';
		$article_col_size = '6';
	};
	?>

	<div class="sizeContent container-fluid main-container">
		<div class="row">
			<div class="col xten-hero-banner-w-divider-wrapper p-0">
				<?php
				$queried_object = get_queried_object();
				echo render_hero_banner( $queried_object );
				?>
			</div>
		</div>
		<div class="row">
			<div class="col<?php echo esc_attr( $column ); ?> order-xl-1 content-area" id="primary">
				<main id="main" class="site-main archive-page container container-ext">

					<?php

					if ( have_posts() ) :
						/*
						* Include the component stylesheet for the content.
						* This call runs only once on index and archive pages.
						* At some point, override functionality should be built in similar to the template part below.
						*/
						wp_print_styles( array( 'xten-content-css' ) ); // Note: If this was already done it will be skipped.

						/* Display the appropriate header when required. */
						xten_index_header();

						?>

						<div class="archive-container d-flex flex-row flex-wrap align-items-stretch">
							<?php

							/* Start the Loop */
							while ( have_posts() ) :
								?>
								<div class="article-container col-md-<?php echo $article_col_size; ?>">
									<?php
									the_post();

									/*
									* Include the Post-Type-specific template for the content.
									* If you want to override this in a child theme, then include a file
									* called content-___.php (where ___ is the Post Type name) and that will be used instead.
									*/
									get_template_part( 'template-parts/content', 'archive-post' );
									?>
								</div><!-- .article-container -->
								<?php
							endwhile;
							?>
						</div><!-- /.archive-container -->
						<?php

						the_posts_navigation(
							array(
								'prev_text'          => __( '<i class="fas fa-arrow-left"></i> Older posts', 'xten' ),
								'next_text'          => __( 'Newer posts <i class="fas fa-arrow-right"></i>', 'xten' ),
								'screen_reader_text' => __( 'Posts navigation', 'xten' ),
							)
						);

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;

					?>

				</main><!-- #primary -->
			</div> <!-- end column -->
			<?php
			/**
			 * Customizer Ordered sidebar.
			 */
			require get_template_directory() . '/inc/sidebar-display-order.php';
			?>
		</div> <!-- end row -->
	</div> <!-- end sizeContent -->
<?php



get_footer();