<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/tienda.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 06/Agosto/2019
    case 'listarEscuelasPorAliasNombre':
        $alias  = isset($_POST['alias']) ? limpiarCadena($_POST['alias']) : '';
        $nombre = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        $dominio          = isset($_POST['dominio']) ? limpiarCadena($_POST['dominio']) : '';
        echo json_encode(listarEscuelasPorAliasNombre($alias, $nombre, $dominio), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'listarEscuelasPorDireccion':
        $estado        = isset($_POST['estado']) ? limpiarCadena($_POST['estado']) : '';
        $ciudad        = isset($_POST['ciudad']) ? limpiarCadena($_POST['ciudad']) : '';
        $codigo_postal = isset($_POST['codigo_postal']) ? limpiarCadena($_POST['codigo_postal']) : '';
        $dominio          = isset($_POST['dominio']) ? limpiarCadena($_POST['dominio']) : '';
        echo json_encode(listarEscuelasPorDireccion($estado, $ciudad, $codigo_postal, $dominio), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'listarProgramasPorEscuela':
        $idescuela = isset($_POST['idescuela']) ? limpiarCadena($_POST['idescuela']) : '';
        echo json_encode(listarProgramasPorEscuela($idescuela), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'listarNivelesPorPrograma':
        $idprograma = isset($_POST['idprograma']) ? limpiarCadena($_POST['idprograma']) : '';
        echo json_encode(listarNivelesPorPrograma($idprograma), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 22/Agosto/2019
    case 'listarNivelesPorProgramaSinImagen':
        $idprograma = isset($_POST['idprograma']) ? limpiarCadena($_POST['idprograma']) : '';
        echo json_encode(listarNivelesPorProgramaSinImagen($idprograma), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'obtenerArticuloEnPrograma':
        $idarticulo = isset($_POST['idarticulo']) ? limpiarCadena($_POST['idarticulo']) : '';
        $idprograma = isset($_POST['idprograma']) ? limpiarCadena($_POST['idprograma']) : '';
        echo json_encode(obtenerArticuloEnPrograma($idarticulo, $idprograma), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>