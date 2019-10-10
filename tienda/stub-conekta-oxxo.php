<html>

<head>
    <link href="stub-conekta-styles.css" media="all" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../sistema/img/sitio_icono_32x32.png" />
    <title>Referencia de Pago</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <div class="opps">
        <div class="opps-header">
            <div onclick="window.print();" class="opps-reminder" style="cursor: pointer;">Click aquí para imprimir.</div>
            <div class="opps-info">
                <div class="opps-brand"><img src="stub-conekta-oxxopay-brand.png" alt="OXXOPay"></div>
                <div class="opps-ammount">
                    <h3>Monto a pagar</h3>
                    <h2 id="pago-cantidad"></h2>
                    <p>OXXO cobrará una comisión adicional de $12.00 al momento de realizar el pago.</p>
                </div>
            </div>
            <div class="opps-reference">
                <h3>Concepto</h3>
                <h1 id="pago-concepto"></h1>
            </div>
            <div class="opps-reference">
                <h3>Referencia</h3>
                <h1 id="pago-referencia"></h1>
            </div>
        </div>
        <div class="opps-instructions">
            <h3>Instrucciones</h3>
            <ol>
                <li id="pago-descripcion"></li>
                <li id="pago-paso-1"></li>
                <li id="pago-paso-2"></li>
                <li id="pago-paso-3"></li>
                <li id="pago-comision"></li>
                <li id="pago-expiracion"></li>
                <li id="pago-confirmacion"></li>
            </ol>
            <div class="opps-footnote">Al completar estos pasos recibirás un correo confirmando tu pago.</div>
        </div>
    </div>

    <script>
    
        function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
            return vars;
        }
        
        function formatearDinero(n, c, d, t)
        {
        	var c = isNaN(c = Math.abs(c)) ? 2 : c,
        		d = d == undefined ? "." : d,
        		t = t == undefined ? "," : t,
        		s = n < 0 ? "-" : "",
        		i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        		j = (j = i.length) > 3 ? j % 3 : 0;
        	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };
        
        $(document).ready(function() {
            var idpago = getUrlVars()['idpago'];
            $.ajax({
                url: '../sistema/x/pago.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    op: 'obtenerReferenciaPago',
                    idpago: idpago
                },
                error: function(xhr, status, error) {
                    console.error('[login.php] [ready] • Error connecting to the server, please contact support or try again later...');
                },
                success: function(data) {
                    if (data.resultado === 'OK') {
                        console.log(JSON.stringify(data));
                        var pago = data.detalles;
                        var total = formatearDinero(pago.pago_total);
                        var total_leyenda = '$' + total + '<sup>MXN</sup>';
                        var concepto = pago.pago_concepto;
                        var referencia = pago.pago_referencia;
                        $('#pago-cantidad').html(total_leyenda);
                        $('#pago-concepto').html(concepto);
                        $('#pago-referencia').html(referencia);
                        $('#pago-descripcion').html(pago.pago_descripcion);
                        $('#pago-paso-1').html(pago.pago_paso_1);
                        $('#pago-paso-2').html(pago.pago_paso_2);
                        $('#pago-paso-3').html(pago.pago_paso_3);
                        $('#pago-comision').html(pago.pago_comision);
                        $('#pago-expiracion').html(pago.pago_expiracion);
                        $('#pago-confirmacion').html(pago.pago_confirmacion);
                    } else {
                        console.warn('[login.php] [ready] • Could not retrieve the requested data...');
                    }
                }
            }).done(function() {});
        });
        
    </script>

</body>

</html>