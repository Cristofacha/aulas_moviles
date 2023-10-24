<?php
include("connection.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aulas moviles</title>
    <link rel="icon" href="img/ico.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Navbar  -->
    <nav class="navbar navbar-expand-lg" style="background-color: #d9dadb;">
        <div style="width: 300px;"><img src="img/inetIcon.png" alt="INET" style="width: 100%;"></div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a style="color: #0E68AF;" class="nav-link" href="form.php">Agregar marcadores</a>
                </li>
                <li class="nav-item">
                    <a style="color: #0E68AF;" class="nav-link" href="marcadores.php">Lista de marcadores</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /Navbar  -->
	<br>
	<br>
    
    <div class="container mt-5">
        <h2 style="color: #0E68AF;">Tabla de Marcadores</h2>
        <!-- Tabla  -->
        <table class="table">
            <!-- Titulos de la tabla -->
            <thead style="color: #0E68AF;">
                <tr>
                    <th>Nombre</th>
                    <th>Escuela</th>
                    <th>Oferta</th>
                    <th>Provincia</th>
                    <th>Localidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <!-- /Titulos de la tabla -->
            <tbody style="color: #0E68AF;">
                <?php

                    // Realiza una consulta para obtener los datos de la base de datos
                    $query = "SELECT * FROM marcadores";
                    $resultado = $conexion->query($query);

                    if ($resultado->num_rows > 0) {
                        // Itera sobre los resultados creado una fila por cada uno
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
        <!-- /Tabla  -->
    </div>
    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Script que envia el id del campo a borrar de la tabla marcadores mediante Ajax -->
    <script>
        $(document).ready(function() {
            $(".eliminar").click(function() {
                var id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "mod_eliminar.php",
                    data: { id: id },
                    success: function(data) {
                        Swal.fire({
                        title: 'Borrado!',
                        text: 'Borrado con exito',
                        icon: 'success',
                        confirmButtonText: 'Continuar'
                    }).then((result) => {

                        if (result.isConfirmed) {
                            window.location.reload();
                        } 
                    })
                    }
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>