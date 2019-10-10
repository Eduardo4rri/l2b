<?php

    session_start();
    ob_start();
    $token = uniqid();
    require_once '../sistema/header.php';

?>

<style type="text/css">
	#puntos-para-usar,
	#puntos-obtenidos {
		background: rgba(0, 0, 0, 0);
		border: none;
	}
</style>

<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>¡Bienvenido a <i class="fas fa-school"></i> Mis recompensas!</strong><br><br>
    En está página podrás:<br>
    • Visualizar tus puntos disponibles,las recompensas disponibles y el canje realizado<br>
    • Seleccionar la recompensa<br>
</div>

<div class="row">
	<div class="col-xs-12 col-md-12 mb-4">
		<div class="card shadow">
			<div class="card-header"><i class="fas fa-award"></i><strong> Mis recompensas</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<label><i class="fas fa-info-circle"></i> Cada compra realizada por los alumnos sumará un porcentaje (<strong>según lo acordado en tu contrato</strong>) del total del pedido en forma de puntos para canjear por diversas recompensas</label>
						<br>
						<label><i class="fas fa-info-circle"></i> El canje de recompensas estará disponible durante <strong>Marzo y Octubre</strong>, por lo cual podrás hacer uso de los puntos acumulados <strong>ÚNICAMENTE</strong> durante esas fechas</label>
						<br>
						<label><i class="fas fa-info-circle"></i> Una vez seleccionadas las recompensas deseadas, haz click en <i class="fas fa-check"></i> <strong>Canjear</strong> para realizar la solicitud, nos pondremos en contacto contigo para afinar los detalles pertinentes</label>
						<br>
						<hr>
						<br>
						<div class="text-center"><label><i class="fas fa-award"></i> <strong>Lista de Recompensas</strong></label></div>
						<br>
						<div class="accordion" id="accordion-recompensas">
							<div class="card">
								<div class="card-header" id="headingOne">
									<h2 class="mb-0">
										<button class="btn btn-block" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
											<i class="fas fa-book"></i> Libros de <strong>H</strong>elbling
										</button>
									</h2>
								</div>
								<div id="collapseOne" class="collapse multi-collapse">
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-hover" id="libro-recompensas">
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingTwo">
									<h2 class="mb-0">
										<button class="btn btn-block" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											<i class="fas fa-chalkboard-teacher"></i> Links2Training
										</button>
									</h2>
								</div>
								<div id="collapseTwo" class="collapse multi-collapse">
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-hover" id="curso-recompensas">
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingThree">
									<h2 class="mb-0">
										<button class="btn btn-block" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
											<i class="fas fa-user-tie"></i> Patrocinios
										</button>
									</h2>
								</div>
								<div id="collapseThree" class="collapse multi-collapse">
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-hover" id="material-recompensas">
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-3 col-md-3 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-balance-scale"></i><strong> Puntos Disponibles</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<label><i class="fas fa-star"></i> Puntos totales acumulados: <strong id="puntos-acumulados">1500</strong></label>
						<br>
						<label><i class="fas fa-star-half-alt"></i> Puntos gastados anteriormente: <strong id="puntos-gastados">0</strong></label>
						<hr>
						<label><i class="fas fa-balance-scale"></i> Puntos disponibles: <strong id="puntos-disponibles">1500</strong></label>
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-9 col-md-9 mb-4">
		<div class="card shadow h-100">
			<div class="card-header"><i class="fas fa-shopping-cart"></i><strong> Carrito de recompensas</strong></div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="table-responsive">
    						<table class="table table-sm" id="carrito-recompensas">
    							<thead>
    								<tr>
    									<th scope="col">Nombre</th>
    									<th scope="col">Descripción</th>
    									<th scope="col">Puntos</th>
    									<th scope="col">Cantidad</th>
    									<th scope="col">Total</th>
    									<th scope="col">Quitar</th>
    								</tr>
    							</thead>
    							<tbody>
    							</tbody>
    						</table>
    					</div>
    					<br>
    					<hr>
    					<button type="button" class="btn btn-primary btn-block" id="carrito-recompensas-canjear"><i class="fas fa-check"></i> Canjear</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<br>

<?php

    require_once '../sistema/footer.php';

?>

<!-- Página -->
<script type="text/javascript" src="scripts/recompensas.js?token=<?php echo $token; ?>"></script>
<script type="text/javascript" src="scripts/carrito_recompensas.js?token=<?php echo $token; ?>"></script>

<?php

    ob_end_flush();

?>