# API

> Obtener discografia a partir del nombre del artista

## Instalación

Clonar repositorio desde github e instalar dependencias ejecutando el comando:

```bash
composer install # composer
```

## Desarrollo

Copiar el contenido del archivo `.env.example` en un nuevo archivo llamado `.env`:

```bash
# linux / macos
cp .env.example .env

# windows
copy .env.example .env
```

Poner en marcha al servidor de desarrollo:

```bash
php -S localhost:8000 -t public # url:http://localhost:8000/
```


## Desarrollo

    Para la realizacion del proyecto se utilizo el api para develper de spotify
    La premisa del proyecto es obtener la lista de album de un artista, esta se realizo en 3 partes que seria :

    1. obtener el tocken de autentificación de spotify
    2. obtener el id del artista
    3. obtener la lista de albums en caso de que exista

## Aclaraciones

A la hora de consultar la api se debe ingresar el nombre del artista sin espacios en blanco, ademas solo se toma en cuenta el primer artista que encuente y apartir de ahi hace la busqueda de la Discografía. 

## Ejemplo de consulta 

```bash
# Metodo GET
http://localhost:8001/api/v1/albums/camilacabello