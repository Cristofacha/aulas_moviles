
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
          success: function (json_response) {
            // Procesa el JSON de respuesta
            var marcadores = JSON.parse(json_response);

            // Llama a una función para ocultar los marcadores
            ocultarMarcadores(marcadores);
          }
      });
  });
});