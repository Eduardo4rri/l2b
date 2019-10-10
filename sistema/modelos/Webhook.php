<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Webhook
{
    public function __construct()
    {
    
    }
    // obtenerReferenciaPago($idpago)
    // Descripción:
    // Devuelve los datos de un pago de cualquier tipo
    // Notas:
    // N/A
    public function obtenerReferenciaPago($idpago)
    {
        $sql = "SELECT p.idpago, p.pago_id, p.respuesta_referencia as 'pago_referencia', p.pago_tienda, p.pago_total, p.pago_concepto, p.pago_estatus, p.pago_estatus_leyenda, p.pago_descripcion, p.pago_paso_1, p.pago_paso_2, p.pago_paso_3, p.pago_comision, p.pago_expiracion, p.pago_confirmacion FROM pago p WHERE p.idpago = '$idpago'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // crearRegistro($idventa, $idpago, $data, $id, $referencia, $estatus)
    // Descripción:
    // Crea un registro de webhook
    // Notas:
    // N/A
    public function crearRegistro($idventa, $idpago, $data, $id, $referencia, $estatus)
    {
        $sql = "INSERT INTO webhooks (idventa, idpago, data, id, referencia, estatus) VALUES ('$idventa', '$idpago', '$data', '$id', '$referencia', '$estatus')";
        return ejecutarConsulta_retornarID($sql);
    }
}


?>