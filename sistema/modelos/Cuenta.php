<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Cuenta
{
    public function __construct()
    {
        
    }
    
    // listarVentasDeAlumno($idalumno)
    // Descripción:
    // Obtiene una lista de las ventas de un alumno de tipo VENTA
    // Notas:
    // Corregido para tipo de venta
    function listarVentasDeAlumno($idalumno)
    {
        $sql = "SELECT DISTINCT (v.idventa), vd.articulo_nivel AS articulo_nivel, vd.articulo_nombre AS articulo_nombre, vd.articulo_descripcion AS articulo_descripcion, v.pago_fecha_hora, v.fecha_hora, v.fecha_entrega_prevista, v.estatus_pago_leyenda, v.total, v.tipo_pago, v.pago_referencia, v.fecha_entrega, u.matricula AS matricula FROM venta v LEFT JOIN venta_detalle vd ON vd.idventa = v.idventa LEFT JOIN articulo a ON a.idarticulo = vd.idarticulo LEFT JOIN usuario u ON u.idusuario = v.idusuario WHERE v.idusuario = '$idalumno' and v.tipo = 'venta'";
        return ejecutarConsulta($sql);
    }
    
    // listarVentasDeAlumnoPorCurso($idalumno, $idcurso)
    // Descripción:
    // Obtiene una lista de los ventas de un alumno de tipo VENTA en un curso
    // Notas:
    // Corregido para tipo de venta
    function listarVentasDeAlumnoPorCurso($idalumno, $idcurso)
    {
        $sql = "SELECT DISTINCT (v.idventa), vd.articulo_nivel AS articulo_nivel, vd.articulo_nombre AS articulo_nombre, vd.articulo_descripcion AS articulo_descripcion, v.pago_fecha_hora, v.fecha_hora, v.fecha_entrega_prevista, v.estatus_pago_leyenda, v.total, v.tipo_pago, v.pago_referencia, v.fecha_entrega, u.matricula AS matricula FROM venta v LEFT JOIN venta_detalle vd ON vd.idventa = v.idventa LEFT JOIN articulo a ON a.idarticulo = vd.idarticulo LEFT JOIN usuario u ON u.idusuario = v.idusuario WHERE v.idusuario = '$idalumno' AND v.idcurso = '$idcurso' and v.tipo = 'venta'";
        return ejecutarConsulta($sql);
    }
    
    // listarVentasDeCoordinadorPorEscuelaYCurso($idescuela, $idcurso)
    // Descripción:
    // Obtiene una lista de los ventas de un coordinador de tipo CONSIGNACION en una escuela y en un curso
    // Notas:
    // Corregido para tipo de venta
    function listarVentasDeCoordinadorPorEscuelaYCurso($idescuela, $idcurso)
    {
        $sql = "SELECT DISTINCT (v.idventa), vd.articulo_nivel AS articulo_nivel, vd.articulo_nombre AS articulo_nombre, vd.articulo_descripcion AS articulo_descripcion, v.pago_fecha_hora, v.fecha_hora, v.fecha_entrega_prevista, v.estatus_pago_leyenda, v.total, v.tipo_pago, v.pago_referencia, v.fecha_entrega, u.matricula AS matricula FROM venta v LEFT JOIN venta_detalle vd ON vd.idventa = v.idventa LEFT JOIN articulo a ON a.idarticulo = vd.idarticulo LEFT JOIN usuario u ON u.idusuario = v.idusuario WHERE v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' and v.tipo = 'consignacion'";
        return ejecutarConsulta($sql);
    }
    
    // enviarMensajeDeAyuda($idusuario, $nombre, $correo, $datos_adicionales)
    // Descripción:
    // Envia mensaje de ayuda de los usuarios
    // Notas:
    // Se usa cuando el usuario tenga dudas o problemas con la plataforma
    public function enviarMensajeDeAyuda($idusuario, $nombre, $correo, $datos_adicionales)
    {
        $sql = "INSERT INTO solicitud_ayuda (idusuario, usuario_nombre, usuario_email, usuario_notas) VALUES ('$idusuario', '$nombre', '$correo', '$datos_adicionales')";
        return ejecutarConsulta_retornarID($sql);
    }
}

?>