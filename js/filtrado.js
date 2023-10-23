jQuery(document).ready(function($) {
    $('#filtrado a').click(function(e) {
        e.preventDefault();
        var term = $(this).data('filter');

        // Elimina la clase "active" de todos los elementos <a> dentro de #filters
        $("#filters a").removeClass("active");
        // Agrega la clase "active" al elemento <a> que se hizo clic
        $(this).addClass("active");        
        
        // Realiza una solicitud AJAX
        $.ajax({
            type: 'POST',
            url: ajax_params.ajax_url, // Utiliza la URL de administración de AJAX proporcionada desde PHP
            data: {
                action: 'filtrar_articulos', // Nombre de la acción de WordPress para manejar la solicitud
                term: term // Término de taxonomía a filtrar
            },
            success: function(response) {
                // La respuesta contiene el contenido de los artículos filtrados
                $('#articulos').html(response);
            },
            error: function(xhr, status, error) {
                // Maneja errores si los hay
                console.log(error);
            }
        });
    });
});
