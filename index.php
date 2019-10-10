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

<br>
<br>

<body class="py-5">
	<div class="container py-5">
		<div class="row">
			<div class="col-md-12 text-center">
				<img class="mb-5" src="sistema/img/sitio_logo_2920x1436.png" alt="" width="400px" height="200px">
			</div>
			<div class="col-md-12 text-center">
			    <br>
			    <br>
				<h3>¡Bienvenido a <strong><?php echo PRO_NOMBRE; ?>!</strong></h3>
			</div>
		</div>
	</div>
</body>

</html>

<?php

    ob_end_flush();

?>