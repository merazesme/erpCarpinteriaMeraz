  $(document).ready(function () {
  	tablaTrabajadores();
  });

  // TABLA TRABAJADORES
  function tablaTrabajadores(){
    $.ajax({
        type: 'GET',
        url: base_url+'/trabajadores/lista',
        success: function(msg){
          // var data = JSON.parse(msg);
          console.log(msg);
          var length = msg.length;
          // for(var x=0; x<length; x++) {
          //   if(msg[x].Estado != '0'){
          //     console.log("HOLA1:"+msg[x].Estado);
          //   }
          //   else {
          //     console.log("HOLA2:"+msg[x].Estado);
          //   }
          // }
        }, error: function(error) {
            console.log("ERRORRRRRRRRRRRRRRRRRRRRRRRR"+error);
            return;
        }
    });
  }
