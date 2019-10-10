////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SECCIÓN CONFIGURABLE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// NO MODIFICAR A PARTIR DE ESTE PUNTO
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Configuración y funciones de la aplicación
var config_ajax_timeout = 300000;

function mostrarAvisoToast(titulo, mensaje, tipo, tiempo)
{
	$('#notificacion-mensaje-progreso').html('<strong>' + titulo + ' &#8226; ' + mensaje + '</strong>');
	$('#notificacion-mensaje').removeClass('invisible').addClass('visible');
	$('#notificacion-mensaje').fadeIn();
}

function ocultarAvisoToast()
{
	$('#notificacion-mensaje').fadeOut('slow');

}

function mostrarEsperaAjax(mensaje)
{
	var animaciones = [
		'rotatingPlane',
		'wave',
		'wanderingCubes',
		'spinner',
		'chasingDots',
		'threeBounce',
		'circle',
		'cubeGrid',
		'fadingCircle',
		'foldingCube'
	];
	var anim = animaciones[Math.floor(Math.random() * 10)];
	$('body').loadingModal(
	{
		position: 'auto',
		text: mensaje,
		color: '#fff',
		opacity: '0.7',
		backgroundColor: 'rgb(0,0,0)',
		animation: anim
	});
}

function ocultarEsperaAjax()
{
	var delay = function(ms)
	{
		return new Promise(function(r)
		{
			setTimeout(r, ms)
		})
	};
	var time = 500;
	delay(time)
		.then(function()
		{
			$('body').loadingModal('hide');
			return delay(time);
		})
		.then(function()
		{
			$('body').loadingModal('destroy');
		});
}

function formatearDinero(n, c, d, t)
{
	var c = isNaN(c = Math.abs(c)) ? 2 : c,
		d = d == undefined ? "." : d,
		t = t == undefined ? "," : t,
		s = n < 0 ? "-" : "",
		i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
		j = (j = i.length) > 3 ? j % 3 : 0;
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
}

function obtenerObjectoEnArreglo(array, key, value)
{
	for (var i = 0; i < array.length; i++)
	{
		if (array[i][key] === value)
		{
			return array[i];
		}
	}
	return null;
}

function validarDatosNumericos(event)
{
	if (isNaN(String.fromCharCode(event.keyCode)))
	{
		return false;
	}
}

function limpiarString(string)
{
	var cadena_limpia = string.replace(/[`~´!#$%^&*|+\-=¿?;:'",<>\{\}\[\]\(\)\\\/]/gi, '');
	return cadena_limpia.trim();
}

function obtenerNavegador()
{
	var browser = '';
	var browserVersion = 0;
	if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent))
	{
		browser = 'Opera';
	}
	else if (/MSIE (\d+\.\d+);/.test(navigator.userAgent))
	{
		browser = 'MSIE';
	}
	else if (/Navigator[\/\s](\d+\.\d+)/.test(navigator.userAgent))
	{
		browser = 'Netscape';
	}
	else if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent))
	{
		browser = 'Chrome';
	}
	else if (/Safari[\/\s](\d+\.\d+)/.test(navigator.userAgent))
	{
		browser = 'Safari';
		/Version[\/\s](\d+\.\d+)/.test(navigator.userAgent);
		browserVersion = new Number(RegExp.$1);
	}
	else if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent))
	{
		browser = 'Firefox';
	}
	if (browserVersion === 0)
	{
		browserVersion = parseFloat(new Number(RegExp.$1));
	}
	return {
	    nombre: browser,
	    version: browserVersion
	};
}