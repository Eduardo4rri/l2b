function init() {
	crearTablaPedido();
	listarPedidosDeAlumnos();
	$('#actualizar-entregados').click(function(){
		actualizarEntregadoOnLine();
	});
}

function listarPedidosDeAlumnos() {
    var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax({
		url: '../sistema/x/venta.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'obtenerVentasEscuelaCursoEstatus',
			idescuela: '276',
			idcurso: '1',
			pago_estatus: '0'
		},
		error: function(xhr, status, error) {
			console.error('[pedido.js] [listarPedidosDeAlumnos] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
			    var tabla = $('#tabla-pedidos').DataTable();
			    var ndata = data.detalles;
			    for(var i = 0; i < ndata.length; i++){
			        ndata[i].estatus_entrega = '<td><input type="checkbox"></td>'
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
				console.warn('[pedido.js] [listarPedidosDeAlumnos] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function crearTablaPedido() {
	var tabla = $('#tabla-pedidos').DataTable({
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
			lengthMenu: 'Mostrar  _MENU_  pedidos',
			search: 'Filtrar',
			zeroRecords: ' ',
			infoFiltered: '(Se filtraron _MAX_ pedidos)',
			info: 'Mostrando _START_ a _END_ de _TOTAL_ pedidos',
			paginate: {
				first: 'Primero',
				last: 'Último',
				next: 'Siguiente',
				previous: 'Anterior'
			},
		},
		dom: 'Bfrt<"col-md-6 inline"i> <"col-md-6 inline"p>',
		buttons: {
			dom: {
				container: {
					tag: 'div',
					className: 'flexcontent'
				},
				buttonLiner: {
					tag: null
				}
			},
			buttons: [{
					extend: 'excelHtml5',
					text: 'Exportar Excel',
					title: 'PedidosExcel',
					titleAttr: 'Excel',
					className: 'btn btn-success export excel'
				},
				{
					text: 'Import Excel',
					action: function() {
						$('#importar-excel-modal').modal('show');
					},
					className: 'btn btn-success'
				},
				{
					extend: 'pageLength',
					titleAttr: 'Registros',
					className: 'selectTable btn-success'
				}
			]
		},
		data: null,
		columns: [{
				title: 'Venta',
				data: 'idventa'
			},
			{
				title: 'Alumno',
				data: 'comprador_nombre'
			},
			{
				title: 'Matricula',
				data: 'comprador_matricula'
			},
			{
				title: 'Tipo Pago',
				data: 'tipo_pago'
			},
			{
				title: 'Pago Referencia',
				data: 'pago_referencia'
			},
			{
				title: 'Estatus de Pago',
				data: 'estatus_pago_leyenda'
			},
			{
				title: 'Fecha de Pago',
				data: 'pago_fecha'
			},
			{
				title: 'Entregado',
				data: 'estatus_entrega'
			},
			{
				title: 'Estatus de Entrega',
				data: 'estatus_entrega_leyenda'
			},
			{
				title: 'Fecha de Entregado',
				data: 'fecha_entrega'
			}
		]
	});
	tabla.on('select', function(e, dt, type, indexes) {
	    
	});
}

function actualizarEntregadoOnLine() {
    var tabla = $('#tabla-pedidos').DataTable();
    var seleccion = tabla.rows('.selected').data();
    var idventa = new Array();
    for(var i =0; i < seleccion.length; i++){
        idventa.push(seleccion[i].idventa);
    }
    $.ajax({
		url: '../sistema/x/distribuidor.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data: {
			op: 'actualizarEntregadoOnLine',
			idventa: idventa
		},
		error: function(xhr, status, error) {
			console.error('[curso.js] [actualizarEntregadoOnLine] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data) {
			if (data.resultado === 'OK') 
			{
			    listarPedidosDeAlumnos();
			    bootbox.alert("¡Datos de entregas actualizados!");
			} 
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else 
			{
				console.warn('[curso.js] [actualizarEntregadoOnLine] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function ExportToTable() {
	var regex = /^([a-zA-Z0-9\s_\\.\-:()])+(.xlsx|.xls)$/;
	/*Checks whether the file is a valid excel file*/
	if (regex.test($('#subir_file').val().toLowerCase())) {
		var xlsxflag = false; /*Flag for checking whether excel is .xls format or .xlsx format*/
		if ($('#subir_file').val().toLowerCase().indexOf(".xlsx") > 0) {
			xlsxflag = true;
		}
		/*Checks whether the browser supports HTML5*/
		if (typeof(FileReader) != "undefined") {
			var reader = new FileReader();
			reader.onload = function(e) {
				var data = e.target.result;
				/*Converts the excel data in to object*/
				if (xlsxflag) {
					var workbook = XLSX.read(data, {
						type: 'binary'
					});
				} else {
					var workbook = XLS.read(data, {
						type: 'binary'
					});
				}
				/*Gets all the sheetnames of excel in to a variable*/
				var sheet_name_list = workbook.SheetNames;
				var cnt = 0; /*This is used for restricting the script to consider only first sheet of excel*/
				sheet_name_list.forEach(function(y) {
					/*Iterate through all sheets*/
					/*Convert the cell value to Json*/
					if (xlsxflag) {
						var exceljson = XLSX.utils.sheet_to_json(workbook.Sheets[y]);
					} else {
						var exceljson = XLS.utils.sheet_to_row_object_array(workbook.Sheets[y]);
					}
					if (exceljson.length > 0 && cnt == 0) {
						BindTable(exceljson, '#tabla-pedidos');
						cnt++;
					}
				});
				//$('#tabla-pedidos').show();
				$('#importar-excel-modal').modal('hide');
			}
			if (xlsxflag) {
				/*If excel file is .xlsx extension than creates a Array Buffer from excel*/
				reader.readAsArrayBuffer($('#subir_file')[0].files[0]);
			} else {
				reader.readAsBinaryString($('#subir_file')[0].files[0]);
			}
		} else {
			alert("Lo sentimos! Tu buscador no soporta Html5!");
		}
	} else {
		bootbox.alert({
			message: "Por favor carga un archivo Excel (.xlsx)!"
		});
	}
}

function BindTable(jsondata, tableid) {
	/*Function used to convert the JSON array to Html Table*/
	var columns = BindTableHeader(jsondata, tableid); /*Gets all the column headings of Excel*/
	var data = validateColumns(columns);
	console.log(jsondata);
	console.log(data.detalles);
	if (data.resultado === 'OK') {
		var tabla = $(tableid).DataTable();
		tabla.clear();
		tabla.rows.add(jsondata);
		tabla.order([0, 'asc']);
		tabla.draw();
	}
}

function BindTableHeader(jsondata, tableid) {
	/*Function used to get all column names from JSON and bind the html table header*/
	var columnSet = [];
	var headerTr$ = $('<tr/>');
	for (var i = 0; i < jsondata.length; i++) {
		var rowHash = jsondata[i];
		for (var key in rowHash) {
			if (rowHash.hasOwnProperty(key)) {
				if ($.inArray(key, columnSet) == -1) {
					/*Adding each unique column names to a variable array*/
					columnSet.push(key);
					headerTr$.append($('<th/>').html(key));
				}
			}
		}
	}
	//$(tableid).append(headerTr$);
	return columnSet;
}

function validateColumns(columns) {
	var data = {};
	var mensaje = 'Nombra las siguientes columnas del modo correcto<br>';
	var col_venta = false;
	var col_alumno = false;
	var col_matricula = false;
	var col_tipo_pago = false;
	var col_pago_preferencia = false;
	var col_estatus_pago = false;
	var col_fecha_pago = false;
	var col_entregado = false;
	var col_fecha_entregado = false;

	if (columns[0] != 'Venta') {
		mensaje += '• Columna 1 - Venta<br>';
	} else {
		col_venta = true;
		
	}
	if (columns[1] != 'Alumno') {
		mensaje += '• Columna 2 - Alumno<br>';
	} else {
		col_alumno = true;
	}
	if (columns[2] != 'Matricula') {
		mensaje += '• Columna 3 - Matricula<br>';
	} else {
		col_matricula = true;
	}
	if (columns[3] != 'Tipo Pago') {
		mensaje += '• Columna 4 - Tipo pago<br>';
	} else {
		col_tipo_pago = true;
	}
	if (columns[4] != 'Pago Referencia') {
		mensaje += '• Columna 5 - Pago Referencia<br>';
	} else {
		col_pago_preferencia = true;
	}
	if (columns[5] != 'Estatus de Pago') {
		mensaje += '• Columna 6 - Estatus de Pago<br>';
	} else {
		col_estatus_pago = true;
	}
	if (columns[6] != 'Fecha de Pago') {
		mensaje += '• Columna 7 - Fecha de Pago<br>';
	} else {
		col_fecha_pago = true;
	}
	if (columns[7] != 'Entregado') {
		mensaje += '• Columna 8 - Entregado<br>';
	} else {
		col_entregado = true;
	}
	if (columns[8] != 'Estatus de Entrega') {
		mensaje += '• Columna 9 - Estatus Entrega<br>';
	} else {
		col_estatus_pago = true;
	}
	if (columns[9] != 'Fecha de Entregado') {
		mensaje += '• Columna 10 - Fecha de Entregado<br>';
	} else {
		col_fecha_entregado = true;
	}
	if (!col_venta || !col_alumno || !col_matricula || !col_tipo_pago || !col_pago_preferencia || !col_estatus_pago || !col_fecha_pago || !col_entregado || !col_fecha_entregado) {
		bootbox.alert({
			message: mensaje
		});
		data.resultado = 'ERROR';
		data.mensaje = '¡Error en las columnas!';
		data.detalles = null;
	} else {
	    var detalles_new_cols = ['idventa','comprador_nombre','comprador_matricula','tipo_pago','pago_referencia','estatus_pago_leyenda','pago_fecha','estatus_entrega','estatus_entrega_leyenda','fecha_entrega'];
		data.resultado = 'OK';
		data.mensaje = '¡Datos correctos!';
		data.detalles = detalles_new_cols;
	}
	return data;
}

init();