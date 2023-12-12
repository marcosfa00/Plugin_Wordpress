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



