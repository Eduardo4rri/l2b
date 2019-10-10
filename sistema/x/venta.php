<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/venta.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 06/Agosto/2019
    case 'obtenerVenta':
        $idventa = isset($_POST['idventa']) ? limpiarCadena($_POST['idventa']) : '';
        echo json_encode(obtenerVenta($idventa), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'obtenerPDFVenta':
        $idventa = isset($_POST['idventa']) ? limpiarCadena($_POST['idventa']) : '';
        echo json_encode(obtenerPDFVenta($idventa), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'obtenerVentaConImagen':
        $idventa = isset($_POST['idventa']) ? limpiarCadena($_POST['idventa']) : '';
        echo json_encode(obtenerVentaConImagen($idventa), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'actualizarDatosDeFacturacion': 
        $idusuario              = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        $idventa                = isset($_POST['idventa']) ? limpiarCadena($_POST['idventa']) : '';
        $usuario_rfc            = isset($_POST['rfc']) ? limpiarCadena($_POST['rfc']) : '';
        $usuario_email          = isset($_POST['correo']) ? limpiarCadena($_POST['correo']) : '';
        $datos_adicionales      = isset($_POST['datos_adicionales']) ? limpiarCadena($_POST['datos_adicionales']) : '';
        $libro                  = isset($_POST['libro']) ? limpiarCadena($_POST['libro']) : '';
        $nombre_usuario         = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        $usuario_telefono       = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : '';
        $calle                  = isset($_POST['calle']) ? limpiarCadena($_POST['calle']) : '';
        $numero_exterior        = isset($_POST['numero_exterior']) ? limpiarCadena($_POST['numero_exterior']) : '';
        $numero_interior        = isset($_POST['numero_interior']) ? limpiarCadena($_POST['numero_interior']) : '';
        $colonia                = isset($_POST['colonia']) ? limpiarCadena($_POST['colonia']) : '';
        $delegacion             = isset($_POST['delegacion']) ? limpiarCadena($_POST['delegacion']) : '';
        $ciudad                 = isset($_POST['ciudad']) ? limpiarCadena($_POST['ciudad']) : '';
        $pais                   = isset($_POST['pais']) ? limpiarCadena($_POST['pais']) : '';
        $codigo_postal          = isset($_POST['codigo_postal']) ? limpiarCadena($_POST['codigo_postal']) : '';
        echo json_encode(actualizarDatosDeFacturacion($idusuario, $idventa, $usuario_rfc , $usuario_email, $datos_adicionales, $libro, $nombre_usuario, $usuario_telefono, $calle, $numero_exterior, $numero_interior, $colonia, $delegacion, $ciudad, $pais, $codigo_postal), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'obtenerVentasEscuelaCursoEstatusTodos':
        $idescuela = isset($_POST['idescuela']) ? limpiarCadena($_POST['idescuela']) : '';
        $idcurso = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        echo json_encode(obtenerVentasEscuelaCursoEstatusTodos($idescuela, $idcurso), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'obtenerEstatusEntregaVentaEscuelaCursoEstatus':
        $idescuela = isset($_POST['idescuela']) ? limpiarCadena($_POST['idescuela']) : '';
        $idcurso = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $idventa = isset($_POST['idventa']) ? limpiarCadena($_POST['idventa']) : '';
        echo json_encode(obtenerEstatusEntregaVentaEscuelaCursoEstatus($idescuela, $idcurso, $idventa), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'establecerEstatusEntregaVentaEntregadaEscuelaCursoEstatus':
        $idescuela = isset($_POST['idescuela']) ? limpiarCadena($_POST['idescuela']) : '';
        $idcurso = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $idventa = isset($_POST['idventa']) ? limpiarCadena($_POST['idventa']) : '';
        $fecha_entrega = isset($_POST['fecha_entrega']) ? limpiarCadena($_POST['fecha_entrega']) : '';
        echo json_encode(establecerEstatusEntregaVentaEntregadaEscuelaCursoEstatus($idescuela, $idcurso, $idventa, $fecha_entrega), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'establecerEstatusEntregaVentaEntregadaEscuelaCursoBatch':
        $idescuela = isset($_POST['idescuela']) ? limpiarCadena($_POST['idescuela']) : '';
        $idcurso = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $lista_venta = isset($_POST['lista_venta']) ? $_POST['lista_venta'] : null;
        echo json_encode(establecerEstatusEntregaVentaEntregadaEscuelaCursoBatch($idescuela, $idcurso, $lista_venta), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 22/Agosto/2019
    case 'obtenerVentaParaCambioArticulo':
        $idventa = isset($_POST['idventa']) ? limpiarCadena($_POST['idventa']) : '';
        echo json_encode(obtenerVentaParaCambioArticulo($idventa), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>