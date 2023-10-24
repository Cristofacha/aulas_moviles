<?php
// Conexión a la base de datos (reemplaza con tus credenciales)
$conexion = new mysqli("localhost", "root", "", "albergues");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>