<?php
include("connection.php");

// Consulta SQL para obtener las coordenadas y nombres
$query = "SELECT nombre_escuelas, direccion_escuelas, jurisdiccion_escuelas, nombre, oferta_escuelas FROM marcadores";
$resultado = $conexion->query($query);

?>