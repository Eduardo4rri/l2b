function init()
{
	obtenerRecompensasLibro();
	obtenerRecompensasCurso();
	obtenerRecompensasMaterial();
}

function obtenerRecompensasLibro()
{
	$.ajax(
	{
		url: '../sistema/x/recompensas.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerRecompensasLibro',
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[recompensas.js] [obtenerRecompensasLibro] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK' || data.resultado === 'WARNING')
			{
				var html_articulos = '';
				html_articulos += '<thead>';
				html_articulos += '	<tr>';
				html_articulos += '		<th>Nombre</th>';
				html_articulos += '		<th>Descripción</th>';
				html_articulos += '		<th>Puntos</th>';
				html_articulos += '		<th>Cantidad</th>';
				html_articulos += '		<th>Agregar al carrito</th>';
				html_articulos += '	</tr>';
				html_articulos += '</thead>';
				html_articulos += '<tbody>';
				for (var i = 0; i < data.detalles.length; i++)
				{
					html_articulos += '<tr>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].nombre + '</td>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].descripcion + '</td>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].costo + '</td>';
					html_articulos += '	<td class="align-middle"><input type="number" min="1" max="10" class="form-control" id="recompensas-' + data.detalles[i].idrecompensa + '-cantidad" placeholder="Cantidad" aria-label="Cantidad" value="1"></td>';
					html_articulos += '	<td class="align-middle"><button class="btn btn-primary" onclick="carritoRecompensasSeleccionarRecompensa(' + data.detalles[i].idrecompensa + ', 1);" type="button"><i class="fas fa-shopping-cart"></i> Agregar al carrito</button></td>';
					html_articulos += '</tr>';
				}
				html_articulos += '</tbody>';
				$('#libro-recompensas').empty();
				$('#libro-recompensas').append(html_articulos);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[recompensas.js] [obtenerRecompensasLibro] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function()
	{
		ocultarEsperaAjax();
	});
}

function obtenerRecompensasCurso()
{
	$.ajax(
	{
		url: '../sistema/x/recompensas.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerRecompensasCurso'
		},
		error: function(xhr, status, error)
		{
			console.error('[recompensas.js] [obtenerRecompensasCurso] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK' || data.resultado === 'WARNING')
			{
				var html_articulos = '';
				html_articulos += '<thead>';
				html_articulos += '	<tr>';
				html_articulos += '		<th>Nombre</th>';
				html_articulos += '		<th>Descripción</th>';
				html_articulos += '		<th>Puntos</th>';
				html_articulos += '		<th>Cantidad</th>';
				html_articulos += '		<th>Agregar al carrito</th>';
				html_articulos += '	</tr>';
				html_articulos += '</thead>';
				html_articulos += '<tbody>';
				for (var i = 0; i < data.detalles.length; i++)
				{
					html_articulos += '<tr>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].nombre + '</td>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].descripcion + '</td>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].costo + '</td>';
					html_articulos += '	<td class="align-middle"><input type="number" min="1" max="10" class="form-control" id="recompensas-' + data.detalles[i].idrecompensa + '-cantidad" placeholder="Cantidad" aria-label="Cantidad" value="1"></td>';
					html_articulos += '	<td class="align-middle"><button class="btn btn-primary" onclick="carritoRecompensasSeleccionarRecompensa(' + data.detalles[i].idrecompensa + ', 1);" type="button"><i class="fas fa-shopping-cart"></i> Agregar al carrito</button></td>';
					html_articulos += '</tr>';
				}
				html_articulos += '</tbody>';
				$('#curso-recompensas').empty();
				$('#curso-recompensas').append(html_articulos);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[recompensas.js] [obtenerRecompensasCurso] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function()
	{
		ocultarEsperaAjax();
	});
}

function obtenerRecompensasMaterial()
{
	$.ajax(
	{
		url: '../sistema/x/recompensas.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerRecompensasMaterial'
		},
		error: function(xhr, status, error)
		{
			console.error('[recompensas.js] [obtenerRecompensasMaterial] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK' || data.resultado === 'WARNING')
			{
				var html_articulos = '';
				html_articulos += '<thead>';
				html_articulos += '	<tr>';
				html_articulos += '		<th>Nombre</th>';
				html_articulos += '		<th>Descripción</th>';
				html_articulos += '		<th>Puntos</th>';
				html_articulos += '		<th>Cantidad</th>';
				html_articulos += '		<th>Agregar al carrito</th>';
				html_articulos += '	</tr>';
				html_articulos += '</thead>';
				html_articulos += '<tbody>';
				for (var i = 0; i < data.detalles.length; i++)
				{
					html_articulos += '<tr>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].nombre + '</td>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].descripcion + '</td>';
					html_articulos += '	<td class="align-middle">' + data.detalles[i].costo + '</td>';
					html_articulos += '	<td class="align-middle"><input type="number" min="1" max="10" class="form-control" id="recompensas-' + data.detalles[i].idrecompensa + '-cantidad" placeholder="Cantidad" aria-label="Cantidad" value="1"></td>';
					html_articulos += '	<td class="align-middle"><button class="btn btn-primary" onclick="carritoRecompensasSeleccionarRecompensa(' + data.detalles[i].idrecompensa + ', 1);" type="button"><i class="fas fa-shopping-cart"></i> Agregar al carrito</button></td>';
					html_articulos += '</tr>';
				}
				html_articulos += '</tbody>';
				$('#material-recompensas').empty();
				$('#material-recompensas').append(html_articulos);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[recompensas.js] [obtenerRecompensasMaterial] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function()
	{
		ocultarEsperaAjax();
	});
}

init();
initCarrito();