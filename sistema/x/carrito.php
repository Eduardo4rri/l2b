<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/carrito.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 01/Agosto/2019
    case 'obtenerCarritoDeUsuario':
        $idusuario = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        echo json_encode(obtenerCarritoDeUsuario($idusuario), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 01/Agosto/2019
    case 'obtenerCarrito':
        $idcarrito = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        echo json_encode(obtenerCarrito($idcarrito), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 01/Agosto/2019
    case 'validarCarrito':
        $idcarrito = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        echo json_encode(validarCarrito($idcarrito), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 01/Agosto/2019
    case 'agregarArticuloAlCarrito':
        $idcarrito  = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        $idprograma = isset($_POST['idprograma']) ? limpiarCadena($_POST['idprograma']) : '';
        $idarticulo = isset($_POST['idarticulo']) ? limpiarCadena($_POST['idarticulo']) : '';
        $cantidad   = isset($_POST['cantidad']) ? limpiarCadena($_POST['cantidad']) : '';
        echo json_encode(agregarArticuloAlCarrito($idcarrito, $idprograma, $idarticulo, $cantidad), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 01/Agosto/2019
    case 'eliminarArticuloDelCarrito':
        $idcarrito  = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        $idarticulo = isset($_POST['idarticulo']) ? limpiarCadena($_POST['idarticulo']) : '';
        echo json_encode(eliminarArticuloDelCarrito($idcarrito, $idarticulo), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 01/Agosto/2019
    case 'vaciarCarrito':
        $idcarrito = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        echo json_encode(vaciarCarrito($idcarrito), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 01/Agosto/2019
    case 'pagarCarritoTarjeta':
        $idcarrito               = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        $token_id                = isset($_POST['token_id']) ? limpiarCadena($_POST['token_id']) : '';
        echo json_encode(pagarCarritoTarjeta($idcarrito, $token_id), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 01/Agosto/2019
    case 'pagarCarritoTienda':
        $idcarrito               = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        $tienda                  = isset($_POST['tienda']) ? limpiarCadena($_POST['tienda']) : '';
        echo json_encode(pagarCarritoTienda($idcarrito, $tienda), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 01/Agosto/2019
    case 'pagarCarritoConsignacion':
        $idcarrito = isset($_POST['idcarrito']) ? limpiarCadena($_POST['idcarrito']) : '';
        echo json_encode(pagarCarritoConsignacion($idcarrito), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>