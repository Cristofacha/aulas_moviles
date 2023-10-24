<?php
include("connection.php");
include("mod_coord.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tu Sitio Web</title>
    <!-- Agrega enlaces a los archivos CSS de Bootstrap -->
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="module">
        // Initialize and add the map
            let map;
            var botonMiUbicacion = document.getElementById('miUbicacion');
            async function initMap() {
              // The location of Uluru
              
              let markers = [];
              // Request needed libraries.
              //@ts-ignore
              const { Map } = await google.maps.importLibrary("maps");
              const { AdvancedMarkerView } = await google.maps.importLibrary("marker");
              const image = "img/mapicon.png";
  
                    // El navegador no admite la geolocalización, maneja este caso
                    var latitudIni = -34.354;
                    var longitudIni = -64.714;
                    const position = { lat: latitudIni, lng: longitudIni };

                // The map, centered at Uluru
                map = new Map(document.getElementById("map"), {
                    zoom: 8,
                    center: position,
                    mapId: "DEMO_MAP_ID",
                });
  
              <?php while ($fila = $resultado->fetch_assoc()) { ?>
                // Declarar el nombre de la ubicación que deseas buscar
                var nombreUbicacion = '<?php echo $fila['nombre_escuelas']; ?>';
                var nombreUbicacion = '<?php echo $fila['direccion_escuelas']; ?>, <?php echo $fila['jurisdiccion_escuelas']; ?>';
                // Crear un objeto de geocodificación inversa
                var geocoder = new google.maps.Geocoder();
  
                // Realizar la solicitud de geocodificación inversa
                geocoder.geocode({ 'address': nombreUbicacion }, function (results, status) {
                    if (status === 'OK') {
                        // Obtener las coordenadas geográficas
                        var latitud = results[0].geometry.location.lat();
                        var longitud = results[0].geometry.location.lng();
  
                        const contentString =
                                          '<div id="content">' +
                                          '<div id="siteNotice">' +
                                          "</div>" +
                                          '<h2 id="firstHeading" class="firstHeading"><?php echo $fila['nombre']; ?></h2>' +
                                          '<div id="bodyContent">' +
                                          "<h4><?php echo $fila['nombre_escuelas']; ?></h4>" +
                                          "<h6><?php echo $fila['oferta_escuelas']; ?></h6>" +
                                          "</div>" +
                                          "</div>";
                        
                        const infowindow = new google.maps.InfoWindow({
                            content: contentString,
                            ariaLabel: "Uluru",
                        });
                                        
                        var marker = new google.maps.Marker({
                            position: {lat: latitud, lng: longitud},
                            map: map,
                            icon: image,
                            title: '<?php echo $fila['nombre']; ?>'
                        });
                                        
                        marker.addListener("click", () => {
                            infowindow.open({
                            anchor: marker,
                            map,
                            });
                        });

                        markers.push(marker);      

                    } else {
                      
                      geocoder.geocode({ 'address': nombreDireccion }, function (results, status) {
                    if (status === 'OK') {
                        // Obtener las coordenadas geográficas
                        var latitud = results[0].geometry.location.lat();
                        var longitud = results[0].geometry.location.lng();
  
                        const contentString =
                                          '<div id="content">' +
                                          '<div id="siteNotice">' +
                                          "</div>" +
                                          '<h2 id="firstHeading" class="firstHeading"><?php echo $fila['nombre']; ?></h2>' +
                                          '<div id="bodyContent">' +
                                          "<h4><?php echo $fila['nombre_escuelas']; ?></h4>" +
                                          "<h6><?php echo $fila['oferta_escuelas']; ?></h6>" +
                                          "</div>" +
                                          "</div>";
                        const infowindow = new google.maps.InfoWindow({
                            content: contentString,
                            ariaLabel: "Uluru",
                        });
                                        
                        var marker = new google.maps.Marker({
                            position: {lat: latitud, lng: longitud},
                            map: map,
                            icon: image,
                            title: '<?php echo $fila['nombre']; ?>'
                        });
                                        
                        marker.addListener("click", () => {
                            infowindow.open({
                                anchor: marker,
                                map,
                            });
                        });
                                        
                        markers.push(marker); 
                     } 
                     });
                    }
                });
                

              <?php } ?>
                function ocultarMarcadores(resultados){
                    console.log(resultados);
                }
                function mostrarMarcadores(resultados2){
                   // console.log(resultados2);
                }
                
                    $(document).ready(function() {
                    $("#filtrado").on("click", function() {
                        var select1Value = $("#select1").val();
                        var select2Value = $("#select2").val();
                        var select3Value = $("#select3").val();
                        var select4Value = $("#select4").val();

                        $.ajax({
                            type: "POST",
                            url: "mod_filtro.php", // Ajusta la URL a tu script PHP
                            data: {
                                select1: select1Value,
                                select2: select2Value,
                                select3: select3Value,
                                select4: select4Value
                            },
                            success: function (response) {
                                // Procesa el JSON de respuesta
                                var resultados = JSON.parse(response);
                                console.log(resultados);
                                for (var i = 0; i < markers.length; i++) {
                                    markers[i].setMap(null); // Muestra los marcadores nuevamente
                                }
                                // Llama a una función para ocultar los marcadores
                                for (var i = 0; i < markers.length; i++) {
                                    if (resultados.indexOf(markers[i].getTitle()) !== -1) {
                                        markers[i].setMap(map); // Oculta el marcador
                                    }
                                }
                            }
                        });
                    });
                    });

                    if ("geolocation" in navigator) {
        // Maneja la geolocalización
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var latitud = position.coords.latitude;
                            var longitud = position.coords.longitude;

                            // Centra el mapa en la ubicación del usuario
                            map.setCenter({ lat: latitud, lng: longitud });

                        }, function(error) {
                            console.error("Error de geolocalización: " + error.message);
                        });
                    } else {
                        console.error("El navegador no admite la geolocalización.");
                    }
                
            }
  
            initMap();
      </script>

</head>
<body style="background-color: #FFFFFF; color: #000000;">

    <!-- Navbar con título a la izquierda y 3 botones a la derecha -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #d9dadb;">
        <div class="navbar-brand" style="color: #0E68AF;">Aulas moviles</div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
       
    </nav>
	<br>
	<br>
    <!-- Barra de búsqueda y botón de filtros -->
    <div class="container mt-4" style="background-color: #0E68AF;">
        <div class="row mt-2" id="filtroOptions">
            <div class="col-lg-4">
                    <div class="form-group">
                        <label for="select1">Tipo:</label>
                        <select class="form-control" id="select1">
                            <option value="" selected>Seleccione...</option>
                        <?php

                            // Consulta SQL para obtener todas las escuelas
                            $queryTipo = "SELECT DISTINCT clase FROM escuelas";
                            $resultadoTipo = $conexion->query($queryTipo);

                            while ($filaTipo = $resultadoTipo->fetch_assoc()) {
                                echo "<option value='" . $filaTipo['clase'] . "'>" . $filaTipo['clase'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select2">Titulo:</label>
                        <select class="form-control" id="select2">
                            <option value="" selected>Seleccione...</option>
                        <?php

                                // Consulta SQL para obtener todas las escuelas
                                $queryTitulo = "SELECT DISTINCT titulo FROM escuelas";
                                $resultadoTitulo = $conexion->query($queryTitulo);

                                while ($filaTitulo = $resultadoTitulo->fetch_assoc()) {
                                    echo "<option value='" . $filaTitulo['titulo'] . "'>" . $filaTitulo['titulo'] . "</option>";
                                }

                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select3">Provincia:</label>
                        <select class="form-control" id="select3">
                            <option value="" selected>Seleccione...</option>
                        <?php

                                // Consulta SQL para obtener todas las escuelas
                                $queryProvincias = "SELECT DISTINCT jurisdiccion FROM escuelas";
                                $resultadoProvincias = $conexion->query($queryProvincias);

                                while ($filaProvincias = $resultadoProvincias->fetch_assoc()) {
                                    echo "<option value='" . $filaProvincias['jurisdiccion'] . "'>" . $filaProvincias['jurisdiccion'] . "</option>";
                                }

                        ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="select4">Localidad:</label>
                        <select class="form-control" id="select4">
                            <option value="" selected>Seleccione...</option>
                        <?php

                                // Consulta SQL para obtener todas las escuelas
                                $queryLocalidad = "SELECT DISTINCT localidad FROM escuelas";
                                $resultadoLocalidad = $conexion->query($queryLocalidad);

                                while ($filaLocalidad = $resultadoLocalidad->fetch_assoc()) {
                                    echo "<option value='" . $filaLocalidad['localidad'] . "'>" . $filaLocalidad['localidad'] . "</option>";
                                }

                        ?>
                        </select>
                    </div>

                    <button type="submit" id="filtrado">Filtrar</button>

            </div>
            <div class="col-lg-8">
                    <div id="map" style="height: 70vh;"></div>

                    <!-- prettier-ignore -->
                    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
                    ({key: "AIzaSyBi4SVxq6MCFInlZuEPi3pZFx3mI5akSE8", v: "beta"});</script>
            </div>
        </div>
    </div>
	<br>
	<br>
    <!-- Espacio para el mapa (ajusta el tamaño según tus necesidades) -->

    <!-- Agrega enlaces a los archivos JavaScript de Bootstrap y otros scripts necesarios -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#select1").select2(); // Aplicar Select2 al select
            $("#select2").select2(); // Aplicar Select2 al select
            $("#select3").select2(); // Aplicar Select2 al select
            $("#select4").select2(); // Aplicar Select2 al select
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!-- Agrega aquí tus scripts para trabajar con mapas u otras funcionalidades -->

</body>
</html>