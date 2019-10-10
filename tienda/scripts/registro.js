function initTiendaRegistro()
{
	localStorage.setItem('tienda_paso', JSON.stringify('registro'));
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
	$('#tienda-escuela').hide();
	$('#tienda-programa').hide();
	$('#tienda-pre-confirmar-registro-cambio-escuela-programa').hide();
	$('#usuario-nombre').change(function()
	{
		tiendaRegistroValidarDatosUsuario('usuario-nombre');
	});
	$('#usuario-apellido-paterno').change(function()
	{
		tiendaRegistroValidarDatosUsuario('usuario-apellido-paterno');
	});
	$('#usuario-apellido-materno').change(function()
	{
		tiendaRegistroValidarDatosUsuario('usuario-apellido-materno');
	});
	$('#usuario-matricula').change(function()
	{
		tiendaRegistroValidarDatosUsuario('usuario-matricula');
	});
	$('#usuario-telefono').change(function()
	{
		tiendaRegistroValidarDatosUsuario('usuario-telefono');
	});
	$('#usuario-lada').change(function()
	{
		tiendaRegistroValidarDatosUsuario('usuario-lada');
	});
	$('#usuario-login').change(function()
	{
		tiendaRegistroValidarDatosUsuario('usuario-login');
	});
	$('#usuario-terminos-condiciones').change(function()
	{
		tiendaRegistroValidarDatosUsuario('usuario-terminos-condiciones');
	});
	$('#tienda-pre-confirmar-registro').click(function()
	{
		tiendaRegistroPreConfirmarRegistro();
	});
	$('#tienda-pre-confirmar-registro-cambio-escuela-programa').click(function()
	{
		tiendaRegistroPreConfirmarRegistroCambioEscuelaPrograma();
	});
	$('#tienda-confirmar-registro').click(function()
	{
		tiendaRegistroConfirmarRegistro();
	});
	$('#tienda-form-alias-nombre').on('submit', function(e)
	{
		e.preventDefault();
		var usuario = JSON.parse(localStorage.getItem('usuario'));
		var dominio = usuario.usuario_dominio;
		var alias = limpiarString($('#alias').val());
		var nombre = limpiarString($('#nombre').val());
		$('#tienda-escuela').fadeOut();
		if (!alias && !nombre)
		{
			bootbox.alert('Por favor proporciona un alias o un nombre para realizar la búsqueda');
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
				op: 'listarEscuelasPorAliasNombre',
				alias: alias,
				nombre: nombre,
				dominio: dominio
			},
			error: function(xhr, status, error)
			{
				console.error('[registro.js] [initTiendaRegistro] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
				bootbox.alert('Error connecting to the server, please contact support or try again later...');
			},
			success: function(data)
			{
				if (data.resultado === 'OK')
				{
					var tienda_registro_escuelas = data.detalles;
					for (var i = 0; i < tienda_registro_escuelas.length; i++)
					{
						var html = '<button class="btn btn-warning" onclick="tiendaRegistroSeleccionarEscuela(' + tienda_registro_escuelas[i].idescuela + ');"><i class="fa fa-check"></i> Confirmar</button>';
						tienda_registro_escuelas[i].opc_seleccionar = html;
					}
					localStorage.setItem('tienda_registro_escuelas', JSON.stringify(tienda_registro_escuelas));
					tiendaRegistroListarEscuelas();
				}
    			else if (data.resultado === 'ERROR_TOKEN')
    			{
    				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
    				bootbox.alert(data.mensaje);
    				$(location).attr('href', '../login.php');
    			}
				else
				{
					console.warn('[registro.js] [initTiendaRegistro] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
					bootbox.alert(data.mensaje);
				}
			}
		}).done(function() {});
	});
	$('#tienda-form-direccion').on('submit', function(e)
	{
		e.preventDefault();
		var usuario = JSON.parse(localStorage.getItem('usuario'));
		var dominio = usuario.usuario_dominio;
		var estado = limpiarString($('#estado').val());
		var ciudad = limpiarString($('#ciudad').val());
		var codigo_postal = $('#codigo-postal').val();
		$('#tienda-escuela').fadeOut();
		if (!estado && !ciudad && !codigo_postal)
		{
			bootbox.alert('Por favor proporciona un estado, una ciudad, un código postal una combinación de dichos datos pare realizar la búsqueda');
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
				op: 'listarEscuelasPorDireccion',
				estado: estado,
				ciudad: ciudad,
				codigo_postal: codigo_postal,
				dominio: dominio
			},
			error: function(xhr, status, error)
			{
				console.error('[registro.js] [initTiendaRegistro] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
				bootbox.alert('Error connecting to the server, please contact support or try again later...');
			},
			success: function(data)
			{
				if (data.resultado === 'OK')
				{
					var tienda_registro_escuelas = data.detalles;
					for (var i = 0; i < tienda_registro_escuelas.length; i++)
					{
						var html = '<button class="btn btn-warning" onclick="tiendaRegistroSeleccionarEscuela(' + tienda_registro_escuelas[i].idescuela + ');"><i class="fa fa-check"></i> Confirmar</button>';
						tienda_registro_escuelas[i].opc_seleccionar = html;
					}
					localStorage.setItem('tienda_registro_escuelas', JSON.stringify(tienda_registro_escuelas));
					tiendaRegistroListarEscuelas();
				}
    			else if (data.resultado === 'ERROR_TOKEN')
    			{
    				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
    				bootbox.alert(data.mensaje);
    				$(location).attr('href', '../login.php');
    			}
				else
				{
					console.warn('[registro.js] [initTiendaRegistro] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
					bootbox.alert(data.mensaje);
				}
			}
		}).done(function() {});
	});
	tiendaRegistroCargarDatosUsuario();
}

function tiendaRegistroCargarDatosUsuario()
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
			console.error('[registro.js] [tiendaRegistroCargarDatosUsuario] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var usuario = data.detalles;
				var usr_telefono = usuario.usuario_telefono;
				usr_telefono += '';
				var primera_validacion = usr_telefono.indexOf('(');
				var segunda_validacion = usr_telefono.indexOf(')');
				if (primera_validacion >= 0 && segunda_validacion >= 0)
				{
					var split_usr_telefono = usr_telefono.split(')');
					var usr_lada = split_usr_telefono[0].substring(1, split_usr_telefono[0].length);
					var usr_numero = split_usr_telefono[1];
					$('#usuario-lada').val(usr_lada);
					$('#usuario-telefono').val(usr_numero);
				}
				else
				{
					$('#usuario-telefono').val(usuario.usuario_telefono);
				}
				//$('#pagina-mensaje').html('Felicidades por estar en ' + usuario.usuario_dominio.toUpperCase() + '. ¡Te deseamos mucho éxito!');
				$('#usuario-id').val(usuario.usuario_idusuario);
				$('#usuario-nombre').val(usuario.usuario_nombre);
				$('#usuario-apellido-paterno').val(usuario.usuario_apellido_paterno);
				$('#usuario-apellido-materno').val(usuario.usuario_apellido_materno);
				$('#usuario-matricula').val(usuario.usuario_matricula);
				$('#usuario-login').val(usuario.usuario_login);
				$('#usuario-terminos-condiciones').attr('checked', usuario.usuario_terminos_condiciones == 1 ? true : false);
				$('#usuario-escuela').text(usuario.usuario_escuela_nombre);
				$('#usuario-programa').text(usuario.usuario_programa_nombre);
				$('#usuario-programa-nivel').text(usuario.usuario_programa_nivel);
				if (!usuario.usuario_idescuela || usuario.usuario_idescuela == 0)
				{
					$('#usuario-idescuela').val('');
					$('#usuario-escuela').text('Sin escuela, favor de seleccionar');
					$('#usuario-escuela-nombre').val('');
				}
				else
				{
					$('#usuario-idescuela').val(usuario.usuario_idescuela);
					$('#usuario-escuela').text(usuario.usuario_escuela_nombre);
					$('#usuario-escuela-nombre').val(usuario.usuario_escuela_nombre);
				}
				if (!usuario.usuario_idprograma || usuario.usuario_idprograma == 0)
				{
					$('#usuario-idprograma').val('');
					$('#usuario-programa').text('Sin programa de Inglés, favor de seleccionar');
					$('#usuario-programa-nombre').val('');
				}
				else
				{
					$('#usuario-idprograma').val(usuario.usuario_idprograma);
					$('#usuario-programa').text(usuario.usuario_programa_nombre);
					$('#usuario-programa-nombre').val(usuario.programa_nombre);
				}
				if (!usuario.usuario_idcurso || usuario.usuario_idcurso == 0)
				{
					$('#usuario-idcurso').val('');
				}
				else
				{
					$('#usuario-idcurso').val(usuario.usuario_idcurso);
				}
				if (!usuario.usuario_idconsignacion || usuario.usuario_idconsignacion == 0)
				{
					$('#usuario-idconsignacion').val('');
				}
				else
				{
					$('#usuario-idconsignacion').val(usuario.usuario_idconsignacion);
				}
				localStorage.setItem('tienda_registro_escuela_seleccionada_id', JSON.stringify(usuario.usuario_idescuela));
				localStorage.setItem('tienda_registro_programa_seleccionado_id', JSON.stringify(usuario.usuario_idprograma));
				localStorage.setItem('tienda_registro_curso_seleccionado_id', JSON.stringify(usuario.usuario_idcurso));
				localStorage.setItem('tienda_registro_consignacion_seleccionada_id', JSON.stringify(usuario.usuario_idconsignacion));
				
				if (usuario.usuario_rol === 'alumno')
				{
				    $('#confirmacion-usuario-identificador').html('Matrícula');
				    $('#usuario-identificador').html('Matrícula');
				}
				else if (usuario.usuario_rol === 'coordinador_dominio' || usuario.usuario_rol === 'coordinador_zona' || usuario.usuario_rol === 'coordinador_subzona' || usuario.usuario_rol === 'coordinador_escuela')
				{
				    $('#confirmacion-usuario-identificador').html('DNI');
				    $('#usuario-identificador').html('DNI');
				}
				
				var validacion = tiendaRegistroValidarDatosUsuario('todos');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[registro.js] [tiendaRegistroCargarDatosUsuario] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function tiendaRegistroListarEscuelas()
{
	var tienda_registro_escuelas = JSON.parse(localStorage.getItem('tienda_registro_escuelas'));
	$('#tienda-escuela').fadeOut();
	$('#tienda-programa').fadeOut();
	$('#tienda-pre-confirmar-registro-cambio-escuela-programa').fadeOut();
	$('#tienda-escuela').fadeIn();
	$('#tienda-tabla-escuelas').DataTable(
	{
		destroy: true,
		responsive: true,
		searching: false,
		paging: false,
		ordering: false,
		info: false,
		scrollY: '300px',
		scrollX: true,
		scrollCollapse: true,
		columnDefs: [
		{
			width: 200,
			targets: 0
		}],
		language:
		{
			lengthMenu: 'Mostrar  _MENU_  registros',
			search: 'Filtrar',
			zeroRecords: 'No se encontraron registros',
			infoFiltered: '(Se filtraron _MAX_ registros totales)',
			info: 'Mostrando _START_ a _END_ de _TOTAL_ registros totales',
			paginate:
			{
				first: 'Primero',
				last: 'Último',
				next: 'Siguiente',
				previous: 'Anterior'
			},
		},
		data: tienda_registro_escuelas,
		columns: [
		{
			title: 'Alias',
			data: 'alias'
		},
		{
			title: 'Nombre',
			data: 'nombre'
		},
		{
			title: 'Campus',
			data: 'campus'
		},
		{
			title: 'Ciudad',
			data: 'ciudad'
		},
		{
			title: 'Estado',
			data: 'estado'
		},
		{
			title: 'CP',
			data: 'codigo_postal'
		},
		{
			title: 'Seleccionar',
			data: 'opc_seleccionar'
		}]
	});
	$('#tienda-programa').fadeOut();
	$('#tienda-pre-confirmar-registro-cambio-escuela-programa').fadeOut();
}

function tiendaRegistroSeleccionarEscuela(idescuela)
{
	var tienda_registro_escuelas = JSON.parse(localStorage.getItem('tienda_registro_escuelas'));
	var tienda_registro_escuela_seleccionada = '{}';
	$('#tienda-programa').fadeOut();
	$('#tienda-pre-confirmar-registro-cambio-escuela-programa').fadeOut();
	for (var i = 0; i < tienda_registro_escuelas.length; i++)
	{
		if (tienda_registro_escuelas[i].idescuela == idescuela)
		{
			tienda_registro_escuela_seleccionada = tienda_registro_escuelas[i];
			tienda_registro_escuela_seleccionada_id = tienda_registro_escuelas[i].idescuela;
			break;
		}
	}
	localStorage.setItem('tienda_registro_escuela_seleccionada', JSON.stringify(tienda_registro_escuela_seleccionada));
	localStorage.setItem('tienda_registro_escuela_seleccionada_id', JSON.stringify(tienda_registro_escuela_seleccionada_id));
	$.ajax(
	{
		url: '../sistema/x/tienda.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'listarProgramasPorEscuela',
			idescuela: idescuela
		},
		error: function(xhr, status, error)
		{
			console.error('[registro.js] [tiendaRegistroSeleccionarEscuela] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var tienda_registro_programas = data.detalles;
				for (var i = 0; i < tienda_registro_programas.length; i++)
				{
					var html = '<button class="btn btn-warning" onclick="tiendaRegistroSeleccionarPrograma(' + tienda_registro_programas[i].idprograma + ',' + tienda_registro_programas[i].idcurso + ',' + tienda_registro_programas[i].idconsignacion + ');"><i class="fa fa-check"></i> Confirmar</button>';
					tienda_registro_programas[i].opc_seleccionar = html;
				}
				localStorage.setItem('tienda_registro_programas', JSON.stringify(tienda_registro_programas));
				tiendaRegistroListarProgramas();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[registro.js] [tiendaRegistroSeleccionarEscuela] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function tiendaRegistroListarProgramas()
{
	var tienda_registro_programas = JSON.parse(localStorage.getItem('tienda_registro_programas'));
	$('#tienda-programa').fadeOut();
	$('#tienda-pre-confirmar-registro-cambio-escuela-programa').fadeOut();
	$('#tienda-programa').fadeIn();
	$('#tienda-tabla-programas').DataTable(
	{
		destroy: true,
		responsive: true,
		searching: false,
		paging: false,
		ordering: false,
		info: false,
		scrollY: '300px',
		scrollX: true,
		scrollCollapse: true,
		columnDefs: [
		{
			width: 200,
			targets: 0
		}],
		language:
		{
			lengthMenu: 'Mostrar  _MENU_  registros',
			search: 'Filtrar',
			zeroRecords: 'No se encontraron registros',
			infoFiltered: '(Se filtraron _MAX_ registros totales)',
			info: 'Mostrando _START_ a _END_ de _TOTAL_ registros totales',
			paginate:
			{
				first: 'Primero',
				last: 'Último',
				next: 'Siguiente',
				previous: 'Anterior'
			},
		},
		data: tienda_registro_programas,
		columns: [
		{
			title: 'Nombre',
			data: 'nombre'
		},
		{
			title: 'Niveles',
			data: 'nivel'
		},
		{
			title: 'Descripción',
			data: 'descripcion'
		},
		{
			title: 'Curso',
			data: 'curso'
		},
		{
			title: 'Seleccionar',
			data: 'opc_seleccionar'
		}]
	});
}

function tiendaRegistroSeleccionarPrograma(idprograma, idcurso, idconsignacion)
{
	var tienda_registro_programas = JSON.parse(localStorage.getItem('tienda_registro_programas'));
	var tienda_registro_programa_seleccionado = '{}';
	$('#tienda-pre-confirmar-registro-cambio-escuela-programa').fadeOut();
	for (var i = 0; i < tienda_registro_programas.length; i++)
	{
		if (tienda_registro_programas[i].idprograma == idprograma && tienda_registro_programas[i].idcurso == idcurso && tienda_registro_programas[i].idconsignacion == idconsignacion)
		{
			tienda_registro_programa_seleccionado = tienda_registro_programas[i];
			tienda_registro_programa_seleccionado_id = tienda_registro_programas[i].idprograma;
			tienda_registro_curso_seleccionado_id = tienda_registro_programas[i].idcurso;
			tienda_registro_consignacion_seleccionada_id = tienda_registro_programas[i].idconsignacion;
			break;
		}
	}
	localStorage.setItem('tienda_registro_programa_seleccionado', JSON.stringify(tienda_registro_programa_seleccionado));
	localStorage.setItem('tienda_registro_programa_seleccionado_id', JSON.stringify(tienda_registro_programa_seleccionado_id));
	localStorage.setItem('tienda_registro_curso_seleccionado_id', JSON.stringify(tienda_registro_curso_seleccionado_id));
	localStorage.setItem('tienda_registro_consignacion_seleccionada_id', JSON.stringify(tienda_registro_consignacion_seleccionada_id));
	$('#tienda-pre-confirmar-registro-cambio-escuela-programa').fadeIn();
}

function tiendaRegistroValidarEmail(email)
{
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

function tiendaRegistroValidarDatosUsuario(campo)
{
	var errores = 0;
	if (campo === 'todos' || campo === 'usuario-nombre')
	{
		if (!$('#usuario-nombre').val().trim())
		{
			$('#usuario-nombre').removeClass('is-valid');
			$('#usuario-nombre').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-nombre').removeClass('is-invalid');
			$('#usuario-nombre').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-apellido-paterno')
	{
		if (!$('#usuario-apellido-paterno').val().trim())
		{
			$('#usuario-apellido-paterno').removeClass('is-valid');
			$('#usuario-apellido-paterno').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-apellido-paterno').removeClass('is-invalid');
			$('#usuario-apellido-paterno').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-apellido-materno')
	{
		if (!$('#usuario-apellido-materno').val().trim())
		{
			$('#usuario-apellido-materno').removeClass('is-valid');
			$('#usuario-apellido-materno').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-apellido-materno').removeClass('is-invalid');
			$('#usuario-apellido-materno').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-matricula')
	{
		if (!$('#usuario-matricula').val().trim())
		{
			$('#usuario-matricula').removeClass('is-valid');
			$('#usuario-matricula').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-matricula').removeClass('is-invalid');
			$('#usuario-matricula').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-telefono')
	{
		if (!$('#usuario-telefono').val().trim())
		{
			$('#usuario-telefono').removeClass('is-valid');
			$('#usuario-telefono').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-telefono').removeClass('is-invalid');
			$('#usuario-telefono').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-lada')
	{
		if (!$('#usuario-lada').val().trim())
		{
			$('#usuario-lada').removeClass('is-valid');
			$('#usuario-lada').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-lada').removeClass('is-invalid');
			$('#usuario-lada').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-login')
	{
		if (!$('#usuario-login').val().trim() || !tiendaRegistroValidarEmail($('#usuario-login').val().trim()))
		{
			$('#usuario-login').removeClass('is-valid');
			$('#usuario-login').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-login').removeClass('is-invalid');
			$('#usuario-login').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-terminos-condiciones')
	{
		if (!$('#usuario-terminos-condiciones').is(':checked') == true)
		{
			$('#usuario-terminos-condiciones').removeClass('is-valid');
			$('#usuario-terminos-condiciones').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-terminos-condiciones').removeClass('is-invalid');
			$('#usuario-terminos-condiciones').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-escuela')
	{
		if (!$('#usuario-idescuela').val().trim())
		{
			$('#usuario-escuela').removeClass('is-valid');
			$('#usuario-escuela').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-escuela').removeClass('is-invalid');
			$('#usuario-escuela').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-programa')
	{
		if (!$('#usuario-idprograma').val().trim())
		{
			$('#usuario-programa').removeClass('is-valid');
			$('#usuario-programa').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-programa').removeClass('is-invalid');
			$('#usuario-programa').addClass('is-valid');
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

function tiendaRegistroPreConfirmarRegistro()
{
	var usuario_nombre = $('#usuario-nombre').val() + ' ' + $('#usuario-apellido-paterno').val() + ' ' + $('#usuario-apellido-materno').val();
	var usuario_matricula = $('#usuario-matricula').val();
	var usuario_telefono = $('#usuario-telefono').val();
	var usuario_login = $('#usuario-login').val();
	var tienda_registro_escuela_seleccionada = $('#usuario-escuela').text();
	var tienda_registro_programa_seleccionado = $('#usuario-programa').text();
	var tienda_registro_programa_nivel_seleccionado = $('#usuario-programa-nivel').text();
	var lada = $('#usuario-lada').val();
	var usuario_telefono_sin_lada = $('#usuario-telefono').val();
	var telefono = '(' + lada + ')' + usuario_telefono_sin_lada;
    
    if(limpiarString(telefono).length != 10)
	{   
	        $('#usuario-lada').removeClass('is-valid');
	        $('#usuario-lada').addClass('is-invalid');
	        $('#usuario-telefono').removeClass('is-valid');
		    $('#usuario-telefono').addClass('is-invalid');
		    
	    bootbox.alert('Hay errores de validación en tu teléfono, por favor completa correctamente este campo');
		return;
	}
	
	$('#confirmacion-usuario-nombre').text(usuario_nombre);
	$('#confirmacion-usuario-matricula').text(usuario_matricula);
	$('#confirmacion-usuario-telefono').text(telefono);
	$('#confirmacion-usuario-login').text(usuario_login);
	$('#confirmacion-escuela-seleccionada').text(tienda_registro_escuela_seleccionada);
	$('#confirmacion-programa-seleccionado').text(tienda_registro_programa_seleccionado);
	$('#confirmacion-programa-nivel-seleccionado').text(tienda_registro_programa_nivel_seleccionado);
	var validacion = tiendaRegistroValidarDatosUsuario('todos');
	if (validacion == false)
	{
		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	$('#registro-confirmacion-modal').modal('show');
}

function tiendaRegistroPreConfirmarRegistroCambioEscuelaPrograma()
{
	$('#escuela-programa-collapse').collapse('hide');
	var usuario_nombre = $('#usuario-nombre').val() + ' ' + $('#usuario-apellido-paterno').val() + ' ' + $('#usuario-apellido-materno').val();
	var usuario_matricula = $('#usuario-matricula').val();
	var usuario_telefono = $('#usuario-telefono').val();
	var usuario_login = $('#usuario-login').val();
	var tienda_registro_escuela_seleccionada = JSON.parse(localStorage.getItem('tienda_registro_escuela_seleccionada'));
	var tienda_registro_escuela_seleccionada_id = JSON.parse(localStorage.getItem('tienda_registro_escuela_seleccionada_id'));
	var tienda_registro_programa_seleccionado = JSON.parse(localStorage.getItem('tienda_registro_programa_seleccionado'));
	var tienda_registro_programa_seleccionado_id = JSON.parse(localStorage.getItem('tienda_registro_programa_seleccionado_id'));
	var tienda_registro_curso_seleccionado_id = JSON.parse(localStorage.getItem('tienda_registro_curso_seleccionado_id'));
	var tienda_registro_consignacion_seleccionada_id = JSON.parse(localStorage.getItem('tienda_registro_consignacion_seleccionada_id'));
	$('#confirmacion-usuario-nombre').text(usuario_nombre);
	$('#confirmacion-usuario-matricula').text(usuario_matricula);
	$('#confirmacion-usuario-telefono').text(usuario_telefono);
	$('#confirmacion-usuario-login').text(usuario_login);
	$('#confirmacion-escuela-seleccionada').text(tienda_registro_escuela_seleccionada.nombre);
	$('#confirmacion-programa-seleccionado').text(tienda_registro_programa_seleccionado.nombre);
	$('#confirmacion-programa-nivel-seleccionado').text(tienda_registro_programa_seleccionado.nivel);
	$('#usuario-idescuela').val(tienda_registro_escuela_seleccionada_id);
	$('#usuario-escuela-nombre').val(tienda_registro_escuela_seleccionada.nombre);
	$('#usuario-idprograma').val(tienda_registro_programa_seleccionado_id);
	$('#usuario-programa-nombre').val(tienda_registro_programa_seleccionado.nombre);
	$('#usuario-escuela').text(tienda_registro_escuela_seleccionada.nombre);
	$('#usuario-programa').text(tienda_registro_programa_seleccionado.nombre);
	$('#usuario-idcurso').val(tienda_registro_curso_seleccionado_id);
	$('#usuario-idconsignacion').val(tienda_registro_consignacion_seleccionada_id);
	var validacion = tiendaRegistroValidarDatosUsuario('todos');
	if (validacion == false)
	{
		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	$('#registro-confirmacion-modal').modal('show');
}

function tiendaRegistroConfirmarRegistro()
{
	var tienda_registro_escuela_seleccionada = JSON.parse(localStorage.getItem('tienda_registro_escuela_seleccionada'));
	var tienda_registro_programa_seleccionado = JSON.parse(localStorage.getItem('tienda_registro_programa_seleccionado'));
	var lada = $('#usuario-lada').val();
	var telefono_sin_lada = $('#usuario-telefono').val();
	var telefono = '(' + lada + ')' + telefono_sin_lada;
	$.ajax(
	{
		url: '../sistema/x/usuario.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'actualizarUsuario',
			idusuario: $('#usuario-id').val(),
			nombre: limpiarString($('#usuario-nombre').val()),
			apellido_paterno: limpiarString($('#usuario-apellido-paterno').val()),
			apellido_materno: limpiarString($('#usuario-apellido-materno').val()),
			telefono: telefono,
			login:$('#usuario-login').val(),
			matricula: $('#usuario-matricula').val(),
			terminos_condiciones: $('#usuario-terminos-condiciones').is(':checked') == true ? 1 : 0,
			idescuela: $('#usuario-idescuela').val(),
			idprograma: $('#usuario-idprograma').val(),
			idcurso: $('#usuario-idcurso').val(),
			idconsignacion: $('#usuario-idconsignacion').val()
		},
		error: function(xhr, status, error)
		{
			console.error('[registro.js] [tiendaRegistroConfirmarRegistro] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var usuario = data.detalles;
				localStorage.setItem('usuario', JSON.stringify(usuario));
				$(location).attr('href', 'compra.php');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[registro.js] [tiendaRegistroConfirmarRegistro] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

initTiendaRegistro();