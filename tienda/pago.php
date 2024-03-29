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

<br>
<br>
<div class="alert pasos-alert" role="alert">
    <div class="text-center" id="pagina-mensaje"><br>
    	<h2>Paso 3 • Pago</h2>
    </div>
    <br>
    <br>
    
    <div class="row">
    	<div class="col-xs-12 col-md-12">
    		<nav class="nav nav-pills flex-column flex-sm-row">
    			<a class="flex-sm-fill text-sm-center nav-link" href="registro.php" id="paso-registro"><i class="fas fa-user"></i> 1. Registro</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link" href="compra.php" id="paso-compra"><i class="fas fa-shopping-cart"></i> 2. Compra</a>
    			<a class="flex-sm-fill text-sm-center nav-link disabled" href="#"><i class="fas fa-circle"></i></a>
    			<a class="flex-sm-fill text-sm-center nav-link active" href="#" id="paso-confirmacion"><i class="fas fa-credit-card"></i> 3. Pago</a>
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

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-parachute-box"></i><strong> Tu compra</strong> (regresa al paso <strong>2. Compra</strong> si deseas hacer algún cambio)</div>
			<div class="card-body">
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
						<div id="usuario-telefono"></div>
						<div id="usuario-matricula"></div>
					</div>
				</div>
				<br>
				<div>
					<strong>Carrito de compras</strong>
				</div>
				<br>
				<div class="table-responsive-sm">
					<table class="table table-striped" id="pago-articulos-formato">
					</table>
				</div>
				<div class="row">
					<div class="col-lg-4 col-sm-5">
					</div>
					<div class="col-lg-4 col-sm-5 ml-auto">
						<table class="table table-clear" id="pago-totales-formato">
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
                  
			</div>
		</div>
	</div>
</div>

<div class="row" id="pago-opcion-conecta" style="display:none">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-money-bill-wave"></i><strong> Tu pago</strong> (Ponemos a tu disposición el pago en <strong>OXXO, SPEI y TARJETA BANCARIA</strong>)
				<br>
				<br>
				<div class="alert alert-success text-center" role="alert">
					<label class="radio-inline" for="pago-opcion-conekta-oxxo"><input type="radio" name="pago-opcion-conekta" id="pago-opcion-conekta-oxxo"> <img src="../sistema/img/pago_oxxo.png" style="width: 35px; height: 25px;"> <strong>OXXOPay</strong></label>
					<br>
					<label class="radio-inline" for="pago-opcion-conekta-spei"><input type="radio" name="pago-opcion-conekta" id="pago-opcion-conekta-spei"> <img src="../sistema/img/pago_spei.png" style="width: 65px; height: 25px;"> <strong>SPEI</strong></label>
					<br>
					<label class="radio-inline" for="pago-opcion-conekta-tarjeta"><input type="radio" name="pago-opcion-conekta" id="pago-opcion-conekta-tarjeta"> <img src="../sistema/img/pago_visa.png" style="width: 35px; height: 25px;"> <img src="../sistema/img/pago_mastercard.png" style="width: 35px; height: 25px;"> <img src="../sistema/img/pago_american_express.png" style="width: 35px; height: 25px;"> <strong>TARJETA BANCARIA</strong></label>
					<br>
				</div>
			</div>
			<div class="card-body" id="pago-opcion-conekta-oxxo-div" style="display:none">
				<div >
				    <div class="text-center">
    					<label><strong>Pago mediante OXXO</strong></label>
    					<br>
    					<img src="../sistema/img/pago_oxxo.png">
    				</div>
					<br>
					<br>
					<label>• Con esta forma de pago, tu compra será generada con un estatus de pago <strong>PENDIENTE</strong> y se te proporcionará una <strong>REFERENCIA DE PAGO</strong>.</label>
					<br>
					<label>• Acude a la sucursal <strong>OXXO</strong> más cercana, proporciona la <strong>REFERENCIA DE PAGO</strong> y paga en efectivo la <strong>CANTIDAD INDICADA</strong> en el detalle de tu compra.</label>
					<br>
					<label>• <strong>OXXO</strong> te cobrará una comisión adicional de <strong>$12.00 pesos</strong>.</label>
					<br>
					<label>• Conserva el <strong>TICKET DE PAGO</strong> que <strong>OXXO</strong> te entregará, ya que este será tu <strong>COMPROBANTE DE PAGO</strong> y será requerido para la <strong>ENTREGA DE TU COMPRA</strong>.</label>
					<br>
					<label>• En un máximo de <strong>48 HORAS (2 DÍAS)</strong> posteriores a tu pago, tu compra pasará de <strong>PENDIENTE</strong> a <strong>PAGADA</strong>, con lo cual tu compra estará <strong>CONFIRMADA</strong> y será entregada <strong> EN TU ESCUELA</strong> en las <strong>FECHAS INDICADAS POR LA ADMINISTRACIÓN</strong>.</label>
					<br>
					<label>• Tienes hasta <strong>UN MES</strong> para realizar tu pago, sin embargo, recomendamos que lo realices lo más pronto posible <strong>(DENTRO DE 48 HORAS)</strong>.</label>
					<br>
					<div id="pago-opcion-conekta-oxxo-div-mensaje-sistema"></div>
					<div id="pago-opcion-conekta-oxxo-div-mensaje-pago"></div>
					<button class="subscribe btn btn-primary btn-block" type="button" id="pago-opcion-conekta-oxxo-div-pagar"><i class="fas fa-money-bill-wave"></i> Proceder al pago en <strong>OXXO</strong></button>
				</div>
			</div>
			<div class="card-body" id="pago-opcion-conekta-spei-div"  style="display:none">
				<div>
					<div class="text-center ">
    					<label><strong>Pago mediante SPEI</strong></label>
    					<br>
    					<img src="../sistema/img/pago_spei.png">
    				</div>
					<br>
					<br>
					<label>• Inicia sesión en el <strong>PORTAL DE TU BANCO</strong> o en la <strong>APLICACIÓN DEL MISMO EN TU TELÉFONO MOVIL</strong>.</label>
					<br>
					<label>• Busca la opción de <strong>pago/transferencia</strong> por <strong>SPEI</strong>.</label>
					<br>
					<label>• Introduce la <strong>CLABE</strong> proporcionada y selecciona el banco <strong>STP</strong>.</label>
					<br>
					<label>• Realiza el <strong>pago/transferencia</strong> por la <strong>cantidad EXACTA</strong>, de lo contrario la operación será <strong>RECHAZADA</strong>.</label>
					<br>
					<label>• Este tipo de pago <strong>no generá ningún tipo de comisión adicional</strong>.</label>
					<br>
					<label>• Una vez que el pago haya sido procesado, <strong>el portal de tu banco o aplicación movíl te entregará un comprobante digital</strong>, conservalo y comprueba que el pago se haya realizado correctamente. En algunas ocasiones el pago puede verse reflejado hasta <strong>48 horas después</strong>. Una vez que el pago se haya procesado correctamente, recibirás un correo confirmando tu pago.</label>
					<br>
					<div id="pago-opcion-conekta-spei-div-mensaje-sistema"></div>
					<div id="pago-opcion-conekta-spei-div-mensaje-pago"></div>
					<button class="subscribe btn btn-primary btn-block" type="button" id="pago-opcion-conekta-spei-div-pagar"><i class="fas fa-money-bill-wave"></i> Proceder al pago por <strong>SPEI</strong></button>
				</div>
			</div>
			<div class="card-body" id="pago-opcion-conekta-tarjeta-div" style="display:none">
        		<div>
        		    <div class="text-center">
    					<label><strong>Pago mediante TARJETA BANCARIA</strong></label>
                		<br>
                		<img src="../sistema/img/pago_visa.png">
                		<img src="../sistema/img/pago_mastercard.png">
                		<img src="../sistema/img/pago_american_express.png">
    				</div>
            		<br>
            		<br>
            		<label>• Con esta forma de pago, se realizará un cargo a tu <strong>TARJETA BANCARIA</strong>, ya sea de <strong>DÉBITO</strong> o de <strong>CRÉDITO</strong></label>
            		<br>
            		<label>• Tu <strong>TARJETA BANCARIA</strong> puede ser del tipo <strong>VISA</strong>, <strong>MASTERCARD</strong> ó <strong>AMERICAN EXPRESS</strong>, no necesitas especificar de que tipo es</label>
            		<br>
            		<label>• No guardaremos <strong>NINGÚN DATO</strong> de tu <strong>TARJETA BANCARIA</strong> y utilizamos un <strong>CERTIFICADO DE SEGURIDAD</strong> con lo que el proceso de pago en línea es <strong>100% SEGURO</strong></label>
            		<br>
            		<form action="" method="POST" role="form" id="pago-opcion-conekta-tarjeta-form">
            			<div class="form-group">
            				<label for="tarjeta-nombre"><strong>Nombre completo impreso en tu tarjeta</strong> (tal como aparece)</label>
            				<div class="input-group">
            					<div class="input-group-prepend">
            						<span class="input-group-text"><i class="fa fa-user"></i></span>
            					</div>
            					<input type="text" class="form-control" name="tarjeta-nombre" id="tarjeta-nombre" placeholder="" required value="" data-conekta="card[name]">
            					<div class="invalid-feedback">Por favor completa este campo</div>
            				</div>
            			</div>
            			<div class="form-group">
            				<label for="tarjeta-numero"><strong>Número de tu tarjeta</strong> (sin espacios ni guiones)</label>
            				<div class="input-group">
            					<div class="input-group-prepend">
            						<span class="input-group-text"><i class="fa fa-credit-card"></i></span>
            					</div>
            					<input type="text" class="form-control" name="tarjeta-numero" id="tarjeta-numero" placeholder="" required value="" data-conekta="card[number]">
            					<div class="invalid-feedback">Por favor completa este campo</div>
            				</div>
            			</div>
            			<div class="row">
            				<div class="col-sm-8">
            					<div class="form-group">
            						<label><span class="hidden-xs"><strong>Fecha de expiración de tu tarjeta</strong> (mes/año)</span></label>
            						<div class="form-inline">
            							<select class="form-control" style="width:45%" name="tarjeta-expiracion-mes" id="tarjeta-expiracion-mes" required data-conekta="card[exp_month]">
            								<option value="">Mes</option>
            								<option value="01">01</option>
            								<option value="02">02</option>
            								<option value="03">03</option>
            								<option value="04">04</option>
            								<option value="05">05</option>
            								<option value="06">06</option>
            								<option value="07">07</option>
            								<option value="08">08</option>
            								<option value="09">09</option>
            								<option value="10">10</option>
            								<option value="11">11</option>
            								<option value="12">12</option>
            							</select>
            							<div class="invalid-feedback">Por favor completa este campo</div>
            							<span style="width:10%; text-align: center"> / </span>
            							<select class="form-control" style="width:45%" name="tarjeta-expiracion-anio" id="tarjeta-expiracion-anio" required data-conekta="card[exp_year]">
            								<option value="">Año</option>
            								<option value="2019">2019</option>
            								<option value="2020">2020</option>
            								<option value="2021">2021</option>
            								<option value="2022">2022</option>
            								<option value="2023">2023</option>
            								<option value="2024">2024</option>
            								<option value="2025">2025</option>
            								<option value="2026">2026</option>
            								<option value="2027">2027</option>
            								<option value="2028">2028</option>
            								<option value="2029">2029</option>
            								<option value="2030">2030</option>
            							</select>
            							<div class="invalid-feedback">Por favor completa este campo</div>
            						</div>
            					</div>
            				</div>
            				<div class="col-sm-4">
            					<div class="form-group">
            						<label><span class="hidden-xs"><strong>CVV</strong> (código de seguridad)</span></label>
            						<input class="form-control" type="password" name="tarjeta-cvv" id="tarjeta-cvv" required value="" data-conekta="card[cvc]">
            						<div class="invalid-feedback">Por favor completa este campo</div>
            					</div>
            				</div>
            			</div>
            			<br>
            			<input type="hidden" name="conektaTokenId" id="conektaTokenId">
            			<div id="pago-opcion-conekta-tarjeta-div-mensaje-sistema"></div>
					    <div id="pago-opcion-conekta-tarjeta-div-mensaje-pago"></div>
            			<button class="subscribe btn btn-primary btn-block" type="submit" id="pago-opcion-conekta-tarjeta-div-pagar"><i class="fas fa-money-bill-wave"></i> Proceder al pago mediante <strong>TARJETA BANCARIA</strong></button>
            		</form>
        		</div>
        	</div>
		</div>
	</div>
</div>

<div class="row" id="pago-opcion-consignacion" style="display:none">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-truck"></i><strong> Consignación</strong> (Ponemos a tu disposición <strong>CONSIGNACIÓN</strong>, la cual estará sujeta a aprobación por parte de nuestro equipo)
			</div>
			<div class="card-body" id="pago-opcion-consignacion-solicitar-div">
				<button class="subscribe btn btn-primary btn-block" type="button" id="pago-opcion-consignacion-solicitar-div-pagar"><i class="fas fa-money-bill-wave"></i> Solicitar <strong>CONSIGNACIÓN</strong></button>
        	</div>
		</div>
	</div>
</div>

<?php

    require_once '../sistema/footer.php';

?>

<!-- Conekta -->
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>

<!-- Página -->
<script type="text/javascript" src="scripts/pago.js?token=<?php echo $token; ?>"></script>

<?php

	ob_end_flush();

?>