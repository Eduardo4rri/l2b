<?php

    ob_start();
    session_start();
    $token = uniqid();
    require_once '../sistema/header.php';
    $rol = $_SESSION['usuario_rol'];
    if (!($rol == 'alumno' || $rol == 'coordinador_dominio' || $rol == 'coordinador_zona' || $rol == 'coordinador_subzona' || $rol == 'coordinador_escuela'))
    {
        header('Location: ' . PRO_URL_SESION_CADUCADA);
    }

?>

<style  type="text/css">
/* Seccion de  @medias queries
 Para medias de pantalla y dispositivos 
*/
 @media screen and (max-width:1250px){
     .seccion-articulos-responsive{
         -webkit-box-flex: 0;
          flex: 0 0 100% !important;
          max-width: 90% !important;
          width: 100% !important;
          padding-left: 49px;
     }
 }
 
  @media screen and (max-width:600px){
     .seccion-articulos-responsive{
         -webkit-box-flex: 0;
          flex: 0 0 100% !important;
          max-width: 100% !important;
          width: 100% !important;0px;
           padding-left: 0px;
     }
 }

</style>
<br>
<br>
<div class="alert pasos-alert" role="alert">
    <div class="text-center" id="pagina-mensaje"><br>
    	<h2>Paso 2 • Compra</h2>
    </div>
    <br>
    <br>
    <div class="row">
    	<div class="col-xs-12 col-md-12 text-center">
    		<nav class="nav nav-pills flex-column flex-sm-row">
    			<a class="flex-sm-fill text-sm-center nav-link" href="registro.php" id="paso-registro"><i class="fas fa-user"></i> 1. Registro</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link active" href="#" id="paso-compra"><i class="fas fa-shopping-cart"></i> 2. Compra</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#" id="paso-confirmacion"><i class="fas fa-credit-card"></i> 3. Pago</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#" id="paso-entrega"><i class="fas fa-parachute-box"></i> 4. Entrega</a>
    		</nav>
    	</div>
    </div>
</div>
<br>
<br>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-user"></i><strong> Tus datos</strong> (regresa al paso <strong>1. Registro</strong> si deseas hacer algún cambio)</div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-3 col-md-3">
						<strong>Comprador</strong>
						<p class="card-text" id="confirmacion-usuario"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong id="confirmacion-usuario-identificador"></strong>
						<p class="card-text" id="confirmacion-usuario-matricula"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Teléfono</strong>
						<p class="card-text" id="confirmacion-usuario-telefono"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Correo Electrónico</strong>
						<p class="card-text" id="confirmacion-usuario-login"></p>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-xs-6 col-md-6">
						<strong>Escuela</strong>
						<p class="card-text" id="confirmacion-escuela-seleccionada"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Programa</strong>
						<p class="card-text" id="confirmacion-programa-seleccionado"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Niveles</strong>
						<p class="card-text" id="confirmacion-programa-nivel-seleccionado"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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

<div class="row" id="tienda-articulo">
	<div class="col-xs-3 col-md-3 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-layer-group"></i><strong> 1. Nivel</strong></div>
			<div class="card-body">
				<div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical" id="compra-niveles">
				</div>
			</div>
		</div>
		<br>
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-exclamation-triangle"></i><strong> IMPORTANTE </strong><i class="fas fa-exclamation-triangle"></i></div>
			<div class="card-body">
				Si aún no has realizado tu <strong>PLACEMENT TEST</strong> o aún no sabes en que nivel de Inglés te encuentras, elige <strong>NIVEL POR ASIGNAR</strong> y selecciona el libro <strong>American JETSTREAM Nivel Por Asignar</strong> para proceder con tu compra, realiza tu pago y conserva tu ticket.<br><br>
				<strong>Tu universidad</strong> te asignará el nivel que deberás de cursar y podrás recoger tu libro correspondiente entregando tu recibo de pago en las fechas indicadas por la administración.
			</div>
		</div>
	</div>
	<div class="col-xs-6 col-md-6 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-book"></i><strong> 2. Libros en el nivel</strong></div>
			<div class="card-body">
				<div class="row" id="compra-articulos">
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-3 col-md-3 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-credit-card"></i><strong> 3. Pagar</strong></div>
			<div class="card-body">
				<button type="button" class="btn btn-primary btn-block" id="carrito-validar"><i class="fas fa-credit-card"></i> Pagar</button>
			</div>
		</div>
	</div>
</div>

<br>
<br>

<?php

    require_once '../sistema/footer.php';

?>

<!-- Página -->
<script type="text/javascript" src="scripts/compra.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>