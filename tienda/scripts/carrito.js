function carritoCargar()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax(
	{
		url: '../sistema/x/carrito.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerCarritoDeUsuario',
			idusuario: usuario.usuario_idusuario
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito.js] [carritoCargar] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var carrito = data.detalles;
				var detalles = carrito.detalles;
				localStorage.setItem('carrito', JSON.stringify(carrito));
				$('#carrito-nav-cantidad').text(carrito.total_articulos);
				$('#carrito-boton-cantidad').text(carrito.total_articulos);
				$('#carrito-mensaje').text('Cuentas con ' + carrito.total_articulos + ' libro(s) en tu carrito');
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
				html_articulos += '		<th></th>';
				html_articulos += '	</tr>';
				html_articulos += '</thead>';
				html_articulos += '<tbody>';
				for (var i = 0; i < detalles.length; i++)
				{
					html_articulos += '<tr>';
					html_articulos += '	<td class="align-middle"><strong>' + (i + 1) + '</strong></td>';
					html_articulos += '	<td class="align-middle"><a><img class="img-rounded" width="48" height="48" src="data:image/png;base64, ' + detalles[i].imagen + '"></a></td>';
					html_articulos += '	<td class="align-middle">' + detalles[i].nivel + '</td>';
					html_articulos += '	<td class="align-middle">' + detalles[i].nombre + '</td>';
					html_articulos += '	<td class="align-middle">$' + formatearDinero(detalles[i].precio_descuento) + '</td>';
					html_articulos += '	<td class="align-middle">' + detalles[i].cantidad + '</td>';
					html_articulos += '	<td class="align-middle">$' + formatearDinero(detalles[i].precio_total) + '</td>';
					html_articulos += '	<td class="align-middle"><button type="button" class="btn" style="background-color:transparent" onclick="carritoEliminarArticulo(' + detalles[i].idarticulo + ');"><i class="fas fa-trash"></i> Quitar del carrito</button></td>';
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
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle">Total</th>';
				html_articulos += '		<th class="align-middle">' + carrito.total_articulos + '</th>';
				html_articulos += '		<th class="align-middle">$' + formatearDinero(carrito.total_precio) + '</th>';
				if (detalles.length > 0)
				{
					html_articulos += '		<th class="align-middle"><button type="button" class="btn" style="background-color:transparent" id="carrito-vaciar"><i class="fas fa-trash"></i> Vaciar el carrito</button></th>';
				}
				else
				{
					html_articulos += '		<th></th>';
				}
				html_articulos += '	</tr>';
				html_articulos += '</tfoot>'
				$('#carrito-articulos').empty();
				$('#carrito-articulos').append(html_articulos);
				$('#carrito-vaciar').click(function()
				{
					bootbox.confirm(
					{
						message: "¿Estás seguro que deseas vaciar el carrito?",
						buttons:
						{
							confirm:
							{
								label: 'Si',
								className: 'btn-primary'
							},
							cancel:
							{
								label: 'No',
								className: 'btn-danger'
							}
						},
						callback: function(result)
						{
							if (result == true)
							{
								carritoVaciar();
							}
							else
							{
								return;
							}
						}
					});
				});
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito.js] [carritoCargar] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function carritoCargarRedireccionarEntrega()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax(
	{
		url: '../sistema/x/carrito.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerCarritoDeUsuario',
			idusuario: usuario.usuario_idusuario
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito.js] [carritoCargarRedireccionarEntrega] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var carrito = data.detalles;
				var detalles = carrito.detalles;
				localStorage.setItem('carrito', JSON.stringify(carrito));
				$(location).attr('href', 'entrega.php');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito.js] [carritoCargarRedireccionarEntrega] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function carritoAgregarArticulo(idprograma, idarticulo, cantidad)
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
			op: 'agregarArticuloAlCarrito',
			idcarrito: carrito.idcarrito,
			idprograma: idprograma,
			idarticulo: idarticulo,
			cantidad: cantidad
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito.js] [agregarArticuloAlCarrito] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				carritoCargar();
				$('#carrito-modal').modal('show');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito.js] [agregarArticuloAlCarrito] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);

				console.warn('[carrito.js] [agregarArticuloAlCarrito] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert('The server encountered a problem while performing the request, please contact support or try again later...');
			}
		}
	}).done(function() {});
}

function carritoEliminarArticulo(idarticulo)
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	bootbox.confirm(
	{
		message: "¿Estás seguro que deseas eliminar este libro del carrito?",
		buttons:
		{
			confirm:
			{
				label: 'Si',
				className: 'btn-primary'
			},
			cancel:
			{
				label: 'No',
				className: 'btn-danger'
			}
		},
		callback: function(result)
		{
			if (result == true)
			{
				$.ajax(
				{
					url: '../sistema/x/carrito.php',
					type: 'POST',
					dataType: 'json',
					timeout: config_ajax_timeout,
					data:
					{
						op: 'eliminarArticuloDelCarrito',
						idcarrito: carrito.idcarrito,
						idarticulo: idarticulo
					},
					error: function(xhr, status, error)
					{
						console.error('[carrito.js] [carritoEliminarArticulo] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
						bootbox.alert('Error connecting to the server, please contact support or try again later...');
					},
					success: function(data)
					{
						if (data.resultado === 'OK')
						{
							carritoCargar();
							$('#carrito-modal').modal('show');

						}
            			else if (data.resultado === 'ERROR_TOKEN')
            			{
            				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
            				bootbox.alert(data.mensaje);
            				$(location).attr('href', '../login.php');
            			}
						else
						{
							console.warn('[carrito.js] [carritoEliminarArticulo] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
							bootbox.alert(data.mensaje);
						}
					}
				}).done(function() {});
			}
			else
			{
				return;
			}
		}
	});
}

function carritoVaciar()
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
			op: 'vaciarCarrito',
			idcarrito: carrito.idcarrito
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito.js] [carritoVaciar] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				carritoCargar();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito.js] [carritoVaciar] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function carritoValidar()
{
	var dominio = JSON.parse(localStorage.getItem('dominio'));
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
			op: 'validarCarrito',
			idcarrito: carrito.idcarrito
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito.js] [carritoValidar] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				$(location).attr('href', '//' + dominio + '.links2books.com/tienda/pago.php');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito.js] [carritoValidar] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function carritoPagarTarjeta(token_id)
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/carrito.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'pagarCarritoTarjeta',
			idcarrito: carrito.idcarrito,
			token_id: token_id
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[carrito.js] [carritoPagarTarjeta] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK' || data.resultado === 'ADVERTENCIA')
			{
				var tienda_entrega_venta_id = data.detalles.idventa;
				localStorage.setItem('tienda_entrega_venta_id', JSON.stringify(tienda_entrega_venta_id));
				carritoCargarRedireccionarEntrega();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito.js] [carritoPagarTarjeta] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(JSON.stringify(data.mensaje));
				$('#pago-opcion-conekta-tarjeta-div-pagar').prop('disabled', false);
			}
		}
	}).done(function() {});
}

function carritoPagarTienda(tienda)
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/carrito.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'pagarCarritoTienda',
			idcarrito: carrito.idcarrito,
			tienda: tienda
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[carrito.js] [carritoPagarTienda] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK' || data.resultado === 'ADVERTENCIA')
			{
				var tienda_entrega_venta_id = data.detalles.idventa;
				localStorage.setItem('tienda_entrega_venta_id', JSON.stringify(tienda_entrega_venta_id));
				carritoCargarRedireccionarEntrega();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito.js] [carritoPagarTienda] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(JSON.stringify(data.mensaje));
				$('#pago-opcion-conekta-oxxo-div-pagar').prop('disabled', false);
				$('#pago-opcion-conekta-spei-div-pagar').prop('disabled', false);
			}
		}
	}).done(function() {});
}

function carritoPagarConsignacion()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/carrito.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'pagarCarritoConsignacion',
			idcarrito: carrito.idcarrito
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[carrito.js] [carritoPagarConsignacion] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK' || data.resultado === 'ADVERTENCIA')
			{
				var tienda_entrega_venta_id = data.detalles.idventa;
				localStorage.setItem('tienda_entrega_venta_id', JSON.stringify(tienda_entrega_venta_id));
				carritoCargarRedireccionarEntrega();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito.js] [carritoPagarConsignacion] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(JSON.stringify(data.mensaje));
				$('#pago-opcion-consignacion-solicitar-div-pagar').prop('disabled', false);
			}
		}
	}).done(function() {});
}

function initCarrito()
{
	$('#navegacion-boton-carrito').click(function()
	{
		$('#carrito-modal').modal();
	});
	carritoCargar();
	
	$('#carrito-pagar').click(function()
	{
		carritoValidar();
	});
}