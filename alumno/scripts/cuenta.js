function init()
{
	crearTablaVentas();
	cargarDatosUsuario();
	listarProgramaCursosEscuela();
	$('#usuario-nombre').change(function()
	{
		validarDatosUsuario('usuario-nombre');
	});
	$('#usuario-apellido-paterno').change(function()
	{
		validarDatosUsuario('usuario-apellido-paterno');
	});
	$('#usuario-apellido-materno').change(function()
	{
		validarDatosUsuario('usuario-apellido-materno');
	});
	$('#usuario-matricula').change(function()
	{
		validarDatosUsuario('usuario-matricula');
	});
	$('#usuario-telefono').change(function()
	{
		validarDatosUsuario('usuario-telefono');
	});
	$('#usuario-lada').change(function()
	{
		validarDatosUsuario('usuario-lada');
	});
	$('#usuario-login').change(function()
	{
		validarDatosUsuario('usuario-login');
	});
	$('#usuario-clave').change(function()
	{
		$('#usuario-clave-confirmar').val('');
		validarClaveUsuario('usuario-clave');
		validarClaveUsuario('usuario-clave-confirmar');
	});
	$('#usuario-clave-confirmar').change(function()
	{
		validarClaveUsuario('usuario-clave-confirmar');
	});
	$('#usuario-terminos-condiciones').change(function()
	{
		validarDatosUsuario('usuario-terminos-condiciones');
	});
	$('#usuario-guardar-datos').click(function()
	{
		guardarDatosUsuario();
	});
	$('#usuario-guardar-clave').click(function()
	{
		guardarClaveUsuario();
	});
	$('#curso-select').html('<option value="">Seleccionar curso</option>');
	$('#curso-select').selectpicker('refresh');
	$('#curso-select').change(function()
	{
		listarVentasDeAlumnoPorCurso();
	});
}

function cargarDatosUsuario()
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
			console.error('[cuenta.js] [cargarDatosUsuario] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
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
				$('#usuario-id').val(usuario.usuario_idusuario);
				$('#usuario-nombre').val(usuario.usuario_nombre);
				$('#usuario-apellido-paterno').val(usuario.usuario_apellido_paterno);
				$('#usuario-apellido-materno').val(usuario.usuario_apellido_materno);
				$('#usuario-matricula').val(usuario.usuario_matricula);
				$('#usuario-login').val(usuario.usuario_login);
				$('#usuario-terminos-condiciones').attr('checked', usuario.usuario_terminos_condiciones == 1 ? true : false);
				$('#usuario-escuela').val(usuario.usuario_escuela_nombre);
				$('#usuario-programa').val(usuario.usuario_programa_nombre);
				$('#usuario-programa-nivel').val(usuario.usuario_programa_nivel);
				$('#confirmacion-usuario').text(usuario.usuario_nombre + ' ' + usuario.usuario_apellido_paterno + ' ' + usuario.usuario_apellido_materno);
				$('#confirmacion-usuario-matricula').text(usuario.usuario_matricula);
				$('#confirmacion-usuario-telefono').text(usuario.usuario_telefono);
				$('#confirmacion-usuario-login').text(usuario.usuario_login);
				$('#confirmacion-escuela-nombre').text(usuario.usuario_escuela_nombre);
				$('#confirmacion-usuario-programa-nombre').text(usuario.usuario_programa_nombre);
				$('#confirmacion-usuario-programa-nivel').text(usuario.usuario_programa_nivel);
				var validacion = validarDatosUsuario('todos');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function crearTablaVentas()
{
	var table = $('#tabla-pedidos').DataTable(
	{
		destroy: true,
        responsive: true,
        searching: true,
        paging: false,
        ordering: true,
        info: false,
        //scrollY: '2000px',
        //scrollX: true,
        scrollCollapse: true,
        columnDefs: [{
            width: 200,
            targets: 0
        }],
		language:
		{
			lengthMenu: 'Mostrar  _MENU_  registros',
			search: 'Filtrar',
			zeroRecords: ' ',
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
		select:
		{
			style: 'multi',
			selector: 'td:nth-child(3)'
		},
		data: null,
		columns: [
		{
			title: 'Compra',
			data: 'idventa'
		},
		{
			title: 'Nivel',
			data: 'nivel'
		},
		{
			title: 'Libro',
			data: 'articulo'
		},
		{
			title: 'Fecha y hora de la compra',
			data: 'fecha_hora'
		},
		{
			title: 'Fecha de entrega prevista',
			data: 'fecha_entrega_prevista'
		},
		{
			title: 'Estatus del Pago',
			data: 'estatus_pago_leyenda'
		},
		{
			title: 'Fecha del Pago',
			data: 'pago_fecha_hora'
		},
		{
			title: 'Forma de pago',
			data: 'tipo_pago'
		},
		{
			title: 'Referencia de pago',
			data: 'pago_referencia'
		},
		{
			title: 'Total de la compra',
			data: 'total'
		},
		{
			title: 'Comprobante',
			data: 'comprobante'
		}]
	});
}

function validarEmail(email)
{
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

function validarDatosUsuario(campo)
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
	if (campo === 'todos' || campo === 'usuario-login')
	{
		if (!$('#usuario-login').val().trim() || !validarEmail($('#usuario-login').val().trim()))
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
	if (errores == 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function validarClaveUsuario(campo)
{
	var errores = 0;
	if (campo === 'todos' || campo === 'usuario-clave')
	{
		if (!$('#usuario-clave').val().trim() || $('#usuario-clave').val().trim().length < 6)
		{
			$('#usuario-clave').removeClass('is-valid');
			$('#usuario-clave').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-clave').removeClass('is-invalid');
			$('#usuario-clave').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'usuario-clave-confirmar')
	{
		if (!$('#usuario-clave-confirmar').val().trim() || $('#usuario-clave-confirmar').val().trim().length < 6 || $('#usuario-clave').val().trim() != $('#usuario-clave-confirmar').val().trim())
		{
			$('#usuario-clave-confirmar').removeClass('is-valid');
			$('#usuario-clave-confirmar').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#usuario-clave-confirmar').removeClass('is-invalid');
			$('#usuario-clave-confirmar').addClass('is-valid');
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

function guardarDatosUsuario()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var validacion = validarDatosUsuario('todos');
	var lada = $('#usuario-lada').val();
	var telefono_sin_lada = $('#usuario-telefono').val();
	var telefono = '(' + lada + ')' + telefono_sin_lada;
	
	if(limpiarString(telefono).length != 10)
	{   
	   
	        $('#usuario-lada').removeClass('is-valid');
	        $('#usuario-lada').addClass('is-invalid');
	        $('#usuario-telefono').removeClass('is-valid');
		    $('#usuario-telefono').addClass('is-invalid');

	    bootbox.alert('Hay errores de validación en tu teléfono, por favor completa correctamente este campo');
		return;
	}
	
	if (validacion === false)
	{
		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/usuario.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'actualizarUsuario',
			idusuario: usuario.usuario_idusuario,
			nombre: limpiarString($('#usuario-nombre').val()),
			apellido_paterno: limpiarString($('#usuario-apellido-paterno').val()),
			apellido_materno: limpiarString($('#usuario-apellido-materno').val()),
			telefono: telefono,
			login:$('#usuario-login').val(),
			matricula: limpiarString($('#usuario-matricula').val()),
			terminos_condiciones: $('#usuario-terminos-condiciones').is(':checked') == true ? 1 : 0,
			idescuela: usuario.usuario_idescuela,
			idprograma: usuario.usuario_idprograma
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[cuenta.js] [guardarDatosUsuario] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				cargarDatosUsuario();
				$('#usuario-modal').modal('hide');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cuenta.js] [guardarDatosUsuario] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function guardarClaveUsuario()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var validacion = validarClaveUsuario('todos');
	if (validacion == false)
	{
		bootbox.alert('Hay errores de validación en tu contraseña, por favor revisala, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	mostrarEsperaAjax('');
	$.ajax(
	{
		url: '../sistema/x/usuario.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'actualizarUsuarioClave',
			idusuario: usuario.usuario_idusuario,
			clave: $('#usuario-clave').val()
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[cuenta.js] [guardarClaveUsuario] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				cargarDatosUsuario();
				$('#usuario-clave-modal').modal('hide');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cuenta.js] [guardarClaveUsuario] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function listarProgramaCursosEscuela()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax(
	{
		url: '../sistema/x/programa.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'listarProgramaCursosEscuela',
			idescuela: usuario.usuario_idescuela
		},
		error: function(xhr, status, error)
		{
			console.error('[cuenta.js] [listarProgramaCursosEscuela] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var ndata = data.detalles,
					html_cursos = '<option value="">Selecciona un curso</option>';
				for (var i = 0; i < ndata.length; i++)
				{
					html_cursos += '<option value="' + ndata[i].idcurso + '">' + ndata[i].curso_nombre + '</option>';
				}
				$('#curso-select').html(html_cursos);
				$('#curso-select').selectpicker('refresh');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cuenta.js] [listarProgramaCursosEscuela] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function listarVentasDeAlumnoPorCurso()
{
	var usuario = JSON.parse(localStorage.getItem('usuario')),
		idcurso = $('#curso-select').val();
	mostrarAvisoToast('Por favor espera', 'Buscando...');
	$.ajax(
	{
		url: '../sistema/x/cuenta.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'listarVentasDeAlumnoPorCurso',
			idalumno: usuario.usuario_idusuario,
			idcurso: idcurso
		},
		error: function(xhr, status, error)
		{
			ocultarAvisoToast();
			console.error('[cuenta.js] [listarVentasDeAlumnoPorCurso] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var ndata = data.detalles;
				for (var i = 0; i < ndata.length; i++)
				{
					ndata[i].nivel = '<td class="align-middle"><strong>' + ndata[i].articulo_nivel + '</strong></td>';
					ndata[i].articulo = '<td class="align-middle"><strong>' + ndata[i].articulo_nombre + '</strong></td>';
					ndata[i].estatus_pago_leyenda = '<td class="align-middle"><strong>' + ndata[i].estatus_pago_leyenda + '</strong></td>';
					ndata[i].tipo_pago = '<td class="align-middle">' + ndata[i].tipo_pago + '</td>';
					ndata[i].pago_referencia = '<td class="align-middle">' + ndata[i].pago_referencia + '</td>';
					ndata[i].fecha_hora = '<td class="align-middle">' + ndata[i].fecha_hora + '</td>';
					ndata[i].fecha_entrega = '<td class="align-middle">' + ndata[i].fecha_entrega + '</td>';
					ndata[i].total = '<td class="align-middle">$' + formatearDinero(ndata[i].total) + '</td>';
					ndata[i].comprobante = '<td class="align-middle"><a class="links-style" href="#" onclick="verComprobante(' + ndata[i].idventa + ')"><i class="fas fa-info-circle"></i> Comprobante</a></td>';
				}
				var tabla = $('#tabla-pedidos').DataTable();
				tabla.clear();
				tabla.rows.add(ndata);
				tabla.order([0, 'desc']);
				tabla.draw();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cuenta.js] [listarVentasDeAlumnoPorCurso] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
			ocultarAvisoToast();
		}
	}).done(function() {});
}

function verComprobante(idventa)
{
	localStorage.setItem('tienda_entrega_venta_id', JSON.stringify(idventa));
	$(location).attr('href', '../tienda/entrega.php');
}

function descargarPDFDeCompra(idventa)
{
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
			idventa: idventa
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[cuenta.php] [descargarPDFDeCompra] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				var base64 = data.detalles.pdf_base_64;
				if (base64 != null)
				{
					var linkSource = 'data:application/pdf;base64,' + base64;
					var downloadLink = document.createElement("a");
					var fileName = "comprobante.pdf";
					downloadLink.href = linkSource;
					downloadLink.download = fileName;
					downloadLink.click();
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
				console.warn('[cuenta.php] [descargarPDFDeCompra] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);

				console.warn('[cuenta.js] [descargarPDFDeCompra] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert('The server encountered a problem while performing the request, please contact support or try again later...');
			}
		}
	}).done(function() {});
}

init();