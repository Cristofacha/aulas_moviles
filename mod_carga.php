<?php
include("connection.php");

// Recuperar los valores del formulario
// Recuperar los valores del formulario
$nombre = $_POST['nombre'];
$escuela = $_POST['escuela'];

// Obtener la dirección y la jurisdicción de la escuela en función de la escuela seleccionada
$query = "SELECT Direccion, Jurisdiccion, Titulo, Localidad, clase FROM escuelas WHERE nombre = ?";
$statement = $conexion->prepare($query);
$statement->bind_param("s", $escuela);
$statement->execute();
$statement->bind_result($direccion, $jurisdiccion, $oferta, $localidad, $clase);
$statement->fetch();
$statement->close();

if (empty($localidad)) {
    $localidad = "0";
}
// Preparar la consulta SQL para insertar los datos en la tabla de marcadores
$query = "INSERT INTO marcadores (nombre, oferta_escuelas, nombre_escuelas, direccion_escuelas, jurisdiccion_escuelas, localidad_escuelas, tipo_escuelas) VALUES (?, ?, ?, ?, ?, ?, ?)";
$statement = $conexion->prepare($query);

// Vincular los parámetros y ejecutar la consulta
$statement->bind_param("sssssss", $nombre, $oferta, $escuela, $direccion, $jurisdiccion, $localidad, $clase);

if ($statement->execute()) {
    header("Location: form.php");
    exit;
} else {
    echo "Error al guardar los datos: " . $conexion->error;
}

// Cerrar la conexión
$statement->close();
$conexion->close();
?>