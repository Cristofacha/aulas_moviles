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
<body>

    <!-- Navbar  -->
    <nav class="navbar navbar-expand-lg" style="background-color: #d9dadb;">
        <a class="navbar-brand" href="#">Aulas moviles - Admin</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="form.php">Agregar marcadores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="marcadores.php">Lista de marcadores</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /Navbar  -->

	<br>
	<br>


    <div class="container">
        <h2 style="color: #0E68AF;">Formulario de Carga</h2>
        <form action="mod_carga.php" method="POST">

            <!-- Input de nombres del aula movil -->
            <div class="form-group">
                <label style="color: #0E68AF;" for="nombre">Nombre del Aula Movil:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <!-- /Input de nombres del aula movil -->

            <!-- Input de escuela traido de la BD -->
            <div class="form-group">
                <label style="color: #0E68AF;" for="escuela">Escuela:</label>
                <select class="form-control" id="escuela" name="escuela" required>
                    <?php

                    // Consulta SQL para obtener todas las escuelas
                    $query = "SELECT DISTINCT nombre FROM escuelas";
                    $resultado = $conexion->query($query);

                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<option value='" . $fila['nombre'] . "'>" . $fila['nombre'] . "</option>";
                    }

                    // Cerrar la conexión
                    $conexion->close();
                    ?>
                </select>
            </div>
            <!-- /Input de escuela traido de la BD -->

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Script de Select2 para busqueda en los selects -->
    <script>
        $(document).ready(function () {
            $("#escuela").select2(); // Aplicar Select2 al select
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>