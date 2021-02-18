<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area' ); ?>>
	<div class="entry-content">
		<?php

		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'xten' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'xten' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- /.entry-content -->

	<footer class="entry-footer xten-highlight-font">
		<div class="post-category">
			<h5 class="post-category-title">Category:</h5>
			<?php xten_post_categories(); ?>
		</div><!-- .post-category -->
		<?php
		xten_edit_post_link();
		?>
	</footer><!-- /.entry-footer -->
</article><!-- /#post-<?php the_ID(); ?> -->

<?php
if ( is_singular() ) :
	$post_type_name = esc_attr( get_post_type_object( get_post_type() )->labels->singular_name );
	the_post_navigation(
		array(
			'prev_text'          => __( '<div class="nav-link-label"><i class="nav-link-label-icon fas fa-arrow-left"></i> <span class="nav-link-label-text">Previous ' . $post_type_name . '</span></div><div class="ctnr-nav-title"><span class="nav-title">%title</span></div>' ),
			'next_text'          => __( '<div class="nav-link-label"><span class="nav-link-label-text">Next ' . $post_type_name . '</span> <i class="nav-link-label-icon fas fa-arrow-right"></i></div><div class="ctnr-nav-title"><span class="nav-title">%title</span></div>' ),
			'screen_reader_text' => __( 'Posts navigation' ),
		)
	);

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endif;
