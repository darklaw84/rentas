$(document).ready(function () {


    $('#fechaIni').on('change', function () {
        var str = $("#fechaIni").val();

       

            var parts = str.split("-");

            var year = parts[0] && parseInt( parts[0], 10 );
            var month = parts[1] && parseInt( parts[1], 10 );
            var day = parts[2] && parseInt( parts[2], 10 );
            

            if( day <= 31 && day >= 1 && month <= 12 && month >= 1 ) {

                var expiryDate = new Date( year, month - 1, day );
                expiryDate.setFullYear( expiryDate.getFullYear() + 1 );

                var day = ( '0' + expiryDate.getDate() ).slice( -2 );
                var month = ( '0' + ( expiryDate.getMonth() + 1 ) ).slice( -2 );
                var year = expiryDate.getFullYear();

                $("#fechaFin").val( year + "-" + month + "-" + day );

            } else {
                $('#modalMensajeError').find('.modal-body').text('La fecha Inicial no es válida').end().modal('show');
            }
        




    });


    $('#tipoContrato').on('change', function () {
        var tipoContrato = $('#tipoContrato').val();
        if (tipoContrato == "") {
            $('#datosContrato').hide();
        } else {
            $('#datosContrato').show();
            $('#tituloDatosAval').hide();
            $('#datosAval').hide();
            $('#idPersonas').hide();
            $('#idUsoLocalidad').hide();






            $("#usolocalidad").removeAttr('required');
            $("#nombreaval").removeAttr('required');
            $("#domicilioaval").removeAttr('required');
            $("#domicilioInmuebleAval").removeAttr('required');
            $("#personas").removeAttr('required');


            if (tipoContrato == "1" || tipoContrato == "2") {
                $('#idUsoLocalidad').show();
                $("#usolocalidad").attr("required", true);
            }

            if (tipoContrato == "1" || tipoContrato == "3") {
                $('#tituloDatosAval').show();
                $('#datosAval').show();
                $("#nombreaval").attr("required", true);
                $("#domicilioaval").attr("required", true);
                $("#domicilioInmuebleAval").attr("required", true);

            }

            if (tipoContrato == "3" || tipoContrato == "4") {
                $('#idPersonas').show();
                $("#personas").attr("required", true);

            }

        }
    });



    $('#crearContratoN').click(function () {

        var usuarioInqui = $('#nombreInqui').val();
        var nombreInqui = $('#nombreInqui').val();
        var razonInqui = $('#razonInqui').val();
        var apellidosInqui = $('#apellidosInqui').val();
        var rfcInqui = $('#rfcInqui').val();
        var correoInqui = $('#correoInqui').val();

        var telefonoInqui = $('#telefonoInqui').val();

        var tipoPersona = $('#tipoPersonaIn').val();


        var factura = 0;

        if ($("#facturaIn").prop("checked") == true) {
            factura = 1;
        }
        var nombre = razonInqui;
        if (tipoPersona == 1) {
            nombre = nombreInqui;
        }




        if (usuarioInqui === "" || nombre === "" || correoInqui === "" ||
            rfcInqui === "" || telefonoInqui === "") {
            $('#modalMensajeError').find('.modal-body').text('Los campos son obligatorios').end().modal('show');
        } else {

            $.ajax({
                url: 'agregarInquilino.php',
                method: 'post',
                data: {
                    usuarioInqui: usuarioInqui,
                    nombreInqui: nombre,
                    correoInqui: correoInqui,
                    apellidosInqui: apellidosInqui,
                    requiereFactura: factura,
                    tipoPersona: tipoPersona,
                    rfcInqui: rfcInqui,
                    telefonoInqui: telefonoInqui
                },
                success: function (data) {
                    //aqui recibes el json y haces lo que quieras con el
                    var obj = jQuery.parseJSON(data);
                    if (obj.exito) {

                        $("#idInquilino").append(new Option(nombre.toUpperCase() + ' ' + apellidosInqui.toUpperCase(), obj.valor));
                        $("#idInquilino").val(obj.valor);
                        $('#modalAgregarInquilino').modal('toggle');
                    } else {
                        $('#modalMensajeError').find('.modal-body').text(obj.mensaje).end().modal('show');
                    }


                }
            });
        }

    });



});