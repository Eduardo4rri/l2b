<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Escuela.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Distribuidor.php';

// obtenerEscuela($idescuela)
// Descripción:
// Obtiene una escuela
// Notas:
// Devuelve un objeto cuyas propiedades son customizadas con prefijo 'escuela_'
function obtenerEscuela($idescuela)
{
    $escuela = new Escuela();
    $rspta   = $escuela->obtenerEscuela($idescuela);
    $data    = new stdClass();
    $esc     = new stdClass();
    if ($rspta)
    {
        $esc->escuela_idescuela     = $rspta->idescuela;
        $esc->escuela_alias         = $rspta->alias;
        $esc->escuela_nombre        = $rspta->nombre;
        $esc->escuela_campus        = $rspta->campus;
        $esc->escuela_calle         = $rspta->calle;
        $esc->escuela_num_exterior  = $rspta->num_exterior;
        $esc->escuela_num_interior  = $rspta->num_interior;
        $esc->escuela_colonia       = $rspta->colonia;
        $esc->escuela_ciudad        = $rspta->ciudad;
        $esc->escuela_estado        = $rspta->estado;
        $esc->escuela_codigo_postal = $rspta->codigo_postal;
        $data->resultado            = 'OK';
        $data->mensaje              = '¡Datos de la escuela disponibles!';
        $data->detalles             = $esc;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos de la escuela no encontrados!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerEscuelasEnLista($lista_idescuela)
// Descripción:
// Obtiene una lista de escuelas
// Notas:
// El parámetro $lista_idescuela es un arreglo de todas las escuelas a buscar sin propiedades customizadas, para mostrar sólo una escuela, enviar un arreglo con solo una escuela
function obtenerEscuelasEnLista($lista_idescuela)
{
    $escuela = new Escuela();
    $data    = new stdClass();
    $rspta   = $escuela->obtenerEscuelasEnLista($lista_idescuela);
    if ($rspta)
    {
        $escs = Array();
        while ($reg = $rspta->fetch_object())
        {
            $reg->seleccionar = '';
            array_push($escs, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de escuelas disponible!';
        $data->detalles  = $escs;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de escuelas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// asignarDistribuidorAEscuelas($lista_idescuela, $iddistribuidor)
// Descripción:
// Asigna un distribuidor a una lista de escuelas
// Notas:
// El parámetro $lista_idescuela es un arreglo de todas las escuelas a buscar, el distribuidor se asignará a todas esas escuelas
function asignarDistribuidorAEscuelas($lista_idescuela, $iddistribuidor)
{
    $escuela = new Escuela();
    $data    = new stdClass();
    $rspta   = $escuela->asignarDistribuidorAEscuelas($lista_idescuela, $iddistribuidor);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Distribuidor asignado!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Distribuidor no asignado!';
        $data->detalles  = null;
    }
    return $data;
}

// asignarFechasPlacementTestAEscuelas($lista_idescuela, $fecha_placement_test_inicio, $fecha_placement_test_fin)
// Descripción:
// Asigna fechas de placement test a una lista de escuelas
// Notas:
// El parámetro $lista_idescuela es un arreglo de todas las escuelas a buscar, las fechas se asignarán a todas esas escuelas
function asignarFechasPlacementTestAEscuelas($lista_idescuela, $fecha_placement_test_inicio, $fecha_placement_test_fin)
{
    $escuela = new Escuela();
    $data    = new stdClass();
    $rspta   = $escuela->asignarFechasPlacementTestAEscuelas($lista_idescuela, $fecha_placement_test_inicio, $fecha_placement_test_fin);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Fechas de Placement Tests asignadas!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Fechas de Placement Tests no asignadas!';
        $data->detalles  = null;
    }
    return $data;
}

// asignarFechasCursoInicioAEscuelas($lista_idescuela, $fecha_curso_inicio, $fecha_curso_fin)
// Descripción:
// Asigna fechas de inicio de curso a una lista de escuelas
// Notas:
// El parámetro $lista_idescuela es un arreglo de todas las escuelas a buscar, las fechas se asignarán a todas esas escuelas
function asignarFechasCursoInicioAEscuelas($lista_idescuela, $fecha_curso_inicio, $fecha_curso_fin)
{
    $escuela = new Escuela();
    $data    = new stdClass();
    $rspta   = $escuela->asignarFechasCursoInicioAEscuelas($lista_idescuela, $fecha_curso_inicio, $fecha_curso_fin);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Fechas de inicio de curso asignadas!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Fechas de inicio de curso no asignadas!';
        $data->detalles  = null;
    }
    return $data;
}

// asignarFechasEntregaMaterialAEscuelas($lista_idescuela, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin)
// Descripción:
// Asigna fechas de entrega de material a una lista de escuelas
// Notas:
// El parámetro $lista_idescuela es un arreglo de todas las escuelas a buscar, las fechas se asignarán a todas esas escuelas
function asignarFechasEntregaMaterialAEscuelas($lista_idescuela, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin)
{
    $escuela = new Escuela();
    $data    = new stdClass();
    $rspta   = $escuela->asignarFechasEntregaMaterialAEscuelas($lista_idescuela, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Fechas de entrega de material asignadas!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Fechas de entrega de material no asignadas!';
        $data->detalles  = null;
    }
    return $data;
}

?>