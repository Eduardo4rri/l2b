var g_lista_entregas = [];
var g_lista_entregas_actualizar = [];
var g_lista_entregas_nombre_exportar = 'Lista Entregas';
var g_venta_actual = {};

function init()
{
	crearTablaVentas();
	listarVentasDeAlumnos();
}

$('#filtros-todos').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtros-pagadas').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtros-pendientes').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtros-entregadas').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtros-no-entregadas').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtro-american-jestream-beginner').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtro-american-jestream-elementary').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtro-american-jestream-pre-intermediate').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtro-american-jestream-intermediate').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtro-american-jestream-upper-intermediate').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtro-american-jestream-advanced').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtro-sin-asignar').click(function()
{
	filtroEstatusEntregadasPagadas();
});

$('#filtro-todos-niveles').click(function()
{
	filtroEstatusEntregadasPagadas();
});

function crearTablaVentas()
{
	var tabla = $('#tabla-pedidos').DataTable(
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
		columnDefs: [
		{
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
		dom: 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',
		buttons:
		{
			dom:
			{
				container:
				{
					tag: 'div',
					className: 'flexcontent'
				},
				buttonLiner:
				{
					tag: null
				}
			},
			buttons: [
			{
				extend: 'excelHtml5',
				text: 'Exportar Excel',
				title: '',
				className: 'btn btn-primary export excel',
				filename: g_lista_entregas_nombre_exportar
			},
			{
				text: 'Importar Excel',
				action: function()
				{
					$('#importar-excel-modal').modal('show');
				},
				className: 'btn btn-primary'
			}]
		},
		data: null,
		columns: [
		{
			title: 'Venta',
			data: 'idventa'
		},
		{
			title: 'Libro',
			data: 'pago_concepto'
		},
		{
			title: 'Alumno',
			data: 'comprador_nombre'
		},
		{
			title: 'Matrícula',
			data: 'comprador_matricula'
		},
		{
			title: 'Tipo de Pago',
			data: 'tipo_pago'
		},
		{
			title: 'Referencia de Pago',
			data: 'pago_referencia'
		},
		{
			title: 'Estatus de Pago',
			data: 'estatus_pago_leyenda'
		},
		{
			title: 'Fecha de Pago',
			data: 'pago_fecha_hora'
		},
		{
			title: 'Estatus de Entrega',
			data: 'estatus_entrega_leyenda'
		}]
	});
	tabla.on('select', function(e, dt, type, indexes) {});
}

function filtroEstatusEntregadasPagadas()
{
	var filtro_mostrar_todos = ($('#filtros-todos').is(':checked') === true ? true : false),
		filtro_mostrar_pagadas = ($('#filtros-pagadas').is(':checked') === true ? true : false),
		filtro_mostrar_por_pagar = ($('#filtros-pendientes').is(':checked') === true ? true : false),
		filtro_mostrar_entregadas = ($('#filtros-entregadas').is(':checked') === true ? true : false),
		filtro_mostrar_por_entregar = ($('#filtros-no-entregadas').is(':checked') === true ? true : false),
		tabla = $('#tabla-pedidos').DataTable();

	var filtro_american_jestream_beginner = ($('#filtro-american-jestream-beginner').is(':checked') === true ? true : false),
		filtro_american_jestream_elementary = ($('#filtro-american-jestream-elementary').is(':checked') === true ? true : false),
		filtro_american_jestream_pre_intermediate = ($('#filtro-american-jestream-pre-intermediate').is(':checked') === true ? true : false),
		filtro_american_jestream_intermediate = ($('#filtro-american-jestream-intermediate').is(':checked') === true ? true : false),
		filtro_american_jestream_upper_intermediate = ($('#filtro-american-jestream-upper-intermediate').is(':checked') === true ? true : false),
		filtro_american_jestream_advanced = ($('#filtro-american-jestream-advanced').is(':checked') === true ? true : false),
		filtro_sin_asignar = ($('#filtro-sin-asignar').is(':checked') === true ? true : false),
		filtro_todos_niveles = ($('#filtro-todos-niveles').is(':checked') === true ? true : false),
		tabla = $('#tabla-pedidos').DataTable();

	// Filtros para los estatus
	tabla.columns().search('').draw();
	if (filtro_mostrar_todos === true)
	{
		tabla.columns().search('').draw();
	}
	if (filtro_mostrar_pagadas === true)
	{
		tabla.columns(6).search('PAGADA').draw();
	}
	if (filtro_mostrar_por_pagar === true)
	{
		tabla.columns(6).search('PENDIENTE').draw();
	}
	if (filtro_mostrar_entregadas === true)
	{
		tabla.columns(8).search('ENTREGADO').draw();
	}
	if (filtro_mostrar_por_entregar === true)
	{
		tabla.columns(8).search('SIN ENTREGAR').draw();
	}

	// Filtros para los niveles
	if (filtro_todos_niveles === true)
	{
		tabla.columns(1).search('').draw();
	}
	if (filtro_american_jestream_beginner === true)
	{
		tabla.columns(1).search('American JETSTREAM Beginner Student Book').draw();
	}
	if (filtro_american_jestream_elementary === true)
	{
		tabla.columns(1).search('American JETSTREAM Elementary Student Book').draw();
	}
	if (filtro_american_jestream_pre_intermediate === true)
	{
		tabla.columns(1).search('American JETSTREAM Pre-inter. Student Book').draw();
	}
	if (filtro_american_jestream_intermediate === true)
	{
		tabla.columns(1).search('American JETSTREAM Intermed. Student Book').draw();
	}
	if (filtro_american_jestream_upper_intermediate === true)
	{
		tabla.columns(1).search('American JETSTREAM Upper-inter. Student Book').draw();
	}
	if (filtro_american_jestream_advanced === true)
	{
		tabla.columns(1).search('American JETSTREAM Advanced Student Book').draw();
	}
	if (filtro_sin_asignar === true)
	{
		tabla.columns(1).search('American JETSTREAM Nivel Por Asignar').draw();
	}
}

function listarVentasDeAlumnos()
{
	var entregas_escuela_id = JSON.parse(localStorage.getItem('entregas_escuela_id'));
	var entregas_curso_id = JSON.parse(localStorage.getItem('entregas_curso_id'));
	var entregas_consignacion_id = JSON.parse(localStorage.getItem('entregas_consignacion_id'));

	if (!entregas_escuela_id || !entregas_curso_id || !entregas_consignacion_id)
	{
		bootbox.alert('¡Por favor selecciona una escuela, un curso, y un origen de ventas en la sección Mi Cuenta!');
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
			op: 'obtenerVentasEnConsignacionParaEntrega',
			idescuela: entregas_escuela_id,
			idcurso: entregas_curso_id,
			idconsignacion: entregas_consignacion_id
		},
		error: function(xhr, status, error)
		{
			ocultarAvisoToast();
			console.error('[escuela_entrega.js] [listarVentasDeAlumnos] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarAvisoToast();
			if (data.resultado === 'OK')
			{
				var tabla = $('#tabla-pedidos').DataTable();
				var escuela_alias = data.detalles.escuela_alias;
				var escuela_nombre = data.detalles.escuela_nombre;
				var curso_nombre = data.detalles.curso_nombre;
				var total_solicitados = data.detalles.totales_solicitados;
				var total_todos = data.detalles.totales_total;
				var total_pagadas = data.detalles.totales_pagadas;
				var total_por_pagar = data.detalles.totales_por_pagar;
				var total_entregadas = data.detalles.totales_entregadas;
				var total_por_entregar = data.detalles.totales_por_entregar;
				var total_inventario = data.detalles.totales_inventario;
				var total_nivel_por_asignar = data.detalles.totales_nivel_por_asignar;
				var total_no_pagadas_nivel_por_asignar = data.detalles.totales_nivel_por_asignar_no_pagadas;
				var total_pagadas_nivel_por_asignar = data.detalles.totales_nivel_por_asignar_pagadas;

				$('#escuela-nombre').html('<strong>' + escuela_alias + ' • ' + escuela_nombre + '</strong>');
				$('#curso-nombre').html('<strong>' + curso_nombre + '</strong>');
				$('#entregas-solicitados').html(total_solicitados);
				$('#entregas-totales').html(total_todos);
				$('#entregas-pagadas').html(total_pagadas);
				$('#entregas-por-pagar').html(total_por_pagar);
				$('#entregas-entregadas').html(total_entregadas);
				$('#entregas-por-entregar').html(total_por_entregar);
				$('#entregas-inventario').html(total_inventario);
				$('#entregas-nivel-por-asignar').html(total_nivel_por_asignar);
				$('#entregas-no-pagadas-nivel-por-asignar').html(total_no_pagadas_nivel_por_asignar);
				$('#entregas-pagadas-nivel-por-asignar').html(total_pagadas_nivel_por_asignar);
				
				var ndata = data.detalles.ventas;
				g_lista_entregas = ndata;
				for (var i = 0; i < ndata.length; i++)
				{
					ndata[i].estatus_pago_leyenda = '<td><strong>' + ndata[i].estatus_pago_leyenda + '</strong></td>';
					if (ndata[i].estatus_pago === 1 && ndata[i].estatus_entrega === 0)
					{
						ndata[i].estatus_entrega_leyenda = '<td><strong>' + ndata[i].estatus_entrega_leyenda + '</strong><br><br><button class="btn btn-primary" id="cambiar-articulo" onclick="seleccionarCambioNivelPorAsignarYEntregar(' + ndata[i].idventa + ');"> ENTREGAR LIBRO</button></td>';
					}
					else
					{
						ndata[i].estatus_entrega_leyenda = '<td><strong>' + ndata[i].estatus_entrega_leyenda + '</strong></td>';
					}
				}
				tabla.clear();
				tabla.rows.add(ndata);
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
				console.warn('[escuela_entrega.js] [listarVentasDeAlumnos] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function importarExcel()
{
	var entregas_escuela_id = JSON.parse(localStorage.getItem('entregas_escuela_id'));
	var entregas_curso_id = JSON.parse(localStorage.getItem('entregas_curso_id'));
	var entregas_consignacion_id = JSON.parse(localStorage.getItem('entregas_consignacion_id'));

	if (!entregas_escuela_id || !entregas_curso_id || !entregas_consignacion_id)
	{
		bootbox.alert('¡Por favor selecciona una escuela, un curso, y un origen de ventas en la sección Mi Cuenta!');
		return;
	}

	//Reference the FileUpload element.
	var fileUpload = $('#archivo-subir')[0];

	//Validate whether File is valid Excel file.
	var regex = /^([a-zA-Z0-9\s_\\.\-:()])+(.xls|.xlsx)$/;
	if (regex.test(fileUpload.value.toLowerCase()))
	{
		if (typeof(FileReader) != "undefined")
		{
			var reader = new FileReader();
			//For Browsers other than IE.
			if (reader.readAsBinaryString)
			{
				reader.onload = function(e)
				{
					procesarExcel(e.target.result);
				};
				reader.readAsBinaryString(fileUpload.files[0]);
			}
			else
			{
				//For IE Browser.
				reader.onload = function(e)
				{
					var data = "";
					var bytes = new Uint8Array(e.target.result);
					for (var i = 0; i < bytes.byteLength; i++)
					{
						data += String.fromCharCode(bytes[i]);
					}
					procesarExcel(data);
				};
				reader.readAsArrayBuffer(fileUpload.files[0]);
			}
		}
		else
		{
			bootbox.alert(
			{
				message: "¡Por favor usa un navegador que soporte HTML5!"
			});
		}
	}
	else
	{
		bootbox.alert(
		{
			message: "¡Por favor selecciona un archivo Excel válido, que no tenga paréntesis en el nombre o asegurate de que no esté en uso por algún otro programa!"
		});
	}
};

function procesarExcel(data)
{

	//Read the Excel File data.
	var workbook = XLSX.read(data,
	{
		type: 'binary'
	});

	//Fetch the name of First Sheet.
	var firstSheet = workbook.SheetNames[0];

	//Read all rows from First Sheet into an JSON array.
	var excelRows = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[firstSheet]);

	// Validate the data keys of all the elements
	var columnas_requeridas = [
	{
		title: 'Venta',
		data: 'idventa'
	},
	{
		title: 'Libro',
		data: 'pago_concepto'
	},
	{
		title: 'Alumno',
		data: 'comprador_nombre'
	},
	{
		title: 'Matrícula',
		data: 'comprador_matricula'
	},
	{
		title: 'Tipo de Pago',
		data: 'tipo_pago'
	},
	{
		title: 'Referencia de Pago',
		data: 'pago_referencia'
	},
	{
		title: 'Estatus de Pago',
		data: 'estatus_pago_leyenda'
	},
	{
		title: 'Fecha de Pago',
		data: 'pago_fecha_hora'
	},
	{
		title: 'Estatus de Entrega',
		data: 'estatus_entrega_leyenda'
	}];

	var advertencias = false;
	var nuevos_datos = [];
	for (var i = 0; i < excelRows.length; i++)
	{
		var fila_actual_nueva = {};
		var fila_actual_error = false;
		for (var j = 0; j < columnas_requeridas.length; j++)
		{
			if (!excelRows[i].hasOwnProperty(columnas_requeridas[j].title))
			{
				advertencias = true;
				fila_actual_error = true;
				columnas_requeridas[j].existe = false;
			}
			else
			{
				fila_actual_nueva[columnas_requeridas[j].data] = excelRows[i][columnas_requeridas[j].title];
			}
		}
		if (fila_actual_error === false)
		{
			nuevos_datos.push(fila_actual_nueva);
		}
	}

	if (advertencias === true)
	{
		var advertencias_etiquetas = '';
		for (var i = 0; i < columnas_requeridas.length; i++)
		{
			if (columnas_requeridas[i].existe === false)
			{
				advertencias_etiquetas += '• <strong>' + columnas_requeridas[i].title + '</strong><br>';
			}
		}
		bootbox.alert(
		{
			message: "<strong>¡ADVERTENCIA!</strong><br><br>No todas las filas contenian la información necesaria en el archivo seleccionado: <br><br>" + advertencias_etiquetas + '<br><br>Recuerda que <strong>TODAS LAS COLUMNAS</strong> son requeridas en <strong>TODAS LAS FILAS</strong>, aunque el orden en el que vengan no importa.'
		});
	}

	g_lista_entregas_actualizar = [];

	for (var i = 0; i < nuevos_datos.length; i++)
	{
		for (var j = 0; j < g_lista_entregas.length; j++)
		{
			if (g_lista_entregas[j].idventa == nuevos_datos[i].idventa && g_lista_entregas[j].comprador_matricula == nuevos_datos[i].comprador_matricula && g_lista_entregas[j].pago_referencia == nuevos_datos[i].pago_referencia)
			{
				if (nuevos_datos[i].estatus_entrega_leyenda === 'ENTREGADO')
				{
					if (g_lista_entregas[j].estatus_entrega === 0)
					{
						g_lista_entregas_actualizar.push(
						{
							idventa: nuevos_datos[i].idventa,
							comprador_nombre: nuevos_datos[i].comprador_nombre,
							comprador_matricula: nuevos_datos[i].comprador_matricula,
							pago_concepto: nuevos_datos[i].pago_concepto,
							fecha_entrega: nuevos_datos[i].fecha_entrega
						});
					}
				}
			}
		}
	}

	var actualizar_html = '<i class="fas fa-info-circle"></i> Los siguientes registros de entregas serán actualizados.<br>';
	actualizar_html += '<i class="fas fa-info-circle"></i> Haz click en <strong><i class="fas fa-check"></i> Confirmar y actualizar registros de entregas</strong> para continuar.<br><br>';
	actualizar_html += '<table class="table table-sm">';
	actualizar_html += '	<thead>';
	actualizar_html += '		<tr>';
	actualizar_html += '			<th scope="col">Venta</th>';
	actualizar_html += '			<th scope="col">Alumno</th>';
	actualizar_html += '			<th scope="col">Matrícula</th>';
	actualizar_html += '			<th scope="col">Libro</th>';
	actualizar_html += '		</tr>';
	actualizar_html += '	</thead>';
	actualizar_html += '	<tbody>';

	for (var i = 0; i < g_lista_entregas_actualizar.length; i++)
	{
		actualizar_html += '		<tr>';
		actualizar_html += '			<td>' + g_lista_entregas_actualizar[i].idventa + '</td>';
		actualizar_html += '			<td>' + g_lista_entregas_actualizar[i].comprador_nombre + '</td>';
		actualizar_html += '			<td>' + g_lista_entregas_actualizar[i].comprador_matricula + '</td>';
		actualizar_html += '			<td>' + g_lista_entregas_actualizar[i].pago_concepto + '</td>';
		actualizar_html += '		</tr>';
	}

	actualizar_html += '	</tbody>';
	actualizar_html += '</table>';

	$('#archivo-actualizar').html(actualizar_html);
	$('#importar-excel-modal').modal('hide');
	$('#importar-excel-continuar-modal').modal('show');

};

function confirmarExcel()
{
	var entregas_escuela_id = JSON.parse(localStorage.getItem('entregas_escuela_id'));
	var entregas_curso_id = JSON.parse(localStorage.getItem('entregas_curso_id'));
	var entregas_consignacion_id = JSON.parse(localStorage.getItem('entregas_consignacion_id'));

	if (!entregas_escuela_id || !entregas_curso_id || !entregas_consignacion_id)
	{
		bootbox.alert('¡Por favor selecciona una escuela, un curso, y un origen de ventas en la sección Mi Cuenta!');
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
			op: 'establecerEstatusEntregaVentaEntregadaEscuelaCursoBatch',
			idescuela: entregas_escuela_id,
			idcurso: entregas_curso_id,
			lista_venta: g_lista_entregas_actualizar
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[escuela_entrega.js] [confirmarExcel] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				bootbox.alert(data.mensaje);
				listarVentasDeAlumnos();
				filtroEstatusEntregadasPagadas();
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[escuela_entrega.js] [confirmarExcel] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
	$('#importar-excel-continuar-modal').modal('hide');
}

function seleccionarCambioNivelPorAsignarYEntregar(idventa)
{
	mostrarAvisoToast('Por favor espera', 'Buscando...');
	$.ajax(
	{
		url: '../sistema/x/venta.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerVenta',
			idventa: idventa
		},
		error: function(xhr, status, error)
		{
			ocultarAvisoToast();
			console.error('[escuela_entrega.js] [seleccionarCambioNivelPorAsignarYEntregar] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarAvisoToast();
			if (data.resultado === 'OK')
			{
				var venta = data.detalles;
				var actualizar_html = '<i class="fas fa-info-circle"></i> Por favor selecciona el libro a entregar y haz click en <strong><i class="fas fa-check"></i> Confirmar entrega de libro</strong> para continuar.<br><br>';
				actualizar_html += '<table class="table table-sm">';
				actualizar_html += '	<thead>';
				actualizar_html += '		<tr>';
				actualizar_html += '			<th scope="col">Venta</th>';
				actualizar_html += '			<th scope="col">Alumno</th>';
				actualizar_html += '			<th scope="col">Matrícula</th>';
				actualizar_html += '			<th scope="col">Libro</th>';
				actualizar_html += '		</tr>';
				actualizar_html += '	</thead>';
				actualizar_html += '	<tbody>';
				actualizar_html += '		<tr>';
				actualizar_html += '			<td>' + venta.idventa + '</td>';
				actualizar_html += '			<td>' + venta.comprador_nombre + '</td>';
				actualizar_html += '			<td>' + venta.comprador_matricula + '</td>';
				actualizar_html += '			<td><select name="escuela-select"  id="selecciona-cambio-articulo" class="form-control" data-show-subtext="true" data-live-search="true"></select></td>';
				actualizar_html += '		</tr>';
				actualizar_html += '	</tbody>';
				actualizar_html += '</table>';
				listarCambioNivelesArticulos(venta);
				$('#seleccionar-libro-entregar').html(actualizar_html);
				$('#seleccionar-libro-entregar-modal').modal('show');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[escuela_entrega.js] [seleccionarCambioNivelPorAsignarYEntregar] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[escuela_entrega.js] [seleccionarCambioNivelPorAsignarYEntregar] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function listarCambioNivelesArticulos(venta)
{
	var tienda_compra_programa_seleccionado_id = venta.idprograma;
	var idarticulo = venta.detalles[0].idarticulo;
	$.ajax(
	{
		url: '../sistema/x/tienda.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'listarNivelesPorProgramaSinImagen',
			idprograma: tienda_compra_programa_seleccionado_id
		},
		error: function(xhr, status, error)
		{
			console.error('[escuela_entrega.js] [listarCambioNivelesArticulos] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				g_venta_actual = venta;
				var niveles = data.detalles;
				var html_opciones = '';
				for (var i = 0; i < niveles.length; i++)
				{
					if (niveles[i].nivel !== 'NIVEL POR ASIGNAR')
					{
						html_opciones += '<optgroup label="' + niveles[i].nivel + '">';
						for (var j = 0; j < niveles[i].articulos.length; j++)
						{
							if (niveles[i].articulos[j].idarticulo === idarticulo)
							{

								html_opciones += '<option selected value="' + niveles[i].articulos[j].idarticulo + '">' + niveles[i].articulos[j].nombre + '</option>';
							}
							else
							{
								html_opciones += '<option value="' + niveles[i].articulos[j].idarticulo + '">' + niveles[i].articulos[j].nombre + '</option>';

							}

						}
						html_opciones += '</optgroup>';
					}
				}
				$('#selecciona-cambio-articulo').html(html_opciones);
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[escuela_entrega.js] [listarCambioNivelesArticulos] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[escuela_entrega.js] [listarCambioNivelesArticulos] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function confirmarCambioLibroEntrega()
{
	var id_articulo_selecionado = parseInt($('#selecciona-cambio-articulo').val());
	var idprograma = g_venta_actual.idprograma;
	var idventa = g_venta_actual.idventa;
	var lista_ventas = [];
	lista_ventas.push(
	{
		idventa: idventa
	});

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
			idarticulo: id_articulo_selecionado
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
				mostrarEsperaAjax('');
				$.ajax(
				{
					url: '../sistema/x/venta.php',
					type: 'POST',
					dataType: 'json',
					timeout: config_ajax_timeout,
					data:
					{
						op: 'establecerEstatusEntregaVentaEntregadaEscuelaCursoBatch',
						idescuela: g_venta_actual.idescuela,
						idcurso: g_venta_actual.idcurso,
						lista_venta: lista_ventas
					},
					error: function(xhr, status, error)
					{
						ocultarEsperaAjax();
						console.error('[escuela_entrega.js] [confirmarExcel] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
						bootbox.alert('Error connecting to the server, please contact support or try again later...');
					},
					success: function(data)
					{
						ocultarEsperaAjax();
						if (data.resultado === 'OK')
						{
							nadata = data.detalles;
							if( nadata.no_actualizados.length === 1){
								bootbox.alert('¡El estatus de entrega o el estatus de pago de la venta no permite marcarla como entregada!');
							} 
							else
							{							
								bootbox.alert(data.mensaje);
								location.reload(true);
							}
						}
						else if (data.resultado === 'ERROR_TOKEN')
						{
							console.warn('[escuela_entrega.js] [establecerEstatusEntregaVentaEntregadaEscuelaCursoBatch] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
							bootbox.alert(data.mensaje);
							$(location).attr('href', '../login.php');
						}
						else
						{
							console.warn('[escuela_entrega.js] [establecerEstatusEntregaVentaEntregadaEscuelaCursoBatch] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
							bootbox.alert(data.mensaje);
						}
					}
				}).done(function() {});
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[escuela-entrega.js] [cambiarArticuloEnVentaAlumno] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[escuela-entrega.js] [cambiarArticuloEnVentaAlumno] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

init();