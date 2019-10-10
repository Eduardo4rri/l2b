<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Tienda.php';

// listarEscuelasPorAliasNombre($alias, $nombre, $dominio)
// Descripción:
// Obtiene una lista de escuelas filtradas por alias o por nombre en un dominio
// Notas:
// Se usa para la selección de escuela en el paso de registro de la tienda
function listarEscuelasPorAliasNombre($alias, $nombre, $dominio)
{
    $tienda = new Tienda();
    $data   = new stdClass();
    $rspta  = $tienda->listarEscuelasPorAliasNombre($alias, $nombre, $dominio);
    if ($rspta)
    {
        $escs = Array();
        while ($reg = $rspta->fetch_object())
        {
            $entry                = new stdClass();
            $entry->idescuela     = $reg->idescuela;
            $entry->alias         = $reg->alias;
            $entry->nombre        = $reg->nombre;
            $entry->campus        = $reg->campus;
            $entry->ciudad        = $reg->ciudad;
            $entry->estado        = $reg->estado;
            $entry->codigo_postal = $reg->codigo_postal;
            array_push($escs, $entry);
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

// listarEscuelasPorDireccion($estado, $ciudad, $codigo_postal, $dominio)
// Descripción:
// Obtiene una lista de escuelas filtradas por estado, ciudad o código postal en un dominio
// Notas:
// Se usa para la selección de escuela en el paso de registro de la tienda
function listarEscuelasPorDireccion($estado, $ciudad, $codigo_postal, $dominio)
{
    $tienda = new Tienda();
    $data   = new stdClass();
    $rspta  = $tienda->listarEscuelasPorDireccion($estado, $ciudad, $codigo_postal, $dominio);
    if ($rspta)
    {
        $escs = Array();
        while ($reg = $rspta->fetch_object())
        {
            $entry                = new stdClass();
            $entry->idescuela     = $reg->idescuela;
            $entry->alias         = $reg->alias;
            $entry->nombre        = $reg->nombre;
            $entry->campus        = $reg->campus;
            $entry->ciudad        = $reg->ciudad;
            $entry->estado        = $reg->estado;
            $entry->codigo_postal = $reg->codigo_postal;
            array_push($escs, $entry);
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

// listarProgramasPorEscuela($idescuela)
// Descripción:
// Obtiene una lista de los programas de una escuela
// Notas:
// Se usa para la selección de escuela en el paso de registro de la tienda
function listarProgramasPorEscuela($idescuela)
{
    $tienda = new Tienda();
    $data   = new stdClass();
    $rspta  = $tienda->listarProgramasPorEscuela($idescuela);
    if ($rspta)
    {
        $progs = Array();
        while ($reg = $rspta->fetch_object())
        {
            $entry                       = new stdClass();
            $entry->idprograma           = $reg->idprograma;
            $entry->idescuela            = $reg->idescuela;
            $entry->alias                = $reg->alias;
            $entry->nombre               = $reg->nombre;
            $entry->nivel                = $reg->nivel;
            $entry->descripcion          = $reg->descripcion;
            $entry->idcurso              = $reg->idcurso;
            $entry->curso                = $reg->curso;
            $entry->idconsignacion       = $reg->idconsignacion;
            $entry->consignacion         = $reg->consignacion;
            array_push($progs, $entry);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de programas disponible!';
        $data->detalles  = $progs;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de programas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// listarNivelesPorPrograma($idprograma)
// Descripción:
// Obtiene una lista de los niveles de un programa
// Notas:
// Se usa para la selección de programa en el paso de registro de la tienda
function listarNivelesPorPrograma($idprograma)
{
    $tienda = new Tienda();
    $data   = new stdClass();
    $rspta  = $tienda->listarNivelesPorPrograma($idprograma);
    if ($rspta)
    {
        $nivs = Array();
        while ($reg_nivel = $rspta->fetch_object())
        {
            $entry_nivel        = new stdClass();
            $entry_nivel->nivel = $reg_nivel->nivel;
            $rspta_articulos    = $tienda->listarArticulosPorProgramaYNivel($idprograma, $entry_nivel->nivel);
            $data_articulos     = Array();
            if ($rspta_articulos)
            {
                while ($reg_articulo = $rspta_articulos->fetch_object())
                {
                    $entry_articulo                       = new stdClass();
                    $entry_articulo->idarticulo           = $reg_articulo->idarticulo;
                    $entry_articulo->isbn                 = $reg_articulo->isbn;
                    $entry_articulo->nombre               = $reg_articulo->nombre;
                    $entry_articulo->descripcion          = $reg_articulo->descripcion;
                    $entry_articulo->serie                = $reg_articulo->serie;
                    $entry_articulo->nivel                = $reg_articulo->nivel;
                    $entry_articulo->imagen               = $reg_articulo->imagen;
                    $entry_articulo->componentes          = $reg_articulo->componentes;
                    $entry_articulo->precio               = $reg_articulo->precio;
                    $entry_articulo->precio_descuento     = $reg_articulo->precio_descuento;
                    $entry_articulo->descuento_porcentaje = $reg_articulo->descuento_porcentaje;
                    $entry_articulo->descuento_valor      = $reg_articulo->descuento_valor;
                    array_push($data_articulos, $entry_articulo);
                }
            }
            $entry_nivel->articulos = $data_articulos;
            array_push($nivs, $entry_nivel);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de niveles disponible!';
        $data->detalles  = $nivs;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de niveles no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// listarNivelesPorProgramaSinImagen($idprograma)
// Descripción:
// Obtiene una lista de los niveles de un programa sin imágenes
// Notas:
// Se usa para la selección de programa en el paso de registro de la tienda
function listarNivelesPorProgramaSinImagen($idprograma)
{
    $tienda = new Tienda();
    $data   = new stdClass();
    $rspta  = $tienda->listarNivelesPorPrograma($idprograma);
    if ($rspta)
    {
        $nivs = Array();
        while ($reg_nivel = $rspta->fetch_object())
        {
            $entry_nivel        = new stdClass();
            $entry_nivel->nivel = $reg_nivel->nivel;
            $rspta_articulos    = $tienda->listarArticulosPorProgramaYNivelSinImagen($idprograma, $entry_nivel->nivel);
            $data_articulos     = Array();
            if ($rspta_articulos)
            {
                while ($reg_articulo = $rspta_articulos->fetch_object())
                {
                    $entry_articulo                       = new stdClass();
                    $entry_articulo->idarticulo           = $reg_articulo->idarticulo;
                    $entry_articulo->isbn                 = $reg_articulo->isbn;
                    $entry_articulo->nombre               = $reg_articulo->nombre;
                    $entry_articulo->descripcion          = $reg_articulo->descripcion;
                    $entry_articulo->serie                = $reg_articulo->serie;
                    $entry_articulo->nivel                = $reg_articulo->nivel;
                    $entry_articulo->componentes          = $reg_articulo->componentes;
                    $entry_articulo->precio               = $reg_articulo->precio;
                    $entry_articulo->precio_descuento     = $reg_articulo->precio_descuento;
                    $entry_articulo->descuento_porcentaje = $reg_articulo->descuento_porcentaje;
                    $entry_articulo->descuento_valor      = $reg_articulo->descuento_valor;
                    array_push($data_articulos, $entry_articulo);
                }
            }
            $entry_nivel->articulos = $data_articulos;
            array_push($nivs, $entry_nivel);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de niveles disponible!';
        $data->detalles  = $nivs;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de niveles no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerArticuloEnPrograma($idarticulo, $idprograma)
// Descripción:
// Obtiene un objeto con los detalles de un artículo en un programa
// Notas:
// Se usa para la selección de programa en el paso de registro de la tienda
function obtenerArticuloEnPrograma($idarticulo, $idprograma)
{
    $tienda = new Tienda();
    $data   = new stdClass();
    $rspta  = $tienda->obtenerArticuloEnPrograma($idarticulo, $idprograma);
    if ($rspta)
    {
        $entry                       = new stdClass();
        $entry->idarticulo           = $rspta->idarticulo;
        $entry->isbn                 = $rspta->isbn;
        $entry->nombre               = $rspta->nombre;
        $entry->descripcion          = $rspta->descripcion;
        $entry->serie                = $rspta->serie;
        $entry->nivel                = $rspta->nivel;
        $entry->imagen               = $rspta->imagen;
        $entry->componentes          = $rspta->componentes;
        $entry->precio               = $rspta->precio;
        $entry->precio_descuento     = $rspta->precio_descuento;
        $entry->descuento_porcentaje = $rspta->descuento_porcentaje;
        $entry->descuento_valor      = $rspta->descuento_valor;
        $data->resultado             = 'OK';
        $data->mensaje               = '¡Artículo disponible!';
        $data->detalles              = $entry;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Artículo no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

?>