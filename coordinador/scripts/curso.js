var niveles = Array();

function init() {
	crearDatePickers();
	crearTablaPrecio();
	$('#programa-select').html('<option value="">Selecciona un programa de Inglés</option>');
	$('#programa-select').selectpicker('refresh');
	$('#curso-select').html('<option value="">Selecciona un curso</option>');
	$('#curso-select').selectpicker('refresh');
	$('#curso-nuevo').click(function() {
		crearNuevoCurso();
	});
	$('#accion-guardar-configuracion-precios').click(function() {
		guardarConfiguracionPrecios();
	});
	listarProgramasPorDominio();
	$('#curso-select').change(function() {
		var idprograma = $('#programa-select').val();
		var idcurso = $('#curso-select').val();
		obtenerCurso(idprograma, idcurso);
	});
	$('#accion-editar-nombre-curso').click(function() {
		actualizarNombreCurso();
	});
	//////Botones navegación fechas////////////////////////
	$('#accion-siguiente-periodo-venta').click(function(e) {
		e.preventDefault();
		$("#pills-periodo-venta-tab").tab('show');
	});
	$('#accion-atras-precios').click(function(e) {
		e.preventDefault();
		$("#pills-precios-tab").tab('show');
	});
	$('#accion-siguiente-placement-test').click(function(e) {
		e.preventDefault();
		$("#pills-placement-test-tab").tab('show');
	});
	$('#accion-atras-periodo-venta').click(function(e) {
		e.preventDefault();
		$("#pills-periodo-venta-tab").tab('show');
	});
	$('#accion-siguiente-entrega-material').click(function(e) {
		e.preventDefault();
		$("#pills-entrega-material-tab").tab('show');
	});
	$('#accion-atras-placement-test').click(function(e) {
		e.preventDefault();
		$("#pills-placement-test-tab").tab('show');
	});
	$('#accion-siguiente-inicio-curso').click(function(e) {
		e.preventDefault();
		$("#pills-inicio-curso-tab").tab('show');
	});
	$('#accion-atras-entrega-material').click(function(e) {
		e.preventDefault();
		$("#pills-entrega-material-tab").tab('show');
	});
	/////////////////////////////////////////////////////
	//////Botones guardar configuración//////////////////
	$('#accion-guardar-configuracion-precios').click(function() {

	});
	$('#accion-guardar-fechas-periodo-venta').click(function() {
		guardarFechaPeriodoVenta();
	});
	$('#accion-guardar-fechas-placement-test').click(function() {
		guardarFechaPlacementTest();
	});
	$('#accion-guardar-fechas-entrega-material').click(function() {
		guardarFechaEntregaMaterial();
	});
	$('#accion-guardar-fechas-inicio-curso').click(function() {
		guardarFechaCurso();
	});
	/////////////////////////////////////////////////////
	/////////////////// VALIDAR ////////////////////////
	$('#accion-periodo-venta-inicio').change(function() {
		validarFechasPeridoVenta('accion-periodo-venta-inicio');
	});
	$('#accion-periodo-venta-fin').change(function() {
		validarFechasPeridoVenta('accion-periodo-venta-fin');
	});
	$('#accion-placement-test-inicio').change(function() {
		validarFechasPlacementTest('accion-placement-test-inicio');
	});
	$('#accion-placement-test-fin').change(function() {
		validarFechasPlacementTest('accion-placement-test-fin');
	});
	$('#accion-entrega-material-inicio').change(function() {
		validarFechasEntregaMaterial('accion-entrega-material-inicio');
	});
	$('#accion-entrega-material-fin').change(function() {
		validarFechasEntregaMaterial('accion-entrega-material-fin');
	});
	$('#accion-inicio-curso-inicio').change(function() {
		validarFechasInicioCurso('accion-inicio-curso-inicio');
	});
	////////////////////////////////////////////////////
	
}

function actualizarNombreCurso() {
	var idcurso = $('#curso-select').val();
	var nombre_actual_curso = $('#actualizar-nombre-curso').val();
	if (idcurso == null || idcurso == '') {
		bootbox.alert("¡Por favor selecciona un curso!");
	} else {
		bootbox.prompt({
			title: "¿Nombre del curso?",
			placeholder: nombre_actual_curso,
			className: 'rubberBand animated',
			callback: function(result) {
				if (!result) {
					return;
				} else {
					$.ajax({
						url: '../sistema/x/curso.php',
						type: 'POST',
						dataType: 'json',
						timeout: config_ajax_timeout,
						data: {
							op: 'actualizarNombreCurso',
							idcurso: idcurso,
							nombre: result
						},
						error: function(xhr, status, error) {
							console.error('[curso.js] [actualizarNombreCurso] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
							bootbox.alert('Error connecting to the server, please contact support or try again later...');
						},
						success: function(data) {
							if (data.resultado === 'OK') 
							{
								bootbox.alert('¡Se actualizo el nombre del curso correctamente!');
								var idprograma = $('#programa-select').val();
								var idcurso = $('#curso-select').val();
								listarCursosPorPrograma(idprograma, idcurso);
								obtenerCurso(idprograma, idcurso);
							}
                			else if (data.resultado === 'ERROR_TOKEN')
                			{
                				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
                				bootbox.alert(data.mensaje);
                				$(location).attr('href', '../login.php');
                			}
							else 
							{
								console.warn('[curso.js] [actualizarNombreCurso] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
								bootbox.alert(data.mensaje);
							}
						}
					}).done(function() {});
				}
			}
		});
	}
}

function crearNuevoCurso() {
	var idprograma = $('#programa-select').val();
	if (idprograma == null || idprograma == '') {
		bootbox.alert("¡Por favor selecciona un programa!");
	} else {
		bootbox.prompt({
			title: "¿Nombre del curso nuevo?",
			placeholder: "Curso nuevo",
			callback: function(result) {
				if (!result) {
					bootbox.alert('¡Por favor introduce un nombre para el curso!');
					return;
				} else {
					$.ajax({
						url: '../sistema/x/curso.php',
						type: 'POST',
						dataType: 'json',
						timeout: config_ajax_timeout,
						data: {
							op: 'crearNuevoCurso',
							idprograma: idprograma,
							nombre: result
						},
						error: function(xhr, status, error) {
							console.error('[curso.js] [crearNuevoCurso] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
							bootbox.alert('Error connecting to the server, please contact support or try again later...');
							ocultarEsperaAjax();
						},
						success: function(data) {
							if (data.resultado === 'OK') 
							{
								var idprograma = $('#programa-select').val();
								var idnuevo_curso = data.detalles;
								listarCursosPorPrograma(idprograma, idnuevo_curso);
								obtenerCurso(idprograma, idnuevo_curso);
							}
                			else if (data.resultado === 'ERROR_TOKEN')
                			{
                				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
                				bootbox.alert(data.mensaje);
                				$(location).attr('href', '../login.php');
                			} 
							else 
							{
								console.warn('[curso.js] [crearNuevoCurso] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
								bootbox.alert(data.mensaje);
							}
						}
					}).done(function() {});
				}
			}
		});
	}
}

function listarProgramasPorDominio() {
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	mostrarAvisoToast('Por favor espera', 'Cargando programas...', 'dark');
	$.ajax({
		url: '../sistema/x/curso.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'listarProgramasPorDominio',
			iddominio: usuario.usuario_iddominio
		},
		error: function(xhr, status, error) {
		    ocultarAvisoToast();
			console.error('[curso.js] [listarProgramasPorDominio] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
				var html_cursos = '<option value="">Selecciona un programa de Inglés</option>';
				var ndata = data.detalles;
				for (var i = 0; i < ndata.length; i++) {
					html_cursos += '<option value="' + ndata[i].idprograma + '">' + ndata[i].alias + ' - ' + ndata[i].nombre; + '</option>';
				}
				$('#programa-select').html(html_cursos);
				$('#programa-select').selectpicker('refresh');
				$('#programa-select').change(function() {
					var idprograma = $('#programa-select').val();
					listarCursosPorPrograma(idprograma, null);
					listarDatosPrecio(idprograma);
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
				console.warn('[curso.js] [listarProgramasPorDominio] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		   	ocultarAvisoToast();
		}
	}).done(function() {});
}

function listarCursosPorPrograma(idprograma, preseleccionar_id) {
	mostrarAvisoToast('Por favor espera', 'Cargando cursos...', 'dark');
	$.ajax({
		url: '../sistema/x/curso.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'listarCursosPorPrograma',
			idprograma: idprograma,
		},
		error: function(xhr, status, error) {
		     ocultarAvisoToast();
			console.error('[compra.js] [compraListarNiveles] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
				var html_cursos = '<option value="">Selecciona un curso</option>';
				var ndata = data.detalles;
				for (var i = 0; i < ndata.length; i++) {
					if (preseleccionar_id) {
						if (ndata[i].idcurso == preseleccionar_id) {
							html_cursos += '<option value="' + ndata[i].idcurso + '" selected>' + ndata[i].nombre; + '</option>';
						} else {
							html_cursos += '<option value="' + ndata[i].idcurso + '">' + ndata[i].nombre; + '</option>';
						}
					} else {
						html_cursos += '<option value="' + ndata[i].idcurso + '">' + ndata[i].nombre; + '</option>';
					}
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
				console.warn('[compra.js] [compraListarNiveles] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
			ocultarAvisoToast();
		}
	}).done(function() {});
}

function obtenerCurso(idprograma, idcurso) {
	mostrarEsperaAjax();
	$.ajax({
		url: '../sistema/x/curso.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'obtenerCurso',
			idprograma: idprograma,
			idcurso: idcurso
		},
		error: function(xhr, status, error) {
			console.error('[compra.js] [compraListarNiveles] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
			ocultarEsperaAjax();
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
				var ndata = data.detalles;
				$('#accion-periodo-venta-inicio').val(ndata.fecha_periodo_venta_inicio);
				$('#accion-periodo-venta-fin').val(ndata.fecha_periodo_venta_fin);
				$('#accion-placement-test-inicio').val(ndata.fecha_placement_test_inicio);
				$('#accion-placement-test-fin').val(ndata.fecha_placement_test_fin);
				$('#accion-entrega-material-inicio').val(ndata.fecha_entrega_venta_en_linea_inicio);
				$('#accion-entrega-material-fin').val(ndata.fecha_entrega_venta_en_linea_fin);
				$('#accion-inicio-curso-inicio').val(ndata.fecha_curso_inicio);
				var validacion = validarFechasPeridoVenta('todos');
				var validacion = validarFechasPlacementTest('todos');
				var validacion = validarFechasEntregaMaterial('todos');
				var validacion = validarFechasInicioCurso('todos');
				$('#actualizar-nombre-curso').val(ndata.nombre);
				ocultarEsperaAjax();
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
				ocultarEsperaAjax();
			}
		}
	}).done(function() {});
}

//*******************Funciones para actualizar las fechas del curso*******************
function guardarFechaPeriodoVenta() {
	var idprograma = $('#programa-select').val();
	var idcurso = $('#curso-select').val();
	var fecha_periodo_venta_inicio = $('#accion-periodo-venta-inicio').val();
	var fecha_periodo_venta_fin = $('#accion-periodo-venta-fin').val();
	var validacion = validarFechasPeridoVenta('todos');
	if (idprograma == '' || idcurso == '') {
		bootbox.alert('¡Por favor selecciona un programa y curso!');
		return;
	}
	if (validacion == false) {
		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	mostrarAvisoToast('Por favor espera', 'Cargando datos del curso...', 'dark');
	$.ajax({
		url: '../sistema/x/curso.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'guardarFechaPeriodoVenta',
			idprograma: idprograma,
			idcurso: idcurso,
			fecha_periodo_venta_inicio: fecha_periodo_venta_inicio,
			fecha_periodo_venta_fin: fecha_periodo_venta_fin
		},
		error: function(xhr, status, error) {
		    ocultarAvisoToast();
			console.error('[curso.js] [guardarFechaPeriodoVenta] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
				bootbox.alert('¡Fechas de período de venta guardadas!');
			} 
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else 
			{
				console.warn('[curso.js] [guardarFechaPeriodoVenta] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
			ocultarAvisoToast();
		}
	}).done(function() {});
}

function guardarFechaPlacementTest() {
	var idprograma = $('#programa-select').val();
	var idcurso = $('#curso-select').val();
	var fecha_placement_test_inicio = $('#accion-placement-test-inicio').val();
	var fecha_placement_test_fin = $('#accion-placement-test-fin').val();
	var validacion = validarFechasPlacementTest('todos');
	if (idprograma == '' || idcurso == '') {
		bootbox.alert('¡Por favor selecciona un programa y curso!');
		return;
	}
	if (validacion == false) {
		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	mostrarAvisoToast('Por favor espera', 'Cargando datos del curso...', 'dark');
	$.ajax({
		url: '../sistema/x/curso.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'guardarFechaPlacementTest',
			idprograma: idprograma,
			idcurso: idcurso,
			fecha_placement_test_inicio: fecha_placement_test_inicio,
			fecha_placement_test_fin: fecha_placement_test_fin
		},
		error: function(xhr, status, error) {
		    ocultarAvisoToast();
			console.error('[curso.js] [guardarFechaPlacementTest] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
				bootbox.alert('¡Fechas de placement test guardadas!');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			} 
			else 
			{
				console.warn('[curso.js] [guardarFechaPlacementTest] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
			ocultarAvisoToast();
		}
	}).done(function() {});
}

function guardarFechaEntregaMaterial() {
	var idprograma = $('#programa-select').val();
	var idcurso = $('#curso-select').val();
	var fecha_entrega_venta_en_linea_inicio = $('#accion-entrega-material-inicio').val();
	var fecha_entrega_venta_en_linea_fin = $('#accion-entrega-material-fin').val();
	var fecha_entrega_venta_directa_inicio = $('#accion-entrega-material-inicio').val();
	var fecha_entrega_venta_directa_fin = $('#accion-entrega-material-fin').val();
	var validacion = validarFechasEntregaMaterial('todos');
	if (idprograma == '' || idcurso == '') {
		bootbox.alert('¡Por favor selecciona un programa y curso!');
		return;
	}
	if (validacion == false) {
		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	mostrarAvisoToast('Por favor espera', 'Cargando datos del curso...', 'dark');
	$.ajax({
		url: '../sistema/x/curso.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'guardarFechaEntregaMaterial',
			idprograma: idprograma,
			idcurso: idcurso,
			fecha_entrega_venta_en_linea_inicio: fecha_entrega_venta_en_linea_inicio,
			fecha_entrega_venta_en_linea_fin: fecha_entrega_venta_en_linea_fin,
			fecha_entrega_venta_directa_inicio: fecha_entrega_venta_directa_inicio,
			fecha_entrega_venta_directa_fin: fecha_entrega_venta_directa_fin
		},
		error: function(xhr, status, error) {
		    ocultarAvisoToast();
			console.error('[curso.js] [guardarFechaEntregaMaterial] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
				bootbox.alert('¡Fechas de entrega de material guardadas!');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			} 
			else 
			{
				console.warn('[curso.js] [guardarFechaEntregaMaterial] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
			ocultarAvisoToast();
		}
	}).done(function() {});
}

function guardarFechaCurso() {
	var idprograma = $('#programa-select').val();
	var idcurso = $('#curso-select').val();
	var fecha_curso_inicio = $('#accion-inicio-curso-inicio').val();
	var fecha_curso_fin = $('#accion-inicio-curso-inicio').val();
	var validacion = validarFechasInicioCurso('todos');
	if (idprograma == '' || idcurso == '') {
		bootbox.alert('¡Por favor selecciona un programa y curso!');
		return;
	}
	if (validacion == false) {
		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
		return;
	}
	mostrarAvisoToast('Por favor espera', 'Cargando datos del curso...', 'dark');
	$.ajax({
		url: '../sistema/x/curso.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'guardarFechaCurso',
			idprograma: idprograma,
			idcurso: idcurso,
			fecha_curso_inicio: fecha_curso_inicio,
			fecha_curso_fin: fecha_curso_fin
		},
		error: function(xhr, status, error) {
		    ocultarAvisoToast();
			console.error('[curso.js] [guardarFechaCurso] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
				bootbox.alert('¡Fechas de curso guardadas!');
			} 
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else 
			{
				console.warn('[curso.js] [guardarFechaCurso] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		   ocultarAvisoToast();
		}
	}).done(function() {});
}
//************************************************************************************

function validarFechasPeridoVenta(campo) {
	var errores = 0;
	if (campo === 'todos' || campo === 'accion-periodo-venta-inicio') {
		if (!$('#accion-periodo-venta-inicio').val()) {
			$('#accion-periodo-venta-inicio').removeClass('is-valid');
			$('#accion-periodo-venta-inicio').addClass('is-invalid');
			errores++;
		} else {
			$('#accion-periodo-venta-inicio').removeClass('is-invalid');
			$('#accion-periodo-venta-inicio').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'accion-periodo-venta-fin') {
		if (!$('#accion-periodo-venta-fin').val()) {
			$('#accion-periodo-venta-fin').removeClass('is-valid');
			$('#accion-periodo-venta-fin').addClass('is-invalid');
			errores++;
		} else {
			$('#accion-periodo-venta-fin').removeClass('is-invalid');
			$('#accion-periodo-venta-fin').addClass('is-valid');
		}
	}
	if (errores == 0) {
		return true;
	} else {
		return false;
	}
}

function validarFechasPlacementTest(campo) {
	var errores = 0;
	if (campo === 'todos' || campo === 'accion-placement-test-inicio') {
		if (!$('#accion-placement-test-inicio').val()) {
			$('#accion-placement-test-inicio').removeClass('is-valid');
			$('#accion-placement-test-inicio').addClass('is-invalid');
			errores++;
		} else {
			$('#accion-placement-test-inicio').removeClass('is-invalid');
			$('#accion-placement-test-inicio').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'accion-placement-test-fin') {
		if (!$('#accion-placement-test-fin').val()) {
			$('#accion-placement-test-fin').removeClass('is-valid');
			$('#accion-placement-test-fin').addClass('is-invalid');
			errores++;
		} else {
			$('#accion-placement-test-fin').removeClass('is-invalid');
			$('#accion-placement-test-fin').addClass('is-valid');
		}
	}
	if (errores == 0) {
		return true;
	} else {
		return false;
	}
}

function validarFechasEntregaMaterial(campo) {
	var errores = 0;
	if (campo === 'todos' || campo === 'accion-entrega-material-inicio') {
		if (!$('#accion-entrega-material-inicio').val()) {
			$('#accion-entrega-material-inicio').removeClass('is-valid');
			$('#accion-entrega-material-inicio').addClass('is-invalid');
			errores++;
		} else {
			$('#accion-entrega-material-inicio').removeClass('is-invalid');
			$('#accion-entrega-material-inicio').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'accion-entrega-material-fin') {
		if (!$('#accion-entrega-material-fin').val()) {
			$('#accion-entrega-material-fin').removeClass('is-valid');
			$('#accion-entrega-material-fin').addClass('is-invalid');
			errores++;
		} else {
			$('#accion-entrega-material-fin').removeClass('is-invalid');
			$('#accion-entrega-material-fin').addClass('is-valid');
		}
	}
	if (errores == 0) {
		return true;
	} else {
		return false;
	}
}

function validarFechasInicioCurso(campo) {
	var errores = 0;
	if (campo === 'todos' || campo === 'accion-inicio-curso-inicio') {
		if (!$('#accion-inicio-curso-inicio').val()) {
			$('#accion-inicio-curso-inicio').removeClass('is-valid');
			$('#accion-inicio-curso-inicio').addClass('is-invalid');
			errores++;
		} else {
			$('#accion-inicio-curso-inicio').removeClass('is-invalid');
			$('#accion-inicio-curso-inicio').addClass('is-valid');
		}
	}
	if (errores == 0) {
		return true;
	} else {
		return false;
	}
}

function crearDatePickers() {
	///////////////////////////////////////////////////////////////////////
	$('#accion-placement-test-inicio').datepicker({
		format: 'yyyy-mm-dd',
		weekStart: 1,
		daysOfWeekHighlighted: "6,0",
		autoclose: true,
		todayHighlight: true,
	});
	$('#accion-placement-test-inicio').datepicker("setDate", new Date());
	$('#accion-placement-test-inicio').val('');
	$('#accion-placement-test-fin').datepicker({
		format: 'yyyy-mm-dd',
		weekStart: 1,
		daysOfWeekHighlighted: "6,0",
		autoclose: true,
		todayHighlight: true,
	});
	$('#accion-placement-test-fin').datepicker("setDate", new Date());
	$('#accion-placement-test-fin').val('');
	///////////////////////////////////////////////////////////////////////
	$('#accion-inicio-curso-inicio').datepicker({
		format: 'yyyy-mm-dd',
		weekStart: 1,
		daysOfWeekHighlighted: "6,0",
		autoclose: true,
		todayHighlight: true,
	});
	$('#accion-inicio-curso-inicio').datepicker("setDate", new Date());
	$('#accion-inicio-curso-inicio').val('');
	///////////////////////////////////////////////////////////////////////
	$('#accion-entrega-material-inicio').datepicker({
		format: 'yyyy-mm-dd',
		weekStart: 1,
		daysOfWeekHighlighted: "6,0",
		autoclose: true,
		todayHighlight: true,
	});
	$('#accion-entrega-material-inicio').datepicker("setDate", new Date());
	$('#accion-entrega-material-inicio').val('');
	$('#accion-entrega-material-fin').datepicker({
		format: 'yyyy-mm-dd',
		weekStart: 1,
		daysOfWeekHighlighted: "6,0",
		autoclose: true,
		todayHighlight: true,
	});
	$('#accion-entrega-material-fin').datepicker("setDate", new Date());
	$('#accion-entrega-material-fin').val('');
	///////////////////////////////////////////////////////////////////////
	$('#accion-periodo-venta-inicio').datepicker({
		format: 'yyyy-mm-dd',
		weekStart: 1,
		daysOfWeekHighlighted: "6,0",
		autoclose: true,
		todayHighlight: true,
	});
	$('#accion-periodo-venta-inicio').datepicker("setDate", new Date());
	$('#accion-periodo-venta-inicio').val('');
	$('#accion-periodo-venta-fin').datepicker({
		format: 'yyyy-mm-dd',
		weekStart: 1,
		daysOfWeekHighlighted: "6,0",
		autoclose: true,
		todayHighlight: true,
	});
	$('#accion-periodo-venta-fin').datepicker("setDate", new Date());
	$('#accion-periodo-venta-fin').val('');
	///////////////////////////////////////////////////////////////////////
}

function crearTablaPrecio() {
	var table = $('#tabla-precio').DataTable({
		destroy: true,
		responsive: true,
		searching: true,
		paging: true,
		ordering: true,
		info: false,
		scrollY: '300px',
		scrollX: true,
		scrollCollapse: true,
		columnDefs: [{
			width: 200,
			targets: 0
		}],
		language: {
			lengthMenu: 'Mostrar  _MENU_  libros',
			search: 'Filtrar',
			zeroRecords: ' ',
			infoFiltered: '(Se filtraron _MAX_ niveles de programa)',
			info: 'Mostrando _START_ a _END_ de _TOTAL_ niveles de programa',
			paginate: {
				first: 'Primero',
				last: 'Último',
				next: 'Siguiente',
				previous: 'Anterior'
			},
		},
		select: {
			style: 'multi',
			selector: 'td:nth-child(2)'
		},
		data: null,
		columns: [{
				title: 'Nivel',
				data: 'nivel'
			},
			{
				title: 'Nombre',
				data: 'descripcion'
			},
			{
				title: 'Precio Helbling',
				data: 'precio'
			},
			{
				title: 'Precio alumnos',
				data: 'precio_alumno'
			},
			{
				title: 'Puntos',
				data: 'puntos_por_venta'
			}
		]
	});
}

function listarDatosPrecio(idprograma) {
	$.ajax({
		url: '../sistema/x/curso.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'listarDatosPrecio',
			idprograma: idprograma
		},
		error: function(xhr, status, error) {
			console.error('[curso.js] [listarDatosPrecio] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
			    niveles = data.detalles;
				var ndata = data.detalles;
				for (var i = 0; i < ndata.length; i++) {
					ndata[i].precio = '$' + formatearDinero(ndata[i].precio);
					var precio_descuento = '$' + formatearDinero(ndata[i].precio_descuento);
					ndata[i].precio_alumno = ' <td class="align-middle"><input type="text" name="nivel-'+ndata[i].idprograma_articulo+'-precio-alumno" id="nivel-'+ndata[i].idprograma_articulo+'-precio-alumno" value="'+precio_descuento +'"></td> ';
					ndata[i].puntos_por_venta = ' <td class="align-middle"><input type="text" name="nivel-'+ndata[i].idprograma_articulo+'-puntos" id="nivel-'+ndata[i].idprograma_articulo+'-puntos" value="'+ndata[i].puntos_por_venta+'"></td> ';
				}
				var tabla = $('#tabla-precio').DataTable();
				tabla.clear();
				tabla.rows.add(ndata);
				tabla.order([2, 'desc']);
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
				console.warn('[curso.js] [listarDatosPrecio] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function guardarConfiguracionPrecios(){
	var idprograma = $('#programa-select').val();
    if (idprograma == '') {
		bootbox.alert('¡Por favor selecciona un programa!');
		return;
	}
    for(var i = 0; i < niveles.length; i++){
        var precio_alumnos = $('#nivel-'+niveles[i].idprograma_articulo+'-precio-alumno').val();
        
        var precio_puntos = $('#nivel-'+niveles[i].idprograma_articulo+'-puntos').val();
        
    }
    console.log(precio_alumnos);
    console.log(precio_puntos);
}

init();
initCarrito();