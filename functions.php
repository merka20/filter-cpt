<?php

function redirect_taxonomy_to_articulos() {
    if (is_tax('familia')) { // Reemplaza 'familia' con el nombre de tu taxonomía
        $articulos_url = get_post_type_archive_link('articulos'); // Reemplaza 'articulos' con el nombre de tu CPT
        if ($articulos_url) {
            wp_redirect($articulos_url, 301);
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_taxonomy_to_articulos');


/**
 * ENCOLAR JS PARA EL EFECTO FILTRO
 */

function mk20_agregar_js_filtrado() {
    // Registra y encola el archivo JavaScript
    wp_register_script('mk20-mi-plugin-filtrado', plugin_dir_url(__FILE__) . 'js/filtrado.js', array('jquery'), '1.0', true);
    
    if ( is_post_type_archive('articulos') ){        
        wp_enqueue_script('mk20-mi-plugin-filtrado');
    }

    // Pasa datos necesarios desde PHP a JavaScript, como la URL de administración de AJAX
    wp_localize_script('mk20-mi-plugin-filtrado', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}

add_action('wp_enqueue_scripts', 'mk20_agregar_js_filtrado');

// Incluye el archivo ajax-functions.php
include(plugin_dir_path(__FILE__) . 'includes/mk20-mi-plugin-articulos.php');

/**
 * AÑADIR LAS COLMAS DE IMAGEN Y CATEGORIA EN EL LISTADO DE ADMINISTRACIÓN
 * 
 */
// Función para agregar las columnas personalizadas
function custom_post_type_columns($columns) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'Title',
        'featured_image' => 'Imagen',
        'taxonomy-familia' => 'Familia',
        'date' => 'Date'
    );
    return $new_columns;
}

// Mostrar el contenido de las columnas personalizadas
function custom_post_type_column_content($column, $post_id) {
    if ($column == 'featured_image') {
        echo get_the_post_thumbnail($post_id, array(50, 50));
    } elseif ($column == 'taxonomy-familia') {
        $familia_terms = get_the_terms($post_id, 'familia');
        if ($familia_terms && !is_wp_error($familia_terms)) {
            $familia_names = array();
            foreach ($familia_terms as $term) {
                $familia_names[] = $term->name;
            }
            echo implode(', ', $familia_names);
        }
    }
}

// Agregar las columnas a la pantalla de administración del CPT
function add_custom_columns_to_cpt($columns) {
    return custom_post_type_columns($columns);
}

function add_custom_column_content_to_cpt($column, $post_id) {
    custom_post_type_column_content($column, $post_id);
}

add_filter('manage_articulos_posts_columns', 'add_custom_columns_to_cpt');
add_action('manage_articulos_posts_custom_column', 'add_custom_column_content_to_cpt', 10, 2);

/**
 * Bloquear el número de caracteres pare el bloque parrafo del cpt "articulos"
 */
function limit_paragraph_characters_in_editor($block_content, $block) {
    // Verifica si estás editando un CPT llamado "articulos"
    if ($block['blockName'] === 'core/paragraph' && is_admin() && is_post_type_archive('articulos')) {
        $limit = 84; // Establece el límite de caracteres deseado
        $block_content = substr($block_content, 0, $limit); // Limita el contenido del bloque de párrafo
    }
    return $block_content;
}

add_filter('render_block', 'limit_paragraph_characters_in_editor', 10, 2);