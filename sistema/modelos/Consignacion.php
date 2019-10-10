<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Consignacion
{
    public function __construct()
    {
        
    }
    
    // obtenerConsignacion($idconsignacion)
    // Descripción:
    // Obtiene una consignación por ID de consignación
    // Notas:
    // N/A
    public function obtenerConsignacion($idconsignacion)
    {
        $sql = "SELECT * FROM consignacion WHERE idconsignacion = '$idconsignacion'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerConsignacionPorIDCurso($idcurso)
    // Descripción:
    // Obtiene una consignación por ID de curso
    // Notas:
    // N/A
    public function obtenerConsignacionPorIDCurso($idcurso)
    {
        $sql = "SELECT * FROM consignacion WHERE idcurso = '$idcurso'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerConsignacionVentaDetalles($idventa)
    // Descripción:
    // Obtiene los detalles de la venta de una consignación
    // Notas:
    // N/A
    public function obtenerConsignacionVentaDetalles($idventa)
    {
        $sql = "SELECT v_d.* FROM venta_detalle v_d LEFT JOIN venta v on v_d.idventa = v.idventa WHERE v.idventa = '$idventa' ORDER BY v_d.idventa_detalle ASC";
        return ejecutarConsulta($sql);
    }
    
    // obtenerConsignacionVentaDetallesNivel($idventa, $nivel)
    // Descripción:
    // Obtiene los detalles de la venta de una consignación de un nivel
    // Notas:
    // N/A
    public function obtenerConsignacionVentaDetallesNivel($idventa, $nivel)
    {
        $sql = "SELECT v_d.* FROM venta_detalle v_d LEFT JOIN venta v on v_d.idventa = v.idventa WHERE v.idventa = '$idventa' AND v_d.articulo_nivel = '$nivel' ORDER BY v_d.idventa_detalle ASC";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerTodasConsignacionesAprobadasPorIDCurso($idcurso)
    // Descripción:
    // Obtiene consignaciones por ID de curso
    // Notas:
    // N/A
    public function obtenerTodasConsignacionesAprobadasPorIDCurso($idcurso)
    {
        $sql = "SELECT * FROM consignacion WHERE idcurso = '$idcurso' AND estatus = 2";
        return ejecutarConsulta($sql);
    }
    
    // obtenerConsignacionPorIDEscuelaYIDCurso($idescuela, $idcurso)
    // Descripción:
    // Obtiene una consignación por ID de escuela y ID de curso
    // Notas:
    // N/A
    public function obtenerConsignacionPorIDEscuelaYIDCurso($idescuela, $idcurso)
    {
        $sql = "SELECT * FROM consignacion WHERE idescuela = '$idescuela' AND idcurso = '$idcurso'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // establecerConsignacionEstatusRevision($idconsignacion, $idventa)
    // Descripción:
    // Establece el ID de una venta en una consignación (venta) y le asigna un estatus 
    // Notas:
    // N/A
    public function establecerConsignacionEstatusRevision($idconsignacion, $idventa)
    {
        $sql = "UPDATE consignacion SET idventa = '$idventa', estatus = 1, estatus_leyenda = 'REVISION' WHERE idconsignacion = '$idconsignacion'";
        return ejecutarConsulta($sql);
    }
    
    // establecerConsignacionEstatusAprobada($idconsignacion, $idventa)
    // Descripción:
    // Establece el ID de una venta en una consignación (venta) y le asigna un estatus 
    // Notas:
    // N/A
    public function establecerConsignacionEstatusAprobada($idconsignacion, $idventa)
    {
        $sql = "UPDATE consignacion SET idventa = '$idventa', estatus = 2, estatus_leyenda = 'APROBADA' WHERE idconsignacion = '$idconsignacion'";
        return ejecutarConsulta($sql);
    }
    
    // establecerConsignacionCantidadRequerida($idconsignacion, $cantidad)
    // Descripción:
    // Establece el ID de una venta en una consignación (venta) y le asigna un estatus 
    // Notas:
    // N/A
    public function establecerConsignacionCantidadRequerida($idconsignacion, $cantidad)
    {
        $sql = "UPDATE consignacion SET cantidad_requerida = '$cantidad' WHERE idconsignacion = '$idconsignacion'";
        return ejecutarConsulta($sql);
    }
}

?>