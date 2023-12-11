<?php

/*
Plugin Name: Marcosfa Plugin
*/

// Acción al activar el plugin
register_activation_hook(__FILE__, 'custom_table_activation');
include_once 'Methods.php';


function substitute_last_letter_in_title($title) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'Letras'; // Nombre de la tabla con prefijo de WordPress

    // Obtener la última letra del título
    $last_letter = substr($title, -1);

    // Convertir la última letra del título a mayúscula
    $last_letter_uppercase = strtoupper($last_letter);

    // Consulta para obtener la letra correspondiente de la base de datos
    $query = $wpdb->prepare("SELECT letra FROM $table_name WHERE letra = %s", $last_letter_uppercase);

    // Obtener la letra correspondiente de la base de datos
    $db_letter = $wpdb->get_var($query);

    // Reemplazar la última letra del título con la letra de la base de datos
    if ($db_letter !== null) {
        $new_title = substr_replace($title, $db_letter, -1);
        return $new_title;
    }

    return $title; // Devolver el título original si no se encuentra la letra en la base de datos
}
//add_action('the_title', 'substitute_last_letter_in_title');
add_filter('the_title', 'substitute_last_letter_in_title');


function replace_numbers_with_factorials($content) {
    // Expresión regular para encontrar números en el texto
    $pattern = '/\b(\d+)\b/';

    // Reemplazar los números por sus factoriales utilizando preg_replace_callback
    $content_with_factorials = preg_replace_callback($pattern, 'replace_with_factorial', $content);

    return $content_with_factorials; // Devolver el contenido con los números reemplazados por sus factoriales
}

function replace_with_factorial($matches) {
    return factorial($matches[1]);
}

function factorial($numero){
    //hay una excepción y es que el factorial de 1 es 1
    if ($numero == 1 || $numero == 0) {
        return 1;
    } else {
        return $numero * factorial($numero-1);
    }
}

add_filter('the_content', 'replace_numbers_with_factorials');
