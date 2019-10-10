<?php

	require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/sistema.php';
    $token = uniqid();
	// Validar SESIÓN PHP
	session_start();
	if (!isset($_SESSION['usuario_idusuario']))
    {
    	header('Location: ' . PRO_URL_SESION_CADUCADA);
    	exit;
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/x-icon" href="../sistema/img/sitio_icono_32x32.png" />

	<!-- Title -->
	<title><?php echo PRO_NOMBRE; ?></title>

	<!-- Bootstrap core CSS -->
	<link href="../sistema/vendor/bootstrap/css/bootstrap.min.css?token=<?php echo $token; ?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../sistema/css/shop_styles.css">

	<!-- Custom styles for this template -->
	<link href="../sistema/css/shop-homepage.css" rel="stylesheet">

	<!-- Font Awesome CSS -->
	<link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet">

	<!-- Loading Modal -->
	<link href="../sistema/vendor/loading-modal/css/jquery.loadingModal.min.css" rel="stylesheet">

	<!-- Toast -->
	<link href="../sistema/vendor/toast/jquery.toast.min.css" rel="stylesheet">

	<!-- Data Tables -->
	<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/fixedheader/3.1.5/css/fixedHeader.bootstrap4.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css" rel="stylesheet" />

	<!-- Select Picker -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

	<!-- jVectorMap -->
	<link href="../sistema/vendor/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet" media="screen" />

	<!-- More custom styles for this template -->

</head>

<body>

	<!-- Navigation Start -->
	<nav id="nav" class="navbar navbar-expand-lg navbar-dark">
		<div class="container-fluid">
			<!--Revisar en production-->
			<a class="navbar-brand" href="<?=$_SERVER['DOCUMENT_ROOT'] ?>"><img src="../sistema/img/sitio_navegacion_138x70.png" style="width: 174px; height: 70px;border-radius: 7px;"></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-responsive" aria-controls="navbar-responsive" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbar-responsive">
				<ul class="navbar-nav ml-auto">

					<?php
                    
					    // Validar ROL - coordinadores
						if ($_SESSION['usuario_rol'] == 'coordinador_dominio' || $_SESSION['usuario_rol'] == 'coordinador_zona' || $_SESSION['usuario_rol'] == 'coordinador_subzona' || $_SESSION['usuario_rol'] == 'coordinador_escuela')
						{  
						    // Validar el acceso
						    $acceso = false;
						    
						    // ¿Accediendo a la carpeta de tienda?
						    if ($_SESSION['web_carpeta'] == 'tienda' && ($_SESSION['web_pagina'] == 'registro.php' || $_SESSION['web_pagina'] == 'compra.php' || $_SESSION['web_pagina'] == 'pago.php' || $_SESSION['web_pagina'] == 'entrega.php'))
						    {
						        $acceso = true;
						    }
						    
						    // ¿Accediendo a la carpeta de coordinadores?
						    else if ($_SESSION['web_carpeta'] == 'coordinador' && ($_SESSION['web_pagina'] == 'cuenta.php' || $_SESSION['web_pagina'] == 'curso.php' || $_SESSION['web_pagina'] == 'escuela.php' || $_SESSION['web_pagina'] == 'recompensas.php' || $_SESSION['web_pagina'] == 'escuela-entrega.php'))
						    {
						        $acceso = true;
						    }
						    
						    // ¿Acceso válido?
						    if ($acceso == true)
						    { 
						        
						        // Evaluar si el acceso al modulo esta activado o desactivado e insertar en el menu principal en orden
						        if (PAGINA_TIENDA && ($_SESSION['usuario_rol']=='alumno'))
						        {
						            echo '<li class="nav-item '  . ($_SESSION['web_pagina'] == 'registro.php' || $_SESSION['web_pagina'] == 'compra.php' || $_SESSION['web_pagina'] == 'pago.php' || $_SESSION['web_pagina'] == 'entrega.php' ? 'active' : '') . '">
						                    <a class="nav-link" href="../tienda/registro.php"><i class="fas fa-shopping-cart"></i> <span class="badge badge-warning badge-pill" id="carrito-nav-cantidad" style="color: #67560F;">0</span> Tienda</a>
						                  </li>';
						        }
						        if (PAGINA_COORDINADOR_CUENTA)
						        {
						            echo '<li class="nav-item '  . ($_SESSION['web_pagina'] == 'cuenta.php' ? 'active' : '') . '">
						                    <a class="nav-link" href="../coordinador/cuenta.php"><i class="fas fa-user"></i> Mi cuenta</a>
						                  </li>';
						        }
						        if (PAGINA_COORDINADOR_CURSO)
						        {
						            echo '<li class="nav-item '  . ($_SESSION['web_pagina'] == 'curso.php' ? 'active' : '') . '">
						                    <a class="nav-link" href="../coordinador/curso.php"><i class="fas fa-chalkboard-teacher"></i> Mis cursos</a>
						                  </li>';
						        }
						        if (PAGINA_COORDINADOR_ESCUELA)
						        {
						            echo '<li class="nav-item '  . ($_SESSION['web_pagina'] == 'escuela.php' ? 'active' : '') . '">
						                    <a class="nav-link" href="../coordinador/escuela.php"><i class="fas fa-school"></i> Mis Escuelas</a>
						                  </li>';
						        }
						        if (PAGINA_COORDINADOR_RECOMPENSAS)
						        {
						            echo '<li class="nav-item '  . ($_SESSION['web_pagina'] == 'recompensas.php' ? 'active' : '') . '">
						                    <a class="nav-link" href="../coordinador/recompensas.php"><i class="fas fa-award"></i> Mis Recompensas</a>
						                  </li>';
						        }
						        echo    '<li class="nav-item">
    							            <a class="nav-link" style="cursor:pointer;" id="modalTutorial"><i class="fas fa-play"></i> Tutoriales</a>
    							        </li>';
						        echo    '<li class="nav-item">
    							            <a class="nav-link" style="cursor:help;" id="modalPedirAyuda"><i class="fas fa-question-circle"></i> Ayuda</a>
    							        </li>';
						        echo   '<li class="nav-item">
    							            <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
    							        </li>';
    							        
    						   // Validar la página actual, si el acceso al módulo está desactivado, Sin acceso - ERROR 403
						       if ($_SESSION['web_pagina'] == 'escuela-entrega.php' && PAGINA_COORDINADOR_ESCUELA_ENTREGA == false || $_SESSION['web_pagina'] == 'cuenta.php' && PAGINA_COORDINADOR_CUENTA == false || $_SESSION['web_pagina'] == 'curso.php' && PAGINA_COORDINADOR_CURSO ==  false ||  $_SESSION['web_pagina'] == 'escuela.php' && PAGINA_COORDINADOR_ESCUELA == false || $_SESSION['web_pagina']=='recompensas.php' && PAGINA_COORDINADOR_RECOMPENSAS == false)
						       {
						           header('Location: ' . PRO_URL_403);
						           exit;
						       } 
						        
						    }
						    
						    // Sin acceso - ERROR 403
						    else 
						    {
						        header('Location: ' . PRO_URL_403);
                        	    exit;
						    }
						    
						}
						
						// Validar ROL - alumnos
						else if($_SESSION['usuario_rol'] == 'alumno')
						{
						    
						    // Validar el acceso
						    $acceso = false;
						    
						    // ¿Accediendo a la carpeta de tienda?
						    if ($_SESSION['web_carpeta'] == 'tienda' && ($_SESSION['web_pagina'] == 'registro.php' || $_SESSION['web_pagina'] == 'compra.php' || $_SESSION['web_pagina'] == 'pago.php' || $_SESSION['web_pagina'] == 'entrega.php'))
						    {
						        $acceso = true;
						    }
						    
						    // ¿Accediendo a la carpeta de coordinadores?
						    else if ($_SESSION['web_carpeta'] == 'alumno' && ($_SESSION['web_pagina'] == 'cuenta.php'))
						    {
						        $acceso = true;
						    }
						    
						    // ¿Acceso válido?
						    if ($acceso == true)
						    {
						        
						         // Evaluar si el acceso al modulo esta activado o desactivado e insertar en el menu principal en orden
						         if(PAGINA_TIENDA)
						         {
						             echo '<li class="nav-item '  . ($_SESSION['web_pagina'] == 'registro.php' || $_SESSION['web_pagina'] == 'compra.php' || $_SESSION['web_pagina'] == 'pago.php' || $_SESSION['web_pagina'] == 'entrega.php' ? 'active' : '') . '">
    							            <a class="nav-link" href="../tienda/registro.php"><i class="fas fa-shopping-cart"></i> <span class="badge badge-warning badge-pill" id="carrito-nav-cantidad" style="color: #67560F;">0</span> Tienda</a>
    							        </li>';
						         }
						         if(PAGINA_ALUMNO_CUENTA)
						         {
    						          echo ' <li class="nav-item '  . ($_SESSION['web_pagina'] == 'cuenta.php' ? 'active' : '') . '">
        							            <a class="nav-link" href="../alumno/cuenta.php"><i class="fas fa-user"></i> Mi cuenta</a>
        							      </li>';   
						         }
						        echo    '<li class="nav-item">
    							            <a class="nav-link" style="cursor:pointer;" id="modalTutorial"><i class="fas fa-play"></i> Tutoriales</a>
    							        </li>';
						        echo    '<li class="nav-item">
    							            <a class="nav-link" style="cursor:help;" id="modalPedirAyuda"><i class="fas fa-question-circle"></i> Ayuda</a>
    							        </li>';
						          echo ' <li class="nav-item">
    							            <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
    							        </li>';
    							        
    							// Validar la página actual, si el acceso al módulo está desactivado, Sin acceso - ERROR 403
    						      if ($_SESSION['web_pagina'] == 'cuenta.php' && PAGINA_COORDINADOR_ESCUELA_ENTREGA == false ||  $_SESSION['web_pagina'] == 'tienda/registro.php' && PAGINA_ALUMNO_TIENDA == false)
    						      {
    						           header('Location: ' . PRO_URL_403);
    						           exit;
    						      } 
						    }
						    
						    // Sin acceso - ERROR 403
						    else
						    {
						        header('Location: ' . PRO_URL_403);
                        	    exit;
						    }
						    
						}
						// Validar ROL - distribuidor
						else if($_SESSION['usuario_rol'] == 'distribuidor')
						{
						    
						    // Validar el acceso
						    $acceso = false;
						    
						    // ¿Accediendo a la carpeta de tienda?
						    if ($_SESSION['web_carpeta'] == 'distribuidor' && ($_SESSION['web_pagina'] == 'dashboard.php' ||  $_SESSION['web_pagina'] == 'dashboard_test.php' ||  $_SESSION['web_pagina'] == 'pedido.php' ||  $_SESSION['web_pagina'] == 'cuenta.php'))
						    {
						        $acceso = true;
						    }
						    
						    // ¿Acceso válido?
						    if ($acceso == true)
						    {
						        
                                 if(PAGINA_DISTRIBUIDOR_CUENTA)
                                 {
                                     echo'<li class="nav-item '  . ($_SESSION['web_pagina'] == 'cuenta.php' ? 'active' : '') . '">
    							            <a class="nav-link" href="../distribuidor/cuenta.php"><i class="fas fa-user"></i> Mi cuenta</a>
    							        </li>';
                                 }
                                 if(PAGINA_DISTRIBUIDOR_DASHBOARD)
                                 {
                                   echo ' <li class="nav-item '  . ($_SESSION['web_pagina'] == 'dashboard.php' ? 'active' : '') . '">
    							            <a class="nav-link" href="../distribuidor/dashboard.php"><i class="fas fa-chart-line"></i> Dashboard</a>
    							           </li>';
                                     
                                 }
                                echo    '<li class="nav-item">
    							            <a class="nav-link" style="cursor:help;" id="modalPedirAyuda"><i class="fas fa-question-circle"></i> Ayuda</a>
    							        </li>';
						        echo    '<li class="nav-item">
    							            <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
    							        </li>';
    						   // Validar la página actual, si el acceso al módulo está desactivado, Sin acceso - ERROR 403
    						      
    						      if ($_SESSION['web_pagina'] == 'cuenta.php' && PAGINA_DISTRIBUIDOR_CUENTA == false ||  $_SESSION['web_pagina'] == 'dashboard.php' && PAGINA_DISTRIBUIDOR_DASHBOARD == false)
    						      {
    						           header('Location: ' . PRO_URL_403);
    						           exit;
    						      } 
						    }
						    
						    // Sin acceso - ERROR 403
						    else
						    {
						        header('Location: ' . PRO_URL_403);
                        	    exit;
						    }
						    
						}
						
					?>

				</ul>
			</div>
		</div>

        <?php
        if($_SESSION['usuario_rol'] == 'alumno')
        {
    		echo '<button type="button" class="fixed-cart-button" id="navegacion-boton-carrito">
    			    <span class="badge badge-warning badge-pill" id="carrito-boton-cantidad" style="color: #67560F;">0</span><i class="fa fa-shopping-cart" style="color: #FFFFFF;"></i>
    		     </button>';
    	}
    	?>

	</nav>
	<!-- Navigation End -->

	<!-- Page Content Start -->

	<?php

    if($_SESSION['web_carpeta'] == 'coordinador')
	{
	    echo '<div class="container-fluid" style="background-color: #7e99ca;">';
	}
	else if ($_SESSION['web_carpeta'] == 'alumno')
	{
	    echo '<div class="container-fluid" style="background-color: #7e99ca;">';
	}
	else if ($_SESSION['web_carpeta'] == 'recompensas')
	{
	    echo '<div class="container-fluid" style="background-color: #7e99ca;">';
	}
	else if ($_SESSION['web_carpeta'] == 'tienda')
	{
	    echo '<div class="container-fluid" style="background-color: #7e99ca;">';
	}
    else if ($_SESSION['web_carpeta'] == 'distribuidor')
	{
	    echo '<div class="container-fluid" style="background-color: #7e99ca;">';
	}
	
?>

	<!-- Carrito Modal Start -->
	<div class="modal fade" id="carrito-modal" tabindex="-1" role="dialog" aria-labelledby="carrito-modal-label" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90% !important; width: 90% !important;" role="document">
			<div class="modal-content">
				<div class="modal-header modal-vegdi">
					<h5 class="modal-title"><i class="fa fa-shopping-cart"></i> Carrito</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card shadow">
						<div class="card-header"><strong id="carrito-mensaje"></strong></div>
						<div class="card-body">
							<div class="table-responsive-sm">
								<table class="table table-striped" id="carrito-articulos">
								</table>
							</div>
						</div>
					</div>

					<br>

					<!-- Alert Costo Envío -->
					<?php
                	
                    	if (MENSAJE_NOTIFICACION_COSTO_ENVIO)
                    	{
                    	    echo '<div class="row">
                                    <div class="col-xs-12 col-md-12">
                                    	<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    		' . MENSAJE_NOTIFICACION_COSTO_ENVIO_TEXTO . '
                                    	</div>
                                    </div>
                                </div>';
                        }
                         
                    ?>

				</div>
				<div class="modal-footer">
					<div style="width: 100%;">
						<div class="row">
							<div class="col-xs-12 col-md-12 mb-2">
								<button class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
							</div>
							<div class="col-xs-12 col-md-12 mb-2">
								<a href="../tienda/registro.php" style="text-decoration:none;"><button type="button" class="btn btn-primary btn-block"><i class="fas fa-shopping-cart"></i> Ir a la tienda</button></a>
							</div>
							<div class="col-xs-12 col-md-12 mb-2">
								<button class="btn btn-primary btn-block" id="carrito-pagar"><i id="carrito-logo" class="fa fa-credit-card"></i> Pagar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Carrito Modal End -->

	<!-- Ayuda Modal Start -->
	<div class="modal fade" id="ayuda-modal" tabindex="-1" role="dialog" aria-labelledby="ayuda-modal-label" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header modal-vegdi">
					<h5 class="modal-title"><i class="fas fa-question-circle"></i> Ayuda</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="card shadow">
						<div class="card-header"><strong> ¿Necesitas ayuda?</strong></div>
						<div class="card-body">
							<form id="form-ayuda">
								<div class="form-row">
									<input type="hidden" id="ayuda-usuario-id" name="ayuda-usuario-id" value="">
								</div>
								<div class="form-row">
									<div class="col-md-6 mb-6 mb-4">
										<label for="ayuda-nombre-usuario"><strong>Nombre</strong></label>
										<input type="text" class="form-control" id="ayuda-nombre-usuario" name="ayuda-nombre-usuario" placeholder="Nombre" value="" disabled>
										<div class="invalid-feedback">Por favor completa este campo</div>
									</div>
									<div class="col-md-6 mb-6 mb-4">
										<label for="ayuda-correo"><strong>Correo Electrónico</strong></label>
										<input type="text" class="form-control" id="ayuda-correo" name="ayuda-correo" placeholder="Correo electrónico" value="" disabled>
										<div class="invalid-feedback">Por favor completa este campo</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12 mb-12 mb-4">
										<label for="ayuda-datos-adicionales"><strong>Escribenos detalladamente tu problema y nosotros nos contactaremos contigo lo más pronto posible</strong></label>
										<br>
										<textarea class="form-control" id="ayuda-datos-adicionales" rows="5" cols="100" placeholder=""></textarea>
										<div class="invalid-feedback">Por favor completa este campo</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div style="width: 100%;">
						<div class="row">
							<div class="col-xs-12 col-md-12 mb-2">
								<button class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
							</div>
							<div class="col-xs-12 col-md-12 mb-2">
								<button class="btn btn-primary btn-block" id="enviar-mensaje-ayuda"><i id="ayuda-logo" class="fa fa-share-square"></i> Enviar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Ayuda Modal End -->

	<!-- Tutorial Modal Start -->
	<div class="modal fade" id="modal-tutorial" tabindex="-1" role="dialog" aria-labelledby="modal-tutorial-label" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header modal-vegdi">
					<h5 class="modal-title"><i class="fas fa-play"></i> Tutorial</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
    				<div class="row">
    				    <div class="col-xs-12 col-md-12 mb-2">
        					<?php
                                if ($_SESSION['usuario_rol'] == 'coordinador_dominio' || $_SESSION['usuario_rol'] == 'coordinador_zona' || $_SESSION['usuario_rol'] == 'coordinador_subzona' || $_SESSION['usuario_rol'] == 'coordinador_escuela')
                                {
            					echo '<div class="card shadow">
            						<div class="card-header"><strong> ¿Como comprar?</strong></div>
                						<div class="card-body">
                							<div class="row">
                                                <div class="col-xs-12 col-md-12 mb-4">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="' . PRO_VIDEO_COORDINADOR_COMPRAS . '" allowfullscreen></iframe>
                                                    </div>
                                                </div>
                							</div>
                						</div>
                					</div>
                					<br>';
                				echo '<div class="card shadow">
            						<div class="card-header"><strong> ¿Como realizar entregas?</strong></div>
                						<div class="card-body">
                							<div class="row">
                                                <div class="col-xs-12 col-md-12 mb-4">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="' . PRO_VIDEO_COORDINADOR_ENTREGAS . '" allowfullscreen></iframe>
                                                    </div>
                                                </div>
                							</div>
                						</div>
                					</div>';
                                
                                }
                                if ($_SESSION['usuario_rol'] == 'alumno')
                                {
                					echo '<div class="card shadow">
                						<div class="card-header"><strong> Guía para comprar (Instrucciones)</strong></div>
                						<div class="card-body">
                							<div class="row">
                                                <div class="col-xs-12 col-md-12 mb-4">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="../como-comprar.php" allowfullscreen></iframe>
                                                    </div>
                                                </div>
                							</div>
                						</div>
                					</div>
                					<br>';
                                }
                				if($_SESSION['web_subdominio'] !== 'anahuac')
                				{
                					echo '<div class="card shadow">
                						<div class="card-header"><strong> Guía para comprar (Video)</strong></div>
                						<div class="card-body">
                							<div class="row">
                                                <div class="col-xs-12 col-md-12 mb-4">
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe class="embed-responsive-item" src="' . $_SESSION['web_subdominio_video_alumno_compras'] . '" allowfullscreen></iframe>
                                                    </div>
                                                </div>
                							</div>
                						</div>
                					</div>';
                                }
                            ?>
                                            
        				</div>
    				</div>
    			</div>
			</div>
		</div>
	</div>
	<!-- Tutorial Modal End -->

	<br>
	<br>

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

	