<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Curso
{
    public function __construct()
    {
        
    }
    
    // listarCursosPorPrograma($idprograma)
    // Descripción:
    // Lista los cursos de un programa
    // Notas:
    // N/A
    public function listarCursosPorPrograma($idprograma)
    {
        $sql = "SELECT * FROM curso WHERE idprograma = '$idprograma'";
        return ejecutarConsulta($sql);
    }
    
    // crearNuevoCurso($idprograma, $nombre)
    // Descripción:
    // Crea un curso en un programa
    // Notas:
    // N/A
    public function crearNuevoCurso($idprograma, $nombre)
    {
        $sql = "INSERT INTO curso (idprograma, nombre) VALUES ('$idprograma', '$nombre')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // obtenerCurso($idcurso)
    // Descripción:
    // Obtiene un curso
    // Notas:
    // N/A
    public function obtenerCurso($idcurso)
    {
        $sql = "SELECT * FROM curso WHERE idcurso = '$idcurso'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // guardarFechaPeriodoVenta($idcurso, $fecha_periodo_venta_inicio, $fecha_periodo_venta_fin)
    // Descripción:
    // Guarda las fechas de periodo de venta
    // Notas:
    // N/A
    public function guardarFechaPeriodoVenta($idcurso, $fecha_periodo_venta_inicio, $fecha_periodo_venta_fin)
    {
        $sql = "UPDATE curso SET fecha_periodo_venta_inicio = '$fecha_periodo_venta_inicio', fecha_periodo_venta_fin = '$fecha_periodo_venta_fin', fecha_periodo_venta_guardado = 1 WHERE idcurso = '$idcurso'";
        return ejecutarConsulta($sql);
    }
    
    // guardarFechaPlacementTest($idcurso, $fecha_placement_test_inicio, $fecha_placement_test_fin)
    // Descripción:
    // Guarda las fechas de placement test
    // Notas:
    // N/A
    public function guardarFechaPlacementTest($idcurso, $fecha_placement_test_inicio, $fecha_placement_test_fin)
    {
        $sql = "UPDATE curso SET fecha_placement_test_inicio = '$fecha_placement_test_inicio', fecha_placement_test_fin = '$fecha_placement_test_fin', fecha_placement_test_guardado = 1 WHERE idcurso = '$idcurso'";
        return ejecutarConsulta($sql);
    }
    
    // guardarFechaEntregaMaterial($idcurso, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin, $fecha_entrega_venta_directa_inicio, $fecha_entrega_venta_directa_fin)
    // Descripción:
    // Guarda las fechas del periodo de entrega en linea y del periodo de entrega directa
    // Notas:
    // N/A
    public function guardarFechaEntregaMaterial($idcurso, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin, $fecha_entrega_venta_directa_inicio, $fecha_entrega_venta_directa_fin)
    {
        $sql = "UPDATE curso SET fecha_entrega_venta_en_linea_inicio = '$fecha_entrega_venta_en_linea_inicio', fecha_entrega_venta_en_linea_fin = '$fecha_entrega_venta_en_linea_fin', fecha_entrega_venta_directa_inicio = '$fecha_entrega_venta_directa_inicio', fecha_entrega_venta_directa_fin = '$fecha_entrega_venta_directa_fin', fecha_entrega_material_guardado = 1 WHERE idcurso = '$idcurso'";
        return ejecutarConsulta($sql);
    }
    
    // guardarFechaCurso($idcurso, $fecha_curso_inicio, $fecha_curso_fin)
    // Descripción:
    // Guarda las fechas de inicio y fin
    // Notas:
    // N/A
    public function guardarFechaCurso($idcurso, $fecha_curso_inicio, $fecha_curso_fin)
    {
        $sql = "UPDATE curso SET fecha_curso_inicio = '$fecha_curso_inicio', fecha_curso_fin = '$fecha_curso_inicio', fecha_curso_guardado = 1 WHERE idcurso = '$idcurso'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarNombreCurso($idcurso, $nombre)
    // Descripción:
    // Actualiza el nombre de un curso
    // Notas:
    // N/A
    public function actualizarNombreCurso($idcurso, $nombre)
    {
        $sql = "UPDATE curso SET nombre = '$nombre' WHERE idcurso = '$idcurso'";
        return ejecutarConsulta($sql);
    }
    
}

?>