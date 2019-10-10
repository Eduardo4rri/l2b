<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/pago.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    case 'obtenerReferenciaPago':
        $idpago = isset($_POST['idpago']) ? limpiarCadena($_POST['idpago']) : '';
        echo json_encode(obtenerReferenciaPago($idpago));
        break;
}

ob_end_flush();
?>