function init() {
    crearMapa();
    crearTablaPedido();
    cargarZonas();
    cargarGraficaBarras();
    cargarGraficaDonut();
    $('#zona-select').html('<option value="">Selecciona una zona</option>');
    $('#zona-select').selectpicker('refresh');
    $('#subzona-select').html('<option value="">Selecciona un estado</option>');
    $('#subzona-select').selectpicker('html_subzonas');
    ocultarAvisoToast();
    
}
$('#graficas-materiales-AJ').click(function()
	{
	    console.log('AJ');
		cargarGraficaDonut();
	});
	$('#graficas-materiales-J').click(function()
	{
	    console.log('J');
		cargarGraficaDonut();
	});
	$('#graficas-materiales-FR').click(function()
	{
	    console.log('FR');
		cargarGraficaDonut();
	});
	$('#graficas-materiales-FRP').click(function()
	{
	    console.log('FRP');
		cargarGraficaDonut();
	});
function cargarZonas() {

}

function crearMapa() {
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

            }]
        },
        onRegionSelected: function(element, code, region, isSelected) {

        },
        onRegionTipShow: function(e, el, code) {

        }
    });
}

var dataSet = [
    [ "Nixon", "", "Tiger Nixon", "System Architect", "Edinburgh", "5421", "2011/04/25", "$320,800", "$320,800" ],
    [ "Garrett", "", "Garrett Winters", "Accountant", "Tokyo", "8422", "2011/07/25", "$170,750", "$320,800" ],
    [ "Ashton", "", "Ashton Cox", "Junior Technical Author", "San Francisco", "1562", "2009/01/12", "$86,000", "$320,800" ],
    [ "Cedric", "", "Cedric Kelly", "Senior Javascript Developer", "Edinburgh", "6224", "2012/03/29", "$433,060", "$320,800" ],
    [ "Airi", "", "Airi Satou", "Accountant", "Tokyo", "5407", "2008/11/28", "$162,700", "$320,800" ],
    [ "Brielle Williamson", "", "sdfs", "Integration Specialist", "New York", "4804", "2012/12/02", "$372,000", "$320,800" ],
    [ "Herrod Chandler", "", "gdfgd", "Sales Assistant", "San Francisco", "9608", "2012/08/06", "$137,500", "$320,800" ],
    [ "Rhona Davidson", "", "dgfgd", "Integration Specialist", "Tokyo", "6200", "2010/10/14", "$327,900", "$320,800" ],
    [ "Colleen Hurst", "", "dfgd", "Javascript Developer", "San Francisco", "2360", "2009/09/15", "$205,500", "$320,800" ],
    [ "Sonya Frost", "", "dfg", "Software Engineer", "Edinburgh", "1667", "2008/12/13", "$103,600", "$320,800" ],
    [ "Jena Gaines", "", "dfgdfg", "Office Manager", "London", "3814", "2008/12/19", "$90,560", "$320,800" ],
    [ "Quinn Flynn", "", "dfgdf", "Support Lead", "Edinburgh", "9497", "2013/03/03", "$342,000", "$320,800" ],
    [ "Charde Marshall", "", "sdfsdf", "Regional Director", "San Francisco", "6741", "2008/10/16", "$470,600", "$320,800" ],
    [ "Haley Kennedy", "", "sdfsdf", "Senior Marketing Designer", "London", "3597", "2012/12/18", "$313,500", "$320,800" ],
    [ "Tatyana Fitzpatrick", "", "sdfsgdfg", "Regional Director", "London", "1965", "2010/03/17", "$385,750", "$320,800" ],
    [ "Michael Silva", "", "sdfsdf", "Marketing Designer", "London", "1581", "2012/11/27", "$198,500", "$320,800" ]
];

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
		select: {
			style: 'multi',
			selector: 'td:nth-child(2)'
		},
		data: dataSet,
		columns: [{
				title: 'Alias',
				//data: 'alias'
			},
			{
				title: 'Selección',
				className: 'select-checkbox',
				//data: 'seleccionar'
			},
			{
				title: 'Nombre',
				//data: 'nombre'
			},
			{
				title: 'Ciudad',
				//data: 'ciudad'
			},
			{
				title: 'Estado',
				//data: 'estado'
			},
			{
				title: 'Ventas Pendientes',
				//data: 'ventas_pendientes'
			},
			{
				title: 'Ventas Pagadas',
				//data: 'ventas_pagadas' 
			},
			{
				title: 'Ventas Totales',
				//data: 'ventas_totales'
			},
			{
				title: 'Detalles de la Orden',
				//data: 'detalle_orden'
			}
		]
	});
	tabla.on('select', function(e, dt, type, indexes) {
		
	});
}

function cargarGraficaBarras() {

    var grafica_meses = document.getElementById('myBarChart');
    var grafica_AJ = {
        label: 'AJ',
        data: [5427, 1243, 3514, 1933, 2326, 4687, 271, 638, 700, 300, 800, 200],
        backgroundColor: '#00cc66',
        lineTension: 0,
        borderWidth: 0,
        yAxisID: 'y-AJ',
        fill: false

    };
    var grafica_J = {
        label: 'BN',
        data: [1427, 1243, 1514, 1933, 1326, 2872, 3271, 2638, 3400, 1400, 2000, 1300],
        backgroundColor: '#0084c9',
        lineTension: 0,
        borderWidth: 0,
        yAxisID: 'y-J'

    };
    var grafica_FR = {
        label: 'RN',
        data: [3427, 2243, 1514, 1933, 1326, 1687, 2271, 2638, 1000, 2000, 1000, 2000],
        backgroundColor: '#79C753',
        lineTension: 0,
        borderWidth: 0,
        yAxisID: 'y-FR'

    };
    var grafica_FRP = {
        label: 'NK',
        data: [427, 243, 514, 933, 326, 687, 271, 638, 1500, 2300, 1800, 3000],
        backgroundColor: '#678574',
        lineTension: 0,
        borderWidth: 0,
        yAxisID: 'y-FRP'

    };
    var meses = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        datasets: [grafica_AJ, grafica_J, grafica_FR, grafica_FRP]

    };
    var charOptions = {
        scales: {
            xAxes: [{
                barpercentaje: 1,
                categoryPercentage: 0.5,
            }],
            yAxes: [{
                id: 'y-AJ'
            }, {
                id: 'y-J',
                display: false
            }, {
                id: 'y-FR',
                display: false

            }, {
                id: 'y-FRP',
                display: false
            }]

        }
    }
    var chart_meses = new Chart(grafica_meses, {
        type: 'bar',
        data: meses,
        options: charOptions
    });
}

function cargarGraficaDonut() {

    // Inicializar las banderas de materiales seleccionados en FALSE
    var graficas_materiales_americanjetstream_seleccionado = false;
    var graficas_materiales_jetstream_seleccionado = false;
    var graficas_materiales_forreal_seleccionado = false;
    var graficas_materiales_forrealplus_seleccionado = false;

    // Revisar que checkboxes est��n seleccionados
    graficas_materiales_americanjetstream_seleccionado = ($('#graficas-materiales-AJ').is(':checked') === true ? true : false);
    graficas_materiales_jetstream_seleccionado = ($('#graficas-materiales-J').is(':checked') === true ? true : false);
    graficas_materiales_forreal_seleccionado = ($('#graficas-materiales-FR').is(':checked') === true ? true : false);
    graficas_materiales_forrealplus_seleccionado = ($('#graficas-materiales-FRP').is(':checked') === true ? true : false);

    // Arreglos para los componenetes de la gr��fica
    var grafica_etiquetas = [],
        grafica_valores = [],
        grafica_colores = [],
        grafica_hovers = [];

    // �0�7American Jetstream seleccionado?
    if (graficas_materiales_americanjetstream_seleccionado === true) {
        grafica_etiquetas.push('American Jetstream');
        grafica_valores.push(40);
        grafica_colores.push("#4e73df");
        grafica_hovers.push("#2e59d9");
    }

    // �0�7Jetstream seleccionado?
    if (graficas_materiales_jetstream_seleccionado === true) {
        grafica_etiquetas.push('Jetstream');
        grafica_valores.push(30);
        grafica_colores.push("#1cc88a");
        grafica_hovers.push("#2e59d9");
    }

    // �0�7For Real seleccionado?
    if (graficas_materiales_forreal_seleccionado === true) {
        grafica_etiquetas.push('For Real');
        grafica_valores.push(30);
        grafica_colores.push("#00b2aa");
        grafica_hovers.push("#2e59d9");
    }

    // �0�7For Real Plus seleccionado?
    if (graficas_materiales_forrealplus_seleccionado === true) {
        grafica_etiquetas.push('For Real +');
        grafica_valores.push(20);
        grafica_colores.push("#00cc66");
        grafica_hovers.push("#17a673");
    }

    // T��tulos para la gr��fica
    var titulos = ['American Jetstream', 'Jetstream', 'For Real', 'For Real +'];

    // Crear la gr��fica
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: titulos,
            datasets: [{
                data: grafica_valores,
                backgroundColor: grafica_colores,
                hoverBackgroundColor: grafica_hovers,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: true
            },
            cutoutPercentage: 80,
        },
    });
}

init();