<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Venta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Curso.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Tienda.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Carrito.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Pago.php';

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

    // ¿Existen los detalles de la venta?
    $rspta_venta_detalles    = $venta->obtenerVentaDetalle($idventa);
    if (!$rspta_venta_detalles)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Detalles de la venta no encontrados!';
        $data->detalles  = null;
        return $data;
    }
    else
    {
        if ($rspta_venta_detalles)
        {
            $arts = Array();
            while ($reg = $rspta_venta_detalles->fetch_object())
            {
                array_push($arts, $reg);
            }
            $rspta_venta->detalles  = $arts;
        }
    }

    // ¿La venta es de tipo alumno?
    if ($rspta_venta->tipo_rol !== 'alumno')
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
        $data->mensaje   = '¡La venta no tiene sólo un artículo!';
        $data->detalles  = null;
        return $data;
    }

    // ¿Existe el carrito de la venta?
    $venta_idcarrito = $rspta_venta->idcarrito;
    $carrito = new Carrito();
    $rspta_carrito    = $carrito->obtenerCarrito($venta_idcarrito);
    if (!$rspta_carrito)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Carrito de la venta no encontrado!';
        $data->detalles  = null;
        return $data;
    }

    // ¿Existen los detalles del carrito?
    $rspta_carrito_detalles    = $carrito->obtenerCarritoDetalle($venta_idcarrito);
    if (!$rspta_carrito_detalles)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Detalles del carrito no encontrados!';
        $data->detalles  = null;
        return $data;
    }
    else
    {
        if ($rspta_carrito_detalles)
        {
            $arts = Array();
            while ($reg = $rspta_carrito_detalles->fetch_object())
            {
                array_push($arts, $reg);
            }
            $rspta_carrito->detalles  = $arts;
        }
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
    
    // Obtener el artículo nuevo
    $tienda_articulo_nuevo = new Tienda();
    $rspta_tienda_articulo_nuevo    = $tienda_articulo_nuevo->obtenerArticuloEnPrograma($idarticulo, $idprograma);
    if (!$rspta_tienda_articulo_nuevo)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Artículo nuevo no encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El articulo anterior y el artículo nuevo son del mismo programa?
    $rspta_tienda_articulo_anterior_idprograma = $rspta_tienda_articulo_anterior->idprograma;
    $rspta_tienda_articulo_nuevo_idprograma = $rspta_tienda_articulo_nuevo->idprograma;
    if ($rspta_tienda_articulo_anterior_idprograma != $rspta_tienda_articulo_nuevo_idprograma)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El programa del artículo anterior y el artículo nuevo no son iguales!';
        $data->detalles  = null;
        return $data;
    }

    // ¿El articulo anterior y el artículo nuevo son del mismo precio?
    $rspta_tienda_articulo_anterior_precio = $rspta_tienda_articulo_anterior->precio_descuento;
    $rspta_tienda_articulo_nuevo_precio = $rspta_tienda_articulo_nuevo->precio_descuento;
    if ($rspta_tienda_articulo_anterior_precio != $rspta_tienda_articulo_nuevo_precio)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El precio del artículo anterior y el artículo nuevo no son iguales!';
        $data->detalles  = null;
        return $data;
    }

    // Actualizar el detalle del carrito
    $venta_idcarrito_detalle = $rspta_carrito->detalles[0]->idcarrito_detalle;
    $carrito_act    = new Carrito();
    $rspta_tienda_carrito_idarticulo = $rspta_tienda_articulo_nuevo->idarticulo;
    $rspta_tienda_carrito_isbn = $rspta_tienda_articulo_nuevo->isbn;
    $rspta_tienda_carrito_nombre = $rspta_tienda_articulo_nuevo->nombre;
    $rspta_tienda_carrito_descripcion = $rspta_tienda_articulo_nuevo->descripcion;
    $rspta_tienda_carrito_serie = $rspta_tienda_articulo_nuevo->serie;
    $rspta_tienda_carrito_nivel = $rspta_tienda_articulo_nuevo->nivel;
    $rspta_carrito_act    = $carrito_act->actualizarCarritoDetalle($venta_idcarrito_detalle, $rspta_tienda_carrito_idarticulo, $rspta_tienda_carrito_isbn, $rspta_tienda_carrito_nombre, $rspta_tienda_carrito_descripcion, $rspta_tienda_carrito_serie, $rspta_tienda_carrito_nivel);

    if (!$rspta_carrito_act)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al actualizar el registro del carrito!';
        $data->detalles  = null;
        return $data;
    }

    // Actualizar la venta
    $venta_act    = new Venta();
    $rspta_venta_articulo_nuevo_concepto = $rspta_tienda_articulo_nuevo->nombre;
    $rspta_venta_act    = $venta_act->actualizarVentaConcepto($idventa, $rspta_venta_articulo_nuevo_concepto);

    if (!$rspta_venta_act)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al actualizar el registro de venta!';
        $data->detalles  = null;
        return $data;
    }

    // Actualizar el detalle de la venta
    $venta_idventa_detalle = $rspta_venta->detalles[0]->idventa_detalle;
    $venta_act_detalle    = new Venta();
    $rspta_tienda_venta_idarticulo = $rspta_tienda_articulo_nuevo->idarticulo;
    $rspta_tienda_venta_nombre = $rspta_tienda_articulo_nuevo->nombre;
    $rspta_tienda_venta_descripcion = $rspta_tienda_articulo_nuevo->descripcion;
    $rspta_tienda_venta_nivel = $rspta_tienda_articulo_nuevo->nivel;
    $rspta_venta_act_detalle    = $venta_act_detalle->actualizarVentaDetalle($venta_idventa_detalle, $rspta_tienda_venta_idarticulo, $rspta_tienda_venta_nombre, $rspta_tienda_venta_descripcion, $rspta_tienda_venta_nivel);

    if (!$rspta_venta_act_detalle)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al actualizar el registro del detalle de la venta!';
        $data->detalles  = null;
        return $data;
    }

    // Actualizar el pago
    $venta_idpago = $rspta_venta->idpago;
    $pago_act    = new Pago();
    $rspta_tienda_articulo_nuevo_concepto = $rspta_tienda_articulo_nuevo->nombre;
    $rspta_pago_act    = $pago_act->actualizarPagoConcepto($venta_idpago, $rspta_tienda_articulo_nuevo_concepto);

    if (!$rspta_pago_act)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Error al actualizar el registro de pago!';
        $data->detalles  = null;
        return $data;
    }

    $data->resultado = 'OK';
    $data->mensaje   = '¡Libro actualizado!';
    $data->detalles  = null;
    return $data;

}

?>