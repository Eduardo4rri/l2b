<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Venta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Curso.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Tienda.php';

// cambiarArticuloEnVentaAlumno($idventa, $idarticulo)
// Descripción:
// Cambia el articulo en una venta
// Notas:
// N/A
function cambiarArticuloEnVentaAlumno($idventa, $idprograma, $idarticulo)
{
    $data     = new stdClass();
    
    // ¿Existe la venta?
    $venta    = new Venta();
    $rspta_venta    = $venta->obtenerVenta($idventa);
    if (!$rspta_venta)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Venta no encontrada!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La venta es de tipo alumno?
    if ($rspta_venta->tipo_rol != 'alumno')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La venta no es de tipo alumno!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La venta tiene sólo un artículo?
    if ($rspta_venta->total_articulos != 1)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La venta tiene sólo un artículo!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿Existe el curso de la venta?
    $venta_idcurso = $rspta_venta->idcurso;
    $curso = new Curso();
    $rspta_curso    = $curso->obtenerCurso($venta_idcurso);
    if (!$rspta_curso)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Curso de la venta no encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El curso permite el cambio de artículo?
    if ($rspta_curso->fecha_cambio_articulo_activo != 1)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El curso de la venta no permite el cambio del artículo!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El programa del artículo anterior es el mismo que el del programa del artículo nuevo?
    $articulo_anterior_idprograma = $rspta_venta->idprograma;
    if ($articulo_anterior_idprograma != $idprograma)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El programa del artículo anterior no es el mismo que el del artículo nuevo!';
        $data->detalles  = null;
        return $data;
    }
    
    // Obtener el artículo anterior
    $articulo_anterior_idarticulo = $rspta_venta->detalles[0]->idarticulo;
    $tienda_articulo_anterior = new Tienda();
    $rspta_tienda_articulo_anterior    = $tienda_articulo_anterior->obtenerArticuloEnPrograma($articulo_anterior_idarticulo, $articulo_anterior_idprograma);
    if (!$rspta_tienda_articulo_anterior)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Artículo anterior no encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // Obtener el artículo anterior
    $tienda_articulo_nuevo = new Tienda();
    $rspta_tienda_articulo_nuevo    = $tienda_articulo_nuevo->obtenerArticuloEnPrograma($idarticulo, $idprograma);
    if (!$rspta_tienda_articulo_nuevo)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Artículo nuevo no encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El nuevo articulo es del mismo programa y del mismo precio?
    
}

?>