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

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<link rel="icon" type="image/x-icon" href="sistema/img/sitio_icono_32x32.png" />

	<!-- Title -->
	<title><?php echo PRO_NOMBRE; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="sistema/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="sistema/css/signin.css" rel="stylesheet">

	<!-- Font Awesome CSS -->
	<link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">
</head>

<style>

</style>

<br>
<br>

<body class="py-5">
	<div class="container py-5">
		<div class="row">
			<div class="col-md-12 text-center">
				<p><i class="fa fa-thumbs-up fa-10x"></i><br /></p>
			</div>
			<div class="col-md-12 text-center">
			    <br>
				<h3>¡Hasta luego!</h3>
				<br>
				<h3>¡Gracias por usar la plataforma <strong><?php echo PRO_NOMBRE; ?>!</strong></h3>
				<br>
				<!--<a class="btn btn-primary" href="<?php echo PRO_ORGANIZACION_WEB; ?>"><i class="fa fa-globe"></i> Ir a <?php echo PRO_ORGANIZACION_NOMBRE; ?></a>-->
				<br>
				<br>
				<a class="btn btn-primary" href="login.php"><i class="fa fa-sync-alt"></i> Acceder nuevamente</a>
			</div>
		</div>
	</div>
	
	<!-- Bootstrap core JavaScript -->
	<script src="sistema/vendor/jquery/jquery.min.js"></script>
	<script src="sistema/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	
    <!-- Página -->
    <script>
    	$(document).ready(function() {
    	    
            localStorage.clear();
        
    	});
    </script>

</body>

</html>

<?php

    ob_end_flush();

?>