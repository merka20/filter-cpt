<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article class="<?php post_class();?>">
	<!--<header>
	<h1><?php the_title(); ?></h1>
	</header>-->
	<?php the_content(); ?>
</article>

<?php endwhile; else: ?>

<article>
	<p>No hay contenido a mostrar </p>
</article>

<?php endif; ?>


<?php get_footer(); ?>