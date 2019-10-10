<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Escuela
{
    public function __construct()
    {
        
    }
    
    // obtenerEscuela($idescuela)
    // Descripción:
    // Obtiene una escuela
    // Notas:
    // N/A
    public function obtenerEscuela($idescuela)
    {
        $sql = "SELECT * FROM escuela e WHERE e.idescuela = '$idescuela'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerEscuelasEnLista($lista_idescuela)
    // Descripción:
    // Obtiene una lista de escuelas
    // Notas:
    // N/A
    public function obtenerEscuelasEnLista($lista_idescuela)
    {
        $sql1 = "(";
        for ($i = 0; $i < count($lista_idescuela); $i++) {
            $sql1 = $sql1 . $lista_idescuela[$i];
            if ($i + 1 == count($lista_idescuela)) {
                
            } else {
                $sql1 = $sql1 . ',';
            }
        }
        $sql1 = $sql1 . ')';
        $sql = "SELECT DISTINCT(e.idescuela), e.alias, e.nombre, e.ciudad, e.estado, d.nombre AS 'distribuidor', e.fecha_placement_test_inicio AS placement_test, e.fecha_curso_inicio AS curso_periodo, e.fecha_entrega_venta_en_linea_inicio AS entrega_material FROM escuela e LEFT JOIN distribuidor d ON e.iddistribuidor = d.iddistribuidor WHERE e.idescuela IN $sql1";
        return ejecutarConsulta($sql);
    }
    
    // asignarDistribuidorAEscuelas($lista_idescuela, $iddistribuidor)
    // Descripción:
    // Asigna un distribuidor a una lista de escuelas
    // Notas:
    // N/A
    public function asignarDistribuidorAEscuelas($lista_idescuela, $iddistribuidor)
    {
        $sql1 = "(";
        for ($i = 0; $i < count($lista_idescuela); $i++) {
            $sql1 = $sql1 . $lista_idescuela[$i];
            if ($i + 1 == count($lista_idescuela)) {
                
            } else {
                $sql1 = $sql1 . ',';
            }
        }
        $sql1 = $sql1 . ')';
        $sql  = "UPDATE escuela SET iddistribuidor = '$iddistribuidor' WHERE idescuela IN $sql1 ";
        return ejecutarConsulta($sql);
    }
    
    // asignarFechasPlacementTestAEscuelas($lista_idescuela, $fecha_placement_test_inicio, $fecha_placement_test_fin)
    // Descripción:
    // Asigna fechas de placement test a una lista de escuelas
    // Notas:
    // N/A
    public function asignarFechasPlacementTestAEscuelas($lista_idescuela, $fecha_placement_test_inicio, $fecha_placement_test_fin)
    {
        $sql1 = "(";
        for ($i = 0; $i < count($lista_idescuela); $i++) {
            $sql1 = $sql1 . $lista_idescuela[$i];
            if ($i + 1 == count($lista_idescuela)) {
                
            } else {
                $sql1 = $sql1 . ',';
            }
        }
        $sql1 = $sql1 . ')';
        $sql  = "UPDATE escuela SET fecha_placement_test_inicio = '$fecha_placement_test_inicio', fecha_placement_test_fin = '$fecha_placement_test_fin' WHERE idescuela IN $sql1";
        return ejecutarConsulta($sql);
    }
    
    // asignarFechasCursoInicioAEscuelas($lista_idescuela, $fecha_curso_inicio, $fecha_curso_fin)
    // Descripción:
    // Asigna fechas de inicio de curso a una lista de escuelas
    // Notas:
    // N/A
    public function asignarFechasCursoInicioAEscuelas($lista_idescuela, $fecha_curso_inicio, $fecha_curso_fin)
    {
        $sql1 = "(";
        for ($i = 0; $i < count($lista_idescuela); $i++) {
            $sql1 = $sql1 . $lista_idescuela[$i];
            if ($i + 1 == count($lista_idescuela)) {
                
            } else {
                $sql1 = $sql1 . ',';
            }
        }
        $sql1 = $sql1 . ')';
        $sql  = "UPDATE escuela SET fecha_curso_inicio = '$fecha_curso_inicio', fecha_curso_fin = '$fecha_curso_fin' WHERE idescuela IN $sql1";
        return ejecutarConsulta($sql);
    }
    
    // asignarFechasEntregaMaterialAEscuelas($lista_idescuela, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin)
    // Descripción:
    // Asigna fechas de entrega de material a una lista de escuelas
    // Notas:
    // N/A
    public function asignarFechasEntregaMaterialAEscuelas($lista_idescuela, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin)
    {
        $sql1 = "(";
        for ($i = 0; $i < count($lista_idescuela); $i++) {
            $sql1 = $sql1 . $lista_idescuela[$i];
            if ($i + 1 == count($lista_idescuela)) {
                
            } else {
                $sql1 = $sql1 . ',';
            }
        }
        $sql1 = $sql1 . ')';
        $sql  = "UPDATE escuela SET fecha_entrega_venta_en_linea_inicio = '$fecha_entrega_venta_en_linea_inicio', fecha_entrega_venta_en_linea_fin = '$fecha_entrega_venta_en_linea_fin' WHERE idescuela IN $sql1";
        return ejecutarConsulta($sql);
    }
}

?>