function initCambioLibro()
{
	$('#cambia-tu-pedido').click(function()
	{
		cambioLibroListarNiveles();
		$('#cambio-material-modal').modal('show');
	});
}

function cambioLibroListarNiveles()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var tienda_compra_programa_seleccionado_id = usuario.usuario_idprograma;
	$.ajax(
	{
		url: '../sistema/x/tienda.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'listarNivelesPorPrograma',
			idprograma: tienda_compra_programa_seleccionado_id
		},
		error: function(xhr, status, error)
		{
			console.error('[cambio-articulo.js] [cambioLibroListarNiveles] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var tienda_compra_articulos = data.detalles;
				var html_niveles = '';
				var primer_nivel = '';
				for (var i = 0; i < tienda_compra_articulos.length; i++)
				{
					if (primer_nivel === '')
					{
						html_niveles += '<a class="nav-link active" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true" onclick="cambioLibroSeleccionarNivel(\'' + tienda_compra_articulos[i].nivel + '\');">' + tienda_compra_articulos[i].nivel + '</a>';
						primer_nivel = tienda_compra_articulos[i].nivel;
					}
					else
					{
						html_niveles += '<a class="nav-link" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true" onclick="cambioLibroSeleccionarNivel(\'' + tienda_compra_articulos[i].nivel + '\');">' + tienda_compra_articulos[i].nivel + '</a>';
					}
				}
				localStorage.setItem('tienda_compra_articulos', JSON.stringify(tienda_compra_articulos));
				$('#compra-niveles').empty();
				$('#compra-niveles').append(html_niveles);
				cambioLibroSeleccionarNivel(primer_nivel);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cambio-articulo.js] [cambioLibroListarNiveles] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cambio-articulo.js] [cambioLibroListarNiveles] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function cambioLibroSeleccionarNivel(nivel)
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var tienda_entrega_venta_id = JSON.parse(localStorage.getItem('tienda_entrega_venta_id'));
	var tienda_compra_programa_seleccionado_id = usuario.usuario_idprograma;
	var tienda_compra_articulos = JSON.parse(localStorage.getItem('tienda_compra_articulos'));
	var nivel_seleccionado = '{}';
	var nivel_modal_default = 'ADVANCED';
	for (var i = 0; i < tienda_compra_articulos.length; i++)
	{
		if (tienda_compra_articulos[i].nivel == nivel)
		{
			nivel_seleccionado = tienda_compra_articulos[i];
			break;
		}
	}
	var articulos = nivel_seleccionado.articulos;
	var html_articulos = '';
	for (var i = 0; i < articulos.length; i++)
	{
		html_articulos += '<div class="col-md-5 col-xs-4 seccion-articulos-responsive">';
		html_articulos += ' <div class="card">';
		html_articulos += '	    <div class="card-header">';
		html_articulos += '		    <h5 class="text-center">' + articulos[i].serie + '</h5>';
		html_articulos += '	    </div>';
		html_articulos += '	    <a><img class="card-img-top" src="data:image/png;base64, ' + articulos[i].imagen + '"></a>';
		html_articulos += '	    <div class="card-body">';
		html_articulos += '		    <h6>' + articulos[i].descripcion + '</h6>';
		html_articulos += '	    </div>';
		html_articulos += '	    <div class="card-footer">';
		html_articulos += '       <button class="btn btn-primary btn-block" onclick="cambiarArticuloConfirmacion(' + tienda_entrega_venta_id + ', ' + tienda_compra_programa_seleccionado_id + ', ' + articulos[i].idarticulo + ');"><i class="fa fa-shopping-cart"></i> Cambiar Libro</button>';
		html_articulos += '	    </div>';
		html_articulos += ' </div>';
		html_articulos += '</div>';
	}
	$('#cambio-libro-articulos').hide();
	$('#cambio-libro-articulos').empty();
	$('#cambio-libro-articulos').append(html_articulos);
	$('#cambio-libro-articulos').fadeIn();
}

function cambiarArticuloConfirmacion(idventa, idprograma, idarticulo)
{
	bootbox.confirm(
	{
		message: "¿Proceder con el cambio de libro?",
		buttons:
		{
			confirm:
			{
				label: 'Si',
				className: 'btn-success'
			},
			cancel:
			{
				label: 'No',
				className: 'btn-danger'
			}
		},
		callback: function(result)
		{
			if (result === true)
			{
				cambiarArticulo(idventa, idprograma, idarticulo);
			}
		}
	});
}

function cambiarArticulo(idventa, idprograma, idarticulo)
{
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/venta_articulo.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'cambiarArticuloEnVentaAlumno',
			idventa: idventa,
			idprograma: idprograma,
			idarticulo: idarticulo
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[cambio-articulo.js] [cambiarArticulo] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				location.reload(true);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cambio-articulo.js] [cambiarArticulo] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cambio-articulo.js] [cambiarArticulo] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

initCambioLibro();