<?php
include("connection.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tu Sitio Web</title>
    <!-- Agrega enlaces a los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="background-color: #343a40;">

    <!-- Navbar con título a la izquierda y 3 botones a la derecha -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Título a la izquierda</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Botón 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Botón 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Botón 3</a>
                </li>
            </ul>
        </div>
    </nav>
	<br>
	<br>
    <div class="container mt-5">
    <h2>Tabla de Marcadores</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Escuela</th>
                <th>Oferta</th>
                <th>Provincia</th>
                <th>Localidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php

            // Realiza una consulta para obtener los datos de la base de datos
            $query = "SELECT * FROM marcadores";
            $resultado = $conexion->query($query);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila["nombre"] . "</td>";
                    echo "<td>" . $fila["nombre_escuelas"] . "</td>";
                    echo "<td>" . $fila["oferta_escuelas"] . "</td>";
                    echo "<td>" . $fila["jurisdiccion_escuelas"] . "</td>";
                    echo "<td>" . $fila["localidad_escuelas"] . "</td>";
                    echo '<td><button class="btn btn-danger eliminar" data-id="' . $fila["id"] . '">Eliminar</button></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No se encontraron registros.</td></tr>";
            }

            // Cierra la conexión a la base de datos
            $conexion->close();
            ?>
        </tbody>
    </table>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $(".eliminar").click(function() {
            var id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "eliminar_marcador.php",
                data: { id: id },
                success: function(data) {
                    alert("Registro eliminado con éxito.");
                    // Actualiza la tabla o realiza otras acciones después de la eliminación
                }
            });
        });
    });
</script>
    <!-- Footer -->
    <footer class="bg-dark text-center text-white py-3">
        © 2023 Tu Sitio Web
    </footer>

    <!-- Agrega enlaces a los archivos JavaScript de Bootstrap y otros scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#escuela").select2(); // Aplicar Select2 al select
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Script para mostrar/ocultar opciones de filtros -->
    

    <!-- Agrega aquí tus scripts para trabajar con mapas u otras funcionalidades -->

</body>
</html>