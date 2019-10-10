<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Programa.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/cuenta.php';

// listarProgramaCursosDominio($iddominio)
// Descripción:
// Obtiene una lista de los cursos de un programa en un dominio
// Notas:
// N/A
function listarProgramaCursosDominio($iddominio)
{
    $programa = new Programa();
    $data   = new stdClass();
    $rspta  = $programa->listarProgramaCursosDominio($iddominio);
    if ($rspta)
    {
        $cursos = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($cursos, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de cursos en programa en dominio disponible!';
        $data->detalles  = $cursos;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de cursos en programa en dominio no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// listarProgramaCursosEscuela($idescuela)
// Descripción:
// Obtiene una lista de los cursos de un programa en una escuela
// Notas:
// N/A
function listarProgramaCursosEscuela($idescuela)
{
    $programa = new Programa();
    $data   = new stdClass();
    $rspta  = $programa->listarProgramaCursosEscuela($idescuela);
    if ($rspta)
    {
        $cursos = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($cursos, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de cursos en programa en escuela disponible!';
        $data->detalles  = $cursos;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de cursos en programa en escuela no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// listarProgramaCursosEscuelaConTotales($idescuela)
// Descripción:
// Obtiene una lista de los cursos de un programa en una escuela con sus totales
// Notas:
// N/A
function listarProgramaCursosEscuelaConTotales($idescuela)
{
    $programa = new Programa();
    $data   = new stdClass();
    $rspta  = $programa->listarProgramaCursosEscuela($idescuela);
    if ($rspta)
    {
        $cursos = Array();
        while ($reg = $rspta->fetch_object())
        {
            $reg->ventas = listarVentasDeCoordinadorPorEscuelaYCurso($idescuela, $reg->idcurso);
            array_push($cursos, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de cursos en programa en escuela disponible!';
        $data->detalles  = $cursos;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de cursos en programa en escuela no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

?>