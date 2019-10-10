<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Venta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Consignacion.php';

// obtenerVenta($idventa)
// Descripción:
// Obtiene una venta
// Notas:
// N/A
function obtenerVenta($idventa)
{
    $venta    = new Venta();
    $data     = new stdClass();
    $car      = new stdClass();
    $car_data = new stdClass();
    $rspta    = $venta->obtenerVenta($idventa);
    if ($rspta)
    {
        $car             = $rspta;
        $car_data        = obtenerVentaDetalle($rspta->idventa);
        $car->detalles   = $car_data->detalles;
        $data->resultado = 'OK';
        $data->mensaje   = '¡Venta disponible!';
        $data->detalles  = $car;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Venta no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerVentaConImagen($idventa)
// Descripción:
// Obtiene los datos de una venta con sus detalles (artículos) y sus imagenes con propiedades customizadas sin prefijo
// Notas:
// Los detalles (artículos) contienen la representación en base 64 de la imagen, por lo que esto repercute en una transferencia de datos algo grande
function obtenerVentaConImagen($idventa)
{
    $venta    = new Venta();
    $data     = new stdClass();
    $car      = new stdClass();
    $car_data = new stdClass();
    $rspta    = $venta->obtenerVenta($idventa);
    if ($rspta)
    {
        $car             = $rspta;
        $car_data        = obtenerVentaDetalleConImagen($rspta->idventa);
        $car->detalles   = $car_data->detalles;
        $data->resultado = 'OK';
        $data->mensaje   = '¡Venta disponible!';
        $data->detalles  = $car;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Venta no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerVentaDetalle($idventa)
// Descripción:
// Obtiene el detalle de una venta
// Notas:
// N/A
function obtenerVentaDetalle($idventa)
{
    $venta = new Venta();
    $data  = new stdClass();
    $rspta = $venta->obtenerVentaDetalle($idventa);
    if ($rspta)
    {
        $arts = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($arts, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Detalle de la venta disponible!';
        $data->detalles  = $arts;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Detalle de la venta no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerVentaDetalleConImagen($idventa)
// Descripción:
// Obtiene el detalle con imagen de una venta
// Notas:
// N/A
function obtenerVentaDetalleConImagen($idventa)
{
    $venta = new Venta();
    $data  = new stdClass();
    $rspta = $venta->obtenerVentaDetalleConImagen($idventa);
    if ($rspta)
    {
        $arts = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($arts, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Detalle de la venta disponible!';
        $data->detalles  = $arts;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Detalle de la venta no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerPDFVenta($idventa)
// Descripción:
// Obtiene el PDF de una venta
// Notas:
// N/A
function obtenerPDFVenta($idventa)
{
    $data = new stdClass();
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPGET, 1);
    curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_GENERATE_PDF);
    curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
    curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
    curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ['saleID' => $idventa]);
    curl_exec($curl);
    if (curl_error($curl))
    {
        $error_msg = curl_error($curl);
    }
    if (!isset($error_msg))
    {
        $venta = new Venta();
        $rspta = $venta->obtenerPDFVenta($idventa);
        $pdf   = new stdClass();
        if ($rspta)
        {
            $pdf->idventa     = $rspta->idventa;
            $pdf->pdf_base_64 = $rspta->pdf_base_64;
            $data->resultado  = 'OK';
            $data->mensaje    = '¡PDF de la venta disponible!';
            $data->detalles   = $pdf;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡PDF de la venta no encontrado, alch!';
            $data->detalles  = null;
        }
        return $data;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $error_msg;
        $data->detalles  = null;
    }
    curl_close($curl);
    return $data;
}

// actualizarDatosDeFacturacion($idusuario, $idventa, $usuario_rfc , $usuario_email, $datos_adicionales, $libro, $nombre_usuario, $usuario_telefono, $calle, $numero_exterior, $numero_interior, $colonia, $delegacion, $ciudad, $pais, $codigo_postal)
// Descripción:
// Actualiza los datos de facturación de una venta
// Notas:
// N/A
function actualizarDatosDeFacturacion($idusuario, $idventa, $usuario_rfc , $usuario_email, $datos_adicionales, $libro, $nombre_usuario, $usuario_telefono, $calle, $numero_exterior, $numero_interior, $colonia, $delegacion, $ciudad, $pais, $codigo_postal)
{
    $factura = new Venta();
    $data    = new stdClass();
    $rspta   = $factura->actualizarDatosDeFacturacion($idusuario, $idventa, $usuario_rfc , $usuario_email, $datos_adicionales, $libro, $nombre_usuario, $usuario_telefono, $calle, $numero_exterior, $numero_interior, $colonia, $delegacion, $ciudad, $pais, $codigo_postal);
    if ($rspta)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_SEND_EMAILS_SALES);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['saleID' => $idventa, 'type' => 'Solicitud Factura']);
        curl_exec($curl);
        if (curl_error($curl))
        {
            $error_msg = curl_error($curl);
        }
        if (!isset($error_msg))
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡Solicitud de factura enviada!';
            $data->detalles  = null;
        }
        else
        {
            $data->resultado = 'ADVERTENCIA';
            $data->mensaje   = '¡Solicitud de factura enviada, pero ocurrió un problema con la notificación!';
            $data->detalles  = null;
        }
        curl_close($curl);
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al guardar la solicitud de factura!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerVentasEscuelaCursoEstatusTodos($idescuela, $idcurso)
// Descripción:
// Obtiene una lista de las ventas realizadas por los alumnos en una escuela y en un curso
// Notas:
// N/A
function obtenerVentasEscuelaCursoEstatusTodos($idescuela, $idcurso)
{
    $venta = new Venta();
    $consignacion = new Consignacion();
    $data  = new stdClass();
    
    $rspta_consignacion = $consignacion->obtenerConsignacionPorIDCurso($idcurso);
    $rspta_todos = $venta->obtenerVentasEscuelaCurso($idescuela, $idcurso);
    $rspta_pendientes = $venta->obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, 0);
    $rspta_pagadas = $venta->obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, 1);
    $rspta_rechazadas = $venta->obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, 2);
    $rspta_expiradas = $venta->obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, 3);
    $rspta_sin_entregar = $venta->obtenerVentasEntregadasEscuelaCursoEstatus($idescuela, $idcurso, 0);
    $rspta_entregadas = $venta->obtenerVentasEntregadasEscuelaCursoEstatus($idescuela, $idcurso, 1);
    
    $rspta_todos_num = mysqli_num_rows($rspta_todos);
    $rspta_pendientes_num = mysqli_num_rows($rspta_pendientes);
    $rspta_pagadas_num = mysqli_num_rows($rspta_pagadas);
    $rspta_rechazadas_num = mysqli_num_rows($rspta_rechazadas);
    $rspta_expiradas_num = mysqli_num_rows($rspta_expiradas);
    $rspta_sin_entregar_num = mysqli_num_rows($rspta_sin_entregar);
    $rspta_entregadas_num = mysqli_num_rows($rspta_entregadas);
    
    if ($rspta_todos)
    {
        $arts = Array();
        while ($reg = $rspta_todos->fetch_object())
        {
            array_push($arts, $reg);
        }
        $cont = new stdClass();
        $cont->total_todos = $rspta_todos_num;
        $cont->total_pendientes = $rspta_pendientes_num;
        $cont->total_pagadas = $rspta_pagadas_num;
        $cont->total_rechazadas = $rspta_rechazadas_num;
        $cont->total_expiradas = $rspta_expiradas_num;
        $cont->total_sin_entregar = $rspta_sin_entregar_num;
        $cont->total_entregadas = $rspta_entregadas_num;
        $cont->consignacion_cantidad_requerida = $rspta_consignacion->cantidad_requerida;
        $cont->compras = $arts;
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de ventas disponible!';
        $data->detalles  = $cont;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de ventas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerEstatusEntregaVentaEscuelaCursoEstatus($idescuela, $idcurso, $idventa)
// Descripción:
// Obtiene una venta de una escuela en un curso
// Notas:
// N/A
function obtenerEstatusEntregaVentaEscuelaCursoEstatus($idescuela, $idcurso, $idventa)
{
    $venta    = new Venta();
    $data     = new stdClass();
    $rspta    = $venta->obtenerEstatusEntregaVentaEscuelaCursoEstatus($idescuela, $idcurso, $idventa);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Datos de la entrega de la venta disponibles!';
        $data->detalles  = $rspta;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos de la entrega de la venta no disponibles!';
        $data->detalles  = null;
    }
    return $data;
}

// establecerEstatusEntregaVentaEntregadaEscuelaCursoEstatus($idescuela, $idcurso, $idventa, $fecha_entrega)
// Descripción:
// Establece el estatus de una venta en ENTREGADO y la fecha de entrega en una escuela y en un curso
// Notas:
// N/A
function establecerEstatusEntregaVentaEntregadaEscuelaCursoEstatus($idescuela, $idcurso, $idventa, $fecha_entrega)
{
    $venta    = new Venta();
    $data     = new stdClass();
    $datos = obtenerEstatusEntregaVentaEscuelaCursoEstatus($idescuela, $idcurso, $idventa);
    if ($datos->resultado == 'OK')
    {
        if ($datos->detalles->estatus_entrega == 0)
        {
            $rspta    = $venta->establecerEstatusEntregaVentaEntregadaEscuelaCursoEstatus($idescuela, $idcurso, $idventa, $fecha_entrega);
            if ($rspta)
            {
                $data->resultado = 'OK';
                $data->mensaje   = '¡Venta marcada como entregada!';
                $data->detalles  = null;
            }
            else
            {
                $data->resultado = 'ERROR';
                $data->mensaje   = '¡Ocurrió un error al marcar la venta como entregada!';
                $data->detalles  = null;
            }
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡El estatus de entrega de la venta no permite marcarla como entregada!';
            $data->detalles  = null;
        }
    }
    return $data;
}

// establecerEstatusEntregaVentaEntregadaEscuelaCursoBatch($idescuela, $idcurso, $lista_venta)
// Descripción:
// Actualiza un batch de ventas en una escuela y en un curso
// Notas:
// El arreglo $lista_venta contiene objetos con un ID de venta y la fecha de entrega
function establecerEstatusEntregaVentaEntregadaEscuelaCursoBatch($idescuela, $idcurso, $lista_venta)
{
    $data     = new stdClass();
    $resultados_actualizados = array();
    $resultados_no_actualizados = array();
    for ($i = 0; $i < count($lista_venta); $i++)
    {
        $idventa_actual = $lista_venta[$i]['idventa'];
        $fecha_entrega_actual = date('Y-m-d');
        $rspta    = establecerEstatusEntregaVentaEntregadaEscuelaCursoEstatus($idescuela, $idcurso, $idventa_actual, $fecha_entrega_actual);
        $res = new stdClass();
        if ($rspta->resultado == 'OK')
        {
            $res->idventa = $idventa_actual;
            $res->fecha_entrega = $fecha_entrega_actual;
            array_push($resultados_actualizados, $res);
        }
        else
        {
            $res->idventa = $idventa_actual;
            $res->fecha_entrega = $fecha_entrega_actual;
            array_push($resultados_no_actualizados, $res);
        }
    }
    $res_todos = new stdClass();
    $res_todos->actualizados = $resultados_actualizados;
    $res_todos->no_actualizados = $resultados_no_actualizados;
    $data->resultado = 'OK';
    $data->mensaje   = '¡Operación finalizada!';
    $data->detalles  = $res_todos;
    return $data;
}

// obtenerVentaParaCambioArticulo($idventa)
// Descripción:
// Obtiene la venta seleccinada para el cambio de articulo
// Notas:
// N/A
function obtenerVentaParaCambioArticulo($idventa)
{
    $venta = new Venta();
    $data   = new stdClass();
    $rspta  = $venta->obtenerVentaParaCambioArticulo($idventa);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Datos de la venta disponibles!';
        $data->detalles  = $rspta;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos de la venta no disponibles!';
        $data->detalles  = null;
    }
    return $data;
}

?>