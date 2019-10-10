<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/venta_articulo.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 20/Agosto/2019
    case 'cambiarArticuloEnVentaAlumno':
        $idventa = isset($_POST['idventa']) ? limpiarCadena($_POST['idventa']) : '';
		$idprograma = isset($_POST['idprograma']) ? limpiarCadena($_POST['idprograma']) : '';
		$idarticulo = isset($_POST['idarticulo']) ? limpiarCadena($_POST['idarticulo']) : '';
        echo json_encode(cambiarArticuloEnVentaAlumno($idventa, $idprograma, $idarticulo), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>