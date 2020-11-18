$(document).ready(function () {

    //lenarDatosModal

  

    $('#btnQuitarModulo').click(function () {

        $('#opcion').val('quitarModulo');
        $('#formulario').submit();
       

    });


    $('#btnAsignarModulo').click(function () {

        $('#opcion').val('asignarModulo');
        $('#formulario').submit();
       

    });

    $('#btnQuitarAccion').click(function () {

        $('#opcion').val('quitarAccion');
        $('#formulario').submit();
       

    });

    $('#btnAsignarAccion').click(function () {

        $('#opcion').val('asignarAccion');
        $('#formulario').submit();
       

    });

    

});