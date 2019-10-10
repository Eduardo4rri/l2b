<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Pago
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
        $sql = "SELECT p.idpago, p.pago_id, p.respuesta_banco_nombre, p.respuesta_banco_cuenta, p.pago_tienda, p.pago_proveedor, p.pago_referencia, p.pago_envio, p.pago_total, p.pago_concepto, p.pago_estatus, p.pago_estatus_leyenda, p.pago_descripcion, p.pago_paso_1, p.pago_paso_2, p.pago_paso_3, p.pago_comision, p.pago_expiracion, p.pago_confirmacion, p.fecha_hora_solicitud, p.fecha_hora_respuesta, p.fecha_hora_expiracion FROM pago p WHERE p.idpago = '$idpago'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // obtenerReferenciaPago($idpago)
    // Descripción:
    // Devuelve los datos de un pago de cualquier tipo por referencia
    // Notas:
    // N/A
    public function obtenerReferenciaPagoPorIDOrdenYReferencia($idorden, $referencia)
    {
        $sql = "SELECT p.idpago, p.pago_id, p.respuesta_banco_nombre, p.respuesta_banco_cuenta, p.pago_tienda, p.pago_proveedor, p.pago_referencia, p.pago_envio, p.pago_total, p.pago_concepto, p.pago_estatus, p.pago_estatus_leyenda, p.pago_descripcion, p.pago_paso_1, p.pago_paso_2, p.pago_paso_3, p.pago_comision, p.pago_expiracion, p.pago_confirmacion, p.fecha_hora_solicitud, p.fecha_hora_respuesta, p.fecha_hora_expiracion FROM pago p WHERE p.pago_id = '$idorden' AND p.respuesta_referencia = '$referencia'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // crearPago($idcarrito,$solicitud,$solicitud_referencia,$respuesta,$respuesta_referencia,$respuesta_banco_nombre,$respuesta_banco_cuenta,$respuesta_banco_referencia, $fecha_hora_solicitud,$fecha_hora_respuesta, $pago_tienda,$pago_proveedor,$pago_referencia,$pago_estatus,$pago_estatus_leyenda,$pago_id,$pago_concepto, $pago_envio,$pago_total)
    // Descripción:
    // Crea un pago
    // Notas:
    // N/A
    // Crea un pago
    public function crearPago(
        $idcarrito,
        $solicitud,
        $solicitud_referencia,
        $respuesta,
        $respuesta_referencia,
        $respuesta_banco_nombre,
        $respuesta_banco_cuenta,
        $respuesta_banco_referencia,
        $fecha_hora_solicitud,
        $fecha_hora_respuesta,
        $pago_tienda,
        $pago_proveedor,
        $pago_referencia,
        $pago_estatus,
        $pago_estatus_leyenda,
        $pago_id,
        $pago_concepto,
        $pago_envio,
        $pago_total,
        $pago_moneda,
        $pago_descripcion,
        $pago_paso_1,
        $pago_paso_2,
        $pago_paso_3,
        $pago_comision,
        $pago_expiracion,
        $pago_confirmacion
        )
    {
        $sql = "INSERT INTO pago (
        idcarrito,
        solicitud,
        solicitud_referencia,
        respuesta,
        respuesta_referencia,
        respuesta_banco_nombre,
        respuesta_banco_cuenta,
        respuesta_banco_referencia,
        fecha_hora_solicitud,
        fecha_hora_respuesta,
        pago_tienda,
        pago_proveedor,
        pago_referencia,
        pago_estatus,
        pago_estatus_leyenda,
        pago_id,
        pago_concepto,
        pago_envio,
        pago_total,
        pago_moneda,
        pago_descripcion,
        pago_paso_1,
        pago_paso_2,
        pago_paso_3,
        pago_comision,
        pago_expiracion,
        pago_confirmacion,
        validacion,
        activo
        ) VALUES (
            '$idcarrito',
            '$solicitud',
            '$solicitud_referencia',
            '$respuesta',
            '$respuesta_referencia',
            '$respuesta_banco_nombre',
            '$respuesta_banco_cuenta',
            '$respuesta_banco_referencia',
            '$fecha_hora_solicitud',
            '$fecha_hora_respuesta',
            '$pago_tienda',
            '$pago_proveedor',
            '$pago_referencia',
            '$pago_estatus',
            '$pago_estatus_leyenda',
            '$pago_id',
            '$pago_concepto',
            '$pago_envio',
            '$pago_total',
            '$pago_moneda',
            '$pago_descripcion',
            '$pago_paso_1',
            '$pago_paso_2',
            '$pago_paso_3',
            '$pago_comision',
            '$pago_expiracion',
            '$pago_confirmacion',
            '1',
            '1'
            )";
        return ejecutarConsulta_retornarID($sql);
    }
    // actualizarEstatusPago($idpago, $estatus, $estatus_leyenda, $fecha_hora_aprobacion, $fecha_hora_rechazo, $fecha_hora_expiracion)
    // Descripción:
    // Actualiza el estatus de tu pago
    // Notas:
    // N/A
    public function actualizarEstatusPago($idpago, $estatus, $estatus_leyenda, $fecha_hora_aprobacion, $fecha_hora_rechazo, $fecha_hora_expiracion)
    {
        $sql = "UPDATE pago SET pago_estatus = '$estatus', pago_estatus_leyenda = '$estatus_leyenda', fecha_hora_aprobacion = '$fecha_hora_aprobacion', fecha_hora_rechazo = '$fecha_hora_rechazo', fecha_hora_expiracion = '$fecha_hora_expiracion' WHERE idpago = '$idpago'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarPagoConcepto($idpago, $concepto)
    // Descripción:
    // Actualiza el concepto de tu pago
    // Notas:
    // N/A
    public function actualizarPagoConcepto($idpago, $pago_concepto)
    {
        $sql = "UPDATE pago SET pago_concepto = '$pago_concepto' WHERE idpago = '$idpago'";
        return ejecutarConsulta($sql);
    }
}

?>