## README

### Marcosfa WordPress Plugin con DOCKER COMPOSE

Principalemnte hemos levantado el servicio de **Wordpress** con un archivo **docker-compose.yml** que contiene los siguientes servicios:

- **db**: Base de datos MariaDB
- **wordpress**: Servidor de Wordpress

### Archivo YML

Para levantar los servicios ejecutamos el siguiente comando:

```bash
docker-compose up -d
```

# PLUGIN
## ESTRUCTURA

Como buen programador hemos estructurado el código en una especia de Patrón **MV** (Modelo Vista) donde tenemos:
Una carpeta Contenedora llamada **myPluguin** que contiene dos archivos **php**:

- **main.php**: Archivo principal que contiene "la vista"
- **Metho.php**: Archivo que contiene los métodos que se usan en el archivo principal

Basicamente el criterio que he seguido ha sido separar en el archivo **METHODS.PHP** los métodos que hacen referencia a la base de datos,
es decir Crear la tabla e insertar los datos en la tabla.

Por otro lado en el archivo **main.php** es donde he creado los métodos que muestran un cambio en nuestra página
es decir, los **add_filter**

## FUNCIONAMIENTO

1. **Modificación de títulos de publicaciones:**
La función substitute_last_letter_in_title reemplaza la última letra de los títulos de las publicaciones por una letra almacenada en la base de datos. Utiliza consultas SQL para buscar la última letra del título y luego busca su correspondencia en la tabla Letras. Si encuentra una coincidencia, reemplaza la última letra del título por la letra de la base de datos.

2. **Modificación del contenido de las publicaciones:**
   La función replace_numbers_with_factorials busca números en el contenido de las publicaciones y los reemplaza por sus factoriales. Utiliza expresiones regulares para identificar los números y luego utiliza la función factorial para calcular los factoriales correspondientes.

## Methods.php

Funcion que crea la tabla en la base de datos, **si ya existe no la vuelve a crear.**

```php
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
```
La función de inset, inserta los datos, en este caso todas las letras del abecedario **MAYUSCULAS.**

```php

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
```

## Main.php

Aquí es donde realmente viene lo gordo del asunto, donde se hace la magia, en este archivo es donde se crean los **add_filter** que modifican el contenido de la página.

Cambio de ultima hora en este commit, he decidido crear una nueva función que subtituye la ultima letra del titulo por la letra correspondiente al id de la bae de datos, es decir, se genera un numero aleatorio entre 1 y 27 y cambia esta ultima letra del titulo por la generada, si sale el id 3 por ejemplo se subtituye por la letra C

```php
function substitute_last_letter_in_title($title) {
global $wpdb;

    $table_name = $wpdb->prefix . 'Letras'; // Nombre de la tabla con prefijo de WordPress

    // Obtener la última letra del título
    $last_letter = substr($title, -1);

    // Generar un número aleatorio entre 1 y 27 (inclusive)
    $random_number = mt_rand(1, 27);

    // Consulta para obtener la letra correspondiente del número aleatorio
    $query = $wpdb->prepare("SELECT letra FROM $table_name WHERE id = %d", $random_number);

    // Obtener la letra correspondiente de la base de datos
    $db_letter = $wpdb->get_var($query);

    // Reemplazar la última letra del título con la letra de la base de datos
    if ($db_letter !== null) {
        $new_title = substr_replace($title, $db_letter, -1);
        return $new_title;
    }

    return $title; // Devolver el título original si no se encuentra la letra en la base de datos
}
````
//add_action('the_title', 'substitute_last_letter_in_title');
add_filter('the_title', 'substitute_last_letter_in_title');



### The content
l segundo filtro es un poco más complejo, ya que tiene que buscar los números en el contenido de la página y sustituirlos por su factorial.

```php
function replace_numbers_with_factorials($content) {
    // Expresión regular para encontrar números en el texto
    $pattern = '/\b(\d+)\b/';

    // Reemplazar los números por sus factoriales utilizando preg_replace_callback
    $content_with_factorials = preg_replace_callback($pattern, 'replace_with_factorial', $content);

    return $content_with_factorials; // Devolver el contenido con los números reemplazados por sus factoriales
}
```
y ahora te preguntarás que interesante, y cómo calculamos el factorial, pues esto mismo se ve en uno de los cursos de **php** que he realizado, y es muy sencillo, se crea una función que calcula el factorial de un número.
Esta función debe ser recursiva, es decir, que se llama a sí misma, y se llama a sí misma hasta que el número sea 1.

```php
function factorial($numero){
    //hay una excepción y es que el factorial de 1 es 1
    if ($numero == 1 || $numero == 0) {
        return 1;
    } else {
        return $numero * factorial($numero-1);
    }
}
```

# Filter
Por supuesto, para que todas ests funciones se vena reflejadas en nuestra páguna, debemos hacer un **add_filter**, que es lo que realmente hace que se ejecute la función.

```php
add_filter('the_content', 'replace_numbers_with_factorials');
add_filter('the_title', 'substitute_last_letter_in_title');
```

# Database
También pasa lo mismo con **add_action** que es lo que hace que se ejecute la función, en este caso la función que crea la tabla y la función que inserta los datos en la tabla.

```php
add_action('plugins_loaded', 'insert_letters_into_table');
add_action('plugins_loaded', 'custom_table_activation');
``` 

# Signature

**Marcos Fernández Avendaño**




