 $(document).ready(function() {
    var table = $('#example').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    } );
    var table_pedidos = $('#table-pedidos').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    } );
} );
var g_coordinador_escuela_seleccionada_id = -1;
var g_coordinador_curso_seleccionado_id = -1;
var g_mapa_subzonas = new Array();
var g_mapa_escuelas_seleccionadas = new Array();

function init()
{
	cargarDatosUsuario();
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
	$('#usuario-lada').change(function()
	{
		validarDatosUsuario('usuario-lada');
	});
	$('#usuario-telefono').change(function()
	{
		validarDatosUsuario('usuario-telefono');
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
	$('#recargar-escuela-curso').click(function()
	{
		listarVentasDeCoordinadorPorEscuelaYCurso();
	});
	obtenerZonasSubzonas();
	obtenerEscuelasSeleccionadas();
	listarEscuelasSeleccionadas();
	crearDataTablePedidos();
}

function crearDataTableVentas(idventa)
{
	var table = $('#' + idventa).DataTable(
	{
		destroy: true,
		responsive: true,
		searching: true,
		paging: false,
		//ordering: true,
		'bSort': false,
		info: false,
		//scrollY: '2000px',
		//scrollX: true,
		scrollCollapse: true,
		columnDefs: [
		{
			width: 200,
			targets: [0,1,2,3,4,5,6,7],
			className: "text-right"
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
		data: null,
		columns: [
		{
			title: 'Nivel',
			data: 'nivel'
		},
		{
			title: 'Libros Solicitados',
			data: 'totales_solicitados'
		},
		{
			title: 'Total Pedidos',
			data: 'totales_total'
		},
		{
			title: 'Total Pedidos Pagados',
			data: 'totales_pagadas'
		},
		{
			title: 'Compras Entregadas',
			data: 'totales_entregadas'
		},
		{
			title: 'Libros pagados por Entregar',
			data: 'totales_por_entregar'
		},
		{
			title: 'Pedidos por Pagar',
			data: 'totales_por_pagar'
		},
		{
			title: 'Balance en En Almacén',
			data: 'totales_inventario'
		}]
	});
}

function crearDataTablePedidos()
{
	var table = $('#tabla-pedido').DataTable(
	{
		destroy: true,
		responsive: true,
		searching: true,
		paging: false,
		//ordering: true,
		'bSort': false,
		info: false,
		//scrollY: '2000px',
		//scrollX: true,
		scrollCollapse: true,
		columnDefs: [
		{
			width: 200,
			targets: [0,1,2,3]
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
		data: null,
		columns: [
		{
			title: 'Nivel',
			data: 'nivel'
		},
		{
			title: 'Stock Actual',
			data: 'stock_actual'
		},
		{
			title: 'Necesito',
			data: 'necesito'
		},
		{
			title: 'Pedido',
			data: 'pedido'
		}]
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
				var usuario_rol = usuario.usuario_rol;
				var usuario_rol_html = '';
				if (usuario_rol === 'coordinador_dominio')
				{
					usuario_rol_html = 'Coordinador de Institución';
				}
				else if (usuario_rol === 'coordinador_zona')
				{
					usuario_rol_html = 'Coordinador de Zona';
				}
				else if (usuario_rol === 'coordinador_subzona')
				{
					usuario_rol_html = 'Coordinador de Subzona';
				}
				else if (usuario_rol === 'coordinador_escuela')
				{
					usuario_rol_html = 'Coordinador de Escuela';
				}
				$('#confirmacion-usuario-rol').text(usuario_rol_html);
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

function validarDatosUsuario(campo)
{
	var errores = 0;
	if (campo === 'todos' || campo === 'usuario-nombre')
	{
		if (!$('#usuario-nombre').val())
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
		if (!$('#usuario-apellido-paterno').val())
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
		if (!$('#usuario-apellido-materno').val())
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
		if (!$('#usuario-matricula').val())
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
		if (!$('#usuario-lada').val())
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
		if (!$('#usuario-telefono').val())
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
		if (!$('#usuario-login').val() || !validarEmail($('#usuario-login').val()))
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

function validarEmail(email)
{
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

function validarClaveUsuario(campo)
{
	var errores = 0;
	if (campo === 'todos' || campo === 'usuario-clave')
	{
		if (!$('#usuario-clave').val() || $('#usuario-clave').val().length < 6)
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
		if (!$('#usuario-clave-confirmar').val() || $('#usuario-clave-confirmar').val().length < 6 || $('#usuario-clave').val() != $('#usuario-clave-confirmar').val())
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

	if (limpiarString(telefono).length != 10)
	{
		$('#usuario-lada').removeClass('is-valid');
		$('#usuario-lada').addClass('is-invalid');
		$('#usuario-telefono').removeClass('is-valid');
		$('#usuario-telefono').addClass('is-invalid');

		bootbox.alert('Hay errores de validación en tu teléfono, por favor completa correctamente este campo');
		return;
	}

	if (validacion == false)
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
			login: $('#usuario-login').val(),
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

function obtenerZonasSubzonas() {
	var usuario_zonas = JSON.parse(localStorage.getItem('usuario_zonas'));
	var zonas_codigos = {};
	var zonas_colores = {};
	g_lista_zonas = usuario_zonas;
	for (var i = 0; i < usuario_zonas.length; i++) {
		var zona_id = usuario_zonas[i].idzona;
		var zona_nombre = usuario_zonas[i].nombre;
		var zona_color_hex = usuario_zonas[i].color_hex;
		var zonas_subzonas = usuario_zonas[i].subzonas;
		for (var j = 0; j < zonas_subzonas.length; j++) {
			var subzona_estado_codigo = zonas_subzonas[j].estado_codigo;
			var subzona_estado_nombre = zonas_subzonas[j].estado_nombre;
			if (!zonas_codigos.hasOwnProperty(subzona_estado_codigo)) {
				var subzona_estado_escuelas = zonas_subzonas[j].escuelas;
				var subzona_estado_escuelas_total = zonas_subzonas[j].escuelas_total;
				zonas_codigos[subzona_estado_codigo] = zona_nombre;
				g_mapa_subzonas.push({
					zona_id: zona_id,
					zona_nombre: zona_nombre,
					estado_codigo: subzona_estado_codigo,
					estado_nombre: subzona_estado_nombre,
					escuelas: subzona_estado_escuelas,
					escuelas_total: subzona_estado_escuelas_total
				});
			}
		}
		zonas_colores[zona_nombre] = zona_color_hex;
	}
}

function obtenerEscuelasSeleccionadas() {
    for (var i = 0; i < g_mapa_subzonas.length; i++) {
		var subzona_actual = {
			codigo: g_mapa_subzonas[i].estado_codigo,
			nombre: g_mapa_subzonas[i].estado_nombre,
			escuelas: new Array()
		};
		var subzona_escuelas = g_mapa_subzonas[i].escuelas;
		for (var j = 0; j < subzona_escuelas.length; j++) {
			subzona_actual.escuelas.push(subzona_escuelas[j]);
			g_mapa_escuelas_seleccionadas.push(subzona_actual);
		}
	}
}

function listarEscuelasSeleccionadas()
{
	var estados = g_mapa_escuelas_seleccionadas;
	var html_opciones = '<option value="-1">Selecciona una escuela</option>';
	for (var i = 0; i < estados.length; i++)
	{
		html_opciones += '<optgroup label="' + estados[i].nombre + '">';
		var escuelas = estados[i].escuelas;
		for (var j = 0; j < escuelas.length; j++)
		{
			html_opciones += '<option value="' + escuelas[j].idescuela + '">' + escuelas[j].nombre + '</option>';
		}
		html_opciones += '</optgroup">';
	}
	$('#escuela-pedido-select').html(html_opciones);
	$('#escuela-pedido-select').selectpicker('refresh');
	$('#escuela-pedido-select').change(function()
	{
		g_coordinador_escuela_seleccionada_id = $('#escuela-pedido-select').val();
	});


	$('#escuela-select').html(html_opciones);
	$('#escuela-select').selectpicker('refresh');
	$('#escuela-select').change(function()
	{
		g_coordinador_escuela_seleccionada_id = $('#escuela-select').val();
		listarProgramaCursosEscuela(g_coordinador_escuela_seleccionada_id);
	});
}

function listarProgramaCursosEscuela(idescuela)
{
	if (idescuela === -1)
	{
		$('#curso-select').html('');
		$('#curso-select').selectpicker('refresh');
		$('#curso-select').change(function()
		{
			return;
		});
		return;
	}

	var usuario = JSON.parse(localStorage.getItem('usuario'));
	mostrarAvisoToast('Por favor espera', 'Buscando...');
	$.ajax(
	{
		url: '../sistema/x/programa.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'listarProgramaCursosEscuelaConTotales',
			idescuela: idescuela
		},
		error: function(xhr, status, error)
		{
		    ocultarAvisoToast();
			console.error('[cuenta.js] [listarProgramaCursosEscuela] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
		    ocultarAvisoToast();
			if (data.resultado === 'OK')
			{
				var ndata = data.detalles;
		    	cargarTablaDePedidosPorEscuela(ndata);
				var html_cursos = '<option value="-1">Selecciona un curso</option>';
				
				var totales_solicitados = 0;
        		var totales_total = 0;
        		var totales_pagadas = 0;
        		var totales_entregadas = 0;
        		var totales_por_entregar = 0;
        		var totales_por_pagar = 0;
        		var totales_inventario = 0;
				
				// Por cada curso
				for (var i = 0; i < ndata.length; i++)
				{
					html_cursos += '<option value="' + ndata[i].idcurso + '">' + ndata[i].curso_nombre + '</option>';
					
					// Por cada consignación del curso
					var escuela_consignaciones = ndata[i].ventas.detalles;
					escuela_consignaciones = calcularEscuelaCursos(escuela_consignaciones, false, false, true);
					
    				for (var j = 0; j < escuela_consignaciones.length; j++)
    	            {
                        totales_solicitados += escuela_consignaciones[j].totales.totales_solicitados;
            			totales_total += escuela_consignaciones[j].totales.totales_total;
            			totales_pagadas += escuela_consignaciones[j].totales.totales_pagadas;
            			totales_entregadas += escuela_consignaciones[j].totales.totales_entregadas;
            			totales_por_entregar += escuela_consignaciones[j].totales.totales_por_entregar;
            			totales_por_pagar += escuela_consignaciones[j].totales.totales_por_pagar;
            			totales_inventario += escuela_consignaciones[j].totales.totales_inventario;
    	            }
				}
				
				console.log('idescuela: ' + idescuela);
				console.log('totales_solicitados: ' + totales_solicitados);
				console.log('totales_total: ' + totales_total);
				console.log('totales_pagadas: ' + totales_pagadas);
				console.log('totales_entregadas: ' + totales_entregadas);
				console.log('totales_por_entregar: ' + totales_por_entregar);
				console.log('totales_por_pagar: ' + totales_por_pagar);
				console.log('totales_inventario: ' + totales_inventario);

				$('#entregas-solicitados').html(totales_solicitados);
				$('#entregas-totales').html(totales_total);
				$('#entregas-pagadas').html(totales_pagadas);
				$('#entregas-por-pagar').html(totales_por_pagar);
				$('#entregas-entregadas').html(totales_entregadas);
				$('#entregas-por-entregar').html(totales_por_entregar);
				$('#entregas-inventario').html(totales_inventario);
				
				/*$('#entregas-nivel-por-asignar').html(total_nivel_por_asignar);
				$('#entregas-no-pagadas-nivel-por-asignar').html(total_no_pagadas_nivel_por_asignar);
				$('#entregas-pagadas-nivel-por-asignar').html(total_pagadas_nivel_por_asignar);*/
				
				$('#curso-select').html(html_cursos);
				$('#curso-select').selectpicker('refresh');
				$('#curso-select').change(function()
				{
					g_coordinador_curso_seleccionado_id = $('#curso-select').val();
					listarVentasDeCoordinadorPorEscuelaYCurso();
					$('html, body').animate({
					    scrollTop: $('#contenedor-tablas').offset().top
                    }, 2000);
                    
				console.log('idcurso: ' + $('#curso-select').val());
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
				console.warn('[cuenta.js] [listarProgramaCursosEscuela] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function cargarTablaDePedidosPorEscuela(ndata)
{
	console.log(ndata);
	for (var i = 0; i < ndata.length; i++) {
		console.log(ndata[i].ventas.detalles);
		var ventas = ndata[i].ventas.detalles;
		for (var i = 0; i < ventas.length; i++) {
			console.log(ventas[0].niveles);
			console.log(ventas[0].totales);
		}
	}
}

function listarVentasDeCoordinadorPorEscuelaYCurso()
{
	if (g_coordinador_escuela_seleccionada_id === -1 || g_coordinador_curso_seleccionado_id === -1)
	{
		return;
	}

	mostrarAvisoToast('Por favor espera', 'Buscando...');
	$.ajax(
	{
		url: '../sistema/x/cuenta.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'listarVentasDeCoordinadorPorEscuelaYCurso',
			idescuela: g_coordinador_escuela_seleccionada_id,
			idcurso: g_coordinador_curso_seleccionado_id
		},
		error: function(xhr, status, error)
		{
			ocultarAvisoToast();
			console.error('[cuenta.js] [listarVentasDeCoordinadorPorEscuelaYCurso] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var ndata = data.detalles;
				
				// Crear un datatable por cada consignación encontrada en la escuela y el curso
				var ndata = calcularEscuelaCursos(ndata, true, true, false);
				$('#contenedor-tablas').empty();
				for (var i = 0; i < ndata.length; i++)
	            {
	                $('#contenedor-tablas').append(ndata[i].html_tabla);
	                crearDataTableVentas(ndata[i].idventa);
	                ndata[i].html_tabla;
	                var tabla = $('#' + ndata[i].idventa).DataTable();
            		tabla.clear();
            		tabla.rows.add(ndata[i].niveles);
            		tabla.draw();
	            }
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [listarVentasDeCoordinadorPorEscuelaYCurso] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cuenta.js] [listarVentasDeCoordinadorPorEscuelaYCurso] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
			ocultarAvisoToast();
		}
	}).done(function() {});
}

function calcularEscuelaCursos(ndata, gestionarEntregas, verComprobante, verTotales)
{
    // Por cada consignación encontrada en la escuela y el curso
    for (var i = 0; i < ndata.length; i++)
	{
		var html_tabla = '';
		html_tabla += '<div class="col-xs-12 col-md-12 mb-3"><hr>';
		if (gestionarEntregas === true) {
		    html_tabla += '<button type="button" class="btn btn-primary btn-block" onclick="gestionarEntregas(' + ndata[i].idescuela + ', ' + ndata[i].idcurso + ', ' + ndata[i].idconsignacion + ');"><i class="fas fa-dolly-flatbed"></i> Realizar Entregas en <strong>' + ndata[i].escuela_nombre + '</strong> para el curso <strong>' + ndata[i].curso_nombre + '</strong></button>';
		}
		if (verComprobante === true) {
		    html_tabla += '<button type="button" class="btn btn-primary btn-block" onclick="verComprobante(' + ndata[i].idventa + ');"><i class="fas fa-money-bill-wave"></i> Comprobante</button><br>';
		}
		if (verTotales === true)
		{
		    html_tabla += '<div class="alert alert-warning alert-dismissible fade show text-center" role="alert"><i class="fas fa-envelope-open-text"></i> <strong>Total de pedidos con NIVEL POR ASIGNAR: ' + ndata[i].totales_nivel_por_asignar + '</strong></div>';
		    html_tabla += '<div class="alert alert-warning alert-dismissible fade show text-center" role="alert"><i class="fas fa-envelope-open-text"></i> <strong>Total de pedidos PAGADOS con NIVEL POR ASIGNAR: ' + ndata[i].totales_nivel_por_asignar_pagadas + '</strong></div>';
		    html_tabla += '<div class="alert alert-warning alert-dismissible fade show text-center" role="alert"><i class="fas fa-envelope-open-text"></i> <strong>Total de pedidos NO PAGADOS con NIVEL POR ASIGNAR: ' + ndata[i].totales_nivel_por_asignar_no_pagadas + '</strong></div>';
		}
		
		html_tabla += '<table id="' + ndata[i].idventa + '" class="table table-striped table-bordered nowrap" style="width:100%"></table></div>';

        var nivel = '<strong>TOTALES</strong>';
        var ventas_totales= '<strong>GRANDES TOTALES</strong>';
		var totales_solicitados = 0;
		var totales_total = 0;
		var totales_pagadas = 0;
		var totales_entregadas = 0;
		var totales_por_entregar = 0;
		var totales_por_pagar = 0;
		var totales_inventario = 0;
		
		for (var j = 0; j < ndata[i].niveles.length; j++)
		{
			totales_solicitados += ndata[i].niveles[j].totales_solicitados;
			totales_total += ndata[i].niveles[j].totales_total;
			totales_pagadas += ndata[i].niveles[j].totales_pagadas;
			totales_entregadas += ndata[i].niveles[j].totales_entregadas;
			totales_por_entregar += ndata[i].niveles[j].totales_por_entregar;
			totales_por_pagar += ndata[i].niveles[j].totales_por_pagar;
			totales_inventario += ndata[i].niveles[j].totales_inventario;
		}
		
		var npa = {
			nivel: 'NIVEL POR ASIGNAR',
			totales_solicitados: 0,
			totales_total: ndata[i].totales_nivel_por_asignar,
			totales_pagadas: ndata[i].totales_nivel_por_asignar_pagadas,
			totales_entregadas: 0,
			totales_por_entregar: ndata[i].totales_nivel_por_asignar_pagadas,
			totales_por_pagar: ndata[i].totales_nivel_por_asignar_no_pagadas,
			totales_inventario: 0
		}

		var totales = {
			nivel: nivel,
			totales_solicitados: totales_solicitados + npa.totales_solicitados,
			totales_total: totales_total + npa.totales_total,
			totales_pagadas: totales_pagadas + npa.totales_pagadas,
			totales_entregadas: totales_entregadas + npa.totales_entregadas,
			totales_por_entregar: totales_por_entregar + npa.totales_por_entregar,
			totales_por_pagar: totales_por_pagar + npa.totales_por_pagar,
			totales_inventario: totales_inventario + npa.totales_inventario
		}
		
		var grandes_totales = {
			nivel: ventas_totales,
			totales_solicitados: ' ',
			totales_total: totales_total + ndata[i].totales_nivel_por_asignar,
			totales_pagadas: ' ',
			totales_entregadas:' ',
			totales_por_entregar: totales_por_entregar + ndata[i].totales_nivel_por_asignar_pagadas,
			totales_por_pagar: ' ',
			totales_inventario: ''
		};
		
		ndata[i].html_tabla = html_tabla;
		ndata[i].niveles.unshift(npa);
		ndata[i].niveles.push(totales);
        ndata[i].totales = totales;
	}
	
	return ndata;
}

function verComprobante(idventa)
{
	localStorage.setItem('tienda_entrega_venta_id', JSON.stringify(idventa));
	$(location).attr('href', '../tienda/entrega.php');
}

function gestionarEntregas(idescuela, idcurso, idconsignacion)
{
	if (!idescuela || !idcurso || !idconsignacion)
	{
		return;
	}
	localStorage.setItem('entregas_escuela_id', JSON.stringify(idescuela));
	localStorage.setItem('entregas_curso_id', JSON.stringify(idcurso));
	localStorage.setItem('entregas_consignacion_id', JSON.stringify(idconsignacion));
	$(location).attr('href', 'escuela-entrega.php');
}

init();
initCarrito();