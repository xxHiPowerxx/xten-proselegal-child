<?php
/**
 * Template part for displaying a single archive-post in a collection of archive-posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

global $wp_query;
$open  = $wp_query->current_post === 0;

$_args = array(
	'open'   => $open,
	'parent' => $args['parent'],
);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'listed-post listed-service' ); ?>>
	<?php echo xten_render_component( 'service', $_args ); ?>
</article><!-- #post-<?php the_ID(); ?> -->
