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
				<!--<h1 class="h3 mb-5 font-weight-normal">Portal para usuarios <strong>Helbling</strong> en <strong><?php echo strtoupper($_SESSION['web_subdominio']); ?></strong></h1>-->
			</div>
		</div>
		
		<br>
		<br>
		
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<h1 class="h3 mb-3 font-weight-normal">Recuperación de <strong>contraseña</strong></h1>
				<br>
				<h6>Proporciona el correo electrónico con el que te registraste.</h6>
				<h6>Te enviaremos una recuperación de contraseña a esa dirección.</h6>
				<br>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-md-12">
				<form id="form-usuario" class="form-signin">
					<div class="form-row">
						<div class="col-md-12 mb-12">
							<input type="text" class="form-control" id="usuario-login" name="usuario-login" placeholder="Correo Electrónico" value="">
							<div class="valid-feedback">Validaremos que este registrado...</div>
							<div class="invalid-feedback" id="usuario-login-mensaje"></div>
						</div>
					</div>
					<br>
					<button class="btn btn-primary" type="submit"><i class="fas fa-lock"></i> Recuperar mi contraseña</button>
				</form>
				<br>
				<button type="button" class="btn btn-link" id="cancelar-recuperacion"><i class="fas fa-arrow-left"></i> Cancelar y regresar a la página de login</button>
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
		    
			function mostrarEsperaAjax(mensaje) {
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

				var anim = animaciones[Math.floor(Math.random() * animaciones.length)];

				$('body').loadingModal({
					position: 'auto',
					text: mensaje,
					color: '#fff',
					opacity: '0.7',
					backgroundColor: 'rgb(0,0,0)',
					animation: anim
				});
			}

			function ocultarEsperaAjax() {
				var delay = function(ms) {
					return new Promise(function(r) {
						setTimeout(r, ms)
					})
				};
				var time = 500;
				delay(time)
					.then(function() {
						$('body').loadingModal('hide');
						return delay(time);
					})
					.then(function() {
						$('body').loadingModal('destroy');
					});
			}

			$('#usuario-login').change(function() {
				validarDatosUsuario('usuario-login');
			});

			$('#cancelar-recuperacion').click(function() {
				$(location).attr('href', 'login.php');
			});

			$('#form-usuario').on('submit', function(e) {
				e.preventDefault();
				var dominio = '<?php echo $_SESSION['web_subdominio']; ?>';
				var validacion = validarDatosUsuario('todos');
				if (validacion == false) {
					bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
					return;
				}
				$.ajax({
					url: '../sistema/x/login.php',
					type: 'POST',
					dataType: 'json',
					timeout: config_ajax_timeout,
					data: {
						op: 'validarLoginRegistrado',
						login: $('#usuario-login').val(),
						dominio: dominio
					},
					error: function(xhr, status, error) {
						console.error('[recuperar_password.php] [ready] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
						bootbox.alert('Error connecting to the server, please contact support or try again later...');
					},
					success: function(data) {
						if (data.resultado === 'OK') 
						{
						    mostrarEsperaAjax('');
							$.ajax({
								url: '../sistema/x/login.php',
								type: 'POST',
								dataType: 'json',
								timeout: config_ajax_timeout,
								data: {
									op: 'recuperarPassword',
									login: $('#usuario-login').val(),
									dominio: dominio
								},
								error: function(xhr, status, error) {
								    ocultarEsperaAjax();
									console.error('[recuperar_password.php] [ready] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
					            	bootbox.alert('Error connecting to the server, please contact support or try again later...');
								},
								success: function(data) {
								    ocultarEsperaAjax();
									if (data.resultado === 'OK') {
										bootbox.alert('<i class="fas fa-check"></i> ' + data.mensaje, function() {
											$(location).attr('href', 'login.php');
										});
									} else {
										console.warn('[recuperar_password.php] [ready] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
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