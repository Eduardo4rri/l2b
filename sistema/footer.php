	</div>
	<!-- Page Content End -->

	<!-- Bootstrap core JavaScript -->
	<script src="../sistema/vendor/jquery/jquery.min.js"></script>
	<script src="../sistema/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Loading Modal -->
	<script src="../sistema/vendor/loading-modal/js/jquery.loadingModal.min.js"></script>

	<!-- Toast -->
	<script src="../sistema/vendor/toast/jquery.toast.min.js"></script>

	<!-- Data Tables -->
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
	<script src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

	<!-- Select Picker -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

	<!-- jVectorMap -->
	<script src="../sistema/vendor/jvectormap/jquery-jvectormap-2.0.3.min.js"></script>
	<script type="text/javascript" src="../sistema/mapa_mx_en.js"></script>
	<script type="text/javascript" src="../sistema/mapa.js?token=<?php echo $token; ?>"></script>

	<!-- Bootbox -->
	<script src="../sistema/vendor/bootbox/bootbox.min.js"></script>
	<script src="../sistema/vendor/bootbox/bootbox.locales.min.js"></script>

	<!-- Excel -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xls/0.7.4-a/xls.core.min.js"></script>  

	<!-- Sistema -->
	<script type="text/javascript" src="../sistema/config/sistema.js?token=<?php echo $token; ?>"></script>

	<!-- Carrito -->
	<script type="text/javascript" src="../tienda/scripts/carrito.js?token=<?php echo $token; ?>"></script>

	<script>
	    var usuario = JSON.parse(localStorage.getItem('usuario'));
		$(document).ready(function() {
			if (usuario.usuario_rol === 'coordinador_dominio' || usuario.usuario_rol === 'coordinador_zona' || usuario.usuario_rol === 'coordinador_subzona' || usuario.usuario_rol === 'coordinador_escuela') {
				$('#mensaje-bienvenida').html('¡Hola <strong>' + usuario.usuario_nombre + ' ' + usuario.usuario_apellido_paterno + ' ' + usuario.usuario_apellido_materno + '</strong>, bienvenid@ a <strong>Links2Books</strong>!');
				$('#mensaje-dominio').html('Felicidades por ser parte de <strong>' + usuario.usuario_dominio.toUpperCase() + '</strong>, ¡te deseamos mucho éxito!');
				$('#mensaje-ultima-conexion').html('Tu última conexión fue el <strong>' + usuario.usuario_token_ultimo + '</strong>');
			}
			if (usuario.usuario_rol === 'alumno') {
				$('#mensaje-bienvenida').html('¡Hola <strong>' + usuario.usuario_nombre + ' ' + usuario.usuario_apellido_paterno + ' ' + usuario.usuario_apellido_materno + '</strong>, bienvenid@ a <strong>Links2Books</strong>!');
				$('#mensaje-dominio').html('Felicidades por ser parte de <strong>' + usuario.usuario_dominio.toUpperCase() + '</strong>, ¡te deseamos mucho éxito!');
				$('#mensaje-ultima-conexion').html('Tu última conexión fue el <strong>' + usuario.usuario_token_ultimo + '</strong>');
			}
			if (usuario.usuario_rol === 'distribuidor') {
				$('#mensaje-bienvenida').html('¡Bienvenido Distribuidor <strong>' + usuario.usuario_nombre + '</strong>!');
				$('#mensaje-dominio').html('Gracias por formar parte de <strong>' + usuario.usuario_dominio.toUpperCase() + '</strong>');
				$('#mensaje-ultima-conexion').html('Tu última conexión fue el <strong>' + usuario.usuario_token_ultimo + '</strong>');
			}
			initCarrito();
			cargarDatosAyudaModal();
			$('#modalPedirAyuda').click(function()
        	{
        		$('#ayuda-modal').modal('show');
        	});
        	$('#modalTutorial').click(function()
        	{
        		$('#modal-tutorial').modal('show');
        	});
        	$('#enviar-mensaje-ayuda').click(function()
        	{
        	    enviarMensajeDeAyuda();
        	});
        	$('#ayuda-datos-adicionales').change(function()
        	{
        	    console.log("entrando al change");
        		validarDatosUsuario('ayuda-datos-adicionales');
        	});
        	
        	function validarDatosUsuario(campo)
            {
            	var errores = 0;
            	if (campo === 'todos' || campo === 'ayuda-datos-adicionales')
            	{
            		if (!$('#ayuda-datos-adicionales').val())
            		{
            			$('#ayuda-datos-adicionales').removeClass('is-valid');
            			$('#ayuda-datos-adicionales').addClass('is-invalid');
            			errores++;
            		}
            		else
            		{
            			$('#ayuda-datos-adicionales').removeClass('is-invalid');
            			$('#ayuda-datos-adicionales').addClass('is-valid');
            		}
            	}
            	if (errores == 0)
            	{
            		return true;
            	}
            	else
            	{
            		return false;
            	}
            }
        	
        	function cargarDatosAyudaModal()
    	    {
    	        $('#ayuda-usuario-id').val(usuario.usuario_idusuario);
        	    $('#ayuda-nombre-usuario').val(usuario.usuario_nombre + ' ' + usuario.usuario_apellido_paterno + ' ' + usuario.usuario_apellido_materno);
        	    $('#ayuda-correo').val(usuario.usuario_email);
        	}
        	function enviarMensajeDeAyuda()
        	{
        	    var validacion = validarDatosUsuario('todos');
            	var nombre = $('#ayuda-nombre-usuario').val();
            	var correo = $('#ayuda-correo').val();
            	var datos_adicionales = limpiarString($('#ayuda-datos-adicionales').val());
            	var idusuario = $('#ayuda-usuario-id').val();
            	if (validacion == false)
            	{
            		bootbox.alert('Hay errores de validación en tus datos, por favor revisalos, completa la información necesaria y vuelve a intentarlo');
            		return;
            	}
            	mostrarEsperaAjax('');
            	$.ajax(
            	{
            		url: '../sistema/x/cuenta.php',
            		type: 'POST',
            		dataType: 'json',
            		timeout: config_ajax_timeout,
            		data:
            		{
            			op: 'enviarMensajeDeAyuda',
            			idusuario: idusuario,
            			nombre: nombre,
            			correo: correo,
            			datos_adicionales: datos_adicionales
            		},
            		error: function(xhr, status, error)
            		{
            			ocultarEsperaAjax();
            			console.error('[footer.js] [enviarMensajeDeAyuda] • Error connecting to the server, please contact support or try again later... • ' + JSON.stringify(error));
            			bootbox.alert('Error connecting to the server, please contact support or try again later...');
            		},
            		success: function(data)
            		{
            			ocultarEsperaAjax();
            			if (data.resultado === 'OK' || data.resultado === 'ADVERTENCIA')
            			{
            				bootbox.alert('<i class="fas fa-check"></i> ' + data.mensaje);
            				$('#ayuda-datos-adicionales').val('');
            				$('#ayuda-datos-adicionales').removeClass('is-valid');
            				$('#ayuda-modal').modal('hide');
            			}
            			else
            			{
            				console.warn('[footer.js] [enviarMensajeDeAyuda] • The server encountered a problem while performing the request, please contact support or try again later... • ' + JSON.stringify(data));
            				bootbox.alert(data.mensaje);
            			}
            		}
            	}).done(function() {});
        	}
		});
    	
	</script>

	<nav id="notificacion-mensaje" class="navbar fixed-bottom navbar-light bg-faded invisible">
		<div class="alert alert-primary col-md-12" role="alert" style="background-color:#4d648d;">
			<p class="text-center" style="font-size: 14px; color: #FFFFFF;" id="notificacion-mensaje-progreso"></p>
			<div class="progress">
				<div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; background-color: #aab9d2 !important;"></div>
			</div>
		</div>
	</nav>

	</body>

	</html>