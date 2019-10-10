<?php
	
	session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(), '', 0, '/');
    require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/sistema.php';
    ob_start();

?>

<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/x-icon" href="sistema/img/sitio_icono_32x32.png" />
	
	<!-- Title -->
	<title><?php echo PRO_NOMBRE; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="sistema/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="sistema/css/signin.css" rel="stylesheet">
	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
      /*@medias queries
       Screen de imagenes
      */
		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>
	
	<!-- Font Awesome CSS -->
	<link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">

	<!-- Loading Modal -->
	<link href="sistema/vendor/loading-modal/css/jquery.loadingModal.min.css" rel="stylesheet">

</head>

<body class="text-center bg-white">

	<div class="modal fade" id="terminos-modal" tabindex="-1" role="dialog" aria-labelledby="terminos-modal-label" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90% !important; width: 90% !important;" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="terminos-modal-label"><i class="fas fa-file-alt"></i><strong> Términos y condiciones</strong></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="container">
                                <iframe src="terminos-y-condiciones.php" height="500" width="100%" style="border:0"></iframe>
                            </div>
                        </div>
                    </div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
	    
	    <!-- Alert Tiempo EMail -->
    	<?php
    	
        	if (MENSAJE_NOTIFICACION_ESPERA_EMAIL)
        	{
        	    echo '<div class="row">
                        <div class="col-xs-12 col-md-12 mt-2">
                        	<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        		' . MENSAJE_NOTIFICACION_ESPERA_EMAIL_TEXTO . '
                        		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        			<span aria-hidden="true">&times;</span>
                        		</button>
                        	</div>
                        </div>
                    </div>';
            }
             
          ?>
	    
	    <br>
	    <br>
	    
	    <div class="row">
			<div class="col-xs-12 col-md-12">
				<img class="mb-5" src="sistema/img/<?php echo $_SESSION['web_subdominio_imagen']; ?>" alt="" width="200px" height="200px">
			    <img src="sistema/img/sitio_logo_contraste_365x180.png">
				<!--<h1 class="h3 mb-5 font-weight-normal"><strong><?php echo PRO_NOMBRE; ?></strong></h1>-->
				<h1 class="h3 mb-5 font-weight-normal">Registrarse como <strong>alumno</strong> en <strong><?php echo strtoupper($_SESSION['web_subdominio']); ?></strong></h1>
			</div>
		</div>
	    
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<form id="form-usuario">
					<div class="form-row">
						<div class="col-md-4 mb-3">
							<label for="usuario-nombre">Nombre(s)</label>
							<input type="text" class="form-control" id="usuario-nombre" name="usuario-nombre" placeholder="Nombre" value="">
							<div class="invalid-feedback">Por favor completa este campo</div>
						</div>
						<div class="col-md-4 mb-3">
							<label for="usuario-apellido-paterno">Apellido Paterno</label>
							<input type="text" class="form-control" id="usuario-apellido-paterno" name="usuario-apellido-paterno" placeholder="Apellido Paterno" value="">
							<div class="invalid-feedback">Por favor completa este campo</div>
						</div>
						<div class="col-md-4 mb-3">
							<label for="usuario-apellido-materno">Apellido Materno</label>
							<input type="text" class="form-control" id="usuario-apellido-materno" name="usuario-apellido-materno" placeholder="Apellido Materno" value="">
							<div class="invalid-feedback">Por favor completa este campo</div>
						</div>
					</div>
					<br>
					<div class="form-row">
							<div class="col-md-2 mb-3"></div>
                            <div class="col-md-4 mb-3">
                                <label for="usuario-matricula">Matrícula</label>
                                <input type="text" class="form-control" id="usuario-matricula" name="usuario-matricula" placeholder="Matrícula" value="">
                                <div class="invalid-feedback">Por favor completa este campo</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="row">
                                    <div class="col-md-4 mb-3" style="padding-right:2px;">
                                        <label for="usuario-lada" type="tel">Lada</label>
                                        <input class="form-control" id="usuario-lada" name="usuario-lada" placeholder="Lada" value="" type="text" maxlength="3" onkeypress="return validarDatosNumericos(event)" >
                                        <div class="invalid-feedback">Por favor completa este campo</div>
                                    </div>
                                    <div class="col-md-8 mb-3" style="padding-left:2px;">
                                        <label for="usuario-telefono" type="tel">Teléfono</label>
                                        <input type="text" class="form-control" id="usuario-telefono" name="usuario-telefono" placeholder="Telefono" value="" maxlength="8" onkeypress="return validarDatosNumericos(event)"  >
                                        <div class="invalid-feedback">Por favor completa este campo</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3"></div>
                    </div>
					<br>
					<div class="form-row justify-content-md-center">
						<div class="col-md-4 mb-3">
							<label for="usuario-login">Correo Electrónico</label>
							<input type="text" class="form-control" id="usuario-login" name="usuario-login" placeholder="Correo Electrónico" value="" onpaste="return false;">
							<div class="valid-feedback">Validaremos que este disponible...</div>
							<div class="invalid-feedback" id="usuario-login-mensaje"></div>
				    	</div>
						<div class="col-md-4 mb-3">
							<label for="usuario-login-confirmar">Confirmar Correo Electrónico</label>
							<input type="text" class="form-control" id="usuario-login-confirmar" name="usuario-login-confirmar" placeholder="Confirmar Correo Electrónico" value="" onpaste="return false;">
							<div class="invalid-feedback">Debe coincidir con el correo electrónico anterior</div>
						</div>
					</div>
					<br>
					<div class="form-row justify-content-md-center">
						<div class="col-md-4 mb-3">
							<label for="usuario-clave">Contraseña</label>
							<input type="password" class="form-control" id="usuario-clave" name="usuario-clave" placeholder="Contraseña" value="" onpaste="return false;">
							<div class="invalid-feedback">Mínimo 6 caracteres</div>
						</div>
						<div class="col-md-4 mb-3">
							<label for="usuario-clave-confirmar">Confirmar Contraseña</label>
							<input type="password" class="form-control" id="usuario-clave-confirmar" name="usuario-clave-confirmar" placeholder="Confirmar Contraseña" value="" onpaste="return false;">
							<div class="invalid-feedback">Debe coincidir con la contraseña anterior</div>
						</div>
					</div>
					<br>
					<div class="form-group text-center">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="usuario-terminos-condiciones" name="usuario-terminos-condiciones">
							<label class="form-check-label" for="usuario-terminos-condiciones" data-toggle="modal" data-target="#terminos-modal">
								<p><u>Acepto los términos y condiciones</u></p>
							</label>
						</div>
					</div>
					<button class="btn btn-primary" type="submit"><i class="fas fa-graduation-cap"></i> Registrar</button>
				</form>
				<br>
				<button type="button" class="btn btn-link" id="cancelar-registro"><i class="fas fa-arrow-left"></i> Cancelar y regresar a la página de login</button>
			</div>
		</div>

		<br>
		<br>

	</div>

	<!-- Bootstrap core JavaScript -->
	<script src="sistema/vendor/jquery/jquery.min.js"></script>
	<script src="sistema/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Bootbox -->
	<script src="sistema/vendor/bootbox/bootbox.min.js"></script>
	<script src="sistema/vendor/bootbox/bootbox.locales.min.js"></script>

	<!-- Loading Modal -->
	<script src="sistema/vendor/loading-modal/js/jquery.loadingModal.min.js"></script>

	<!-- Sistema -->
	<script src="../sistema/config/sistema.js?token=<?php echo $token; ?>"></script>

	<!-- Página -->
	<script>
		$(document).ready(function() {
		    localStorage.clear();
			$('#usuario-nombre').change(function() {
				validarDatosUsuario('usuario-nombre');
			});
			$('#usuario-apellido-paterno').change(function() {
				validarDatosUsuario('usuario-apellido-paterno');
			});
			$('#usuario-apellido-materno').change(function() {
				validarDatosUsuario('usuario-apellido-materno');
			});
			$('#usuario-login').change(function() {
				$('#usuario-login-confirmar').val('');				
				validarDatosUsuario('usuario-login');
				validarDatosUsuario('usuario-login-confirmar');
			});
			$('#usuario-login-confirmar').change(function() {
				validarDatosUsuario('usuario-login-confirmar');
			});
			$('#usuario-clave').change(function() {
				$('#usuario-clave-confirmar').val('');
				validarDatosUsuario('usuario-clave');
				validarDatosUsuario('usuario-clave-confirmar');
			});
			$('#usuario-clave-confirmar').change(function() {
				validarDatosUsuario('usuario-clave-confirmar');
			});
			$('#usuario-terminos-condiciones').change(function() {
				validarDatosUsuario('usuario-terminos-condiciones');
			});
			$('#cancelar-registro').click(function() {
				$(location).attr('href', 'login.php');
			});
			$('#usuario-matricula').change(function() {
               validarDatosUsuario('usuario-matricula');
            });
            $('#usuario-telefono').change(function() {
                validarDatosUsuario('usuario-telefono');
            });
            $('#usuario-lada').change(function() {
                validarDatosUsuario('usuario-lada');
            });
			
			$('#form-usuario').on('submit', function(e) {
				e.preventDefault();
                var lada = $('#usuario-lada').val(),
            	    telefono_sin_lada = $('#usuario-telefono').val(),
            	    telefono = '(' + lada + ')' + telefono_sin_lada;
            	
            	if(limpiarString(telefono).length != 10)
                {   
                	        $('#usuario-lada').removeClass('is-valid');
                	        $('#usuario-lada').addClass('is-invalid');
                	        $('#usuario-telefono').removeClass('is-valid');
                		    $('#usuario-telefono').addClass('is-invalid');

                	    bootbox.alert('Hay errores de validación en tu teléfono, por favor ingresa los 10 digitos solicitados');
                		return;
                 }

				$('#usuario-login-confirmar').bind("paste",function(e) {
				    e.preventDefault();
				});
				$('#usuario-clave').bind("paste",function(e) {
				    e.preventDefault();
				});
    
            	
				var validacion = validarDatosUsuario('todos');
				if (validacion == false) {
					bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
					return;
				}
                
            	var dominio = '<?php echo $_SESSION['web_subdominio']; ?>';
				$.ajax({
					url: '../sistema/x/login.php',
					type: 'POST',
					dataType: 'json',
					timeout: config_ajax_timeout,
					data: {
						op: 'validarLoginDisponible',
						login: $('#usuario-login').val(),
						dominio: dominio
					},
					error: function(xhr, status, error) {
						console.error('[registro_alumno.php] [ready] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
						bootbox.alert('Error connecting to the server, please contact support or try again later...');
					},
					success: function(data) {
						if (data.resultado === 'OK') {
						    mostrarEsperaAjax('');
							$.ajax({
								url: '../sistema/x/login.php',
								type: 'POST',
								dataType: 'json',
								timeout: config_ajax_timeout,
								data: {
									op: 'registrarAlumno',
									nombre: limpiarString($('#usuario-nombre').val()),
									apellido_paterno: limpiarString($('#usuario-apellido-paterno').val()),
									apellido_materno: limpiarString($('#usuario-apellido-materno').val()),
									telefono: telefono,
									matricula:$('#usuario-matricula').val(),
									login: $('#usuario-login').val(),
									clave: $('#usuario-clave').val(),
									dominio: dominio
								},
								error: function(xhr, status, error) {
								    ocultarEsperaAjax();
									console.error('[registro_alumno.php] [ready] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
									bootbox.alert('Error connecting to the server, please contact support or try again later...');
								},
								success: function(data) {
								    ocultarEsperaAjax();
									if (data.resultado === 'OK' || data.resultado === 'ADVERTENCIA') {
										bootbox.alert('<i class="fas fa-check"></i> ' + data.mensaje, function() {
											$(location).attr('href', 'login.php');
										});
									} else {
										console.warn('[registro_alumno.php] [ready] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
										bootbox.alert(data.mensaje);
									}
								}
							}).done(function() {});
						} else {
							$('#usuario-login').removeClass('is-valid');
							$('#usuario-login').addClass('is-invalid');
							$('#usuario-login-mensaje').text(data.mensaje);
						}
					}
				}).done(function() {});

			});

			function validarEmail(email) {
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return regex.test(email);
			}

			function validarDatosUsuario(campo) {
				var errores = 0;

				if (campo === 'todos' || campo === 'usuario-nombre') {
					if (!$('#usuario-nombre').val()) {
						$('#usuario-nombre').removeClass('is-valid');
						$('#usuario-nombre').addClass('is-invalid');
						errores++;
					} else {
						$('#usuario-nombre').removeClass('is-invalid');
						$('#usuario-nombre').addClass('is-valid');
					}
				}

				if (campo === 'todos' || campo === 'usuario-apellido-paterno') {
					if (!$('#usuario-apellido-paterno').val()) {
						$('#usuario-apellido-paterno').removeClass('is-valid');
						$('#usuario-apellido-paterno').addClass('is-invalid');
						errores++;
					} else {
						$('#usuario-apellido-paterno').removeClass('is-invalid');
						$('#usuario-apellido-paterno').addClass('is-valid');
					}
				}

				if (campo === 'todos' || campo === 'usuario-apellido-materno') {
					if (!$('#usuario-apellido-materno').val()) {
						$('#usuario-apellido-materno').removeClass('is-valid');
						$('#usuario-apellido-materno').addClass('is-invalid');
						errores++;
					} else {
						$('#usuario-apellido-materno').removeClass('is-invalid');
						$('#usuario-apellido-materno').addClass('is-valid');
					}
				}
				
				if (campo === 'todos' || campo === 'usuario-matricula') {
                    if (!$('#usuario-matricula').val()) {
                        $('#usuario-matricula').removeClass('is-valid');
                        $('#usuario-matricula').addClass('is-invalid');
                        errores++;
                    } else {
                        $('#usuario-matricula').removeClass('is-invalid');
                        $('#usuario-matricula').addClass('is-valid');
                    }
                }
                if (campo === 'todos' || campo === 'usuario-telefono') {
                    if (!$('#usuario-telefono').val()) {
                        $('#usuario-telefono').removeClass('is-valid');
                        $('#usuario-telefono').addClass('is-invalid');
                        errores++;
                    } else {
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

				if (campo === 'todos' || campo === 'usuario-login') {
					if (!$('#usuario-login').val() || !validarEmail($('#usuario-login').val())) {
						$('#usuario-login').removeClass('is-valid');
						$('#usuario-login').addClass('is-invalid');
						$('#usuario-login-mensaje').text('Por favor completa este campo');
						errores++;
					} else {
						$('#usuario-login').removeClass('is-invalid');
						$('#usuario-login').addClass('is-valid');
					}
				}

				if (campo === 'todos' || campo === 'usuario-login-confirmar') {
					if (!$('#usuario-login-confirmar').val() || $('#usuario-login-confirmar').val().length < 6 || $('#usuario-login').val() != $('#usuario-login-confirmar').val()) {
						$('#usuario-login-confirmar').removeClass('is-valid');
						$('#usuario-login-confirmar').addClass('is-invalid');
						errores++;
					} else {
						$('#usuario-login-confirmar').removeClass('is-invalid');
						$('#usuario-login-confirmar').addClass('is-valid');
					}
				}

				if (campo === 'todos' || campo === 'usuario-clave') {
					if (!$('#usuario-clave').val() || $('#usuario-clave').val().length < 6) {
						$('#usuario-clave').removeClass('is-valid');
						$('#usuario-clave').addClass('is-invalid');
						errores++;
					} else {
						$('#usuario-clave').removeClass('is-invalid');
						$('#usuario-clave').addClass('is-valid');
					}
				}

				if (campo === 'todos' || campo === 'usuario-clave-confirmar') {
					if (!$('#usuario-clave-confirmar').val() || $('#usuario-clave-confirmar').val().length < 6 || $('#usuario-clave').val() != $('#usuario-clave-confirmar').val()) {
						$('#usuario-clave-confirmar').removeClass('is-valid');
						$('#usuario-clave-confirmar').addClass('is-invalid');
						errores++;
					} else {
						$('#usuario-clave-confirmar').removeClass('is-invalid');
						$('#usuario-clave-confirmar').addClass('is-valid');
					}
				}

				if (campo === 'todos' || campo === 'usuario-terminos-condiciones') {
					if (!$('#usuario-terminos-condiciones').is(':checked') == true) {
						$('#usuario-terminos-condiciones').removeClass('is-valid');
						$('#usuario-terminos-condiciones').addClass('is-invalid');
						errores++;
					} else {
						$('#usuario-terminos-condiciones').removeClass('is-invalid');
						$('#usuario-terminos-condiciones').addClass('is-valid');
					}
				}

				if (errores == 0) {
					return true;
				} else {
					return false;
				}
			}
		});
	</script>

</body>

</html>

<?php

    ob_end_flush();

?>