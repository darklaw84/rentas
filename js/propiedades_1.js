$(document).ready(function () {

    //lenarDatosModal

    $(document).on('click', 'a[data-role=updateMisPropiedades]', function () {
        var id = $(this).data('id');

        var nombre = $('#' + id).children('td[data-target=nombre]').text();
        var direccion = $('#' + id).children('td[data-target=direccion]').text();
        var descripcion = $('#' + id).children('td[data-target=descripcion]').text();
        var renta = $('#' + id).children('td[data-target=renta]').text();


        var numescritura = $('#' + id).children().find('.numescritura').val();
        var predial = $('#' + id).children().find('.predial').val();
        var fechaEscritura = $('#' + id).children().find('.fechaEscritura').val();
        var licEscritura = $('#' + id).children().find('.licEscritura').val();
        var numNotaria = $('#' + id).children().find('.numNotaria').val();
        var folioMercantil = $('#' + id).children().find('.folioMercantil').val();
        var superficie = $('#' + id).children().find('.superficie').val();
        var comprende = $('#' + id).children().find('.comprende').val();




        $('#nombrePro').val(nombre);
        $('#descripcionPro').val(descripcion);
        $('#direccionPro').val(direccion);
        $('#rentaPro').val(renta);
        $('#predialPro').val(predial);
        
        $('#superficiePro').val(superficie);
        $('#construccionPro').val(comprende);
        $('#numescrituraPro').val(numescritura);
        $('#fechaescrituraPro').val(fechaEscritura);
        $('#numNotariaPro').val(numNotaria);
        $('#foliomercantilPro').val(folioMercantil);
        $('#licenciadoPro').val(licEscritura);
        var amueblada = $('#' + id).children().find('.amueblada').val();
        if (amueblada === "1") {
            $("#amuebladaPro").prop('checked', true);
        }
        else {
            $("#amuebladaPro").prop('checked', false);
        }


        $('#idProp').val(id);

        $('#modalPropiedadesUpdate').modal('toggle');
    });

    $('#btnAgregarInquilino').click(function () {

        $('#usuarioInqui').val('');
        $('#nombreInqui').val('');
        $('#apellidosInqui').val('');
        $('#rfcInqui').val('');
        $('#correoInqui').val('');

        $('#telefonoInqui').val('');

        $('#modalAgregarInquilino').modal('toggle');
    });


    $('#btnAgregarArrendatario').click(function () {

        $('#usuarioArre').val('');
        $('#nombreArre').val('');
        $('#apellidosArre').val('');
        $('#rfcArre').val('');
        $('#correoArre').val('');

        $('#telefonoArre').val('');

        $('#banco').val('');
        $('#cuenta').val('');
        $('#clabe').val('');

        $('#modalAgregarArrendatario').modal('toggle');
    });

    



    $('#tipoPersonaIn').on('change', function () {
        var tipoPersona = $('#tipoPersonaIn').val();
        if (tipoPersona == 1) {
            $('#divFisicaIn').show();
            $('#divMoralIn').hide();

        }
        else {
            $('#divFisicaIn').hide();
            $('#divMoralIn').show();

        }
    });



    $('#guardarInquilino').click(function () {

        var usuarioInqui = 'generico';
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




        if (usuarioInqui === "" || nombre === "" || correoInqui === ""
            || rfcInqui === "" || telefonoInqui === "") {
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
                    }
                    else {
                        $('#modalMensajeError').find('.modal-body').text(obj.mensaje).end().modal('show');
                    }


                }
            });
        }

    });


    $('#guardarArrendatario').click(function () {

        var usuarioInqui = $('#usuarioArre').val();
        var nombreInqui = $('#nombreArre').val();
        
        var apellidosInqui = $('#apellidosArre').val();
        var rfcInqui = $('#rfcArre').val();
        var correoInqui = $('#correoArre').val();

        var telefonoInqui = $('#telefonoArre').val();

        var banco = $('#banco').val();
        var cuenta = $('#cuenta').val();
        var clabe = $('#clabe').val();

       




        if (usuarioInqui === "" || nombreInqui === "" || correoInqui === ""
            || rfcInqui === "" || telefonoInqui === "") {
            $('#modalMensajeError').find('.modal-body').text('Los campos son obligatorios').end().modal('show');
        } else {

            $.ajax({
                url: 'agregarArrendatario.php',
                method: 'post',
                data: {
                    usuarioInqui: usuarioInqui,
                    nombreInqui: nombreInqui,
                    correoInqui: correoInqui,
                    apellidosInqui: apellidosInqui,
                    rfcInqui: rfcInqui,
                    banco: banco,
                    cuenta: cuenta,
                    clabe: clabe,
                    telefonoInqui: telefonoInqui
                },
                success: function (data) {
                    //aqui recibes el json y haces lo que quieras con el
                    var obj = jQuery.parseJSON(data);
                    if (obj.exito) {

                        $("#idArrendatario").append(new Option(nombreInqui.toUpperCase() + ' ' + apellidosInqui.toUpperCase(), obj.valor));
                        $("#idArrendatario").val(obj.valor);
                        $('#modalAgregarArrendatario').modal('toggle');
                    }
                    else {
                        $('#modalMensajeError').find('.modal-body').text(obj.mensaje).end().modal('show');
                    }


                }
            });
        }

    });

    $('#btnPruebaCorreo').click(function () {
        $.ajax({
            url: 'mandarCorreosVence.php',
            method: 'post',
            data: {
                hola: 'hola'
            },
            success: function (data) {


            }
        });


    });

    $('#guardarPropiedad').click(function () {

        var idProp = $('#idProp').val();
        var nombrePro = $('#nombrePro').val();
        var descripcionPro = $('#descripcionPro').val();
        var direccionPro = $('#direccionPro').val();
        var rentaPro = $('#rentaPro').val();

        var superficie = $('#superficiePro').val();
        var comprende = $('#construccionPro').val();
        var predial = $('#predialPro').val();
        var numescritura = $('#numescrituraPro').val();
        var fechaEscritura = $('#fechaescrituraPro').val();
        var numNotaria = $('#numNotariaPro').val();
        var folioMercantil = $('#foliomercantilPro').val();
        var licEscritura = $('#licenciadoPro').val();

        var amueblada = 0;

        if ($("#amuebladaPro").prop("checked") == true) {
            amueblada = 1;
        }


        if (nombrePro === "" || descripcionPro === "" || direccionPro === "" || rentaPro === ""
             || numescritura === "" || fechaEscritura === ""
            || numNotaria === "" || folioMercantil === "" || licEscritura === "") {
            $('#modalMensajeError').find('.modal-body').text('Los campos son obligatorios').end().modal('show');
        } else {

            $.ajax({
                url: 'mispropiedadescrud.php',
                method: 'post',
                data: {
                    idProp: idProp,
                    nombre: nombrePro,
                    descripcion: descripcionPro,
                    direccion: direccionPro,
                    predial: predial,

                    superficie: superficie,
                    comprende: comprende,
                    numescritura: numescritura,
                    fechaEscritura: fechaEscritura,
                    numNotaria: numNotaria,
                    folioMercantil: folioMercantil,
                    licEscritura: licEscritura,
                    amueblada: amueblada,

                    renta: rentaPro
                },
                success: function (data) {
                    //aqui recibes el json y haces lo que quieras con el
                    $('#' + idProp).children('td[data-target=nombre]').text(nombrePro);
                    $('#' + idProp).children('td[data-target=descripcion]').text(descripcionPro);
                    $('#' + idProp).children('td[data-target=direccion]').text(direccionPro);
                    $('#' + idProp).children('td[data-target=renta]').text(rentaPro);

                    $('#' + idProp).children().find('.numescritura').val(numescritura);
                    $('#' + idProp).children().find('.fechaEscritura').val(fechaEscritura);
                    $('#' + idProp).children().find('.licEscritura').val(licEscritura);
                    $('#' + idProp).children().find('.numNotaria').val(numNotaria);
                    $('#' + idProp).children().find('.folioMercantil').val(folioMercantil);
                    $('#' + idProp).children().find('.superficie').val(superficie);
                    $('#' + idProp).children().find('.comprende').val(comprende);
                    $('#' + idProp).children().find('.predial').val(predial);
                    $('#' + idProp).children().find('.amueblada').val(amueblada);


                    $('#modalPropiedadesUpdate').modal('toggle');
                }
            });
        }

    });



    $(document).on('click', 'a[data-role=pagoRenta]', function () {
        var id = $(this).data('id');



        $('#idRentaContrato').val(id);

        var fecha = $('#' + id).children('td[data-target=fecha]').text();
        var tipo = $('#' + id).children('td[data-target=tipo]').text();
        var monto = $('#' + id).children('td[data-target=monto]').text();
        var tipoS = "Renta";
        if (tipo == 'M') {
            tipoS = "Mtto";
        }
        $('#lblPreguntaRecibir').text('¿Esta seguro de que desea recibir el monto de  $ ' +
            monto + ' por concepto de ' + tipoS + ' de la fecha ' + fecha + ' ?');


        $('#modalPagoRenta').modal('toggle');
    });


    $(document).on('click', 'a[data-role=eliminarPago]', function () {
        var id = $(this).data('id');
        $('#idPagoContrato').val(id);
        $('#modalEliminarPago').modal('toggle');
    });

    $('#eliminarPagoContrato').click(function () {

        var idPago = $('#idPagoContrato').val();

        var idPropiedad = $('#idPropiedad').val();
        var idContrato = $('#idContrato').children("option:selected").val();

        $.ajax({
            url: 'eliminarPago.php',
            method: 'post',
            data: {
                idPago: idPago
            },
            success: function (data) {
                //aqui recibes el json y haces lo que quieras con el

                $('#modalEliminarPago').modal('toggle');

                window.location = 'index.php?p=consultaPropiedad&idPropiedad=' + idPropiedad + '&idContrato=' + idContrato + '&pes=pagos'
            }
        });

    });


    $('#eliminarPagoContratoPagos').click(function () {

        var idPago = $('#idPagoContratoPagos').val();



        $.ajax({
            url: 'eliminarPago.php',
            method: 'post',
            data: {
                idPago: idPago
            },
            success: function (data) {
                //aqui recibes el json y haces lo que quieras con el

                $('#modalEliminarPagoPagos').modal('toggle');

                window.location = 'index.php?p=pagos'
            }
        });

    });


    $(document).on('click', 'a[data-role=eliminarPagoPagos]', function () {
        var id = $(this).data('id');
        $('#idPagoContratoPagos').val(id);
        $('#modalEliminarPagoPagos').modal('toggle');
    });


    $('#recibirRentaContrato').click(function () {

        var idRentaContrato = $('#idRentaContrato').val();
        var idPropiedad = $('#idPropiedad').val();
        var usuario = $('#usuarioSesion').val();
        var metodoPago = $('#metodoPago').val();


        var idContrato = $('#idContrato').children("option:selected").val();


        $.ajax({
            url: 'recibirRentaContrato.php',
            method: 'post',
            data: {
                idRentaContrato: idRentaContrato,
                metodoPago: metodoPago,
                usuario: usuario
            },
            success: function (data) {
                //aqui recibes el json y haces lo que quieras con el

                $('#modalPagoRenta').modal('toggle');

                window.location = 'index.php?p=consultaPropiedad&idPropiedad=' + idPropiedad + '&idContrato=' + idContrato;
            }
        });


    });



    $(document).on('click', 'a[data-role=pagoRentaRentas]', function () {
        var id = $(this).data('id');



        $('#idRentaContratoRentas').val(id);

        var fecha = $('#' + id).children('td[data-target=fecha]').text();
        var tipo = $('#' + id).children('td[data-target=tipo]').text();
        var monto = $('#' + id).children('td[data-target=monto]').text();
        var tipoS = "Renta";
        if (tipo == 'M') {
            tipoS = "Mtto";
        }
        $('#lblPreguntaRecibirRentas').text('¿Esta seguro de que desea recibir el monto de  $ ' +
            monto + ' por concepto de ' + tipoS + ' de la fecha ' + fecha + ' ?');


        $('#modalPagoRentaRentas').modal('toggle');
    });



    $('#recibirRentaContratoRentas').click(function () {

        var idRentaContrato = $('#idRentaContratoRentas').val();

        var usuario = $('#usuarioSesion').val();
        var metodoPago = $('#metodoPagoRentas').val();




        $.ajax({
            url: 'recibirRentaContrato.php',
            method: 'post',
            data: {
                idRentaContrato: idRentaContrato,
                metodoPago: metodoPago,
                usuario: usuario
            },
            success: function (data) {
                //aqui recibes el json y haces lo que quieras con el

                $('#modalPagoRenta').modal('toggle');

                window.location = 'index.php?p=misrentas';
            }
        });


    });




    $('#btnRentas').click(function () {

        $('#divPagosContrato').hide();
        $('#divRentasContrato').show();

        $('#btnRentas').removeClass('btn-dark');
        $('#btnRentas').addClass('btn-primary');
        $('#btnPagos').removeClass('btn-primary');
        $('#btnPagos').addClass('btn-dark');


    });

    $('#btnPagos').click(function () {

        $('#divPagosContrato').show();
        $('#divRentasContrato').hide();


        $('#btnRentas').removeClass('btn-primary');
        $('#btnRentas').addClass('btn-dark');
        $('#btnPagos').removeClass('btn-dark');
        $('#btnPagos').addClass('btn-primary');

    });

    $('#btnAgregarPago').click(function () {

        $('#modalAgregarPagoPropiedad').modal('toggle');



    });


    $('#btnAgregarPagoPagos').click(function () {

        $('#modalAgregarPagoPropiedadPagos').modal('toggle');



    });


    $('#guardarPago').click(function () {

        var idPropiedad = $('#idPropiedad').val();
        var usuario = $('#usuarioSesion').val();
        var monto = $('#montoPago').val();
        var descripcion = $('#descripcionPago').val();

        var idContrato = $('#idContrato').children("option:selected").val();


        var acepto = $('#tipoPago').prop("checked");
        var tipo = 'E';
        if (acepto == true) {
            tipo = 'I'
        }


        if (descripcion === "" || monto === "") {
            $('#modalMensajeError').find('.modal-body').text('EL monto y la descripción son obligatorios').end().modal('show');
        }
        else {


            $.ajax({
                url: 'agregarPagoPropiedad.php',
                method: 'post',
                data: {
                    idPropiedad: idPropiedad,
                    idContrato: idContrato,
                    monto: monto,
                    descripcion: descripcion,
                    tipo: tipo,
                    usuario: usuario
                },
                success: function (data) {
                    //aqui recibes el json y haces lo que quieras con el

                    $('#modalAgregarPagoPropiedad').modal('toggle');

                    window.location = 'index.php?p=consultaPropiedad&idPropiedad=' + idPropiedad + '&idContrato=' + idContrato + '&pes=pagos'

                }
            });
        }

    });

    $('#btnVer').click(function () {

        var text = $('#tiny').val();

        alert (text);
    });


    $('#guardarPagoPagos').click(function () {

        var idPropiedad = $('#idPropiedadPagos').val();
        var usuario = $('#usuarioSesion').val();
        var monto = $('#montoPagoPagos').val();
        var descripcion = $('#descripcionPagoPagos').val();




        var acepto = $('#tipoPagoPagos').prop("checked");
        var tipo = 'E';
        if (acepto == true) {
            tipo = 'I'
        }


        if (descripcion === "" || monto === "") {
            $('#modalMensajeError').find('.modal-body').text('EL monto y la descripción son obligatorios').end().modal('show');
        }
        else {


            $.ajax({
                url: 'agregarPagoPropiedad.php',
                method: 'post',
                data: {
                    idPropiedad: idPropiedad,
                    monto: monto,
                    descripcion: descripcion,
                    tipo: tipo,
                    usuario: usuario
                },
                success: function (data) {
                    //aqui recibes el json y haces lo que quieras con el

                    $('#modalAgregarPagoPropiedadPagos').modal('toggle');

                    window.location = 'index.php?p=pagos'

                }
            });
        }

    });


    $(document).on('click', 'a[data-role=mostrarFoto]', function () {
        var id = $(this).data('id');

        $('#imagenArchivo').attr("src", "fotos/" + id);

        $('#modalFoto').modal('toggle');
    });


    $(document).on('click', 'a[data-role=subirContrato]', function () {
        var id = $(this).data('id');

        $('#idContratoSubir').val(id);

        $("#C3").popover('hide');
        //$("#popover-custom-content").popover('hide');

        $('#modalSubirContrato').modal('toggle');
    });





    $('#misrentas').DataTable({
        "order": [[2, "asc"]], "lengthMenu": [
            [100, 200, -1],
            [100, 200, "Todos"]
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(4, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(4).footer()).html(
                '$' + pageTotal + ' ( $' + total + ' total)'
            );
        }
    });



    $('#tablapagos').DataTable({
        "order": [[0, "desc"]], "lengthMenu": [
            [-1, 100, 200],
            ["Todos", 100, 200]
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(5, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer
            $(api.column(5).footer()).html(
                '$' + pageTotal + ' ( $' + total + ' total)'
            );
        }
    });


    $(document).on('click', 'a[data-role=xpagoRenta]', function () {
        var id = $(this).data('id');



        $('#idRentaContrato').val(id);

        var fecha = $('#' + id).children('td[data-target=fecha]').text();
        var tipo = $('#' + id).children('td[data-target=tipo]').text();
        var monto = $('#' + id).children('td[data-target=monto]').text();
        var tipoS = "Renta";
        if (tipo == 'M') {
            tipoS = "Mtto";
        }
        $('#lblPreguntaCancelar').text('¿Esta seguro de que desea cancelar el pago de  $ ' +
            monto + ' por concepto de ' + tipoS + ' de la fecha ' + fecha + ' ?');


        $('#modalXPagoRenta').modal('toggle');
    });



    $('#cancelarRentaContrato').click(function () {

        var idRentaContrato = $('#idRentaContrato').val();
        var idPropiedad = $('#idPropiedad').val();
        var usuario = $('#usuarioSesion').val();



        var idContrato = $('#idContrato').children("option:selected").val();


        $.ajax({
            url: 'cancelarRentaContrato.php',
            method: 'post',
            data: {
                idRentaContrato: idRentaContrato,
                usuario: usuario
            },
            success: function (data) {
                //aqui recibes el json y haces lo que quieras con el

                $('#modalXPagoRenta').modal('toggle');

                window.location = 'index.php?p=consultaPropiedad&idPropiedad=' + idPropiedad + '&idContrato=' + idContrato;
            }
        });


    });

    $('#btnMostrarFotos').click(function () {
        var id = $('#idPropiedad').val();

        $.ajax({
            url: 'obtenerFotosPropiedad.php',
            method: 'post',
            data: {
                idPropiedad: id
            },
            success: function (data) {
                //aqui recibes el json y haces lo que quieras con el

                var datos = jQuery.parseJSON(data);
                var registros = datos.registros;
                $('#divFotosPropiedad').empty();
                $.each(registros, function (i, foto) {
                    $('#divFotosPropiedad').append('<div class="col-md-4"><a href="./fotos/' + foto.foto + '" download="' + foto.foto + '"><img id="foto' + foto.idFoto + '" class="img-fluid" src="./fotos/' + foto.foto + '" /></a></div>')
                });




                $('#modalFotosPropiedad').modal('toggle');


            }
        });


    });



    $('#btnModificarContrato').click(function () {
        var id = $('#idContrato').val();


        $('#idContratoAct').val(id);

        $.ajax({
            url: 'obtenerContrato.php',
            method: 'post',
            data: {
                idContrato: id
            },
            success: function (data) {
                //aqui recibes el json y haces lo que quieras con el

                var datos = jQuery.parseJSON(data);

                $('#nombreavalAct').val(datos.aval);
                $('#rfcavalAct').val(datos.rfcaval);
                $('#domicilioavalAct').val(datos.domicilioAval);
                $('#domicilioInmuebleAct').val(datos.domicilioInmueble);
                $('#numescrituraAct').val(datos.numEscrituraArrendatario);
                $('#fechaescrituraAct').val(datos.fechaEscrituraArrendatario);
                $('#numNotariaAct').val(datos.notariaArrendatario);
                $('#foliomercantilAct').val(datos.folioMercantilArrendatario);
                $('#licenciadoinqAct').val(datos.licenciadoArrendatario);




                $('#modalActualizarContrato').modal('toggle');


            }
        });


    });



    $('#actualizarContrato').click(function () {



        var id = $('#idContratoAct').val();
        var nombre = $('#nombreavalAct').val();
        var rfc = $('#rfcavalAct').val();
        var domicilio = $('#domicilioavalAct').val();
        var inmueble = $('#domicilioInmuebleAct').val();
        var escritura = $('#numescrituraAct').val();
        var fecha = $('#fechaescrituraAct').val();
        var notaria = $('#numNotariaAct').val();
        var folio = $('#foliomercantilAct').val();
        var licenciado = $('#licenciadoinqAct').val();

        if (nombre === "" || rfc === "" || domicilio === "" || inmueble === "" ||
            escritura === "" || fecha === "" || notaria === "" || licenciado === "" || folio === "") {
                $('#modalMensajeError').find('.modal-body').text('Todos los campos son obligatorios').end().modal('show');
        }
        else {

            $.ajax({
                url: 'actualizarContrato.php',
                method: 'post',
                data: {
                    idContrato: id,
                    rfc:rfc,
                    domicilio:domicilio,
                    inmueble:inmueble,
                    escritura:escritura,
                    fecha:fecha,
                    notaria:notaria,
                    folio:folio,
                    licenciado:licenciado,
                    nombre:nombre
                },
                success: function (data) {
                    //aqui recibes el json y haces lo que quieras con el

                   
                    $('#modalMensajeError').find('.modal-body').text('Se actualizó con éxito los datos del contrato').end().modal('show');

                    $('#modalActualizarContrato').modal('toggle');


                }
            });
        }


    });




    $('#fileToUpload').on('change', function () {

        $('#btnSubirContra').click();

    });


    $('#fileFoto').on('change', function () {

        $('#btnSubirFoto').click();

    });

});


