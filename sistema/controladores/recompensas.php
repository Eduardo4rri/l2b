<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Recompensas.php';

// obtenerRecompensasLibro()
// Descripción:
// Obtiene una lista de las recompensas que son libros
// Notas:
// N/A
function obtenerRecompensasLibro()
{
    $recompensas = new Recompensas();
    $data        = new stdClass();
    $rspta       = $recompensas->obtenerRecompensasLibro();
    if ($rspta)
    {
        $escs = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($escs, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de pedidos disponible!';
        $data->detalles  = $escs;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de pedidos no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerRecompensasCurso()
// Descripción:
// Obtiene una lista de las recompensas que son cursos
// Notas:
// N/A
function obtenerRecompensasCurso()
{
    $recompensas = new Recompensas();
    $data        = new stdClass();
    $rspta       = $recompensas->obtenerRecompensasCurso();
    if ($rspta)
    {
        $escs = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($escs, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de pedidos disponible!';
        $data->detalles  = $escs;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de pedidos no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerRecompensasMaterial()
// Descripción:
// Obtiene una lista de las recompensas que son materiales
// Notas:
// N/A
function obtenerRecompensasMaterial()
{
    $recompensas = new Recompensas();
    $data        = new stdClass();
    $rspta       = $recompensas->obtenerRecompensasMaterial();
    if ($rspta)
    {
        $escs = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($escs, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de pedidos disponible!';
        $data->detalles  = $escs;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de pedidos no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

?>