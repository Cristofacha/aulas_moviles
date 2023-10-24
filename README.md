# Sistema de Gestión de Marcadores

Este repositorio contiene un sistema que permite a los administradores crear y borrar marcadores en un mapa, y a los usuarios ver esos marcadores en el mapa y filtrarlos según varios parámetros.

## Contenido del Repositorio

- [Funcionalidades](#funcionalidades)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Uso para Administradores](#uso-para-administradores)
- [Uso para Usuarios](#uso-para-usuarios)
- [Extras](#Extras)
- [Creditos](#Creditos)
 
## Funcionalidades

El sistema ofrece las siguientes funcionalidades:

### Para Administradores

1. Crear nuevos marcadores en el mapa en base a las aulas moviles y su ubicacion.
2. Borrar y administrar marcadores existentes.

### Para Usuarios

1. Ver el mapa con todos los marcadores.
2. Filtrar los marcadores según los siguientes parámetros:
   - Tipo de escuela
   - Oferta educativa
   - Provincia
   - Localidad

## Requisitos

Asegúrate de tener instalado lo siguiente antes de utilizar el sistema:

- XAMPP (Para la instalacion de la BD)
- La BD que se encuentra en los archivos (aulas_moviles.sql)

## Instalación

- Clona este repositorio en tu carpeta local
- Importa la BD a tu sistema SQL
- En index, dentro del script la creacion de la keyVar se debe cambiar el espacio para la Key por tu Key de Api
- Listo!

## Uso para Administradores

### Pantalla de creacion de marcadores

Aqui los admins podran escribir el nombre del marcador en base al nombre del aula movil y luego seleccionar la escuela dirigida, una vez eso se clickea el boton y listo, marcador en el mapa.

### Pantalla de administracion de marcadores

Aqui hay una lista de todos los marcadores y se pueden eliminar de la BD

## Uso para Usuarios

1. Al usuario se le solicitara su ubiacion, si acepta el mapa le mostrara su zona, si no el mapa mostrara el centro de la argentina
2. El usuario podra navegar por el mapa viendo las aulas moviles del pais
3. Si quiere buscar aulas moviles segun algun parametro simplemente ajusta los filtros a su busqueda y clickea el boton de filtrar, y se mostraran los marcadores segun lo pedido

## Extras

### Algunos pendientes

1. Barra de busqueda para buscar marcadores por nombre
2. Sistema de edicion de marcadores
3. Agregado de marcadores para albergues
4. Mejorar la fiabilidad a dispositivos mobiles
5. Limitar la creacion de marcadores con nombres iguales

## Creditos

7mo C E.E.S.T N°1

Santiago Ramallo, Franco Rodriguez Gallipoli, Nahuel Agustin Gimenez, Lautaro Rizzo
