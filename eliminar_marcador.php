<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    
    // Realiza una consulta SQL para eliminar el registro con el ID proporcionado
    $query = "DELETE FROM marcadores WHERE id = ?";
    
    $statement = $conexion->prepare($query);
    $statement->bind_param("i", $id); // "i" indica un entero
    
    if ($statement->execute()) {
        echo "Registro eliminado con éxito";
    } else {
        echo "Error al eliminar el registro: " . $conexion->error;
    }

    $statement->close();
} else {
    echo "Solicitud no válida.";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>