<?php
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $select1Value = $_POST["select1"];
    $select2Value = $_POST["select2"];
    $select3Value = $_POST["select3"];
    $select4Value = $_POST["select4"];

    // Inicializa la condición SQL
    $condicion = "";

    // Agrega cada condición si el valor no está vacío
    if (!empty($select1Value)) {
        $condicion .= "nombre IN (SELECT nombre FROM marcadores WHERE tipo_escuelas = '$select1Value') AND ";
    }

    if (!empty($select2Value)) {
        $condicion .= "nombre IN (SELECT nombre FROM marcadores WHERE oferta_escuelas = '$select2Value') AND ";
    }

    if (!empty($select3Value)) {
        $condicion .= "nombre IN (SELECT nombre FROM marcadores WHERE jurisdiccion_escuelas = '$select3Value') AND ";
    }

    if (!empty($select4Value)) {
        $condicion .= "nombre IN (SELECT nombre FROM marcadores WHERE localidad_escuelas = '$select4Value') AND ";
    }

    // Quita el "AND" extra al final de la condición
    $condicion = rtrim($condicion, "AND ");

    // Realiza la consulta SQL
    $queryFiltro = "SELECT nombre FROM marcadores";
    if (!empty($condicion)) {
        $queryFiltro .= " WHERE " . $condicion;
    }

    $resultado = $conexion->query($queryFiltro);
    

        if ($resultado) {
            $resultados = array();

            while ($fila = $resultado->fetch_assoc()) {
                $resultados[] = $fila['nombre'];
            }
            // $resultados contendrá los nombres de los marcadores que cumplen con las condiciones

            // Convierte los resultados en formato JSON
            $json_resultados = json_encode($resultados);

            // Devuelve los resultados como respuesta
            echo $json_resultados;
        } else {
            echo "Error en la consulta: " . $conexion->error;
        }
    
}
?>