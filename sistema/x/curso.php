<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/curso.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 06/Agosto/2019
    case 'listarCursosPorPrograma':
        $idprograma = isset($_POST['idprograma']) ? limpiarCadena($_POST['idprograma']) : '';
        echo json_encode(listarCursosPorPrograma($idprograma), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'crearNuevoCurso':
        $idprograma = isset($_POST['idprograma']) ? limpiarCadena($_POST['idprograma']) : '';
        $nombre     = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        echo json_encode(crearNuevoCurso($idprograma, $nombre), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'obtenerCurso':
        $idcurso    = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        echo json_encode(obtenerCurso($idcurso), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'guardarFechaPeriodoVenta':
        $idcurso                    = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $fecha_periodo_venta_inicio = isset($_POST['fecha_periodo_venta_inicio']) ? limpiarCadena($_POST['fecha_periodo_venta_inicio']) : '';
        $fecha_periodo_venta_fin    = isset($_POST['fecha_periodo_venta_fin']) ? limpiarCadena($_POST['fecha_periodo_venta_fin']) : '';
        echo json_encode(guardarFechaPeriodoVenta($idcurso, $fecha_periodo_venta_inicio, $fecha_periodo_venta_fin), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'guardarFechaPlacementTest':
        $idcurso                     = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $fecha_placement_test_inicio = isset($_POST['fecha_placement_test_inicio']) ? limpiarCadena($_POST['fecha_placement_test_inicio']) : '';
        $fecha_placement_test_fin    = isset($_POST['fecha_placement_test_fin']) ? limpiarCadena($_POST['fecha_placement_test_fin']) : '';
        echo json_encode(guardarFechaPlacementTest($idcurso, $fecha_placement_test_inicio, $fecha_placement_test_fin), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'guardarFechaEntregaMaterial':
        $idcurso                             = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $fecha_entrega_venta_en_linea_inicio = isset($_POST['fecha_entrega_venta_en_linea_inicio']) ? limpiarCadena($_POST['fecha_entrega_venta_en_linea_inicio']) : '';
        $fecha_entrega_venta_en_linea_fin    = isset($_POST['fecha_entrega_venta_en_linea_fin']) ? limpiarCadena($_POST['fecha_entrega_venta_en_linea_fin']) : '';
        $fecha_entrega_venta_directa_inicio  = isset($_POST['fecha_entrega_venta_directa_inicio']) ? limpiarCadena($_POST['fecha_entrega_venta_directa_inicio']) : '';
        $fecha_entrega_venta_directa_fin     = isset($_POST['fecha_entrega_venta_directa_fin']) ? limpiarCadena($_POST['fecha_entrega_venta_directa_fin']) : '';
        echo json_encode(guardarFechaEntregaMaterial($idcurso, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin, $fecha_entrega_venta_directa_inicio, $fecha_entrega_venta_directa_fin), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'guardarFechaCurso':
        $idcurso            = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $fecha_curso_inicio = isset($_POST['fecha_curso_inicio']) ? limpiarCadena($_POST['fecha_curso_inicio']) : '';
        $fecha_curso_fin    = isset($_POST['fecha_curso_fin']) ? limpiarCadena($_POST['fecha_curso_fin']) : '';
        echo json_encode(guardarFechaCurso($idcurso, $fecha_curso_inicio, $fecha_curso_fin), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'actualizarNombreCurso':
        $idcurso = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $nombre  = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        echo json_encode(actualizarNombreCurso($idcurso, $nombre), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>