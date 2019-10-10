function init(){
    cargarUsuarioDistribuidor();
    cargarDatosDistribuidor();
    
    
    // Validaciones de campo lleno o vacio
    ////// Campos de Información personal
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
	$('#usuario-lada').change(function() {
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
	////// Campos de Información de distribución
	$('#distribuidor-nombre').change(function()
	{
		validarDatosDistribuidor('distribuidor-nombre');
	});
	$('#distribuidor-alias').change(function()
	{
		validarDatosDistribuidor('distribuidor-alias');
	});
	$('#distribuidor-lada').change(function()
	{
		validarDatosDistribuidor('distribuidor-lada');
	});
	$('#distribuidor-telefono').change(function()
	{
		validarDatosDistribuidor('distribuidor-telefono');
	});
	$('#distribuidor-estado').change(function()
	{
		validarDatosDistribuidor('distribuidor-estado');
	});
	$('#distribuidor-ciudad').change(function()
	{
		validarDatosDistribuidor('distribuidor-ciudad');
	});
	$('#distribuidor-colonia').change(function()
	{
		validarDatosDistribuidor('distribuidor-colonia');
	});
	$('#distribuidor-codigo-postal').change(function()
	{
		validarDatosDistribuidor('distribuidor-codigo-postal');
	});
	$('#distribuidor-calle').change(function()
	{
		validarDatosDistribuidor('distribuidor-calle');
	});
	$('#distribuidor-numero-exterior').change(function()
	{
		validarDatosDistribuidor('distribuidor-numero-exterior');
	});
	/////////////////////////////////////////////////////////
	// Botones de guardar
	$('#distribuidor-guardar-datos').click(function()
	{
		guardarDatosDistribuidor();
	});
	$('#usuario-guardar-datos').click(function()
	{
		guardarDatosUsuario();
	});
	$('#usuario-guardar-clave').click(function()
	{
		guardarClaveUsuario();
	});
}



function cargarUsuarioDistribuidor() {
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
			console.error('[cuenta.js] [cargarUsuarioDistribuidor] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
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
				if(primera_validacion >= 0 && segunda_validacion >= 0){
				    var split_usr_telefono = usr_telefono.split(')');
    				var usr_lada = split_usr_telefono[0].substring(1, split_usr_telefono[0].length);
    				var usr_numero = split_usr_telefono[1];
    				$('#usuario-lada').val(usr_lada);
    				$('#usuario-telefono').val(usr_numero);
				}else{
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
				console.warn('[cuenta.js] [cargarUsuarioDistribuidor] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function cargarDatosDistribuidor() {
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	$.ajax(
	{
		url: '../sistema/x/usuario.php',
		type: 'POST',
		dataType: 'json',
		timeout: config_ajax_timeout,
		data:
		{
			op: 'obtenerUsuarioDistribuidor',
			idusuario: usuario.usuario_idusuario
		},
		error: function(xhr, status, error)
		{
			console.error('[cuenta.js] [cargarDatosDistribuidor] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			if (data.resultado === 'OK')
			{
				var usuario = data.detalles;
				var usr_telefono = usuario.usuario_telefono_contacto;
				usr_telefono += '';
				var primera_validacion = usr_telefono.indexOf('(');
				var segunda_validacion = usr_telefono.indexOf(')');
				if(primera_validacion >= 0 && segunda_validacion >= 0){
				    var split_usr_telefono = usr_telefono.split(')');
    				var usr_lada = split_usr_telefono[0].substring(1, split_usr_telefono[0].length);
    				var usr_numero = split_usr_telefono[1];
    				$('#distribuidor-lada').val(usr_lada);
    				$('#distribuidor-telefono').val(usr_numero);
				}else{
    				$('#usuario-telefono').val(usuario.usuario_telefono);
				}
				$('#distribuidor-id').val(usuario.usuario_iddistribuidor);
				$('#distribuidor-nombre').val(usuario.usuario_nombre);
				$('#distribuidor-correo').val(usuario.usuario_correo_contacto);
				$('#distribuidor-ciudad').val(usuario.usuario_ciudad);
				$('#distribuidor-estado').val(usuario.usuario_estado);
				$('#distribuidor-codigo-postal').val(usuario.usuario_codigo_postal);
				$('#distribuidor-dominio').val(usuario.usuario_dominio.toUpperCase());
				$('#distribuidor-alias').val(usuario.usuario_alias);
				$('#distribuidor-calle').val(usuario.usuario_calle);
				$('#distribuidor-numero-exterior').val(usuario.usuario_num_exterior);
				$('#distribuidor-numero-interior').val(usuario.usuario_num_interior);
				$('#distribuidor-colonia').val(usuario.usuario_colonia);
				$('#confirmacion-distribuidor-nombre').text(usuario.usuario_nombre);
				$('#confirmacion-distribuidor-telefono').text(usuario.usuario_telefono_contacto);
				$('#confirmacion-distribuidor-correo').text(usuario.usuario_correo_contacto);
				$('#confirmacion-distribuidor-ciudad').text(usuario.usuario_ciudad);
				$('#confirmacion-distribuidor-estado').text(usuario.usuario_estado);
				$('#confirmacion-distribuidor-codigo-postal').text(usuario.usuario_codigo_postal);
				$('#confirmacion-distribuidor-dominio').text(usuario.usuario_dominio.toUpperCase());
				$('#confirmacion-distribuidor-alias').text(usuario.usuario_alias);
				$('#confirmacion-distribuidor-calle').text(usuario.usuario_calle);
				$('#confirmacion-distribuidor-numero-exterior').text(usuario.usuario_num_exterior);
				$('#confirmacion-distribuidor-numero-interior').text(usuario.usuario_num_interior);
				$('#confirmacion-distribuidor-colonia').text(usuario.usuario_colonia);
				var validacion = validarDatosDistribuidor('todos');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cuenta.js] [cargarDatosDistribuidor] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function validarDatosDistribuidor(campo)
{
	var errores = 0;
	if (campo === 'todos' || campo === 'distribuidor-nombre')
	{
		if (!$('#distribuidor-nombre').val())
		{
			$('#distribuidor-nombre').removeClass('is-valid');
			$('#distribuidor-nombre').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#distribuidor-nombre').removeClass('is-invalid');
			$('#distribuidor-nombre').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'distribuidor-alias')
	{
		if (!$('#distribuidor-alias').val())
		{
			$('#distribuidor-alias').removeClass('is-valid');
			$('#distribuidor-alias').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#distribuidor-alias').removeClass('is-invalid');
			$('#distribuidor-alias').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'distribuidor-telefono')
	{
		if (!$('#distribuidor-telefono').val())
		{
			$('#distribuidor-telefono').removeClass('is-valid');
			$('#distribuidor-telefono').addClass('is-invalid');
			errores++;
		}
		else
		{
			$('#distribuidor-telefono').removeClass('is-invalid');
			$('#distribuidor-telefono').addClass('is-valid');
		}
	}
	if (campo === 'todos' || campo === 'distribuidor-lada') 
	{
        if (!$('#distribuidor-lada').val()) 
        {
            $('#distribuidor-lada').removeClass('is-valid');
            $('#distribuidor-lada').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-lada').removeClass('is-invalid');
            $('#distribuidor-lada').addClass('is-valid');
        }
    }
    if (campo === 'todos' || campo === 'distribuidor-dominio') 
	{
        if (!$('#distribuidor-dominio').val()) 
        {
            $('#distribuidor-dominio').removeClass('is-valid');
            $('#distribuidor-dominio').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-dominio').removeClass('is-invalid');
            $('#distribuidor-dominio').addClass('is-valid');
        }
    }
    if (campo === 'todos' || campo === 'distribuidor-correo') 
	{
        if (!$('#distribuidor-correo').val()) 
        {
            $('#distribuidor-correo').removeClass('is-valid');
            $('#distribuidor-correo').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-correo').removeClass('is-invalid');
            $('#distribuidor-correo').addClass('is-valid');
        }
    }
    if (campo === 'todos' || campo === 'distribuidor-estado') 
	{
        if (!$('#distribuidor-estado').val()) 
        {
            $('#distribuidor-estado').removeClass('is-valid');
            $('#distribuidor-estado').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-estado').removeClass('is-invalid');
            $('#distribuidor-estado').addClass('is-valid');
        }
    }
    if (campo === 'todos' || campo === 'distribuidor-ciudad') 
	{
        if (!$('#distribuidor-ciudad').val()) 
        {
            $('#distribuidor-ciudad').removeClass('is-valid');
            $('#distribuidor-ciudad').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-ciudad').removeClass('is-invalid');
            $('#distribuidor-ciudad').addClass('is-valid');
        }
    }
    if (campo === 'todos' || campo === 'distribuidor-colonia') 
	{
        if (!$('#distribuidor-colonia').val()) 
        {
            $('#distribuidor-colonia').removeClass('is-valid');
            $('#distribuidor-colonia').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-colonia').removeClass('is-invalid');
            $('#distribuidor-colonia').addClass('is-valid');
        }
    }
    if (campo === 'todos' || campo === 'distribuidor-codigo-postal') 
	{
        if (!$('#distribuidor-codigo-postal').val()) 
        {
            $('#distribuidor-codigo-postal').removeClass('is-valid');
            $('#distribuidor-codigo-postal').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-codigo-postal').removeClass('is-invalid');
            $('#distribuidor-codigo-postal').addClass('is-valid');
        }
    }
    if (campo === 'todos' || campo === 'distribuidor-calle') 
	{
        if (!$('#distribuidor-calle').val()) 
        {
            $('#distribuidor-calle').removeClass('is-valid');
            $('#distribuidor-calle').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-calle').removeClass('is-invalid');
            $('#distribuidor-calle').addClass('is-valid');
        }
    }
    if (campo === 'todos' || campo === 'distribuidor-numero-exterior') 
	{
        if (!$('#distribuidor-numero-exterior').val()) 
        {
            $('#distribuidor-numero-exterior').removeClass('is-valid');
            $('#distribuidor-numero-exterior').addClass('is-invalid');
            errores++;
        } else {
            $('#distribuidor-numero-exterior').removeClass('is-invalid');
            $('#distribuidor-numero-exterior').addClass('is-valid');
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

function guardarDatosDistribuidor()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var validacion = validarDatosUsuario('todos');
	var lada = $('#distribuidor-lada').val();
	var telefono_sin_lada = $('#distribuidor-telefono').val();
	var telefono = '('+lada+')'+telefono_sin_lada;
	
	if(limpiarString(telefono).length != 10)
	{   
	        $('#distribuidor-lada').removeClass('is-valid');
	        $('#distribuidor-lada').addClass('is-invalid');
	        $('#distribuidor-telefono').removeClass('is-valid');
		    $('#distribuidor-telefono').addClass('is-invalid');

	    bootbox.alert('Hay errores de validación en tu teléfono, por favor correctamente este campo');
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
			op: 'actualizarDatosDistribuidor',
			idusuario: usuario.usuario_idusuario,
			nombre: limpiarString($('#distribuidor-nombre').val()),
			alias: limpiarString($('#distribuidor-alias').val()),
			telefono: telefono,
			estado: limpiarString($('#distribuidor-estado').val()),
			ciudad: limpiarString($('#distribuidor-ciudad').val()),
			colonia: $('#distribuidor-colonia').val(),
			codigo_postal: $('#distribuidor-codigo-postal').val(),
			calle: $('#distribuidor-calle').val(),
			num_exterior: $('#distribuidor-numero-exterior').val(),
			num_interior: $('#distribuidor-numero-interior').val()
		},
		error: function(xhr, status, error)
		{
			ocultarEsperaAjax();
			console.error('[cuenta.js] [guardarDatosDistribuidor] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
			bootbox.alert('Error connecting to the server, please contact support or try again later...');
		},
		success: function(data)
		{
			ocultarEsperaAjax();
			if (data.resultado === 'OK')
			{
				cargarDatosDistribuidor();
				$('#distribuidor-modal').modal('hide');
			}
			else if (data.resultado === 'ERROR_TOKEN')
			{
				console.warn('[cuenta.js] [cargarDatosUsuario] • The server encountered a token problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
				$(location).attr('href', '../login.php');
			}
			else
			{
				console.warn('[cuenta.js] [guardarDatosDistribuidor] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
				bootbox.alert(data.mensaje);
			}
		}
	}).done(function() {});
}

function guardarDatosUsuario()
{
	var usuario = JSON.parse(localStorage.getItem('usuario'));
	var validacion = validarDatosUsuario('todos');
	var lada = $('#usuario-lada').val();
	var telefono_sin_lada = $('#usuario-telefono').val();
	var telefono = '('+lada+')'+telefono_sin_lada;
	
	 if(limpiarString(telefono).length != 10)
	{   
	     if(lada.length<3){
	         $('#usuario-lada').removeClass('is-valid');
	         $('#usuario-lada').addClass('is-invalid');
	     }
	     else if(telefono_sin_lada.length<7)
	     {
	        $('#usuario-telefono').removeClass('is-valid');
		    $('#usuario-telefono').addClass('is-invalid');
	     }

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
			matricula: $('#usuario-matricula').val(),
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
				cargarUsuarioDistribuidor();
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
	if (campo === 'todos' || campo === 'usuario-lada') {
        if (!$('#usuario-lada').val()) {
            $('#usuario-lada').removeClass('is-valid');
            $('#usuario-lada').addClass('is-invalid');
            errores++;
        } else {
            $('#usuario-lada').removeClass('is-invalid');
            $('#usuario-lada').addClass('is-valid');
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
				cargarUsuarioDistribuidor();
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

init();