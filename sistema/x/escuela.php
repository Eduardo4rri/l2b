<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/escuela.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 08/Agosto/2019
    case 'obtenerEscuela':
        $idescuela = isset($_POST['idescuela']) ? limpiarCadena($_POST['idescuela']) : '';
        echo json_encode(obtenerEscuela($idescuela), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 08/Agosto/2019
    case 'obtenerEscuelasEnLista':
        $lista_idescuela = isset($_POST['lista_idescuela']) ? $_POST['lista_idescuela'] : null;
        $rspta           = obtenerEscuelasEnLista($lista_idescuela);
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 08/Agosto/2019
    case 'asignarDistribuidorAEscuelas':
        $lista_idescuela = isset($_POST['lista_idescuela']) ? $_POST['lista_idescuela'] : null;
        $iddistribuidor  = isset($_POST['iddistribuidor']) ? limpiarCadena($_POST['iddistribuidor']) : '';
        $rspta           = asignarDistribuidorAEscuelas($lista_idescuela, $iddistribuidor);
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 08/Agosto/2019
    case 'asignarFechasPlacementTestAEscuelas':
        $lista_idescuela             = isset($_POST['lista_idescuela']) ? $_POST['lista_idescuela'] : null;
        $fecha_placement_test_inicio = isset($_POST['fecha_placement_test_inicio']) ? limpiarCadena($_POST['fecha_placement_test_inicio']) : '';
        $fecha_placement_test_fin    = isset($_POST['fecha_placement_test_fin']) ? limpiarCadena($_POST['fecha_placement_test_fin']) : '';
        $rspta                       = asignarFechasPlacementTestAEscuelas($lista_idescuela, $fecha_placement_test_inicio, $fecha_placement_test_fin);
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 08/Agosto/2019
    case 'asignarFechasCursoInicioAEscuelas':
        $lista_idescuela    = isset($_POST['lista_idescuela']) ? $_POST['lista_idescuela'] : null;
        $fecha_curso_inicio = isset($_POST['fecha_curso_inicio']) ? limpiarCadena($_POST['fecha_curso_inicio']) : '';
        $fecha_curso_fin    = isset($_POST['fecha_curso_fin']) ? limpiarCadena($_POST['fecha_curso_fin']) : '';
        $rspta              = asignarFechasCursoInicioAEscuelas($lista_idescuela, $fecha_curso_inicio, $fecha_curso_fin);
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 08/Agosto/2019
    case 'asignarFechasEntregaMaterialAEscuelas':
        $lista_idescuela                     = isset($_POST['lista_idescuela']) ? $_POST['lista_idescuela'] : null;
        $fecha_entrega_venta_en_linea_inicio = isset($_POST['fecha_entrega_venta_en_linea_inicio']) ? limpiarCadena($_POST['fecha_entrega_venta_en_linea_inicio']) : '';
        $fecha_entrega_venta_en_linea_fin    = isset($_POST['fecha_entrega_venta_en_linea_fin']) ? limpiarCadena($_POST['fecha_entrega_venta_en_linea_fin']) : '';
        $rspta                               = asignarFechasEntregaMaterialAEscuelas($lista_idescuela, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin);
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>