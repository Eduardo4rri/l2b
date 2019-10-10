<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Distribuidor.php';

// obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, $pago_estatus)
// Descripción:
// Obtiene una lista de los pedidos del distribuidor
// Notas:
// N/A
function obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, $pago_estatus)
{
    $distribuidor = new Distribuidor();
    $data  = new stdClass();
    $rspta = $distribuidor->obtenerVentasEscuelaCursoEstatus($idescuela, $idcurso, $pago_estatus);
    if ($rspta)
    {
        $pedidos = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($pedidos, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de pedidos disponible!';
        $data->detalles  = $pedidos;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de pedidos no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// actualizarEntregadoOnLine($idventa)
// Descripción:
// Asignar estatus de entregado
// Notas:
// El parámetro $idventa es un arreglo de todos los pedidos, donde se modificara es estatus de entrega
function actualizarEntregadoOnLine($idventa)
{
    $distribuidor = new Distribuidor();
    $data    = new stdClass();
    $rspta   = $distribuidor->actualizarEntregadoOnLine($idventa);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Datos de entrega actualizados!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡No se actualizaron los datos de entrega!';
        $data->detalles  = null;
    }
    return $data;
}

?>