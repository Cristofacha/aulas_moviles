<?php
include("connection.php");
include("mod_coord.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aulas moviles</title>
    <link rel="icon" href="img/ico.png">
	<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script> var keyVar = "[TU_KEY_API_AQUI]";</script>
    <script type="module">
        // Inicia el mapa 
            
            let map;
            async function initMap() {
              
            // Crea el array de marcadores   
              let markers = [];
            
            // Trae los datos de la libreria de Google Maps
              const { Map } = await google.maps.importLibrary("maps");
              const { AdvancedMarkerView } = await google.maps.importLibrary("marker");

            // Trae el icono custom de los marcadores
              const image = "img/mapicon.png";
  
            // Ubicacion inicial del mapa por defecto previa a la localizacion del usuario
              var latitudIni = -34.354;
              var longitudIni = -64.714;
              const position = { lat: latitudIni, lng: longitudIni };

                // The map, centered at Uluru
              map = new Map(document.getElementById("map"), {
                zoom: 8,
                center: position,
                //mapId: "DEMO_MAP_ID",
              });
              
              // Revisa si el usuario admitio compartir su ubicacion
                if ("geolocation" in navigator) {
                    // Maneja la geolocalización
                    navigator.geolocation.getCurrentPosition(function(position) {
                        var latitud = position.coords.latitude;
                        var longitud = position.coords.longitude;

                        // Centra el mapa en la ubicación del usuario
                        map.setCenter({ lat: latitud, lng: longitud });
                    });

                } 

              // While de PHP que trae todos los datos de los marcadores
              <?php while ($fila = $resultado->fetch_assoc()) { ?>

                // Declarar el nombre de la ubicación de los marcadores
                var nombreUbicacion = '<?php echo $fila['nombre_escuelas']; ?>';
                var nombreUbicacion = '<?php echo $fila['direccion_escuelas']; ?>, <?php echo $fila['jurisdiccion_escuelas']; ?>';

                // Crear un objeto de geocodificación inversa
                var geocoder = new google.maps.Geocoder();
  
                // Realizar la solicitud de geocodificación inversa en base al nombre de la escuela
                geocoder.geocode({ 'address': nombreUbicacion }, function (results, status) {
                    if (status === 'OK') {

                        // Obtener las coordenadas geográficas
                        var latitud = results[0].geometry.location.lat();
                        var longitud = results[0].geometry.location.lng();
  
                        // Datos que apareceran en la ventana de informacion del marcador
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
                        
                        // Creacion de la ventana de informacion del marcador
                        const infowindow = new google.maps.InfoWindow({
                            content: contentString,
                            ariaLabel: "Uluru",
                        });
                           
                        // Creacion del marcador en la pocision obtenida en base al nombre de la escuela, con el icono custom y el nombre del aula movil
                        var marker = new google.maps.Marker({
                            position: {lat: latitud, lng: longitud},
                            map: map,
                            icon: image,
                            title: '<?php echo $fila['nombre']; ?>'
                        });
                                      
                        // Evento que muestra la ventana de informacion al clickearlo
                        marker.addListener("click", () => {
                            infowindow.open({
                            anchor: marker,
                            map,
                            });
                        });

                        // Funcion que carga el marcador en el array de marcadores
                        markers.push(marker);      

                    } else { 

                    // Si no encuentra las coordenadas en base al nombre de la escuela, intenta buscarlas en base a la direccion de la misma
                    geocoder.geocode({ 'address': nombreDireccion }, function (results, status) {
                    if (status === 'OK') {
                        // Obtener las coordenadas geográficas
                        var latitud = results[0].geometry.location.lat();
                        var longitud = results[0].geometry.location.lng();
  
                        // Datos que apareceran en la ventana de informacion del marcador
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

                        // Creacion de la ventana de informacion del marcador
                        const infowindow = new google.maps.InfoWindow({
                            content: contentString,
                            ariaLabel: "Uluru",
                        });
                                 
                        // Creacion del marcador en la pocision obtenida en base a la direccion de la escuela, con el icono custom y el nombre del aula movil
                        var marker = new google.maps.Marker({
                            position: {lat: latitud, lng: longitud},
                            map: map,
                            icon: image,
                            title: '<?php echo $fila['nombre']; ?>'
                        });
                               
                        // Evento que muestra la ventana de informacion al clickearlo
                        marker.addListener("click", () => {
                            infowindow.open({
                                anchor: marker,
                                map,
                            });
                        });
                          
                        // Funcion que carga el marcador en el array de marcadores
                        markers.push(marker); 
                     } 
                     });
                    }
                });
                

              <?php } ?>

              // Ajax para el filtrado en tiempo real de los marcadores
                $(document).ready(function() {
                    $("#filtrado").on("click", function() {

                        // Creacion de variables en base a los parametros de filtrado enviados por el usuario
                        var select1Value = $("#select1").val();
                        var select2Value = $("#select2").val();
                        var select3Value = $("#select3").val();
                        var select4Value = $("#select4").val();

                        $.ajax({
                            type: "POST",
                            url: "mod_filtro.php",
                            data: {
                                select1: select1Value,
                                select2: select2Value,
                                select3: select3Value,
                                select4: select4Value
                            },
                            success: function (response) {
                                // Acciones que suceden cuando el Ajax retorna con exito

                                // Procesa el JSON de respuesta
                                var resultados = JSON.parse(response);

                                // Oculta todos los marcadores
                                for (var i = 0; i < markers.length; i++) {
                                    markers[i].setMap(null); 
                                }

                                // Muestra los marcadores que coinciden con los parametros de filtrado
                                for (var i = 0; i < markers.length; i++) {
                                    if (resultados.indexOf(markers[i].getTitle()) !== -1) {
                                        markers[i].setMap(map);
                                    }
                                }
                            }
                        });
                    });
                    });
                
            }
            // Inicia el mapa
            initMap();
      </script>

</head>
<body style="background-color: #FFFFFF; color: #000000;">

    <!-- Navbar  -->
    <nav class="navbar navbar-expand-lg" style="background-color: #d9dadb;">
        <div style="width: 300px;"><img src="img/inetIcon.png" alt="INET" style="width: 100%;"></div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <!-- //Navbar  -->

	<br>
	<br>

    
    <div class="container mt-4">
        <div class="row mt-2" id="filtroOptions">
            <!-- Filtros -->
            <div class="col-lg-4" style="background-color: #d9dadb; border-radius: 5px 5px 5px 5px;">
                <br>
                <h2 style="color: #0E68AF;">
                    Aulas moviles
                </h2>

                <br>
                <br>
                <h3 style="color: #0E68AF;">Filtros</h3>
                <div class="form-group">
                    
                    <label style="color: #0E68AF;" for="select1">Tipo:</label>
                        
                        <!-- Select que toma los datos de las clases de escuelas de la tabla de escuelas -->
                        <select class="form-control" id="select1">
                            <option value="" selected>Seleccione...</option>
                            <?php

                                // Consulta SQL para obtener las clases de escuelas
                                $queryTipo = "SELECT DISTINCT clase FROM escuelas";
                                $resultadoTipo = $conexion->query($queryTipo);

                                //While que inserta las opciones de las clases dentro del select
                                while ($filaTipo = $resultadoTipo->fetch_assoc()) {
                                    echo "<option value='" . $filaTipo['clase'] . "'>" . $filaTipo['clase'] . "</option>";
                                }
                            ?>
                        </select>
                </div>

                <div class="form-group">
                        
                    <label style="color: #0E68AF;" for="select2">Titulo:</label>

                        <!-- Select que toma los datos de los titulos que ofrecen las escuelas de la tabla de escuelas -->
                        <select class="form-control" id="select2">
                            <option value="" selected>Seleccione...</option>
                            <?php

                                // Consulta SQL para obtener los titulos que ofrecen las escuelas
                                $queryTitulo = "SELECT DISTINCT titulo FROM escuelas";
                                $resultadoTitulo = $conexion->query($queryTitulo);

                                //While que inserta las opciones de los titulos dentro del select
                                while ($filaTitulo = $resultadoTitulo->fetch_assoc()) {
                                    echo "<option value='" . $filaTitulo['titulo'] . "'>" . $filaTitulo['titulo'] . "</option>";
                                }

                            ?>
                        </select>
                </div>

                <div class="form-group">
                        
                    <label style="color: #0E68AF;" for="select3">Provincia:</label>

                        <!-- Select que toma los datos de las jurisdicciones de las escuelas de la tabla de escuelas -->
                        <select class="form-control" id="select3">
                            <option value="" selected>Seleccione...</option>
                            <?php

                                // Consulta SQL para obtener las jurisdicciones de las escuelas
                                $queryProvincias = "SELECT DISTINCT jurisdiccion FROM escuelas";
                                $resultadoProvincias = $conexion->query($queryProvincias);

                                //While que inserta las opciones de las jurisdicciones dentro del select
                                while ($filaProvincias = $resultadoProvincias->fetch_assoc()) {
                                    echo "<option value='" . $filaProvincias['jurisdiccion'] . "'>" . $filaProvincias['jurisdiccion'] . "</option>";
                                }

                            ?>
                        </select>
                </div>
                    
                <div class="form-group">
                    
                    <label style="color: #0E68AF;" for="select4">Localidad:</label>

                        <!-- Select que toma los datos de las localidades de las escuelas de la tabla de escuelas -->
                        <select class="form-control" id="select4">
                            <option value="" selected>Seleccione...</option>
                            <?php

                                // Consulta SQL para obtener las localidades de las escuelas
                                $queryLocalidad = "SELECT DISTINCT localidad FROM escuelas";
                                $resultadoLocalidad = $conexion->query($queryLocalidad);

                                //While que inserta las opciones de las localidades dentro del select
                                while ($filaLocalidad = $resultadoLocalidad->fetch_assoc()) {
                                    echo "<option value='" . $filaLocalidad['localidad'] . "'>" . $filaLocalidad['localidad'] . "</option>";
                                }

                            ?>
                        </select>
                </div>
                <br>

                <button type="submit" class="btn btn-primary btn-lg btn-block" id="filtrado">Filtrar</button>

            </div>
        <!-- /Filtros -->

            <div class="col-lg-8">
                    
                <!-- Div donde se inserta el mapa -->
                <div id="map" style="height: 70vh;"></div>

                <!-- Script que habilita la api de google maps -->
                <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
                    ({key: keyVar, v: "beta"});
                </script>

            </div>

        </div>
    </div>
	<br>
	<br>

    <!-- Scripts y Links -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Script de Select2 para busqueda en los selects -->
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
    <!-- /Scripts y Links-->

</body>
</html>