function carritoRecompensasCargar()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax(
	{
		url: '../sistema/x/carrito_recompensas.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerCarritoRecompensasDeUsuario',
			idusuario: usuario.usuario_idusuario
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito_recompensas.js] [carritoRecompensasCargar] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var carrito = data.detalles;
				var detalles = carrito.detalles;
				localStorage.setItem('carrito_recompensas', JSON.stringify(carrito));
				var html_articulos = '';
				html_articulos += '<thead>';
				html_articulos += '	<tr>';
				html_articulos += '		<th>#</th>';
				html_articulos += '		<th>Nombre</th>';
				html_articulos += '		<th>Descripción</th>';
				html_articulos += '		<th>Puntos</th>';
				html_articulos += '		<th>Cantidad</th>';
				html_articulos += '		<th>Total</th>';
				html_articulos += '		<th>Quitar</th>';
				html_articulos += '	</tr>';
				html_articulos += '</thead>';
				html_articulos += '<tbody>';
				if (detalles.length === 0)
				{
					html_articulos += '<tr>';
					html_articulos += '	<td class="align-middle"></td>';
					html_articulos += '	<td class="align-middle"></td>';
					html_articulos += '	<td class="align-middle"></td>';
					html_articulos += '	<td class="align-middle"></td>';
					html_articulos += '	<td class="align-middle"></td>';
					html_articulos += '</tr>';
				}
				else
				{
					for (var i = 0; i < detalles.length; i++)
					{
						html_articulos += '<tr>';
						html_articulos += '	<td class="align-middle"><strong>' + (i + 1) + '<strong></td>';
						html_articulos += '	<td class="align-middle">' + detalles[i].nombre + '</td>';
						html_articulos += '	<td class="align-middle">' + detalles[i].descripcion + '</td>';
						html_articulos += '	<td class="align-middle">$' + formatearDinero(detalles[i].precio) + '</td>';
						html_articulos += '	<td class="align-middle">' + detalles[i].cantidad + '</td>';
						html_articulos += '	<td class="align-middle">$' + formatearDinero(detalles[i].precio_total) + '</td>';
						html_articulos += '	<td class="align-middle"><button type="button" class="btn" style="background-color:transparent" onclick="carritoRecompensasEliminarRecompensa(' + detalles[i].idrecompensa + ');"><i class="fas fa-trash"></i> Quitar</button></td>';
						html_articulos += '</tr>';
					}
				}
				html_articulos += '</tbody>';
				html_articulos += '<tfoot>';
				html_articulos += '	<tr>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle"></th>';
				html_articulos += '		<th class="align-middle">Total</th>';
				html_articulos += '		<th class="align-middle">' + carrito.total_recompensas + '</th>';
				html_articulos += '		<th class="align-middle">$' + formatearDinero(carrito.total_precio) + '</th>';
				if (detalles.length > 0)
				{
					html_articulos += '		<th class="align-middle"><button type="button" class="btn" style="background-color:transparent" id="carrito-vaciar"><i class="fas fa-trash"></i> Vacíar</button></th>';
				}
				else
				{
					html_articulos += '		<th></th>';
				}
				html_articulos += '	</tr>';
				html_articulos += '</tfoot>'
				$('#carrito-recompensas').empty();
				$('#carrito-recompensas').append(html_articulos);
				$('#carrito-recompensas-vaciar').click(function()
				{
					bootbox.confirm(
					{
						message: "¿Estás seguro que deseas vaciar el carrito de recompensas?",
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
								carritoRecompensasVaciar();
							}
							else
							{
								return;
							}
						}
					});
				});
				$('#carrito-recompensas-canjear').click(function()
				{
					carritoRecompensasValidar();
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
				console.warn('[carrito_recompensas.js] [carritoRecompensasCargar] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function carritoRecompensasSeleccionarRecompensa(idrecompensa)
{
	var idcantidad = '#recompensas-' + idrecompensa + '-cantidad';
	var cantidad = $(idcantidad).val();
	if (cantidad < 1 || cantidad > 10) {
		bootbox.alert('¡La cantidad mínima posible es 1 recompensa y la cantidad máxima posible es 10 recompensas, por favor revisa la cantidad e intenta de nuevo!');
		return;
	}
	carritoRecompensasAgregarRecompensa(idrecompensa, cantidad);
}

function carritoRecompensasAgregarRecompensa(idrecompensa, cantidad)
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito_recompensas = JSON.parse(localStorage.getItem('carrito_recompensas'));
	$.ajax(
	{
		url: '../sistema/x/carrito_recompensas.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'agregarRecompensaAlCarritoRecompensas',
			idcarrito: carrito_recompensas.idcarrito,
			idrecompensa: idrecompensa,
			cantidad: cantidad
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito_recompensas.js] [carritoRecompensasAgregarRecompensa] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				carritoRecompensasCargar();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[carrito_recompensas.js] [carritoRecompensasAgregarRecompensa] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function carritoRecompensasEliminarRecompensa(idrecompensa)
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito_recompensas = JSON.parse(localStorage.getItem('carrito_recompensas'));
	bootbox.confirm(
	{
		message: "¿Estás seguro que deseas eliminar esta recompensa del carrito de recompensas?",
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
					url: '../sistema/x/carrito_recompensas.php',
					type: 'POST',
					dataType: 'json',
					timeout: config_ajax_timeout,
					data:
					{
						op: 'eliminarRecompensaDelCarritoRecompensas',
						idcarrito: carrito_recompensas.idcarrito,
						idrecompensa: idrecompensa
					},
					error: function(xhr, status, error)
					{
						console.error('[carrito_recompensas.js] [carritoRecompensasEliminarRecompensa] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
						bootbox.alert('Error connecting to the server, please contact support or try again later...');
					},
					success: function(data)
					{
						if (data.resultado === 'OK')
						{
							carritoRecompensasCargar();
						}
            			else if (data.resultado === 'ERROR_TOKEN')
            			{
            				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
            				bootbox.alert(data.mensaje);
            				$(location).attr('href', '../login.php');
            			}
						else
						{
							console.warn('[carrito_recompensas.js] [carritoRecompensasEliminarRecompensa] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
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

function carritoRecompensasVaciar()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	$.ajax(
	{
		url: '../sistema/x/carrito_recompensas.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'vaciarCarritoRecompensas',
			idcarrito: carrito.idcarrito
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito_recompensas.js] [carritoRecompensasVaciar] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
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
				console.warn('[carrito_recompensas.js] [carritoRecompensasVaciar] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function carritoRecompensasValidar()
{
	var dominio = JSON.parse(localStorage.getItem('dominio'));
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	$.ajax(
	{
		url: '../sistema/x/carrito_recompensas.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'validarCarritoRecompensas',
			idcarrito: carrito.idcarrito
		},
		error: function(xhr, status, error)
		{
			console.error('[carrito_recompensas.js] [carritoRecompensasValidar] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
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
				console.warn('[carrito_recompensas.js] [carritoRecompensasValidar] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function carritoRecompensasPagar()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var carrito = JSON.parse(localStorage.getItem('carrito'));
	var tarjeta_nombre = $('#tarjeta-nombre').val();
	var tarjeta_numero = $('#tarjeta-numero').val();
	var tarjeta_expiracion_mes = $('#tarjeta-expiracion-mes').val();
	var tarjeta_expiracion_anio = $('#tarjeta-expiracion-anio').val();
	var tarjeta_cvv = $('#tarjeta-cvv').val();
	mostrarEsperaAjax('Procesando, por favor no recarges esta página.<br>La operación puede tardar hasta 1 minuto.<br><i class="fas fa-smile"></i>');
	$.ajax(
	{
		url: '../sistema/x/carrito_recompensas.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'pagarCarritoRecompensas',
			idcarrito: carrito.idcarrito,
			tarjeta_nombre: $('#tarjeta-nombre').val(),
			tarjeta_numero: $('#tarjeta-numero').val(),
			tarjeta_expiracion_mes: $('#tarjeta-expiracion-mes').val(),
			tarjeta_expiracion_anio: $('#tarjeta-expiracion-anio').val(),
			tarjeta_cvv: $('#tarjeta-cvv').val()
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[carrito_recompensas.js] [carritoRecompensasPagar] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				var tienda_entrega_venta_id = data.detalles.saleID;
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
				console.log(data);
				console.warn('[carrito_recompensas.js] [carritoRecompensasPagar] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(JSON.stringify(data.mensaje));
			}
		}
	}).done(function() {});
}

function initCarritoRecompensas()
{
	carritoRecompensasCargar();
}

initCarritoRecompensas();