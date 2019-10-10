<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/carrito_recompensas.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    case 'obtenerCarritoRecompensasDeUsuario':
        $idusuario = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        echo json_encode(obtenerCarritoRecompensasDeUsuario($idusuario), JSON_NUMERIC_CHECK);
        break;
    case 'obtenerCarritoRecompensas':
        $idcarrito = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        echo json_encode(obtenerCarritoRecompensas($idcarrito), JSON_NUMERIC_CHECK);
        break;
    case 'validarCarritoRecompensas':
        $idcarrito = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        echo json_encode(validarCarritoRecompensas($idcarrito), JSON_NUMERIC_CHECK);
        break;
    case 'agregarRecompensaAlCarritoRecompensas':
        $idcarrito    = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        $idrecompensa = isset($_POST['idrecompensa']) ? limpiarCadena($_POST['idrecompensa']) : '';
        $cantidad     = isset($_POST['cantidad']) ? limpiarCadena($_POST['cantidad']) : '';
        echo json_encode(agregarRecompensaAlCarritoRecompensas($idcarrito, $idrecompensa, $cantidad), JSON_NUMERIC_CHECK);
        break;
    case 'eliminarRecompensaDelCarritoRecompensas':
        $idcarrito    = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        $idrecompensa = isset($_POST['idrecompensa']) ? limpiarCadena($_POST['idrecompensa']) : '';
        echo json_encode(eliminarRecompensaDelCarritoRecompensas($idcarrito, $idrecompensa), JSON_NUMERIC_CHECK);
        break;
    case 'vaciarCarritoRecompensas':
        $idcarrito = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        echo json_encode(vaciarCarritoRecompensas($idcarrito), JSON_NUMERIC_CHECK);
        break;
    case 'canjearCarritoRecompensas':
        $idcarrito               = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        $tarjeta_nombre          = isset($_POST['tarjeta_nombre']) ? limpiarCadena($_POST['tarjeta_nombre']) : '';
        $tarjeta_numero          = isset($_POST['tarjeta_numero']) ? limpiarCadena($_POST['tarjeta_numero']) : '';
        $tarjeta_expiracion_mes  = isset($_POST['tarjeta_expiracion_mes']) ? limpiarCadena($_POST['tarjeta_expiracion_mes']) : '';
        $tarjeta_expiracion_anio = isset($_POST['tarjeta_expiracion_anio']) ? limpiarCadena($_POST['tarjeta_expiracion_anio']) : '';
        $tarjeta_cvv             = isset($_POST['tarjeta_cvv']) ? limpiarCadena($_POST['tarjeta_cvv']) : '';
        echo json_encode(canjearCarritoRecompensas($idcarrito, $tarjeta_nombre, $tarjeta_numero, $tarjeta_expiracion_mes, $tarjeta_expiracion_anio, $tarjeta_cvv), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>