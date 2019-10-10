<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Distribuidor
{
    public function __construct()
    {
        
    }
    
    // listarDistribuidores()
    // Descripción:
    // Lista a los distribuidores
    // Notas:
    // N/A
    public function listarDistribuidores()
    {
        $sql = "SELECT * FROM distribuidor";
        return ejecutarConsulta($sql);
    }
    
    // obtenerDistribuidor($iddistribuidor)
    // Descripción:
    // Obtiene al distribuidor
    // Notas:
    // N/A
    public function obtenerDistribuidor($iddistribuidor)
    {
        $sql = "SELECT * FROM distribuidor d WHERE d.iddistribuidor = '$iddistribuidor'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, $pago_estatus)
    // Descripción:
    // Obtiene las ventas de las escuelas por curso y estatus de pago
    // Notas:
    // N/A
    public function obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, $pago_estatus)
    {
        $sql = "SELECT v.idventa, v.tipo_pago, v.pago_referencia, v.estatus_pago_leyenda, v.estatus_entrega, fecha_hora, fecha_entrega_prevista, (CONCAT(u.nombre, ' ', u.apellido_paterno, ' ', u.apellido_materno)) AS alumno, matricula FROM venta v INNER JOIN usuario u ON u.idusuario = v.idusuario WHERE v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND estatus_pago = '$pago_estatus'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarEntregadoOnLine($idventa)
    // Descripción:
    // Actualiza los datos de libros entregados
    // Notas:
    // N/A
    public function actualizarEntregadoOnLine($idventa)
    {
        $sql1 = "(";
        for ($i = 0; $i < count($idventa); $i++) {
            $sql1 = $sql1 . $idventa[$i];
            if ($i + 1 == count($idventa)) {
                
            } else {
                $sql1 = $sql1 . ',';
            }
        }
        $sql1 = $sql1 . ')';
        $sql  = "UPDATE venta SET estatus_entrega = 1 WHERE idventa IN $sql1";
        return ejecutarConsulta($sql);
    }
}

?>