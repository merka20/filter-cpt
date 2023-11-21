<?php

 // Verificar si este archivo se accede directamente y detener la ejecución si es el caso
if (!defined('ABSPATH')) {
    exit; // Evitar el acceso directo a este archivo
}

/**
* Inclusión de archivos relacionados con la estructura del Custom Post Type "Articulos"
*/
include plugin_dir_path( __FILE__ ) . 'cf_articulos.php';

// Registrar el tipo de contenido personalizado "Artículos"
function registrar_tipo_de_contenido_articulos() {
    $labels = array(
        'name'                  =>  __('Artículos'),
        'singular_name'         =>  __('Artículo'),
        'menu_name'             =>  __('Artículos'),
		'name_admin_bar'        => __( 'Artículos', 'artículos_catalogo' ),
		'archives'              => __( 'Archivos de artículos', 'productos_catalogo' ),
		'attributes'            => __( 'Atibutos de artículos', 'artículos_catalogo' ),
		'parent_item_colon'     => __( 'Parent Item:', 'artículos_catalogo' ),
		'all_items'             => __( 'Todos los artículos', 'artículos_catalogo' ),
		'add_new_item'          => __( 'Añadir nuevo artículo', 'artículos_catalogo' ),
		'add_new'               => __( 'Añadir nuevo', 'artículos_catalogo' ),
		'new_item'              => __( 'Nuevo artículo', 'artículos_catalogo' ),
		'edit_item'             => __( 'Editar artículo', 'artículos_catalogo' ),
		'update_item'           => __( 'Actualizar artículo', 'artículos_catalogo' ),
		'view_item'             => __( 'Ver artículo', 'artículos_catalogo' ),
		'view_items'            => __( 'Ver artículos', 'artículos_catalogo' ),
		'search_items'          => __( 'Buscar artículo', 'artículos_catalogo' ),
		'not_found'             => __( 'No se ha encontrado nada', 'artículos_catalogo' ),
		'not_found_in_trash'    => __( 'No se ha encontrado nada en la papelera', 'artículos_catalogo' ),
		'featured_image'        => __( 'Imagen destacada', 'artículos_catalogo' ),
		'set_featured_image'    => __( 'Conjunto de imágenes destacadas', 'artículos_catalogo' ),
		'remove_featured_image' => __( 'Eliminar imagen destacada', 'artículos_catalogo' ),
		'use_featured_image'    => __( 'Usar como imagen destacada', 'artículos_catalogo' ),
		'insert_into_item'      => __( 'Insertar en el artículo', 'artículos_catalogo' ),
		'uploaded_to_this_item' => __( 'artículo subido', 'artículos_catalogo' ),
		'items_list'            => __( 'Listar artículos', 'artículos_catalogo' ),
		'items_list_navigation' => __( 'Items list navigation', 'artículos_catalogo' ),
		'filter_items_list'     => __( 'Filtrar artículos en lista', 'artículos_catalogo' ),
    );

    $rewrite = array(
		'slug'                  => 'articulos',
		'with_front'            => true,
		'pages'                 => true,
		'feeds'                 => true,
	);

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => $rewrite,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-excerpt-view',
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'taxonomies'         => array( 'familia'),
        'show_in_rest'       => true, // Habilitar la API REST
        'template' => array(            
                
			array( 'core/spacer', array('height' => '50',) ),
			//array( 'core/heading', array('placeholder' => 'Título del artículo','fontSize'=>'large',) ),
			//array( 'core/spacer', array('height' => '10',) ),
            array( 'core/paragraph', array('placeholder' => 'Añade la descripción del artículo',
                'textColor'=>'blank',) ),
			/*array( 'core/heading', array('placeholder' => 'Subtítulo del artículo','fontSize'=>'medium',) ),
			array( 'core/spacer', array('height' => '10',) ),				
			array('core/group',array('backgroundColor'=>'azul-oscuro','className' => 'caja_artículo'),array(
					array( 'core/paragraph', array(
						'placeholder' => 'Añade la descripción del artículo',
						'textColor'=>'white',
					) ),
				) ),
			array( 'core/spacer', array('height' => '10',) ),
			array('core/gallery'),				
			array( 'core/spacer', array('height' => '10',) ),
			array('core/embed'), 
			array( 'core/spacer', array('height' => '10',) ),				
			array('core/group',array('backgroundColor'=>'azul-oscuro','className' => 'caja_artículo'),array(
					array( 'core/paragraph', array(
						'placeholder' => 'Añade el contenido del artículo',
						'label' => 'Párrafo del artículo',
						'textColor'=>'white',							
					) ),
			    ) ),
			array( 'core/spacer', array('height' => '50',) )*/
		),
		
		'template_lock' => 'all',/*insert*/	
	);


    register_post_type('articulos', $args);
}
add_action('init', 'registrar_tipo_de_contenido_articulos');

// Registrar la taxonomía "Familia" para el CPT "Artículos"
function registrar_taxonomia_familia() {
    $labels = array(
        'name'                       => 'Familias',
        'singular_name'              => 'Familia',
        'search_items'               => 'Buscar familias',
        'all_items'                  => 'Todas las familias',
        'edit_item'                  => 'Editar familia',
        'update_item'                => 'Actualizar familia',
        'add_new_item'               => 'Agregar nueva familia',
        'new_item_name'              => 'Nombre de la nueva familia',
        'menu_name'                  => 'Familia',
    );

    $args = array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'familia'),
        'show_in_rest'          => true, // Habilitar la API REST
    );

    register_taxonomy('familia', 'articulos', $args);
}
add_action('init', 'registrar_taxonomia_familia');


   