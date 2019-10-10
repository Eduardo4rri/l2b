<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/sistema.php';
	
?>

<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<link rel="icon" type="image/x-icon" href="/sistema/img/sitio_icono_32x32.png" />

	<!-- Title -->
	<title><?php echo PRO_NOMBRE; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="/sistema/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/sistema/css/signin.css" rel="stylesheet">

	<!-- Font Awesome CSS -->
	<link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">
</head>

<br>
<br>

<body class="py-5">
	<div class="container py-5">
		<div class="row">
			<div class="col-md-12 text-center">
				<p><i class="fa fa-clock fa-10x"></i><br /></p>
			</div>
			<div class="col-md-12 text-center">
			    <br>
				<h3>¡Sesión caducada por inactividad!</h3>
				<br>
				<a class="btn btn-primary" href="login.php"><i class="fa fa-sync-alt"></i> Acceder nuevamente</a>
			</div>
		</div>
	</div>
</body>

</html>