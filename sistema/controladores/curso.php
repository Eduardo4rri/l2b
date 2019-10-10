<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Curso.php';

// listarCursosPorPrograma($idprograma)
// Descripción:
// Lista los cursos de un programa
// Notas:
// N/A
function listarCursosPorPrograma($idprograma)
{
    $curso = new Curso();
    $data  = new stdClass();
    $rspta = $curso->listarCursosPorPrograma($idprograma);
    if ($rspta)
    {
        $cursos = Array();
        while ($reg = $rspta->fetch_object())
        {
            $reg->seleccionar = '';
            array_push($cursos, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de cursos disponible!';
        $data->detalles  = $cursos;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de cursos no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// crearNuevoCurso($idprograma, $nombre)
// Descripción:
// Crea un curso en un programa
// Notas:
// N/A
function crearNuevoCurso($idprograma, $nombre)
{
    $curso = new Curso();
    $data  = new stdClass();
    $rspta = $curso->crearNuevoCurso($idprograma, $nombre);
    if ($rspta > 0)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Curso creado!';
        $data->detalles  = $rspta;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al crear el curso!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerCurso($idcurso)
// Descripción:
// Obtiene un curso
// Notas:
// N/A
function obtenerCurso($idcurso)
{
    $curso              = new Curso();
    $data               = new stdClass();
    $curso_seleccioando = new stdClass();
    $rspta              = $curso->obtenerCurso($idcurso);
    if ($rspta)
    {
        $curso_seleccioando->idcurso                             = $rspta->idcurso;
        $curso_seleccioando->idprograma                          = $rspta->idprograma;
        $curso_seleccioando->nombre                              = $rspta->nombre;
        $curso_seleccioando->fecha_limite_configuracion          = $rspta->fecha_limite_configuracion;
        $curso_seleccioando->fecha_periodo_venta_inicio          = $rspta->fecha_periodo_venta_inicio;
        $curso_seleccioando->fecha_periodo_venta_fin             = $rspta->fecha_periodo_venta_fin;
        $curso_seleccioando->fecha_periodo_venta_guardado        = $rspta->fecha_periodo_venta_guardado;
        $curso_seleccioando->fecha_periodo_venta_confirmado      = $rspta->fecha_periodo_venta_confirmado;
        $curso_seleccioando->fecha_placement_test_inicio         = $rspta->fecha_placement_test_inicio;
        $curso_seleccioando->fecha_placement_test_fin            = $rspta->fecha_placement_test_fin;
        $curso_seleccioando->fecha_placement_test_guardado       = $rspta->fecha_placement_test_guardado;
        $curso_seleccioando->fecha_placement_test_confirmado     = $rspta->fecha_placement_test_confirmado;
        $curso_seleccioando->fecha_curso_inicio                  = $rspta->fecha_curso_inicio;
        $curso_seleccioando->fecha_curso_fin                     = $rspta->fecha_curso_fin;
        $curso_seleccioando->fecha_curso_guardado                = $rspta->fecha_curso_guardado;
        $curso_seleccioando->fecha_curso_confirmado              = $rspta->fecha_curso_confirmado;
        $curso_seleccioando->fecha_entrega_venta_en_linea_inicio = $rspta->fecha_entrega_venta_en_linea_inicio;
        $curso_seleccioando->fecha_entrega_venta_en_linea_fin    = $rspta->fecha_entrega_venta_en_linea_fin;
        $curso_seleccioando->fecha_entrega_venta_directa_inicio  = $rspta->fecha_entrega_venta_directa_inicio;
        $curso_seleccioando->fecha_entrega_venta_directa_fin     = $rspta->fecha_entrega_venta_directa_fin;
        $curso_seleccioando->fecha_entrega_material_guardado     = $rspta->fecha_entrega_material_guardado;
        $curso_seleccioando->fecha_entrega_material_confirmado   = $rspta->fecha_entrega_material_confirmado;
        $curso_seleccioando->precio_guardado                     = $rspta->precio_guardado;
        $curso_seleccioando->precio_confirmado                   = $rspta->precio_confirmado;
        $data->resultado                                         = 'OK';
        $data->mensaje                                           = '¡Datos del curso disponibles!';
        $data->detalles                                          = $curso_seleccioando;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos del curso no disponibles!';
        $data->detalles  = null;
    }
    return $data;
}

// guardarFechaPeriodoVenta($idcurso, $fecha_periodo_venta_inicio, $fecha_periodo_venta_fin)
// Descripción:
// Guarda las fechas de periodo de venta
// Notas:
// N/A
function guardarFechaPeriodoVenta($idcurso, $fecha_periodo_venta_inicio, $fecha_periodo_venta_fin)
{
    $curso = new Curso();
    $data  = new stdClass();
    $rspta = $curso->guardarFechaPeriodoVenta($idcurso, $fecha_periodo_venta_inicio, $fecha_periodo_venta_fin);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Fechas del período de venta guardadas!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al guardar las fechas del período de venta!';
        $data->detalles  = null;
    }
    return $data;
}

// guardarFechaPlacementTest($idcurso, $fecha_placement_test_inicio, $fecha_placement_test_fin)
// Descripción:
// Guarda las fechas de placement test
// Notas:
// N/A
function guardarFechaPlacementTest($idcurso, $fecha_placement_test_inicio, $fecha_placement_test_fin)
{
    $curso = new Curso();
    $data  = new stdClass();
    $rspta = $curso->guardarFechaPlacementTest($idcurso, $fecha_placement_test_inicio, $fecha_placement_test_fin);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Fechas de placement test guardadas!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al guardar las fechas de placement test!';
        $data->detalles  = null;
    }
    return $data;
}

// guardarFechaEntregaMaterial($idcurso, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin, $fecha_entrega_venta_directa_inicio, $fecha_entrega_venta_directa_fin)
// Descripción:
// Guarda las fechas del periodo de entrega en linea y del periodo de entrega directa
// Notas:
// N/A
function guardarFechaEntregaMaterial($idcurso, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin, $fecha_entrega_venta_directa_inicio, $fecha_entrega_venta_directa_fin)
{
    $curso = new Curso();
    $data  = new stdClass();
    $rspta = $curso->guardarFechaEntregaMaterial($idcurso, $fecha_entrega_venta_en_linea_inicio, $fecha_entrega_venta_en_linea_fin, $fecha_entrega_venta_directa_inicio, $fecha_entrega_venta_directa_fin);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Fechas de entrega de material guardadas!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al guardar las fechas de entrega de material!';
        $data->detalles  = null;
    }
    return $data;
}

// guardarFechaCurso($idcurso, $fecha_curso_inicio, $fecha_curso_fin)
// Descripción:
// Guarda las fechas de inicio y fin
// Notas:
// N/A
function guardarFechaCurso($idcurso, $fecha_curso_inicio, $fecha_curso_fin)
{
    $curso = new Curso();
    $data  = new stdClass();
    $rspta = $curso->guardarFechaCurso($idcurso, $fecha_curso_inicio, $fecha_curso_fin);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Fechas de cursos guardados!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al guardar las fechas de cursos!';
        $data->detalles  = null;
    }
    return $data;
}

// actualizarNombreCurso($idcurso, $nombre)
// Descripción:
// Actualiza el nombre de un curso
// Notas:
// N/A
function actualizarNombreCurso($idcurso, $nombre)
{
    $curso = new Curso();
    $data  = new stdClass();
    $rspta = $curso->actualizarNombreCurso($idcurso, $nombre);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Se actualizo el nombre del curso!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al actualizar nombre del cursos!';
        $data->detalles  = null;
    }
    return $data;
}

?>