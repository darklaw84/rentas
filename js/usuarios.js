$(document).ready(function () {

    //lenarDatosModal

    $(document).on('click', 'a[data-role=updateUsuarios]', function () {
        var id = $(this).data('id');
        var idPerfil = $('#' + id).children().find('.idPerfil').val();
        var nombre = $('#' + id).children('td[data-target=nombre]').text();
        var correo = $('#' + id).children('td[data-target=correo]').text();
        var rfc = $('#' + id).children('td[data-target=rfc]').text();
        var apellidos = $('#' + id).children('td[data-target=apellidos]').text();
        var telefono = $('#' + id).children('td[data-target=telefono]').text();
        $('#nombreAdmin').val(nombre);
        $('#razonM').val(nombre);
        $('#apellidosAdmin').val(apellidos);
        $('#correoAdmin').val(correo);
        $('#rfcAdmin').val(rfc);
        $('#telefonoAdmin').val(telefono);
        $('#idAdmin').val(id);
        $('#idPerfilU').val(idPerfil);


        var factura = $('#' + id).children().find('.factura').val();
        if (factura === "1") {
            $("#facturaUs").prop('checked', true);
        }
        else {
            $("#facturaUs").prop('checked', false);
        }

        var fisica = $('#' + id).children().find('.fisica').val();
        if (fisica === "1") {
            $('#razonM').val('');
            $("#divMoralM").hide();
            $("#divFisicaM").show();
        }
        else {
            $("#divMoralM").show();
            $("#divFisicaM").hide();
        }

        $('#modalUsuariosUpdate').modal('toggle');

        

    });


    $('#tipoPersona').on('change', function () {
        mostrarDivs();
    });

    function mostrarDivs()
    {
        var idUnidadSel=$('#tipoPersona').val();
        if (idUnidadSel == 1 ) {
            $('#divFisica').show();
            $('#divMoral').hide();

        }
        else  {
            $('#divFisica').hide();
            $('#divMoral').show();

        }
        
    }




    

    

    $('#guardarAdmin').click(function () {

        var idAdmin = $('#idAdmin').val();
        var correoAdmin = $('#correoAdmin').val();
        var rfcAdmin = $('#rfcAdmin').val();
        var nombreAdmin = $('#nombreAdmin').val();
        var razon = $('#razonM').val();
        var apellidosAdmin = $('#apellidosAdmin').val();
        var telefonoAdmin = $('#telefonoAdmin').val();
        var idPerfil = $('#idPerfilU').val();
        var perfilText = $('#idPerfilU option:selected').html();

        var factura = 0;

        if ($("#facturaUs").prop("checked") == true) {
            factura = 1;
        }

        if(razon!="")
        {
            nombreAdmin=razon;
        }


        if (correoAdmin === "" || nombreAdmin === "" || rfcAdmin === ""  || telefonoAdmin === "") {
            $('#modalMensajeError').find('.modal-body').text('Los campos son obligatorios').end().modal('show');
        } else {

            $.ajax({
                url: 'usuarioscrud.php',
                method: 'post',
                data: {
                    idAdmin: idAdmin,
                    correoAdmin: correoAdmin,
                    rfcAdmin: rfcAdmin,
                    idPerfil: idPerfil,
                    nombreAdmin: nombreAdmin,
                    apellidosAdmin: apellidosAdmin,
                    telefonoAdmin: telefonoAdmin,
                    factura: factura,
                    tipo: 'update'
                },
                success: function (data) {
                    //aqui recibes el json y haces lo que quieras con el
                    $('#' + idAdmin).children('td[data-target=correo]').text(correoAdmin);
                    $('#' + idAdmin).children('td[data-target=rfc]').text(rfcAdmin);
                    $('#' + idAdmin).children('td[data-target=nombre]').text(nombreAdmin);
                    $('#' + idAdmin).children('td[data-target=telefono]').text(telefonoAdmin);
                    $('#' + idAdmin).children('td[data-target=apellidos]').text(apellidosAdmin);
                    $('#' + idAdmin).children('td[data-target=perfil]').text(perfilText);
                    $('#' + idAdmin).children().find('.idPerfil').val(idPerfil);
                    $('#' + idAdmin).children().find('.factura').val(factura);
                    $('#modalUsuariosUpdate').modal('toggle');
                }
            });
        }

    });


  



   
});