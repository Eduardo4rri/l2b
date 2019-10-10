<?php
	
	session_start();
	$token = uniqid();
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
	<link href="sistema/vendor/bootstrap/css/bootstrap.min.css?token=<?php echo $token; ?>" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="sistema/css/signin.css" rel="stylesheet">

	<!-- Font Awesome CSS -->
	<link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">

	<!-- Loading Modal -->
	<link href="sistema/vendor/loading-modal/css/jquery.loadingModal.min.css" rel="stylesheet">

    <style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}
        .mensaje-sesion-redireccionamiento{
            position:fixed;
            top:100px;
            
        }
        @media (min-width: 1200px){
             .mensaje-sesion-redireccionamiento{
                max-width:1400px !important;
             }
        }
		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>
	
</head>

<body class="text-center bg-white">
    <!-- Contenedor de inicio de sesión con dominio asignado-->
	<div class="container invisible" id="contener-inicio-sesion-subdominio">
		<br>
		<br>
		<br>
		<div class="row">
			<div class="col-xs-12 col-md-12">
			    <img class="mb-4" src="sistema/img/sitio_logo_contraste_365x180.png?token=<?php echo $token; ?>">
				<!--<h1 class="h3 mb-5 font-weight-normal"><strong><?php echo PRO_NOMBRE; ?></strong></h1>-->
				<!--<h1 class="h3 mb-5 font-weight-normal">Portal para usuarios <strong>Helbling</strong> en <strong><?php echo strtoupper($_SESSION['web_subdominio']); ?></strong></h1>-->
			</div>
		</div>

		<div class="row">		
			<div class="col-xs-12 col-md-12">
				<form id="form-login" class="form-signin">
					<input type="email" id="login" class="form-control" placeholder="Correo electrónico" required autofocus>
					<input type="password" id="clave" class="form-control" placeholder="Contraseña" required>
					<br>
					<button class="btn btn-lg btn-primary btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Iniciar sesión</button>
				</form>
				<button type="button" class="btn btn-link" id="recuperar-clave"><i class="fas fa-lock"></i> Olvidé mi contraseña</button>
				<br>
				<button type="button" class="btn btn-link" id="registro-terminos-y-condiciones"><i class="fas fa-file-alt"></i> Términos y condiciones</button>
				<br>
				<!--<button type="button" class="btn btn-link" id="registro-sub-dominio"><i class="fas fa-globe"></i> Links2Academy</button>-->
				<br>
				<p class="mt-5 mb-5 text-muted"><?php echo PRO_EMPRESA; ?> &copy; <?php echo PRO_ANIOS; ?></p>
			</div>
		</div>

	</div>
   <!--Termina inicio de sesión con dominio asignado -->
    <div class="container mensaje-sesion-redireccionamiento invisible" id="contener-inicio-sesion-sin-subdominio">
        <br>
        <div class="row">
        <div class="col-xs-12 col-md-12 col-ls-12">
			<img src="sistema/img/sitio_logo_contraste_365x180.png">
			<br>
			<br>
            <h5>Este dominio de inicio de sesión no esta asignado </h5>
            <h6>Inicia sesión con  la liga que te fue proporcionada</h6>
        </div>
        </div>
        <br>
    </div>
   <!--Inicio de sesión sin dominio asignado-->
   
   <!--Termino sesión sin dominio asignado-->
   
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
		var dominio_base = '<?php echo $_SESSION['web_dominio']; ?>',
            path_url_actual = window.location.hostname,
            path_name = window.location.pathname;
    	if(dominio_base !== path_url_actual || path_name == '/login-academy.php')
    	{
    	   $('#contener-inicio-sesion-subdominio').removeClass('invisible').addClass('visible');
    	}
    	else
    	{
     	   $('#contener-inicio-sesion-sin-subdominio').removeClass('invisible').addClass('visible');
    	}
    	
		$(document).ready(function() {
			localStorage.clear();
			$('#recuperar-clave').click(function() {
				$(location).attr('href', 'recuperar-password.php');
			});
			$('#registro-alumno').click(function() {
				$(location).attr('href', 'registro-alumno.php');
			});
			$('#registro-coordinador').click(function() {
				$(location).attr('href', 'registro-coordinador.php');
			});
			$('#registro-terminos-y-condiciones').click(function() {
				window.open('terminos-y-condiciones.php', '_blank');
			});
			$('#registro-sub-dominio').click(function() {
				window.open('<?php echo PRO_ORGANIZACION_WEB; ?>', '_blank');
			});
			$('#form-login').on('submit', function(e) {
				e.preventDefault();
				
				/*var navegador = obtenerNavegador();
				var navegador_valido = false;
				if(navegador.nombre === 'Chrome')
				{
				    navegador_valido = true;
				}
				else if (navegador.nombre === 'Firefox')
				{
				    navegador_valido = true;
				}
				else if (navegador.nombre === 'Edge')
				{
				    navegador_valido = true;
				}
				else if (navegador.nombre === 'Safari')
				{
				    navegador_valido = true;
				}
				if (navegador_valido === false)
				{
				    bootbox.alert('¡Por favor utiliza Chrome, Firefox o Safari para poder acceder al sitio!');
				    return;
				}*/
				
				login = $('#login').val();
				clave = $('#clave').val();
				mostrarEsperaAjax('');
				$.ajax({
					url: '../sistema/x/login.php',
					type: 'POST',
					dataType: 'json',
					timeout: config_ajax_timeout,
					data: {
						op: 'login',
						login: login,
						clave: clave,
						dominio: ''
					},
					error: function(xhr, status, error) {
					    ocultarEsperaAjax();
						console.error('[login.php] [ready] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
						bootbox.alert('Error connecting to the server, please contact support or try again later...');
					},
					success: function(data) {
					    ocultarEsperaAjax();
						if (data.resultado === 'OK') 
						{
						        var usuario = data.detalles;
    							var usuario_zonas = usuario.usuario_zonas;
    							delete usuario.usuario_zonas;
    							localStorage.setItem('dominio', JSON.stringify(usuario.usuario_dominio));
    							localStorage.setItem('usuario', JSON.stringify(usuario));
    							localStorage.setItem('usuario_zonas', JSON.stringify(usuario_zonas));
    							var rol = usuario.usuario_rol;
    							if (rol === 'alumno') {
    								$(location).attr('href', 'alumno/cuenta.php');
    							} else if (rol === 'coordinador_dominio' || rol === 'coordinador_zona' || rol === 'coordinador_subzona' || rol === 'coordinador_escuela') {
    							    $(location).attr('href', 'coordinador/cuenta.php');
    							} else if (rol === 'distribuidor_dominio' || rol === 'distribuidor_zona' || rol === 'distribuidor_subzona' || rol === 'distribuidor_escuela') {
    								$(location).attr('href', 'coordinador/cuenta.php');
    							}
						} else {
							console.warn('[login.php] [ready] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
							bootbox.alert(data.mensaje);
						}
					}
				}).done(function() {});
				
			});
		});
		

	</script>

</body>

</html>

<?php

    ob_end_flush();

?>