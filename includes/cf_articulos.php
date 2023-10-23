<?php

/**
 * Creación de meta box para las películas
 */
add_action( 'add_meta_boxes', 'codigo_vivo_add_meta_box_articulos' );
function codigo_vivo_add_meta_box_articulos() {
    add_meta_box( 'meta-box-informacion-articulo', __( 'Información del articulo', 'codigo_vivo' ), 'codigo_vivo_meta_box_informacion_articulo_callback', 'articulos', 'side' );    
}
/**
 * Agregamos custom fields para introducir información artículo acerca de las películas
 */
function codigo_vivo_meta_box_informacion_articulo_callback() {

    global $post;

    $_articulos_precio = get_post_meta( $post->ID, '_articulos_precio', true );

    ?>
        <label for="_articulos_precio"><strong>Precio:</strong></label>
        <br>
        <input name="_articulos_precio" type="text" value="<?php echo $_articulos_precio; ?>">
        <br>
        <small>Especifica el precio del artículo</small> 
    <?php
}

/**
 * Guardamos la información especificada anteriormente en el metabox
 */
function codigo_vivo_save_post_articulos( $post_id, $post, $update ) {
 
    if ( isset( $_POST[ '_articulos_precio' ] ) ) {
        update_post_meta( $post_id, '_articulos_precio', $_POST[ '_articulos_precio' ] );
    }
 
}
add_action( 'save_post', 'codigo_vivo_save_post_articulos', 10, 3 );

/**
 * Adds a box to the main column on the Post add/edit screens.
 */
function wdm_add_meta_box() {

    add_meta_box(
            'wdm_sectionid', 'Radio Buttons Meta Box', 'wdm_meta_box_callback', 'articulos', 'side'
    ); //you can change the 4th paramter i.e. post to custom post type name, if you want it for something else

}

add_action( 'add_meta_boxes', 'wdm_add_meta_box' );

/**
* Prints the box content.
* 
* @param WP_Post $post The object for the current post/page.
*/
function wdm_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'wdm_meta_box', 'wdm_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $value = get_post_meta( $post->ID, 'my_key', true ); //my_key is a meta_key. Change it to whatever you want

    ?>
    <label for="wdm_new_field"><?php _e( "Elije el estado:", 'choose_value' ); ?></label>
    <br />  
    <input type="radio" name="estado" value="Disponible" <?php checked( $value, 'Disponible' ); ?> >Disponible<br>
    <input type="radio" name="estado" value="Prestado" <?php checked( $value, 'Prestado' ); ?> >Prestado<br>
    <input type="radio" name="estado" value="No-disponible" <?php checked( $value, 'No-disponible' ); ?> >No disponible<br> 

    <?php

}

/**
* When the post is saved, saves our custom data.
*
* @param int $post_id The ID of the post being saved.
*/
function wdm_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( !isset( $_POST['wdm_meta_box_nonce'] ) ) {
            return;
    }

    // Verify that the nonce is valid.
    if ( !wp_verify_nonce( $_POST['wdm_meta_box_nonce'], 'wdm_meta_box' ) ) {
            return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
    }

    // Check the user's permissions.
    if ( !current_user_can( 'edit_post', $post_id ) ) {
            return;
    }


    // Sanitize user input.
    $new_meta_value = ( isset( $_POST['estado'] ) ? sanitize_html_class( $_POST['estado'] ) : '' );

    // Update the meta field in the database.
    update_post_meta( $post_id, 'my_key', $new_meta_value );

}

add_action( 'save_post', 'wdm_save_meta_box_data' );