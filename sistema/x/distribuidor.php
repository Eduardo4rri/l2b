<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/distribuidor.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    case 'obtenerVentasEscuelaCursoEstatus':
        $idescuela              = isset($_POST['idescuela']) ? limpiarCadena($_POST['idescuela']) : '';
        $idcurso                = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $pago_estatus           = isset($_POST['pago_estatus']) ? limpiarCadena($_POST['pago_estatus']) : '';
        $rspta                  = obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, $pago_estatus);
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
        
    case 'actualizarEntregadoOnLine':
        $idventa                     = isset($_POST["idventa"]) ? $_POST["idventa"] : null;
        $rspta                       = actualizarEntregadoOnLine($idventa);
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>