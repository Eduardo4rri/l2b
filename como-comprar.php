<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/sistema.php';
	
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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

<body>
	<div class="container">
		<div class="row">
		    <div class="col-xs-12 col-md-12">
    			<article id="post-108" class="post-108 page type-page status-publish hentry">
    				<header class="entry-header">
    					<h1 class="entry-title">Guía para comprar.</h1>
    					<br>
    				</header>
    				<div class="entry-content text-justify">
    				    <br>
    				    <br>
    				    <ol>
    						<li>
    						    Ingresa a <strong><?php echo $_SESSION['web_host']; ?></strong>.
    						</li>
    						<br>
    						<li>
    						    Haz click en <strong>Registrarse como alumno</strong>.
    						</li>
    						<br>
    						<li>
    						    Ingresa tu información: <strong>Nombre, Apellidos, Matrícula, Teléfono, Correo electrónico, y Contraseña</strong>.
    					    </li>
    						<br>
    						<li>
    						    Una vez registrado, recibirás un correo electrónico de bienvenida.
    						</li>
    						<br>
    						<li>
    						    Inicia sesión en <strong><?php echo $_SESSION['web_host']; ?></strong> con tu correo electrónico y contraseña.
    						</li>
    						<br>
    						<li>
    						    Selecciona <strong>Tienda</strong> en el menú superior, esto te llevará al proceso de compra, el cual consiste en 4 pasos: <strong>Registro, Compra, Pago y Entrega</strong>.
    						</li>
    						<br>
    						<li>
    						    Procede al paso 1: <strong>Registro</strong>.
    						</li>
    						<br>
    						<li>
    						    Busca y elige tu escuela.
    						</li>
    						<br>
    						<li>
    						    Selecciona tu programa.
    						</li>
    						<br>
    						<li>
    						    Confirma tus datos y procede al paso 2: <strong>Compra</strong>.
    						</li>
    						<br>
    						<li>
    						    Selecciona el nivel a cursar, se mostrará el libro del nivel seleccionado. <strong>Nota</strong>: Si no sabes cuál es tu nivel, selecciona <strong>Nivel por Asignar</strong>.
    						</li>
    						<br>
    						<li>
    						    Haz click en <i class="fa fa-shopping-cart"></i> <strong>Seleccionar</strong> debajo de la portada del libro del nivel seleccionado para agregarlo al carrito.
    						</li>
    						<br>
    						<li>
    						    Si el libro seleccionado no es el correcto, puedes vaciar el contenido del carrito haciendo click en el ícono <i class="fa fa-shopping-cart"></i> y luego seleccionando la opción <i class="fas fa-trash"></i> <strong>Vaciar Carrito</strong>, posteriormente podrás seleccionar el nivel y libro correcto.
    						</li>
    						<br>
    						<li>
    						    Confirma tus datos y procede al paso 3: <strong>Pago</strong>.
    						</li>
    						<br>
    						<li>
    						    Elige tu forma de pago: <strong>OXXO</strong>, <strong>SPEI</strong> o <strong>Tarjeta Bancaria</strong>. Para <strong>Tarjeta Bancaria</strong> ingresa los datos de tu tarjeta, para <strong>OXXO</strong> y <strong>SPEI</strong> no es necesario capturar información adicional.
    						</li>
    						<br>
    						<li>
    						    Confirma tus datos y procede al paso 4: <strong>Entrega</strong>.
    						</li>
    						<br>
    						<li>
    						    Si en el paso 3: <strong>Pago</strong> elegiste <strong>OXXO</strong> o <strong>SPEI</strong> haz click en <i class="fas fa-print"></i> <strong>Imprimir instrucciones de pago</strong>, se abrirá una nueva ventana con los pasos necesarios para completar tu pago mediante <strong>OXXO</strong> (número de referencia) o <strong>SPEI</strong> (número de cuenta CLABE). Si elegiste <strong>Tarjeta Bancaria</strong> no hace falta hacer nada más ya que el pago ya habrá sido registrado.
    						</li>
    						<br>
    						<li>
    						    Si tu pago fue en <strong>OXXO</strong>, guarda el comprobante de pago que te entregarán en <strong>OXXO</strong>, si tu pago fue por <strong>SPEI</strong>, guarda el comprobante de tu aplicación bancaria, si tu pago fue por <strong>Tarjeta Bancaria</strong> guarda los datos de la autorización del pago que se mostrarán en la pantalla del paso 4: <strong>Entrega</strong>.
    						</li>
    						<br>
    						<li>
    						    <strong>Opcional: </strong> Puedes descargar e imprimir el PDF de tu compra.
    						</li>
    						<br>
    						<li>
    						    Si ya realizaste el pago correspondiente a tu compra y necesitas cambiar el libro, ponte en contacto con nosotros mandando un email a <a style="color: #007bff; cursor: pointer;" href="mailto:<?php echo PRO_EMAIL_SOPORTE; ?>" target="_top"><?php echo PRO_EMAIL_SOPORTE; ?></a>.
    						</li>
    						<br>
    						<li>
    						    Acude a tu escuela con tu comprobante de pago para la entrega de tu libro.
    						</li>
    						<br>
    						<li>
    						    <strong>¡Disfruta de tu curso!</strong>
    						</li>
    					</ol>
    					<br>
    					<br>
    				    Ante cualquier duda, favor de contactarnos en: <a style="color: #007bff; cursor: pointer;" href="mailto:<?php echo PRO_EMAIL_SOPORTE; ?>" target="_top"><?php echo PRO_EMAIL_SOPORTE; ?></a>
    				    <br>
    				    <br>
    				</div>
    			</article>
			</div>
		</div>
	</div>
</body>

</html>