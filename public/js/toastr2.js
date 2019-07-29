/*
Template Name: Material Pro admin
Author: Wrappixel
Email: niravjoshi87@gmail.com
File: js
*/

    "use strict";
      $(".tst1").click(function(){
           $.toast({
            heading: 'Welcome to Material Pro admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'info',
            hideAfter: 3000,
            stack: 6
          });

     });

      $(".tst2").click(function(){
           $.toast({
            heading: 'Welcome to Material Pro admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'warning',
            hideAfter: 3500,
            stack: 6
          });

     });
    function toastSuccess(mensaje){
           $.toast({
            heading: 'Carpintería Meraz',
            text: mensaje,
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'success',
            hideAfter: 3500,
            stack: 6
          });
    }

    function toastError(){
           $.toast({
            heading: 'Carpintería Meraz',
            text: 'Ha ocurrido un error en el servidor. Intentelo más tarde :(.',
            position: 'top-right',
            loaderBg:'#ff6849',
            icon: 'error',
            hideAfter: 3500
          });
     }
