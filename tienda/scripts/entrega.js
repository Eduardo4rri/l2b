function iniTiendaEntrega()
{
	localStorage.setItem('tienda_paso', JSON.stringify('entrega'));
	localStorage.removeItem('tienda_registro_escuelas');
	localStorage.removeItem('tienda_registro_programas');
	localStorage.removeItem('tienda_registro_escuela_seleccionada');
	localStorage.removeItem('tienda_registro_escuela_seleccionada_id');
	localStorage.removeItem('tienda_registro_programa_seleccionado');
	localStorage.removeItem('tienda_registro_programa_seleccionado_id');
	localStorage.removeItem('tienda_compra_escuela_seleccionada_id');
	localStorage.removeItem('tienda_compra_programa_seleccionado_id');
	localStorage.removeItem('tienda_compra_articulos');
	//localStorage.removeItem('tienda_entrega_venta_id');
	$('#entrega-descargar-pdf').click(function()
	{
		tiendaDescargarPDF();
	});
	$('#entrega-enviar-pdf').click(function()
	{
		tiendaEnviarPDF();
	});
	tiendaCargarDatosUsuario();

	$('#guardar-datos-facturacion').click(function()
	{
		guardarDatosDeFacturacion();
	});
	$('#factura-numero-compra').change(function()
	{
		validarDatosUsuario('factura-numero-compra');
	});
	$('#factura-libro').change(function()
	{
		validarDatosUsuario('factura-libro');
	});
	$('#factura-nombre').change(function()
	{
		validarDatosUsuario('factura-nombre');
	});
	$('#factura-correo').change(function()
	{
		validarDatosUsuario('factura-correo');
	});
	$('#factura-telefono').change(function()
	{
		validarDatosUsuario('factura-telefono');
	});
	$('#factura-rfc').change(function()
	{
		validarDatosUsuario('factura-rfc');
	});
	$('#factura-calle').change(function()
	{
		validarDatosUsuario('factura-calle');
	});
	$('#factura-numero-exterior').change(function()
	{
		validarDatosUsuario('factura-numero-exterior');
	});
	$('#factura-colonia').change(function()
	{
		validarDatosUsuario('factura-colonia');
	});
	$('#factura-datos-adicionales').change(function()
	{
		validarDatosUsuario('factura-datos-adicionales');
	});
	$('#factura-delegacion').change(function()
	{
		validarDatosUsuario('factura-delegacion');
	});
	$('#factura-ciudad').change(function()
	{
		validarDatosUsuario('factura-ciudad');
	});
	$('#factura-pais').change(function()
	{
		validarDatosUsuario('factura-pais');
	});
	$('#factura-codigo-postal').change(function()
	{
		validarDatosUsuario('factura-codigo-postal');
	});
	$('#imprimir-comprobante').click(function(){
	    imprimirComprobante();
	});
}

function validarDatosUsuario(campo)
{
	var errores = 0;
	if (campo === 'todos' || campo === 'factura-numero-compra')
	{
		if (!$('#factura-numero-compra').val())
		{
			$('#factura-numero-compra').removeClass('is-valid');
			$('#factura-numero-compra').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-numero-compra').removeClass('is-invalid');
			$('#factura-numero-compra').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-libro')
	{
		if (!$('#factura-libro').val())
		{
			$('#factura-libro').removeClass('is-valid');
			$('#factura-libro').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-libro').removeClass('is-invalid');
			$('#factura-libro').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-nombre')
	{
		if (!$('#factura-nombre').val())
		{
			$('#factura-nombre').removeClass('is-valid');
			$('#factura-nombre').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-nombre').removeClass('is-invalid');
			$('#factura-nombre').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-correo')
	{
		if (!$('#factura-correo').val())
		{
			$('#factura-correo').removeClass('is-valid');
			$('#factura-correo').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-correo').removeClass('is-invalid');
			$('#factura-correo').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-telefono')
	{
		if (!$('#factura-telefono').val())
		{
			$('#factura-telefono').removeClass('is-valid');
			$('#factura-telefono').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-telefono').removeClass('is-invalid');
			$('#factura-telefono').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-rfc')
	{
		if (!$('#factura-rfc').val())
		{
			$('#factura-rfc').removeClass('is-valid');
			$('#factura-rfc').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-rfc').removeClass('is-invalid');
			$('#factura-rfc').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-calle')
	{
		if (!$('#factura-calle').val())
		{
			$('#factura-calle').removeClass('is-valid');
			$('#factura-calle').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-calle').removeClass('is-invalid');
			$('#factura-calle').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-numero-exterior')
	{
		if (!$('#factura-numero-exterior').val())
		{
			$('#factura-numero-exterior').removeClass('is-valid');
			$('#factura-numero-exterior').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-numero-exterior').removeClass('is-invalid');
			$('#factura-numero-exterior').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-colonia')
	{
		if (!$('#factura-colonia').val())
		{
			$('#factura-colonia').removeClass('is-valid');
			$('#factura-colonia').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-colonia').removeClass('is-invalid');
			$('#factura-colonia').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-delegacion')
	{
		if (!$('#factura-delegacion').val())
		{
			$('#factura-delegacion').removeClass('is-valid');
			$('#factura-delegacion').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-delegacion').removeClass('is-invalid');
			$('#factura-delegacion').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-ciudad')
	{
		if (!$('#factura-ciudad').val())
		{
			$('#factura-ciudad').removeClass('is-valid');
			$('#factura-ciudad').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-ciudad').removeClass('is-invalid');
			$('#factura-ciudad').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-pais')
	{
		if (!$('#factura-pais').val())
		{
			$('#factura-pais').removeClass('is-valid');
			$('#factura-pais').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-pais').removeClass('is-invalid');
			$('#factura-pais').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-codigo-postal')
	{
		if (!$('#factura-codigo-postal').val())
		{
			$('#factura-codigo-postal').removeClass('is-valid');
			$('#factura-codigo-postal').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-codigo-postal').removeClass('is-invalid');
			$('#factura-codigo-postal').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'factura-datos-adicionales')
	{
		if (!$('#factura-datos-adicionales').val())
		{
			$('#factura-datos-adicionales').removeClass('is-valid');
			$('#factura-datos-adicionales').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#factura-datos-adicionales').removeClass('is-invalid');
			$('#factura-datos-adicionales').addClass('is-valid');
		}
	}
	if (errores == 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function tiendaCargarDatosUsuario()
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
			console.error('[entrega.js] [tiendaCargarDatosUsuario] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var usuario = data.detalles;
				//$('#pagina-mensaje').html('Felicidades por estar en ' + usuario.usuario_dominio.toUpperCase() + '. ¡Te deseamos mucho éxito!');
				tiendaCargarDatosVenta();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[entrega.js] [tiendaCargarDatosUsuario] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function tiendaCargarDatosVenta()
{
	var tienda_entrega_venta_id = JSON.parse(localStorage.getItem('tienda_entrega_venta_id'));
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax(
	{
		url: '../sistema/x/venta.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerVentaConImagen',
			idventa: tienda_entrega_venta_id
		},
		error: function(xhr, status, error)
		{
			console.error('[entrega.js] [tiendaCargarDatosVenta] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var venta = data.detalles;
				// Cargar datos en modal-factura
				$('#factura-numero-compra').val(JSON.parse(localStorage.getItem('tienda_entrega_venta_id')));
				$('#factura-correo').val(usuario.usuario_email);
				$('#usuario-id').val(usuario.usuario_idusuario);
				$('#factura-libro').val(venta.detalles[0].articulo_nombre);
				///////////////////////////////////////////////////////////////////////////////////////
				var idpago = venta.idpago;
				var detalles = venta.detalles;
				$('#entrega-venta-id').html(venta.idventa);
				$('#entrega-venta-fecha-hora').html(venta.fecha_hora);
				$('#entrega-venta-fecha-entrega').html(venta.fecha_entrega_prevista);
				$('#entrega-venta-estatus').html(venta.estatus_pago_leyenda);
				$('#escuela-nombre').html('<strong>Escuela: </strong>' + venta.entrega_escuela);
				$('#escuela-campus').html('<strong>Campus: </strong>' + venta.entrega_campus);
				$('#escuela-calle').html('<strong>Calle: </strong>' + venta.entrega_calle);
				$('#escuela-ciudad').html('<strong>Ciudad: </strong>' + venta.entrega_ciudad);
				$('#escuela-estado').html('<strong>Estado: </strong>' + venta.entrega_estado);
				$('#escuela-codigo-postal').html('<strong>Código Postal: </strong>' + venta.entrega_codigo_postal);
				$('#usuario-nombre').html('<strong>Comprador: </strong>' + venta.comprador_nombre);
				$('#usuario-login').html('<strong>Correo electrónico: </strong>' + venta.comprador_correo_electronico);
				$('#usuario-matricula').html((usuario.usuario_rol === 'alumno' ? '<strong>Matrícula: </strong>' + venta.comprador_matricula : '<strong>DNI: </strong>' + venta.comprador_matricula));
				$('#usuario-telefono').html('<strong>Teléfono: </strong>' + venta.comprador_telefono);
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
					html_articulos += '	<td class="align-middle">' + detalles[i].articulo_nivel + '</td>';
					html_articulos += '	<td class="align-middle">' + detalles[i].articulo_nombre + '</td>';
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
				html_articulos += '		<th class="align-middle">$' + formatearDinero(venta.envio) + '</th>';
				html_articulos += '		<th></th>';
				html_articulos += '	</tr>';
				
				html_articulos += '	<tr>';
				html_articulos += '		<th></th>';
				html_articulos += '		<th></th>';
				html_articulos += '		<th></th>';
				html_articulos += '		<th></th>';
				html_articulos += '		<th>Total</th>';
				html_articulos += '		<th>' + venta.total_articulos + ' libro(s)</th>';
				html_articulos += '		<td><strong>$' + formatearDinero(venta.total) + '</strong></td>';
				html_articulos += '	</tr>';
				html_articulos += '</tfoot>';
				$('#entrega-articulos-formato').empty();
				$('#entrega-articulos-formato').append(html_articulos);
				
				tiendaCargarDatosPago(idpago);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[entrega.js] [tiendaCargarDatosVenta] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function tiendaCargarDatosPago(idpago)
{
	$.ajax(
	{
		url: '../sistema/x/pago.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerReferenciaPago',
			idpago: idpago
		},
		error: function(xhr, status, error)
		{
			console.error('[entrega.js] [tiendaCargarDatosPago] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var pago = data.detalles;
				var html_detalles = '';
				if (pago.pago_proveedor === 'CONEKTA' && pago.pago_tienda === 'oxxo_cash')
				{
					html_detalles += '<br>';
					html_detalles += '<div class="text-center">';
					html_detalles += '<h3>El estatus de tu pago es: <strong>' + pago.pago_estatus_leyenda + '</strong></h3>';
					html_detalles += '<br>';
					html_detalles += '<h6>• ' + pago.pago_descripcion + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_1 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_2 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_3 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_comision + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_expiracion + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_confirmacion + '</h6>';
					html_detalles += '<br>';
					html_detalles += '<a href="stub-conekta-oxxo.php?idpago=' + pago.idpago + '" target="_blank"><button type="button" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir instrucciones de pago</button></a>';
					html_detalles += '<br>';
					html_detalles += '<br>';
					html_detalles += '<img src="../sistema/img/pago_oxxo.png"><br>';
					html_detalles += '<br>';
					html_detalles += '</div>';
				}
				else if (pago.pago_proveedor === 'CONEKTA' && pago.pago_tienda === 'spei')
				{
					html_detalles += '<br>';
					html_detalles += '<div class="text-center">';
					html_detalles += '<h3>El estatus de tu pago es: <strong>' + pago.pago_estatus_leyenda + '</strong></h3>';
					html_detalles += '<br>';
					html_detalles += '<h6>• ' + pago.pago_descripcion + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_1 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_2 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_3 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_comision + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_expiracion + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_confirmacion + '</h6>';
					html_detalles += '<br>';
					html_detalles += '<a href="stub-conekta-spei.php?idpago=' + pago.idpago + '" target="_blank"><button type="button" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir instrucciones de pago</button></a>';
					html_detalles += '<br>';
					html_detalles += '<br>';
					html_detalles += '<img src="../sistema/img/pago_spei.png"><br>';
					html_detalles += '<br>';
					html_detalles += '</div>';
				}
				else if (pago.pago_proveedor === 'CONEKTA' && pago.pago_tienda === 'Tarjeta')
				{
					html_detalles += '<br>';
					html_detalles += '<div class="text-center">';
					html_detalles += '<h3>El estatus de tu pago es: <strong>' + pago.pago_estatus_leyenda + '</strong></h3>';
					html_detalles += '<br>';
					html_detalles += '<h6>• ' + pago.pago_descripcion + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_1 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_2 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_3 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_comision + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_expiracion + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_confirmacion + '</h6>';
					html_detalles += '<br>';
					html_detalles += '<a href="stub-conekta-tarjeta.php?idpago=' + pago.idpago + '" target="_blank"><button type="button" class="btn btn-primary"><i class="fas fa-print"></i> Imprimir comprobante de pago</button></a>';
					html_detalles += '<br>';
					html_detalles += '<br>';
					if (pago.respuesta_banco_cuenta === 'visa')
					{
					    html_detalles += '<img src="../sistema/img/pago_visa.png"><br>';
					}
					else if (pago.respuesta_banco_cuenta === 'mastercard' || pago.respuesta_banco_cuenta === 'mc')
					{
					    html_detalles += '<img src="../sistema/img/pago_mastercard.png"><br>';
					}
					else if (pago.respuesta_banco_cuenta === 'american_express')
					{
					    html_detalles += '<img src="../sistema/img/pago_american_express.png"><br>';
					}
					html_detalles += '<br>';
					html_detalles += '</div>';
				}
				else if (pago.pago_proveedor === 'Links2Books' && pago.pago_tienda === 'consignacion')
				{
					html_detalles += '<br>';
					html_detalles += '<div class="text-center">';
					html_detalles += '<h3>El estatus de tu consignación es: <strong>' + pago.pago_estatus_leyenda + '</strong></h3>';
					html_detalles += '<br>';
					html_detalles += '<h6>• ' + pago.pago_descripcion + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_1 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_2 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_paso_3 + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_comision + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_expiracion + '</h6>';
					html_detalles += '<h6>• ' + pago.pago_confirmacion + '</h6>';
					html_detalles += '<br>';
					html_detalles += '<img class="min-width-img" src="../sistema/img/sitio_logo_contraste_365x180.png"><br>';
					html_detalles += '<br>';
					html_detalles += '</div>';
				}
				$('#pago-detalles').empty();
				$('#pago-detalles').append(html_detalles);
				
				// Devolución
				if (pago.pago_estatus == 10)
				{
				    $('#cambia-tu-pedido').hide();
				    $('#venta-devuelta-aviso-1').show();
				    $('#venta-devuelta-aviso-2').show();
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
				console.warn('[entrega.js] [tiendaCargarDatosPago] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function tiendaDescargarPDF()
{
	var tienda_entrega_venta_id = JSON.parse(localStorage.getItem('tienda_entrega_venta_id'));
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/venta.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerPDFVenta',
			idventa: tienda_entrega_venta_id
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[entrega.js] [tiendaDescargarPDF] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				var base64 = data.detalles.pdf_base_64;
				var linkSource = 'data:application/pdf;base64,' + base64;
				var downloadLink = document.createElement("a");
				var fileName = 'comprobante.pdf';
				downloadLink.href = linkSource;
				downloadLink.download = fileName;
				downloadLink.click();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[entrega.js] [tiendaDescargarPDF] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function tiendaEnviarPDF()
{
	var tienda_entrega_venta_id = JSON.parse(localStorage.getItem('tienda_entrega_venta_id'));
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/venta.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'enviarPDFVenta',
			idventa: tienda_entrega_venta_id
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[entrega.js] [tiendaEnviarPDF] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				// >:3
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[entrega.js] [tiendaEnviarPDF] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function guardarDatosDeFacturacion()
{
	var validacion = validarDatosUsuario('todos');
	if (validacion == false)
	{
		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/venta.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'actualizarDatosDeFacturacion',
			idusuario: $('#usuario-id').val(),
			idventa: $('#factura-numero-compra').val(),
			libro: $('#factura-libro').val(),
			nombre: $('#factura-nombre').val(),
			correo: $('#factura-correo').val(),
			telefono: $('#factura-telefono').val(),
			rfc: limpiarString($('#factura-rfc').val()),
			calle: $('#factura-calle').val(),
			numero_exterior: $('#factura-numero-exterior').val(),
			numero_interior: $('#factura-numero-interior').val(),
			colonia: $('#factura-colonia').val(),
			delegacion: $('#factura-delegacion').val(),
			ciudad: $('#factura-ciudad').val(),
			pais: $('#factura-pais').val(),
			codigo_postal: $('#factura-codigo-postal').val(),
			datos_adicionales: limpiarString($('#factura-datos-adicionales').val())
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[entrega.js] [guardarDatosDeFacturacion] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK' || data.resultado === 'ADVERTENCIA')
			{
				bootbox.alert('<i class="fas fa-check"></i> ' + data.mensaje);
				$('#factura-rfc').val('');
				$('#factura-datos-adicionales').val('');
				$('#factura-nombre').val('');
				$('#factura-telefono').val('');
				$('#factura-calle').val('');
				$('#factura-numero-exterior').val('');
				$('#factura-colonia').val('');
				$('#factura-delegacion').val('');
				$('#factura-ciudad').val('');
				$('#factura-pais').val('');
				$('#factura-codigo-postal').val('');
				$('#factura-rfc').removeClass('is-valid');
				$('#factura-numero-compra').removeClass('is-valid');
				$('#factura-correo').removeClass('is-valid');
				$('#factura-datos-adicionales').removeClass('is-valid');
				$('#factura-nombre').removeClass('is-valid');
				$('#factura-telefono').removeClass('is-valid');
				$('#factura-libro').removeClass('is-valid');
				$('#factura-calle').removeClass('is-valid');
				$('#factura-numero-exterior').removeClass('is-valid');
				$('#factura-colonia').removeClass('is-valid');
				$('#factura-delegacion').removeClass('is-valid');
				$('#factura-ciudad').removeClass('is-valid');
				$('#factura-pais').removeClass('is-valid');
				$('#factura-codigo-postal').removeClass('is-valid');
				$('#factura-modal').modal('hide');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[entrega.js] [guardarDatosDeFacturacion] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}


//Funcion de JS para obtener los eventos
//Funciona con el ID de la tabla y el ID del div pago detalles

function imprimirComprobante(){
    
	var mywindow = window.open('',"_blank",'height=600,width=1000');
	mywindow.document.write('<style>img{margin-top: 12px;}h3{margin-bottom: -0.9rem !important;font-size: 1.75rem;}h6{margin-bottom:-1rem!important;font-size: 14px;}h3,h6{margin-bottom: .5rem;font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji","Segoe UI Symbol", "Noto Color Emoji";font-weight: 500; line-height: 1.5; color: inherit;}body{font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji","Segoe UI Symbol", "Noto Color Emoji";margin:0px 40px;}table{width:100%;margin-bottom: 1rem;font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji","Segoe UI Symbol", "Noto Color Emoji";background-color: transparent;border-top: 1px solid rgba(0,0,0,.125);border-bottom: 1px solid rgba(0,0,0,.125);}thead {display: table-header-group;vertical-align: middle;border-bottom:1px solid;border-color: inherit;}img{}.text-center {text-align: center !important;font-size:18px;}button{display:none;}</style>');
	mywindow.document.write('<style>.min-width-img{width:120px;height:140px;}.alert{display:none;}#table-responsiv-print{margin-top:25px}.row{display:flex;flex-wrap:wrap;;font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji","Segoe UI Symbol", "Noto Color Emoji";}.col-md-3{flex:0 0 25%; max-width:25%;width:100%;}.col-sm-6{flex:0 0 50%;width:100%;position:relative;}hr{margin-top: 1rem;margin-bottom: 1rem;border: 0; border-top: 1px solid rgba(0, 0, 0, .1);}</style>');
	mywindow.document.write(document.getElementById('pago-detalles').innerHTML);
	mywindow.document.write('<br></br>');
	mywindow.document.write(document.getElementById('detalles-print').innerHTML);
	mywindow.document.write('<br></br>');
	mywindow.document.write('<br></br>');
    mywindow.print();
    mywindow.close();
}

iniTiendaEntrega();