// Arreglos para las zonas, subzonas y escuelas
var g_lista_zonas = new Array();
var g_lista_subzonas = new Array();

// Arreglos específicos para el mapa
var g_mapa_subzonas = new Array();

// Selecciones para las zonas, subzonas y escuelas en el mapa
var g_mapa_interacciones = true;
var g_mapa_zona_seleccionada_id = -1;
var g_mapa_subzona_seleccionada_id = -1;

// Selecciones para las escuelas
var g_lista_escuelas = new Array();

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Hace lo que dice
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function initMapa() {

	var usuario = JSON.parse(localStorage.getItem('usuario'));
	if (usuario.usuario_rol == 'alumno') {
		return;
	}

	$('#mapa-zona-select').html('<option value="">Selecciona una zona</option>');
	$('#mapa-zona-select').selectpicker('refresh');
	$('#mapa-subzona-select').html('<option value="">Selecciona un estado</option>');
	$('#mapa-subzona-select').selectpicker('html_subzonas');
	$('#programa-select').html('<option value="">Selecciona un programa de Inglés</option>');
	$('#programa-select').selectpicker('refresh');
	$('#curso-select').html('<option value="">Selecciona un curso</option>');
	$('#curso-select').selectpicker('refresh');
	mapa_crearMapa();
	mapa_cargarSelectZonas(g_lista_zonas);
	mapa_crearTablaEscuelas();
	mapa_contarEscuelasSeleccionadas();
	$('#escuelas-seleccionar-todas').click(function() {
		var tabla = $('#mapa-tabla-escuelas').DataTable();
		if (tabla.rows()) {
			tabla.rows().select();
		}
		mapa_contarEscuelasSeleccionadas();
	});
	$('#escuelas-seleccionar-ninguna').click(function() {
		var tabla = $('#mapa-tabla-escuelas').DataTable();
		if (tabla.rows()) {
			tabla.rows().deselect();
		}
		mapa_contarEscuelasSeleccionadas();
	});
	$('#navegacion-boton-mapa').click(function() {
		$('#mapa-modal').modal();
		$('#mapa-modal').on('shown.bs.modal', function() {
			window.dispatchEvent(new Event('resize'));
		});
	});
	var mapa_escuelas_seleccionadas = JSON.parse(localStorage.getItem('mapa_escuelas_seleccionadas'));
    if (!mapa_escuelas_seleccionadas || mapa_escuelas_seleccionadas.length === 0)
    {
        //bootbox.alert('¡Bienvenido!<br><br>¡Por favor selecciona un conjunto de escuelas con las que estarás trabajando durante tu sesión!');
        $('#mapa-modal').modal();
		$('#mapa-modal').on('shown.bs.modal', function() {
			window.dispatchEvent(new Event('resize'));
		});
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Crea el mapa e inicializa la variable g_mapa_subzonas que contiene un arreglo con todas las subzonas disponibles
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_crearMapa() {
	var dominio = JSON.parse(localStorage.getItem('dominio'));
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
	$('#vmap').vectorMap({
		map: 'mx_en',
		enableZoom: true,
		showTooltip: true,
		backgroundColor: '#a5bfdd',
		borderColor: '#818181',
		borderOpacity: 0.25,
		borderWidth: 1,
		color: '#f4f3f0',
		hoverColor: '#c9dfaf',
		hoverOpacity: null,
		normalizeFunction: 'polynomial',
		scaleColors: ['#b6d6ff', '#005ace'],
		selectedColor: '#c9dfaf',
		regionsSelectable: true,
		regionsSelectableOne: true,
		regionStyle: {
			initial: {
				fill: '#eee',
				'fill-opacity': 1,
				stroke: 'black',
				'stroke-width': 0.5,
				'stroke-opacity': 1
			},
			hover: {
				fill: '#000000',
				'fill-opacity': 0.5,
				cursor: 'pointer'
			},
			selected: {
				fill: '#3333'
			},
			selectedHover: {}
		},
		regionLabelStyle: {
			initial: {
				'font-family': 'Verdana',
				'font-size': '12',
				'font-weight': 'bold',
				cursor: 'default',
				fill: 'black'
			},
			hover: {
				cursor: 'pointer'
			}
		},
		series: {
			regions: [{
				values: zonas_codigos,
				scale: zonas_colores,
				normalizeFunction: 'polynomial'
			}]
		},
		onRegionSelected: function(element, code, region, isSelected) {
			if (g_mapa_interacciones == true) {
				var regiones = $('#vmap').vectorMap('get', 'mapObject').getSelectedRegions();
				if (regiones.length === 1) {
					$('#vmap').vectorMap('get', 'mapObject').setFocus({
						region: code,
						animate: true
					});
					var subzona = obtenerObjectoEnArreglo(g_mapa_subzonas, 'estado_codigo', code);
					var zona = obtenerObjectoEnArreglo(g_lista_zonas, 'idzona', subzona.zona_id);
					g_mapa_zona_seleccionada_id = zona.idzona;
					g_mapa_subzona_seleccionada_id = subzona.estado_codigo;
					mapa_cargarSelectZonasSubzonasDesdeMapa(g_mapa_zona_seleccionada_id, g_mapa_subzona_seleccionada_id, true);
				}
			}
		},
		onRegionTipShow: function(e, el, code) {
			/*var zona = zonas_codigos[code];
			if (zona !== undefined) {
			    var subzona = obtenerObjectoEnArreglo(g_mapa_subzonas, 'estado_codigo', code);
			    var subzona_escuelas_total = subzona.escuelas_total;
			    el.html(zona + ' • ' + el.html() + ' • ' + subzona_escuelas_total + ' escuelas');
			} else {
			    el.html('¡No hay escuelas de ' + dominio + ' en ' + el.html() + '!');
			}*/
			el.html('');
		}
	});
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Carga el select de zonas y subzonas cuando se interactua con el mapa
// EN: Dont touch this or I'll break you fucking legs! >:'v
// ES: No lo toques o te rompo tus lindas piernas! XOXO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_cargarSelectZonasSubzonasDesdeMapa(zona_seleccionada_id, subzona_seleccionada_id, cargarEscuelas) {
	g_lista_subzonas = new Array();
	var html_zonas = '<option value="none">Selecciona una zona</option>';
	html_zonas += '<option value="all">Todas</option>';
	var html_subzonas = '<option value="none">Selecciona un estado</option>';
	html_subzonas += '<option value="all">Todos</option>';
	var escuelas = new Array();
	for (var i = 0; i < g_lista_zonas.length; i++) {
		html_zonas += '<option value="' + g_lista_zonas[i].idzona + '">' + g_lista_zonas[i].nombre + '</option>';
		var subzonas = g_lista_zonas[i].subzonas;
		for (var j = 0; j < subzonas.length; j++) {
			// if (subzonas[j].estado_codigo === Number(subzona_seleccionada_id))
			if (subzonas[j].estado_codigo === subzona_seleccionada_id) {
				html_subzonas += '<option value="' + subzonas[j].estado_codigo + '">' + subzonas[j].estado_nombre + '</option>';
				escuelas = subzonas[j].escuelas;
			}
			g_lista_subzonas.push(subzonas[j]);
		}
	}
	$('#mapa-zona-select').html(html_zonas);
	$('#mapa-zona-select').val(zona_seleccionada_id);
	$('#mapa-zona-select').selectpicker('refresh');
	$('#mapa-subzona-select').html(html_subzonas);
	$('#mapa-subzona-select').val(subzona_seleccionada_id);
	$('#mapa-subzona-select').selectpicker('refresh');
	if (cargarEscuelas === true) {
		mapa_obtenerEscuelas(escuelas);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Carga el select de zonas
// EN: Dont touch this or I'll break you fucking legs! >:'v
// ES: No lo toques o te rompo tus lindas piernas! XOXO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_cargarSelectZonas(lista_zonas) {

	var html_zonas = '<option value="none">Selecciona una zona</option>';
	html_zonas += '<option value="all">Todas</option>';
	for (var i = 0; i < lista_zonas.length; i++) {
		html_zonas += '<option value="' + lista_zonas[i].idzona + '">' + lista_zonas[i].nombre + '</option>';
	}
	$('#mapa-zona-select').html(html_zonas);
	$('#mapa-zona-select').selectpicker('refresh');
	$('#mapa-zona-select').change(function() {
		g_mapa_zona_seleccionada_id = $('#mapa-zona-select').val();
		mapa_seleccionarZona(g_mapa_zona_seleccionada_id, true);
	});
	g_mapa_zona_seleccionada_id = 'none';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Selecciona una zona
// EN: Dont touch this or I'll break you fucking legs! >:'v
// ES: No lo toques o te rompo tus lindas piernas! XOXO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_seleccionarZona(zona_seleccionada_id, cargarEscuelas) {
	var mapa_regiones = new Array();
	var lista_subzonas = new Array();
	var escuelas = new Array();
	// ¿Ninguna zona?
	if (zona_seleccionada_id === 'none') {
		g_mapa_interacciones = false;
		$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
		$('#vmap').vectorMap('get', 'mapObject').setFocus({
			scale: 0.38094693877551017,
			lat: 0,
			lng: 447.51125016071666,
			x: 0.5,
			y: 0.5,
			animate: true
		});
		g_mapa_interacciones = true;
		if (cargarEscuelas === true) {
			mapa_obtenerEscuelas(null);
		}
	}
	// ¿Todas las zonas?
	else if (zona_seleccionada_id === 'all') {
		// Recorrer todas las subzonas de todas las zonas y obtener las escuelas y las regiones para el mapa
		for (var i = 0; i < g_mapa_subzonas.length; i++) {
			mapa_regiones.push(g_mapa_subzonas[i].estado_codigo);
			lista_subzonas.push(g_mapa_subzonas[i]);
			var subzona_escuelas = g_mapa_subzonas[i].escuelas;
			for (var j = 0; j < subzona_escuelas.length; j++) {
				escuelas.push(subzona_escuelas[j]);
			}
		}
		g_mapa_interacciones = false;
		if (mapa_regiones.length > 0) {

			$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
			$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
			$('#vmap').vectorMap('get', 'mapObject').setFocus({
				scale: 0.38094693877551017,
				lat: 0,
				lng: 447.51125016071666,
				x: 0.5,
				y: 0.5,
				animate: true
			});
		} else {
			$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
			$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
			$('#vmap').vectorMap('get', 'mapObject').setFocus({
				scale: 0.38094693877551017,
				lat: 0,
				lng: 447.51125016071666,
				x: 0.5,
				y: 0.5,
				animate: true
			});
		}
		g_mapa_interacciones = true;
		if (cargarEscuelas === true) {
			mapa_obtenerEscuelas(escuelas);
		}
	}
	// ¿Una zona en particular?
	else {
		// Recorrer todas las subzonas de la zona y obtener las escuelas y las regiones para el mapa
		for (var i = 0; i < g_mapa_subzonas.length; i++) {
			if (g_mapa_subzonas[i].zona_id === Number(zona_seleccionada_id)) {
				mapa_regiones.push(g_mapa_subzonas[i].estado_codigo);
				lista_subzonas.push(g_mapa_subzonas[i]);
				var subzona_escuelas = g_mapa_subzonas[i].escuelas;
				for (var j = 0; j < subzona_escuelas.length; j++) {
					escuelas.push(subzona_escuelas[j]);
				}
				break;
			}
		}
		g_mapa_interacciones = false;
		if (mapa_regiones.length > 0) {

			$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
			$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
			$('#vmap').vectorMap('get', 'mapObject').setFocus({
				region: mapa_regiones,
				animate: true
			});
		} else {
			$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
			$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
			$('#vmap').vectorMap('get', 'mapObject').setFocus({
				scale: 0.38094693877551017,
				lat: 0,
				lng: 447.51125016071666,
				x: 0.5,
				y: 0.5,
				animate: true
			});
		}
		g_mapa_interacciones = true;
		if (cargarEscuelas === true) {
			mapa_obtenerEscuelas(escuelas);
		}
	}
	window.dispatchEvent(new Event('resize'));
	mapa_cargarSelectSubzonas(lista_subzonas);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Carga el select de subzonas
// EN: Dont touch this or I'll break you fucking legs! >:'v
// ES: No lo toques o te rompo tus lindas piernas! XOXO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_cargarSelectSubzonas(lista_subzonas) {
	g_lista_subzonas = new Array();
	var html_subzonas = '<option value="none">Selecciona un estado</option>';
	if (!(g_mapa_zona_seleccionada_id === 'none')) {
		html_subzonas += '<option value="all">Todos</option>';
	}
	for (var i = 0; i < lista_subzonas.length; i++) {
		var subzona = lista_subzonas[i];
		html_subzonas += '<option value="' + subzona.estado_codigo + '">' + subzona.estado_nombre + '</option>';
		g_lista_subzonas.push(subzona);
	}
	$('#mapa-subzona-select').html(html_subzonas);
	$('#mapa-subzona-select').selectpicker('refresh');
	$('#mapa-subzona-select').change(function() {
		g_mapa_subzona_seleccionada_id = $('#mapa-subzona-select').val();
		mapa_seleccionarSubZona(g_mapa_subzona_seleccionada_id, true);
	});
	g_mapa_subzona_seleccionada_id = 'none';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Selecciona una subzona
// EN: Dont touch this or I'll break you fucking legs! >:'v
// ES: No lo toques o te rompo tus lindas piernas! XOXO
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_seleccionarSubZona(subzona_seleccionada_id, cargarEscuelas) {
	var mapa_regiones = new Array();
	var escuelas = new Array();
	// ¿Ninguna subzona?
	if (subzona_seleccionada_id === 'none') {
		g_mapa_interacciones = false;
		$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
		g_mapa_interacciones = true;
		if (cargarEscuelas === true) {
			mapa_obtenerEscuelas(null);
		}
	}
	// ¿Todas las subzonas?
	else if (subzona_seleccionada_id === 'all') {
		// ¿En todas las zonas?
		if (g_mapa_zona_seleccionada_id === 'all') {
			// Recorrer todas las subzonas de todas las zonas y obtener las escuelas y las regiones para el mapa
			for (var i = 0; i < g_mapa_subzonas.length; i++) {
				mapa_regiones.push(g_mapa_subzonas[i].estado_codigo);
				var subzona_escuelas = g_mapa_subzonas[i].escuelas;
				for (var j = 0; j < subzona_escuelas.length; j++) {
					escuelas.push(subzona_escuelas[j]);
				}
			}
			g_mapa_interacciones = false;
			if (mapa_regiones.length > 0) {

				$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
				$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
				$('#vmap').vectorMap('get', 'mapObject').setFocus({
					region: mapa_regiones,
					animate: true
				});

			} else {
				$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
				$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
				$('#vmap').vectorMap('get', 'mapObject').setFocus({
					scale: 0.38094693877551017,
					lat: 0,
					lng: 447.51125016071666,
					x: 0.5,
					y: 0.5,
					animate: true
				});
			}
			g_mapa_interacciones = true;
			if (cargarEscuelas === true) {
				mapa_obtenerEscuelas(escuelas);
			}
		}
		// ¿En una zona en particular?
		else {
			// Recorrer todas las subzonas de la zona y obtener las escuelas y las regiones para el mapa
			for (var i = 0; i < g_mapa_subzonas.length; i++) {
				if (g_mapa_subzonas[i].zona_id === Number(g_mapa_zona_seleccionada_id)) {
					mapa_regiones.push(g_mapa_subzonas[i].estado_codigo);
					var subzona_escuelas = g_mapa_subzonas[i].escuelas;
					for (var j = 0; j < subzona_escuelas.length; j++) {
						escuelas.push(subzona_escuelas[j]);
					}
				}
			}
			g_mapa_interacciones = false;
			if (mapa_regiones.length > 0) {

				$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
				$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
				$('#vmap').vectorMap('get', 'mapObject').setFocus({
					region: mapa_regiones,
					animate: true
				});

			} else {
				$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
				$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
				$('#vmap').vectorMap('get', 'mapObject').setFocus({
					scale: 0.38094693877551017,
					lat: 0,
					lng: 447.51125016071666,
					x: 0.5,
					y: 0.5,
					animate: true
				});
			}
			g_mapa_interacciones = true;
			if (cargarEscuelas === true) {
				mapa_obtenerEscuelas(escuelas);
			}
		}
	}
	// ¿Una subzona en particular?
	else {
		// ¿En todas las zonas?
		if (g_mapa_zona_seleccionada_id === 'all') {
			// Recorrer todas las subzonas de todas la zonas y obtener las escuelas y las regiones para el mapa
			for (var i = 0; i < g_mapa_subzonas.length; i++) {
				// ¿Es esta la zona de la subzona seleccionada?
				// if (g_mapa_subzonas[i].estado_codigo === Number(subzona_seleccionada_id)) {
				if (g_mapa_subzonas[i].estado_codigo === subzona_seleccionada_id) {
					g_mapa_zona_seleccionada_id = g_mapa_subzonas[i].zona_id;
					mapa_regiones.push(g_mapa_subzonas[i].estado_codigo);
					var subzona_escuelas = g_mapa_subzonas[i].escuelas;
					for (var j = 0; j < subzona_escuelas.length; j++) {
						escuelas.push(subzona_escuelas[j]);
					}
					break;
				}
			}
			mapa_seleccionarZona(g_mapa_zona_seleccionada_id, false);
			$('#mapa-zona-select').val(g_mapa_zona_seleccionada_id);
			$('#mapa-zona-select').selectpicker('render');
			$('#mapa-subzona-select').val(subzona_seleccionada_id);
			$('#mapa-subzona-select').selectpicker('render');
			g_mapa_interacciones = false;
			if (mapa_regiones.length > 0) {

				$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
				$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
				$('#vmap').vectorMap('get', 'mapObject').setFocus({
					region: mapa_regiones,
					animate: true
				});

			} else {
				$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
				$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
				$('#vmap').vectorMap('get', 'mapObject').setFocus({
					scale: 0.38094693877551017,
					lat: 0,
					lng: 447.51125016071666,
					x: 0.5,
					y: 0.5,
					animate: true
				});
			}
			g_mapa_interacciones = true;
			if (cargarEscuelas === true) {
				mapa_obtenerEscuelas(escuelas);
			}
		}
		// ¿En una zona en particular?
		else {
			// Encontrar la subzona y obtener las escuelas y las regiones para el mapa
			for (var i = 0; i < g_mapa_subzonas.length; i++) {
				// ¿Es esta la zona de la subzona seleccionada?
				// if (g_mapa_subzonas[i].estado_codigo === Number(subzona_seleccionada_id)) {
				if (g_mapa_subzonas[i].estado_codigo === subzona_seleccionada_id) {
					mapa_regiones.push(g_mapa_subzonas[i].estado_codigo);
					var subzona_escuelas = g_mapa_subzonas[i].escuelas;
					for (var j = 0; j < subzona_escuelas.length; j++) {
						escuelas.push(subzona_escuelas[j]);
					}
					break;
				}
			}
			g_mapa_interacciones = false;
			if (mapa_regiones.length > 0) {

				$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
				$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
				$('#vmap').vectorMap('get', 'mapObject').setFocus({
					region: mapa_regiones,
					animate: true
				});

			} else {
				$('#vmap').vectorMap('get', 'mapObject').clearSelectedRegions();
				$('#vmap').vectorMap('get', 'mapObject').setSelectedRegions(mapa_regiones);
				$('#vmap').vectorMap('get', 'mapObject').setFocus({
					scale: 0.38094693877551017,
					lat: 0,
					lng: 447.51125016071666,
					x: 0.5,
					y: 0.5,
					animate: true
				});
			}
			g_mapa_interacciones = true;
			if (cargarEscuelas === true) {
				mapa_obtenerEscuelas(escuelas);
			}
		}
	}
	window.dispatchEvent(new Event('resize'));
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Crea la tabla de escuelas, duh...
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_crearTablaEscuelas() {
	var tabla = $('#mapa-tabla-escuelas').DataTable({
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
			lengthMenu: 'Mostrar  _MENU_  escuelas',
			search: 'Filtrar',
			zeroRecords: ' ',
			infoFiltered: '(Se filtraron _MAX_ escuelas)',
			info: 'Mostrando _START_ a _END_ de _TOTAL_ escuelas',
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
				title: 'Alias',
				data: 'alias'
			},
			{
				title: 'Selección',
				className: 'select-checkbox',
				data: 'seleccionar'
			},
			{
				title: 'Nombre',
				data: 'nombre'
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
				title: 'Distribuidor',
				data: 'distribuidor'
			}
		]
	});
	tabla.on('select', function(e, dt, type, indexes) {
		mapa_contarEscuelasSeleccionadas();
		mapa_actualizarEscuelasSeleccionadas();
	});
	tabla.on('deselect', function(e, dt, type, indexes) {
		mapa_contarEscuelasSeleccionadas();
		mapa_actualizarEscuelasSeleccionadas();
	});
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Carga las escuelas indicadas y llena la tabla
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_obtenerEscuelas(escuelas) {
	g_lista_escuelas = escuelas;
	if (!escuelas || escuelas.length === 0) {
		var tabla = $('#mapa-tabla-escuelas').DataTable();
		tabla.clear();
		tabla.draw();
		tabla.columns.adjust();
		mapa_contarEscuelasSeleccionadas();
	} else {
		var lista_idescuela = new Array();
		for (var i = 0; i < escuelas.length; i++) {
			lista_idescuela.push(escuelas[i].idescuela);
		}
		$.ajax({
			url: '../sistema/x/escuela.php',
			type: 'POST',
			dataType: 'json',
			timeout: config_ajax_timeout,
			data: {
				op: 'obtenerEscuelasEnLista',
				lista_idescuela: lista_idescuela
			},
			error: function(xhr, status, error) {
				console.error('[escuela.js] [mapa_obtenerEscuelas] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
				bootbox.alert('Error connecting to the server, please contact support or try again later...');
				mapa_contarEscuelasSeleccionadas();
			},
			success: function(data) {
				if (data.resultado === 'OK') {
					var escs = data.detalles;
					for (var i = 0; i < escs.length; i++) {
						escs[i].seleccionar = '';
					}
					var tabla = $('#mapa-tabla-escuelas').DataTable();
					tabla.clear();
					tabla.rows.add(escs);
					tabla.order([0, 'asc']);
					tabla.draw();
					tabla.columns.adjust();
					mapa_contarEscuelasSeleccionadas();
				} else {
					console.warn('[escuela.js] [mapa_obtenerEscuelas] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
					bootbox.alert(data.mensaje);
					mapa_contarEscuelasSeleccionadas();
				}
			}
		}).done(function() {});
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Cuenta las escuelas seleccionadas
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_contarEscuelasSeleccionadas() {
	var tabla = $('#mapa-tabla-escuelas').DataTable();
	var filas = tabla.rows();
	if (filas) {
		$('#mapa-escuelas-total').html(filas.count());
	} else {
		$('#mapa-escuelas-total').html(0);
	}
	var seleccion = tabla.rows('.selected').data();
	if (seleccion) {
		$('#mapa-escuelas-seleccionadas').html(seleccion.length);
	} else {
		$('#mapa-escuelas-seleccionadas').html(0);
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Actualiza las escuelas seleccionadas
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mapa_actualizarEscuelasSeleccionadas() {
	var super_escuelas = new Array();
	var tabla = $('#mapa-tabla-escuelas').DataTable();
	var selecciones = tabla.rows('.selected').data();
	if (selecciones.length === 0) {
		localStorage.setItem('mapa_escuelas_seleccionadas', JSON.stringify(''));
	} else {
		for (var i = 0; i < g_mapa_subzonas.length; i++) {
			var subzona_actual = {
				codigo: g_mapa_subzonas[i].estado_codigo,
				nombre: g_mapa_subzonas[i].estado_nombre,
				escuelas: new Array()
			};
			var subzona_escuelas = g_mapa_subzonas[i].escuelas;
			for (var j = 0; j < subzona_escuelas.length; j++) {
				for (var k = 0; k < selecciones.length; k++) {
					if (subzona_escuelas[j].idescuela === selecciones[k].idescuela) {
						subzona_actual.escuelas.push(subzona_escuelas[j]);
					}
				}
				super_escuelas.push(subzona_actual);
			}
		}
		localStorage.setItem('mapa_escuelas_seleccionadas', JSON.stringify(super_escuelas));
    	var sPath = window.location.pathname;
    	if (sPath === '/coordinador/cuenta.php')
    	{
    	    listarEscuelasSeleccionadas();
    	}
	}
}