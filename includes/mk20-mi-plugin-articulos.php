<?php
function filtrar_articulos() {
    $term = $_POST['term'];

    $args = array(
        'post_type' => 'articulos',
        'posts_per_page' => -1,
    );

    if ($term !== 'Todos') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'familia',
                'field' => 'slug',
                'terms' => $term,
            ),
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :?>       
                <?php while ($query->have_posts()) : $query->the_post(); ?>

                    <?php $terms = get_the_terms(get_the_ID(), 'familia'); ?>

                    <?php
                    // Mostramos sólo aquellos elementos que contienen imagen destacada

                    if (has_post_thumbnail(get_the_ID())) {
                        $_articulos_precio = get_post_meta(get_the_ID(), '_articulos_precio', true);
                        $_articulos_estado = get_post_meta(get_the_ID(), 'my_key', true ); // Asegúrate de que el nombre de campo personalizado sea correcto
                        $todos = get_post_custom();                        
                        ?>
                        <article class="proyectos-grid portfolio-item item element<?php echo $count; ?> <?php if ($terms) {
                            foreach ($terms as $termi) {
                                echo $termi->slug . ' ';
                            }
                        } ?>">
                            <div class="imagen">

                                <?php the_post_thumbnail(); ?>

                            </div>

                            <h4><?php the_title(); ?></h4>

                            <p>
                                <?php
                                // Muestra el contenido del artículo
                                the_content();
                                ?>
                            </p>
                            <div class="datos">
                                <div class="precio">
                                    <?php echo '<strong>' . $_articulos_precio . '€</strong>'; ?>
                                </div>                                
                                <?php if ($_articulos_estado == 'Disponible') {
                                    echo '<div class="disponible"><strong>' . $_articulos_estado . '</strong></div>';
                                } elseif ($_articulos_estado == 'Prestado') {
                                    echo '<div class="prestado"><strong>' . $_articulos_estado . '</strong></div>';
                                } elseif ($_articulos_estado == 'No-disponible') {
                                    echo '<div class="no_disponible"><strong>' . $_articulos_estado . '</strong></div>';
                                } ?>
                            </div>

                        </article>
                    <?php } ?>
                <?php endwhile;
    else :
        echo 'No se encontraron artículos.';
    endif;

    die();
}

add_action('wp_ajax_filtrar_articulos', 'filtrar_articulos');
add_action('wp_ajax_nopriv_filtrar_articulos', 'filtrar_articulos');