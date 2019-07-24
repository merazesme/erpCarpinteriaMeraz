  $(document).ready(function () {
  	tablaTrabajadores();
  });

  // TABLA TRABAJADORES
  function tablaTrabajadores(){
    $.ajax({
        type: 'GET',
        dataType: "json",
    		enctype: "multipart/form-data",
        url: base_url+'/trabajadores/tabla',
        success: function(msg){
          var data = JSON.parse(msg);
          console.log("ESTO TIENE" + data);
          var tam = data.length;
          for (var i = 0; i < tam; i++) {
            console.log(data[i].Estado);
          //   if(data[i].Estado == 1){
          //     console.log("ACTIVO: " + data[i].Estado);
          //   }
          //   else {
          //     console.log("INACTIVO" + data[i]);
          //   }
          }
        }
    });
  }

  // // POST AGREGAR TRABAJADOR
  // jQuery('#agregarTrabajador').click(function(e){
  //   var datos = new FormData(document.querySelector('#formularioTrabajador'));
  //   $.ajax({
  //       type: 'POST',
  //       processData: false,
  //       contentType: false,
  //       cache: false,
  //       data: datos,
  //       dataType: false,
  //       enctype: 'multipart/form-data',
  //       url: base_url+'/trabajadores/agregar',
  //       success: function(msg){
  //           var data = JSON.parse(msg);
  //           console.log(data);
  //
  //       }, error: function(error) {
  //           swal(titulo, "Ha ocurrido un error, inténtelo más tarde.", "error");
  //       }
  //   });
  // }
