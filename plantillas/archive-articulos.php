<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Astra
 * @since 1.0.0
 */

if( ! defined( 'ABSPATH' ) ) exit; // Salir si acceden directamente


//* Función de loop para seleccionar y mostrar los elementos del portfolio con filtro por categorías.
get_header();

?>
  	 <div id="filtrado" class="archive-description">
  	 
  	 <?php 
	 /*
	 SE NECESITA EL PLUGIN SEARCH AND FILTER PARA PONER ESTE ECHO DE ABAJO CON EL SHORTCODE
	 */
	 //echo do_shortcode( '[searchandfilter fields="search,familia"]' );
  				
	$terms = get_terms( 'familia', 'orderby=name' );		

		if( $terms ) {  				

						echo '<ul id="filters" class="filter clearfix">';						
	                	echo '<li><a href="#" class="active" data-filter="Todos" title="Todos"><span>Todos</span></a></li>';
	                	         

	                    foreach( $terms as $term ){                    	

	                            echo "<li><a href='#' data-filter='.$term->slug'><span>$term->name</span></a></li>";
	                        }
	                	echo '</ul><br/><br/>';
	            }
        
        // Creamos la consulta para filtrar el tipo de post y el máximo por página.
			
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		
		$wpex_port_query = new WP_Query(
			array(
				'post_type' => 'articulos', // enter your custom post type
				'posts_per_page'=> '6',  // overrides posts per page in theme settings
				'paged' => $paged,	
				'post_status' =>'publish', 			
				/**'date_query' => array(
        				array(
							'after'     => array(
								'year'  => 2021,
								'month' => 9,
								'day'   => 1,
							),
							'before'    => array(
								'year'  => 2022,
								'month' => 06,
								'day'   => 27,
							),
							'inclusive' => true,
        				),
    				),**/
			)
		);

		//Mostramos los resultados de la consulta
		if( $wpex_port_query->posts ) { ?>
                <div id="portfolio-wrap" class="clearfix filterable-portfolio">
                    <div id="articulos" class="portfolio-content">
	                    <?php $wpex_count=0; ?>
                        <?php while ( $wpex_port_query->have_posts() ) : $wpex_port_query->the_post(); ?>
                           <?php $wpex_count++; ?>
                           
						<?php $terms = get_the_terms( get_the_ID(), 'familia' ); ?>
							
							<?php 
							//Mostramos sólo aquellos elementos que contienen imagen destacada

							if ( has_post_thumbnail(get_the_ID()) ) { ?>
						
							<article class="proyectos-grid portfolio-item item element<?php echo $count; ?> <?php if( $terms ){ foreach ( $terms as $term ) { echo $term->slug .' '; }}?>">
							<?php $_articulos_precio = get_post_meta( $post->ID, '_articulos_precio', true );
							$_articulos_estado = get_post_meta( $post->ID, 'my_key', true ); $todos=get_post_custom();?>
							<div class="imagen">								

			 	 			<?php the_post_thumbnail();?>

			 	 			</div>
																		
							<h4><?php the_title(); ?></h4>				

							<p>
								<?php
								/*$excerpt = get_the_excerpt();
								$excerpt = substr( $excerpt , 0, 100);
								echo $excerpt;*/
								//echo limite_extracto( get_the_excerpt(), '10' );
								echo the_content();								
								?>	
							</p>
							<div class="datos">
								<div class="precio">
									<?php echo '<strong>' .$_articulos_precio . '€</strong>';?>
								</div>																	
									<?php if($_articulos_estado == 'Disponible') {
										echo '<div class="disponible"><strong>' .$_articulos_estado.'</strong></div>';
									} elseif ($_articulos_estado == 'Prestado') {
										echo '<div class="prestado"><strong>' .$_articulos_estado.'</strong></div>';
									} elseif ($_articulos_estado == 'No-disponible') {
										echo '<div class="no_disponible"><strong>' .$_articulos_estado.'</strong></div>';
									}?>								
							</div>								
							
							</article>
							<?php } ?>
						<?php endwhile; ?>
					</div><!-- /portfolio-content -->
				</div><!-- /portfolio-wrap -->	
		<nav>	
			<ul class="pagination">	                
			<?php			                  
				$big = 999999999; // need an unlikely integer
				//echo'<svg width="24" height="24" fill="none"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12l4.58-4.59z" fill="#2D2D2D"></path></svg>';
				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wpex_port_query ->max_num_pages
				) );?>
			</ul>
		</nav>	
		<?php } ?>
		<?php $wpex_port_query = null;    
    wp_reset_postdata();wp_reset_query();?> 
</div>
<div class="espaciado_100"></div>
<?php get_footer(); ?>