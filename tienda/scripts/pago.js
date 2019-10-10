function initTiendaPago()
{
	localStorage.setItem('tienda_paso', JSON.stringify('pago'));
	localStorage.removeItem('tienda_registro_escuelas');
	localStorage.removeItem('tienda_registro_programas');
	localStorage.removeItem('tienda_registro_escuela_seleccionada');
	localStorage.removeItem('tienda_registro_escuela_seleccionada_id');
	localStorage.removeItem('tienda_registro_programa_seleccionado');
	localStorage.removeItem('tienda_registro_programa_seleccionado_id');
	localStorage.removeItem('tienda_compra_escuela_seleccionada_id');
	localStorage.removeItem('tienda_compra_programa_seleccionado_id');
	localStorage.removeItem('tienda_compra_articulos');
	localStorage.removeItem('tienda_entrega_venta_id');
	pagoCargarDatosUsuario();
	$('#notificacion-mensaje').hide();
}

function pagoCargarDatosUsuario()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax(
	{
		url: '../sistema/x/usuario.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerUsuario',
			idusuario: usuario.usuario_idusuario
		},
		error: function(xhr, status, error)
		{
			console.error('[pago.js] [pagoCargarDatosUsuario] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var usuario = data.detalles;
				//$('#pagina-mensaje').html('Felicidades por estar en ' + usuario.usuario_dominio.toUpperCase() + '. ¡Te deseamos mucho éxito!');
				$('#confirmacion-usuario').text(usuario.usuario_nombre + ' ' + usuario.usuario_apellido_paterno + ' ' + usuario.usuario_apellido_materno);
				$('#confirmacion-usuario-matricula').text(usuario.usuario_matricula);
				$('#confirmacion-usuario-telefono').text(usuario.usuario_telefono);
				$('#confirmacion-usuario-login').text(usuario.usuario_login);
				$('#confirmacion-escuela-seleccionada').text(usuario.usuario_escuela_nombre);
				$('#confirmacion-programa-seleccionado').text(usuario.usuario_programa_nombre);
				$('#confirmacion-programa-nivel-seleccionado').text(usuario.usuario_programa_nivel);
				$('#usuario-nombre').html('<strong>Comprador: </strong>' + usuario.usuario_nombre + ' ' + usuario.usuario_apellido_paterno + ' ' + usuario.usuario_apellido_materno);
				$('#usuario-login').html('<strong>Correo electrónico: </strong>' + usuario.usuario_login);
				$('#usuario-telefono').html('<strong>Teléfono: </strong>' + usuario.usuario_telefono);
				
				if (usuario.usuario_rol === 'alumno')
				{
				    $('#confirmacion-usuario-identificador').html('Matrícula');
				    $('#usuario-matricula').html('<strong>Matrícula: </strong>' + usuario.usuario_matricula);
				}
				else if (usuario.usuario_rol === 'coordinador_dominio' || usuario.usuario_rol === 'coordinador_zona' || usuario.usuario_rol === 'coordinador_subzona' || usuario.usuario_rol === 'coordinador_escuela')
				{
				    $('#confirmacion-usuario-identificador').html('DNI');
				    $('#usuario-matricula').html('<strong>DNI: </strong>' + usuario.usuario_matricula);
				}
				
				pagoCargarDatosPago();
				pagoCargarDatosEscuela();
				pagoCargarDatosCarrito();
				
				if (usuario.usuario_rol === 'alumno')
				{
				    inicializarCONEKTA();
				}
				else if (usuario.usuario_rol === 'coordinador_dominio' || usuario.usuario_rol === 'coordinador_zona' || usuario.usuario_rol === 'coordinador_subzona' || usuario.usuario_rol === 'coordinador_escuela')
				{
				    inicializarConsignacion();
				}
				
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[pago.js] [pagoCargarDatosUsuario] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function pagoCargarDatosEscuela()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax(
	{
		url: '../sistema/x/escuela.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerEscuela',
			idescuela: usuario.usuario_idescuela
		},
		error: function(xhr, status, error)
		{
			console.error('[pago.js] [pagoCargarDatosEscuela] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var escuela = data.detalles;
				$('#escuela-nombre').html('<strong>Escuela: </strong>' + escuela.escuela_nombre);
				$('#escuela-campus').html('<strong>Campus: </strong>' + escuela.escuela_campus);
				$('#escuela-calle').html('<strong>Calle: </strong>' + escuela.escuela_calle + ' Exterior #' + escuela.escuela_num_exterior + (escuela.escuela_num_interior ? ', Interior #' + escuela.escuela_num_interior : ''));
				$('#escuela-ciudad').html('<strong>Ciudad: </strong>' + escuela.escuela_ciudad);
				$('#escuela-estado').html('<strong>Estado: </strong>' + escuela.escuela_estado);
				$('#escuela-codigo-postal').html('<strong>Código Postal: </strong>' + escuela.escuela_codigo_postal);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[pago.js] [pagoCargarDatosEscuela] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function pagoCargarDatosPago()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var rol = usuario.usuario_rol;
	var venta_consigacion = usuario.usuario_dominio_venta_consigacion;
	$('#pago-opcion-conekta-oxxo').click(function()
	{
	    $('#pago-opcion-conekta-oxxo-div').fadeIn(500);
	    $('#pago-opcion-conekta-spei-div').hide(0);
	    $('#pago-opcion-conekta-tarjeta-div').hide(0);
	});
	$('#pago-opcion-conekta-spei').click(function()
	{
	    $('#pago-opcion-conekta-oxxo-div').hide(0);
	    $('#pago-opcion-conekta-spei-div').fadeIn(500);
	    $('#pago-opcion-conekta-tarjeta-div').hide(0);
	});
	$('#pago-opcion-conekta-tarjeta').click(function()
	{
	    $('#pago-opcion-conekta-oxxo-div').hide(0);
	    $('#pago-opcion-conekta-spei-div').hide(0);
	    $('#pago-opcion-conekta-tarjeta-div').fadeIn(500);
	});
}

function inicializarCONEKTA()
{

	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	var conekta = carrito.conekta;

	if (conekta.resultado === 'ERROR')
	{
		return;
	}

	var conekta_detalles = conekta.detalles;
	var conekta_habilitado = conekta_detalles.habilitado;
	var conekta_modo = conekta_detalles.modo;
	var conekta_modo_pruebas_tarjeta_numero = conekta_detalles.modo_pruebas_tarjeta_numero;
	var conekta_modo_pruebas_tarjeta_token = conekta_detalles.modo_pruebas_tarjeta_token;
	var conekta_llave_publica = conekta_detalles.llave_publica;
	
	if (conekta_habilitado === false)
	{
		return;
	}
	
	// Mostrar las opciones de CONEKTA
	$('#pago-opcion-conecta').show();

	// CONEKTA - ¿Se está usando el modo de pruebas?
	if (conekta_modo === 'PRUEBAS')
	{
		$('#pago-opcion-conekta-oxxo-div-mensaje-sistema').html('<div class="alert alert-warning text-center" role="alert"><i class="fas fa-exclamation-triangle"></i> <strong>CONEKTA - Modo de PRUEBAS</strong> <i class="fas fa-exclamation-triangle"></i></div>');
		$('#pago-opcion-conekta-oxxo-div-mensaje-pago').html('');
		$('#pago-opcion-conekta-spei-div-mensaje-sistema').html('<div class="alert alert-warning text-center" role="alert"><i class="fas fa-exclamation-triangle"></i> <strong>CONEKTA - Modo de PRUEBAS</strong> <i class="fas fa-exclamation-triangle"></i></div>');
		$('#pago-opcion-conekta-spei-div-mensaje-pago').html('');
		$('#pago-opcion-conekta-tarjeta-div-mensaje-sistema').html('<div class="alert alert-warning text-center" role="alert"><i class="fas fa-exclamation-triangle"></i> <strong>CONEKTA - Modo de PRUEBAS</strong> <i class="fas fa-exclamation-triangle"></i></div>');
		$('#pago-opcion-conekta-tarjeta-div-mensaje-pago').html('');
		$('#tarjeta-nombre').val('Dueño de la tarjeta');
		$('#tarjeta-numero').val(conekta_modo_pruebas_tarjeta_numero);
		$('#tarjeta-expiracion-mes').val('02');
		$('#tarjeta-expiracion-anio').val('2020');
		$('#tarjeta-cvv').val('123');
		console.warn('CONEKTA - Modo de PRUEBAS');
	}

	// CONEKTA - ¿Se está usando el modo de producción?
	else if (conekta_modo === 'PRODUCCION')
	{
		console.warn('CONEKTA - Modo de PRODUCCION');
	}
	
	// CONEKTA - OXXO
	$('#pago-opcion-conekta-oxxo-div-pagar').click(function(event)
	{
		$('#pago-opcion-conekta-oxxo-div-pagar').prop('disabled', true);
		carritoPagarTienda('CONEKTA_OXXOPay');
	});
	
	// CONEKTA - SPEI
	$('#pago-opcion-conekta-spei-div-pagar').click(function(event)
	{
		$('#pago-opcion-conekta-spei-div-pagar').prop('disabled', true);
		carritoPagarTienda('CONEKTA_SPEI');
	});
	
	// CONEKTA - TARJETA
	Conekta.setPublicKey(conekta_llave_publica);
    var conektaSuccessResponseHandler = function(token) {
        $('#conektaTokenId').val(token.id);
        if (conekta_modo === 'PRUEBAS')
        {
            carritoPagarTarjeta(conekta_modo_pruebas_tarjeta_token);
        }
        else
        {
            carritoPagarTarjeta(token.id);
        }
    };
    var conektaErrorResponseHandler = function(response) {
        $('#pago-opcion-conekta-tarjeta-div-mensaje-sistema').html('<div class="alert alert-warning text-center" role="alert"><i class="fas fa-exclamation-triangle"></i> <strong>CONEKTA - Modo de PRUEBAS - ERROR</strong> <i class="fas fa-exclamation-triangle"></i></div>');
		$('#pago-opcion-conekta-tarjeta-div-mensaje-pago').html(response.message_to_purchaser);
        $('#pago-opcion-conekta-tarjeta-div-pagar').prop('disabled', false);
    };
	$('#pago-opcion-conekta-tarjeta-form').submit(function(e){
        e.preventDefault();
        var $form = $(this);
        $('#pago-opcion-conekta-tarjeta-div-pagar').prop('disabled', true);
        Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
        return false;
    });
}

function inicializarConsignacion()
{
	// Mostrar las opciones de Consignacion
	$('#pago-opcion-consignacion').show();
	
	// Consignacion
	$('#pago-opcion-consignacion-solicitar-div-pagar').click(function(event)
	{
		$('#pago-opcion-consignacion-solicitar-div-pagar').prop('disabled', true);
		carritoPagarConsignacion();
	});
}

function pagoCargarDatosCarrito()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	$.ajax(
	{
		url: '../sistema/x/carrito.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerCarrito',
			idcarrito: carrito.idcarrito
		},
		error: function(xhr, status, error)
		{
			console.error('[pago.js] [pagoCargarDatosCarrito] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var carrito = data.detalles;
				var detalles = carrito.detalles;
				var html_articulos = '';
				html_articulos += '<thead>';
				html_articulos += '	<tr>';
				html_articulos += '		<th>#</th>';
				html_articulos += '		<th>Portada</th>';
				html_articulos += '		<th>Nivel</th>';
				html_articulos += '		<th>Libro</th>';
				html_articulos += '		<th>Precio</th>';
				html_articulos += '		<th>Cantidad</th>';
				html_articulos += '		<th>Total</th>';
				html_articulos += '	</tr>';
				html_articulos += '</thead>';
				html_articulos += '<tbody>';
				for (var i = 0; i < detalles.length; i++)
				{
					html_articulos += '<tr>';
					html_articulos += '	<td class="align-middle">' + (i + 1) + '</td>';
					html_articulos += '	<td class="align-middle"><a><img class="img-rounded" width="48" height="48" src="data:image/png;base64, ' + detalles[i].imagen + '"></a></td>';
					html_articulos += '	<td class="align-middle">' + detalles[i].nivel + '</td>';
					html_articulos += '	<td class="align-middle">' + detalles[i].nombre + '</td>';
					html_articulos += '	<td class="align-middle">$' + formatearDinero(detalles[i].precio_descuento) + '</td>';
					html_articulos += '	<td class="align-middle">' + detalles[i].cantidad + '</td>';
					html_articulos += '	<td class="align-middle">$' + formatearDinero(detalles[i].precio_total) + '</td>';
					html_articulos += '</tr>';
				}
				html_articulos += '</tbody>';
				html_articulos += '<tfoot>';
				
				html_articulos += '	<tr>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle">Envío</th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle">$' + formatearDinero(carrito.total_envio) + '</th>';
				html_articulos += '		<th></th>';
				html_articulos += '	</tr>';
				
				html_articulos += '	<tr>';
				html_articulos += '		<th></th>';
				html_articulos += '		<th></th>';
				html_articulos += '		<th></th>';
				html_articulos += '		<th></th>';
				html_articulos += '		<th>Total</th>';
				html_articulos += '		<th>' + carrito.total_articulos + ' libro(s)</th>';
				html_articulos += '		<td><strong>$' + formatearDinero(carrito.total_precio) + '</strong></td>';
				html_articulos += '	</tr>';
				html_articulos += '</tfoot>';
				$('#pago-articulos-formato').empty();
				$('#pago-articulos-formato').append(html_articulos);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[pago.js] [pagoCargarDatosCarrito] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

initTiendaPago();