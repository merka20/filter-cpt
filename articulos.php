<?php
/*
Plugin Name: Artículos de la trastoteka
Description: Plugin para subir artículos a la trastoteka.
Plugin URI: https://merka20.com
Author: Oscar Domingo
Version: 1.0.0
Author URI: https://merka20.com
Requires at least: 5.0
Tested up to: 5.9.1
Requires PHP: 7.4
Text Domain: MK20-articulos
Domain Path: /languages
*/
if (!defined('ABSPATH')) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
} // Salir si acceden directamente


/**
* Inclusión del archivo functions.php
*/
include plugin_dir_path( __FILE__ ) . 'functions.php';

/**
* Inclusión de archivos relacionados con la estructura del Custom Post Type "Articulos"
*/
include plugin_dir_path( __FILE__ ) . 'includes/cpt_articulos.php';


// Function that is executed when the plugin is activated
function MK20_articulos_plugin_activar() {
    // Realizar tareas de activación aquí
}

// Function that is executed when the plugin is deactivated
function MK20_articulos_plugin_desactivar() {
    // Realizar tareas de desactivación aquí
}

// Add hooks for on and off functions
register_activation_hook(__FILE__, 'MK20_articulos_plugin_activar');
register_deactivation_hook(__FILE__, 'MK20_articulos_plugin_desactivar');


/**
* Inclusión de estilos personales para el Custom Post Type "Articulos"
*/
function MK20_estilos_articulos(){

	$url= plugins_url('css/estilos.css',__FILE__);
	 
 wp_register_style('estilo_pro', $url , array() ,'1.0');
	if ( is_post_type_archive('articulos')){
			wp_enqueue_style('estilo_pro'); 
		}    
}

add_action('wp_enqueue_scripts' , 'MK20_estilos_articulos');


add_filter( 'template_include', 'mk20_force_template' );
function mk20_force_template( $template ) {
    // If the current url is an archive of any kind
    if( is_post_type_archive('articulos') || is_tax('familia') ) {
        // Set this to the template file inside your plugin folder
        $template = WP_PLUGIN_DIR .'/'. plugin_basename( dirname(__FILE__) ) .'/plantillas/archive-articulos.php';        
    }
	elseif( is_single() && 'articulos' == get_post_type() ) {
        // Set this to the template file inside your plugin folder
        $template = WP_PLUGIN_DIR .'/'. plugin_basename( dirname(__FILE__) ) .'/plantillas/single-articulos.php';        
    }   

    // Always return, even if we didn't change anything

    return $template;
}