<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class VentaNivel
{
    protected $modo = null;
    
    public function __construct()
    {
        $this->modo = PRO_MODO_VENTAS;
    }
    
    // obtenerVentasEscuelaCursoConsignacionNivelPorAsignar($idescuela, $idcurso, $idconsignacion)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación con un nivel por asignar
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionNivelPorAsignar($idescuela, $idcurso, $idconsignacion)
    {
        $sql = "SELECT DISTINCT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v LEFT JOIN venta_detalle v_d ON v.idventa = v_d.idventa WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v_d.articulo_nivel = 'NIVEL POR ASIGNAR' AND v.tipo_rol = 'alumno' AND (v.estatus_pago = 0 OR v.estatus_pago = 1)";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacionNivelPorAsignarEstatus($idescuela, $idcurso, $idconsignacion, $pago_estatus)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación con un nivel por asignar y con un estatus de pago
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionNivelPorAsignarEstatus($idescuela, $idcurso, $idconsignacion, $pago_estatus)
    {
        $sql = "SELECT DISTINCT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v LEFT JOIN venta_detalle v_d ON v.idventa = v_d.idventa WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v_d.articulo_nivel = 'NIVEL POR ASIGNAR' AND v.tipo_rol = 'alumno' AND v.estatus_pago = '$pago_estatus'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacionNivel($idescuela, $idcurso, $idconsignacion, $nivel)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación con un nivel
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionNivel($idescuela, $idcurso, $idconsignacion, $nivel)
    {
        $sql = "SELECT DISTINCT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v LEFT JOIN venta_detalle v_d ON v.idventa = v_d.idventa WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v_d.articulo_nivel = '$nivel' AND v.tipo_rol = 'alumno' AND (v.estatus_pago = 0 OR v.estatus_pago = 1)";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacionEstatusNivel($idescuela, $idcurso, $idconsignacion, $pago_estatus, $nivel)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación y con un estatus de pago con un nivel
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionEstatusNivel($idescuela, $idcurso, $idconsignacion, $pago_estatus, $nivel)
    {
        $sql = "SELECT DISTINCT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v LEFT JOIN venta_detalle v_d ON v.idventa = v_d.idventa WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v_d.articulo_nivel = '$nivel' AND v.tipo_rol = 'alumno' AND v.estatus_pago = '$pago_estatus'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacionEstatusEntregaNivel($idescuela, $idcurso, $idconsignacion, $entrega_estatus, $nivel)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación y con un estatus de entrega con un nivel
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionEstatusEntregaNivel($idescuela, $idcurso, $idconsignacion, $entrega_estatus, $nivel)
    {
        $sql = "SELECT DISTINCT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v LEFT JOIN venta_detalle v_d ON v.idventa = v_d.idventa WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v_d.articulo_nivel = '$nivel' AND v.tipo_rol = 'alumno' AND v.estatus_pago = '1' AND v.estatus_entrega = '$entrega_estatus'";
        return ejecutarConsulta($sql);
    }
}

?>