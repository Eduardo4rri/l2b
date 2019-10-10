function initTiendaCompra()
{
	localStorage.setItem('tienda_paso', JSON.stringify('compra'));
	localStorage.removeItem('tienda_registro_escuelas');
	localStorage.removeItem('tienda_registro_programas');
	localStorage.removeItem('tienda_registro_escuela_seleccionada');
	localStorage.removeItem('tienda_registro_escuela_seleccionada_id');
	localStorage.removeItem('tienda_registro_programa_seleccionado');
	localStorage.removeItem('tienda_registro_programa_seleccionado_id');
	localStorage.removeItem('tienda_registro_curso_seleccionado_id');
	localStorage.removeItem('tienda_registro_consignacion_seleccionada_id');
	localStorage.removeItem('tienda_compra_escuela_seleccionada_id');
	localStorage.removeItem('tienda_compra_programa_seleccionado_id');
	localStorage.removeItem('tienda_compra_articulos');
	localStorage.removeItem('tienda_entrega_venta_id');
	$('#carrito-validar').click(function()
	{
		carritoValidar();
	});
	compraCargarDatosUsuario();
}

function compraCargarDatosUsuario()
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
			console.error('[compra.js] [compraCargarDatosUsuario] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var usuario = data.detalles, usr_telefono = usuario.usuario_telefono;
				//$('#pagina-mensaje').html('Felicidades por estar en ' + usuario.usuario_dominio.toUpperCase() + '. ¡Te deseamos mucho éxito!');
				$('#confirmacion-usuario').text(usuario.usuario_nombre + ' ' + usuario.usuario_apellido_paterno + ' ' + usuario.usuario_apellido_materno);
				$('#confirmacion-usuario-matricula').text(usuario.usuario_matricula);
				$('#confirmacion-usuario-telefono').text(usr_telefono);
				$('#confirmacion-usuario-login').text(usuario.usuario_login);
				$('#confirmacion-escuela-seleccionada').text(usuario.usuario_escuela_nombre);
				$('#confirmacion-programa-seleccionado').text(usuario.usuario_programa_nombre);
				$('#confirmacion-programa-nivel-seleccionado').text(usuario.usuario_programa_nivel);
				
				if (usuario.usuario_rol === 'alumno')
				{
				    $('#confirmacion-usuario-identificador').html('Matrícula');
				}
				else if (usuario.usuario_rol === 'coordinador_dominio' || usuario.usuario_rol === 'coordinador_zona' || usuario.usuario_rol === 'coordinador_subzona' || usuario.usuario_rol === 'coordinador_escuela')
				{
				    $('#confirmacion-usuario-identificador').html('DNI');
				}
				
				compraListarNiveles();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[compra.js] [compraCargarDatosUsuario] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function compraListarNiveles()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var tienda_compra_programa_seleccionado_id = usuario.usuario_idprograma;
	var curso_venta_activa = usuario.usuario_curso.venta_activa;
	
	if (curso_venta_activa === 0)
	{
	    var html_niveles = '<p class="m-5"><i class="fas fa-exclamation-triangle"></i> <strong>El periodo de venta de los libros de Inglés no está disponible o ya ha terminado, por favor ponte en contacto con tu escuela.</strong></p>';
	    $('#compra-niveles').empty();
		$('#compra-niveles').append(html_niveles);
		$('#compra-articulos').empty();
	    $('#compra-articulos').append(html_niveles);
		return;
	}
	
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
			console.error('[compra.js] [compraListarNiveles] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
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
					if (i == 0)
					{
						html_niveles += '<a class="nav-link active" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true" onclick="compraSeleccionarNivel(\'' + tienda_compra_articulos[i].nivel + '\');">' + tienda_compra_articulos[i].nivel + '</a>';
						primer_nivel = tienda_compra_articulos[i].nivel;

					}
					else
					{
						html_niveles += '<a class="nav-link" data-toggle="pill" role="tab" aria-controls="v-pills-home" aria-selected="true" onclick="compraSeleccionarNivel(\'' + tienda_compra_articulos[i].nivel + '\');">' + tienda_compra_articulos[i].nivel + '</a>';
					}
				}
				localStorage.setItem('tienda_compra_articulos', JSON.stringify(tienda_compra_articulos));
				$('#compra-niveles').empty();
				$('#compra-niveles').append(html_niveles);
				compraSeleccionarNivel(primer_nivel);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[compra.js] [compraListarNiveles] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function compraSeleccionarNivel(nivel)
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
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
		html_articulos += '		    <h5>$' + formatearDinero(articulos[i].precio_descuento) + '</h5>';
		html_articulos += '	    </div>';
		html_articulos += '	    <div class="card-footer">';

		if (usuario.usuario_rol === 'alumno')
		{
			html_articulos += '       <button class="btn btn-primary btn-block" id="compra-articulo-agregar" onclick="carritoAgregarArticulo(' + tienda_compra_programa_seleccionado_id + ', ' + articulos[i].idarticulo + ', 1);"><i class="fa fa-shopping-cart"></i> Seleccionar</button>';
		}
		else if (usuario.usuario_rol === 'coordinador_dominio' || usuario.usuario_rol === 'coordinador_zona' || usuario.usuario_rol === 'coordinador_escuela')
		{
			html_articulos += '	      <div class="input-group mb-3 ">';
			html_articulos += '	        <input style="text-align:center;" type="number" min="1" max="1000" step="1" pattern="0+\.[0-9]*[1-9][0-9]*$" onkeypress="return (event.charCode >= 48 && event.charCode <= 57);" class="form-control text-center" id="compra-articulo-' + articulos[i].idarticulo + '-cantidad" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon2" value="1">';
			html_articulos += '	        <div class="input-group-append">';
			html_articulos += '	          <button class="btn btn-primary" id="compra-articulo-agregar" onclick="compraSeleccionarArticulo(' + tienda_compra_programa_seleccionado_id + ', ' + articulos[i].idarticulo + ');"><i class="fa fa-shopping-cart"></i> Seleccionar</button>';
			html_articulos += '	        </div>';
			html_articulos += '	      </div>';
		}
		html_articulos += '	    </div>';
		html_articulos += ' </div>';
		html_articulos += '</div>';
	}
	$('#compra-articulos').hide();
	$('#compra-articulos').empty();
	$('#compra-articulos').append(html_articulos);
	$('#compra-articulos').fadeIn();
}

function compraSeleccionarArticulo(idprograma, idarticulo)
{
	var idcantidad = '#compra-articulo-' + idarticulo + '-cantidad';
	var cantidad = $(idcantidad).val();
	if (cantidad < 1 || cantidad > 10000)
	{
		bootbox.alert('¡La cantidad mínima posible es 1 libro y la cantidad máxima posible es 10,000 libros, por favor revisa la cantidad e intenta de nuevo!');
		return;
	}
	carritoAgregarArticulo(idprograma, idarticulo, cantidad);
}

initTiendaCompra();