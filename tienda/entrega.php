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

<style>
	@media screen and (max-width: 991px) and (min-width: 775px) {
		.margin-small-scren {
			margin-bottom: 23%;
		}
	}
</style>

<!-- Modal Facturación -->
<div class="modal fade" id="factura-modal" tabindex="-1" role="dialog" aria-labelledby="factura-modal-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header modal-vegdi">
				<h5 class="modal-title"><i class="fas fa-file-invoice"></i> Ingresa datos para factura</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card card-body">
					<form id="form-factura">
						<div class="form-row">
							<input type="hidden" id="usuario-id" name="usuario-id" value="">
						</div>
						<div class="form-row">
							<div class="col-md-1 mb-1"></div>
							<div class="col-md-5 mb-4">
								<label for="factura-numero-compra"><strong>Número de compra</strong></label>
								<input type="text" class="form-control" id="factura-numero-compra" name="factura-numero-compra" placeholder="Número de compra" value="" disabled>
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-5 mb-4">
								<label for="factura-libro"><strong>Libro</strong></label>
								<input type="text" class="form-control" id="factura-libro" name="factura-libro" placeholder="Libro" value="" disabled>
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-1 mb-1"></div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-4">
								<label for="factura-nombre"><strong>Nombre</strong></label>
								<input type="text" class="form-control" id="factura-nombre" name="factura-nombre" placeholder="Nombre" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-correo"><strong>Correo Electrónico</strong></label>
								<input type="text" class="form-control" id="factura-correo" name="factura-correo" placeholder="Correo electrónico" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-telefono" class="margin-small-scren"><strong>Teléfono</strong></label>
								<input type="text" class="form-control" id="factura-telefono" name="factura-telefono" placeholder="Teléfono" value="" minlength="10" maxlength="13">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-rfc" class="margin-small-scren"><strong>RFC</strong></label>
								<input type="text" class="form-control" id="factura-rfc" name="factura-rfc" placeholder="RFC" value="" minlength="10" maxlength="13">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-4">
								<label for="factura-calle"><strong>Calle</strong></label>
								<input type="text" class="form-control" id="factura-calle" name="factura-calle" placeholder="Calle" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-numero-exterior"><strong>Numero Exterior</strong></label>
								<input type="text" class="form-control" id="factura-numero-exterior" name="factura-numero-exterior" placeholder="Numero Exterior" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-numero-interior"><strong>Numero Interior</strong></label>
								<input type="text" class="form-control" id="factura-numero-interior" name="factura-numero-interior" placeholder="Numero Interior" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-colonia" class="margin-small-scren"><strong>Colonia</strong></label>
								<input type="text" class="form-control" id="factura-colonia" name="factura-colonia" placeholder="Colonia" value="" minlength="10" maxlength="13">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-3 mb-4">
								<label for="factura-delegacion"><strong>Delegación</strong></label>
								<input type="text" class="form-control" id="factura-delegacion" name="factura-delegacion" placeholder="Delegación" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-ciudad"><strong>Ciudad</strong></label>
								<input type="text" class="form-control" id="factura-ciudad" name="factura-ciudad" placeholder="Ciudad" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-pais"><strong>País</strong></label>
								<input type="text" class="form-control" id="factura-pais" name="factura-pais" placeholder="País" value="">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
							<div class="col-md-3 mb-4">
								<label for="factura-codigo-postal" class="margin-small-scren"><strong>Código Postal</strong></label>
								<input type="text" class="form-control" id="factura-codigo-postal" name="factura-codigo-postal" placeholder="Código Postal" value="" minlength="10" maxlength="13">
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col-md-12 mb-12 mb-4">
								<label for="factura-datos-adicionales"><strong>Introduce cualquier información adicional que sea necesaria para generar la factura.</strong></label>
								<br>
								<textarea class="form-control" id="factura-datos-adicionales" rows="5" cols="100" placeholder="Datos adicionales"></textarea>
								<div class="invalid-feedback">Por favor completa este campo</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<div style="width: 100%;">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
					<button type="button" class="btn btn-primary btn-block" id="guardar-datos-facturacion"><i class="fas fa-check"></i> Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Cambio De Libro -->
<div class="modal fade" id="cambio-material-modal" tabindex="-1" role="dialog" aria-labelledby="cambio-material-modal-label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 90% !important; width: 90% !important;" role="document">
		<div class="modal-content">
			<div class="modal-header modal-vegdi">
				<h5 class="modal-title"><i class="fas fa-exchange-alt"></i> Cambia el libro de tu compra</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="card card-body">
					<div>
						<div class="row">
							<div class="col-xs-12 col-md-12 mb-4">
								<div class="card shadow">
									<div class="card-header"><i class="fas fa-exclamation-triangle"></i><strong> IMPORTANTE </strong><i class="fas fa-exclamation-triangle"></i></div>
									<div class="card-body">
										Utiliza esta función si al realizar tu compra si aún no conocias tu nivel de Inglés, o si por accidente elegiste un libro equivocado, <strong>incluso si tu compra ya está pagada</strong>.<br><br><strong>NOTA:</strong><br> Podrás hacer uso de esta función <strong>ÚNICAMENTE ANTES DE QUE SE REALIZE LA ENTREGA DE LIBROS EN TU ESCUELA</strong>, por lo cuál deberás confirmar con tu escuela cuál es el libro correcto que deberás de elegir.
									</div>
								</div>
							</div>
						</div>
						<div class="row" id="tienda-articulo">
							<div class="col-xs-3 col-md-4 mb-4">
								<div class="card h-100 shadow">
									<div class="card-header"><i class="fas fa-layer-group"></i><strong> 1. Nivel</strong></div>
									<div class="card-body">
										<div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical" id="compra-niveles">
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-6 col-md-8 mb-4">
								<div class="card h-100 shadow">
									<div class="card-header"><i class="fas fa-book"></i><strong> 2. Libros en el nivel</strong></div>
									<div class="card-body">
										<div class="row" id="cambio-libro-articulos">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div style="width: 100%;">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<br>
<br>
<div class="alert pasos-alert" role="alert">
    <div class="text-center" id="pagina-mensaje"><br>
    	<h2>Paso 4 • Entrega</h2>
    </div>
    <br>
    <br>
    
    <div class="row">
    	<div class="col-xs-12 col-md-12">
    		<nav class="nav nav-pills flex-column flex-sm-row">
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#" id="paso-registro"><i class="fas fa-user"></i> 1. Registro</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#" id="paso-compra"><i class="fas fa-shopping-cart"></i> 2. Compra</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#" id="paso-confirmacion"><i class="fas fa-credit-card"></i> 3. Pago</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link active" href="#" id="paso-entrega"><i class="fas fa-parachute-box"></i> 4. Entrega</a>
    		</nav>
    	</div>
    </div>
</div>
<br>
<br>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-cash-register"></i><strong> Detalles de tu pago</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-md-12" id="pago-detalles">
					</div>
				</div>
				<div class="row" id="venta-devuelta-aviso-1" style="display:none";>
                    <div class="col-xs-12 col-md-12">
                    	<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    		<i class="fas fa-money-bill-alt"></i><strong> ¡EL PAGO DE ESTA VENTA HA SIDO REEMBOLSADO, LO VERÁS REFLEJADO EN TU CUENTA BANCARIA EN APROXIMADAMENTE 24 HRS!</strong>
                    	</div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12" id="detalles-print">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-money-bill-wave"></i><strong id="print-titulo-detalles"> Detalles de tu compra</strong></div>
			<div class="card-body">
				<div class="row mb-12">
					<div class="col-xs-3 col-md-3">
						<strong>Número de la compra</strong>
						<p class="card-text" id="entrega-venta-id"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Fecha y hora de la compra</strong>
						<p class="card-text" id="entrega-venta-fecha-hora"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Fecha de entrega prevista en tu escuela</strong>
						<p class="card-text" id="entrega-venta-fecha-entrega"></p>
					</div>
					<div class="col-xs-3 col-md-3">
						<strong>Estatus de pago</strong>
						<p class="card-text" id="entrega-venta-estatus"></p>
					</div>
				</div>
				<br>
				<hr>
				<div class="row mb-12">
					<div class="col-sm-6">
						<div><strong>Dirección de entrega</strong></div>
						<hr>
						<div id="escuela-nombre"></div>
						<div id="escuela-campus"></div>
						<div id="escuela-calle"></div>
						<div id="escuela-ciudad"></div>
						<div id="escuela-estado"></div>
						<div id="escuela-codigo-postal"></div>
					</div>
					<div class="col-sm-6">
						<div><strong>Entregar a</strong></div>
						<hr>
						<div id="usuario-nombre"></div>
						<div id="usuario-login"></div>
						<div id="usuario-matricula"></div>
						<div id="usuario-telefono"></div>
					</div>
				</div>
				<br>
				<div class="table-responsive-sm" id="table-responsiv-print">
					<table class="table table-striped" id="entrega-articulos-formato">
					</table>
				</div>
				<div class="row">
					<div class="col-lg-4 col-sm-5">
					</div>
					<div class="col-lg-4 col-sm-5 ml-auto">
						<table class="table table-clear" id="entrega-totales-formato">
						</table>
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
                
                <div class="row" id="venta-devuelta-aviso-2" style="display:none";>
                    <div class="col-xs-12 col-md-12">
                    	<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    		<i class="fas fa-money-bill-alt"></i><strong> ¡EL PAGO DE ESTA VENTA HA SIDO REEMBOLSADO, LO VERÁS REFLEJADO EN TU CUENTA BANCARIA EN APROXIMADAMENTE 24 HRS!</strong>
                    	</div>
                    </div>
                </div>

			</div>
		</div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-info-circle"></i><strong> Información adicional</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<button type="button" class="btn btn-link" id="imprimir-comprobante"><i class="fas fa-print"></i> Imprime tu comprobante</button>
						<button type="button" class="btn btn-link" id="cambia-tu-pedido"><i class="fas fa-exchange-alt"></i> Cambia el libro de tu compra</button>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12">
						
						<hr>
						<h6>• Haz click <a class="links-style" data-toggle="modal" data-target="#factura-modal" href="#">aquí</a> si necesitas una factura de tu compra. Ten a la mano tu número de compra ya que te será solicitado.</h6>
						<hr>
						<div class="row">
							<div class="col-xs-12 col-md-12 mb-2">
								<a href="registro.php" style="text-decoration:none;"><button type="button" class="btn btn-primary btn-block"><i class="fas fa-shopping-cart"></i> Iniciar una nueva compra</button></a>
							</div>
							<div class="col-xs-12 col-md-12 mb-2">
								<?php
						        if ($_SESSION['usuario_rol'] == 'coordinador_dominio' || $_SESSION['usuario_rol'] == 'coordinador_zona' || $_SESSION['usuario_rol'] == 'coordinador_subzona' || $_SESSION['usuario_rol'] == 'coordinador_escuela')
						        {  
						        echo '<a href="../coordinador/cuenta.php" style="text-decoration:none;"><button type="button" class="btn btn-primary btn-block"><i class="fas fa-user"></i> Mi cuenta</button></a>';
						        }
						        else if ($_SESSION['usuario_rol'] == 'alumno')
						        {  
						        echo '<a href="../alumno/cuenta.php" style="text-decoration:none;"><button type="button" class="btn btn-primary btn-block"><i class="fas fa-user"></i> Mi cuenta</button></a>';
						        }
						        ?>
							</div>
						</div>
					</div>
				</div>
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
<script type="text/javascript" src="scripts/entrega.js?token=<?php echo $token; ?>"></script>
<script type="text/javascript" src="scripts/cambio-articulo.js?token=<?php echo $token; ?>"></script>

<?php

	ob_end_flush();

?>