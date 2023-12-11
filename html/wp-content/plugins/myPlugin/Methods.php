<?php
function custom_table_activation()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'Letras'; // Nombre de la tabla con prefijo de WordPress

    $charset_collate = $wpdb->get_charset_collate();

    // Query para crear la tabla
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        letra char(1) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Se requiere el archivo upgrade.php para utilizar dbDelta()
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql); // Si la tabla ya está creada, no la vuelve a crear
}


add_action('plugins_loaded', 'custom_table_activation');

function insert_letters_into_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'Letras'; // Nombre de la tabla con prefijo de WordPress

    // Array con todas las letras del abecedario
    $letters = range('A', 'Z');

    // Preparar el array para realizar la inserción
    $insert_values = array();
    foreach ($letters as $letter) {
        $insert_values[] = array(
            'letra' => $letter
        );
    }

    // Insertar las letras en la tabla
    foreach ($insert_values as $insert_data) {
        $wpdb->insert($table_name, $insert_data);
    }
}

add_action('plugins_loaded', 'insert_letters_into_table');




