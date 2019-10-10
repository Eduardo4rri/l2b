<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Carrito.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Dominio.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Escuela.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Programa.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Distribuidor.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Venta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Tienda.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Pago.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Consignacion.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/pagos/conekta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/pagos/consignacion.php';

// obtenerCarritoDeUsuario($idusuario)
// Descripción:
// Obtiene un carrito por ID de usuario
// Notas:
// Si el usuario no tiene un carrito, se creará uno nuevo y le será asignado con las propiedades y permisos definidos por el rol del usuario
function obtenerCarritoDeUsuario($idusuario)
{
    $conekta  = conekta_obtenerDatosCONEKTA();
    $usuario  = new Usuario();
    $carrito  = new Carrito();
    $data     = new stdClass();
    $car      = new stdClass();
    $car_data = new stdClass();
    $usuario_car  = $usuario->obtenerUsuario($idusuario);
    if ($usuario_car)
    {
        $carrito_activo = $carrito->obtenerCarritoActivoDeUsuario($idusuario);
        if ($carrito_activo)
        {
            $estatus_carrito = $carrito_activo->estatus;
            if ($estatus_carrito == 1)
            {
                $car->idcarrito       = $carrito_activo->idcarrito;
                $car->idusuario       = $carrito_activo->idusuario;
                $car->tipo            = $carrito_activo->tipo;
                $car->max_1_articulo  = $carrito_activo->max_1_articulo;
                $car->total_articulos = $carrito_activo->total_articulos;
                $car->subtotal_precio     = $carrito_activo->subtotal_precio;
                $car->descuento_precio    = $carrito_activo->descuento_precio;
                $car->impuesto_precio     = $carrito_activo->impuesto_precio;
                $car->total_envio    = $carrito_activo->total_envio;
                $car->total_precio    = $carrito_activo->total_precio;
                $car->estatus         = $carrito_activo->estatus;
                $car_data             = obtenerCarritoDetalle($carrito_activo->idcarrito);
                $car->detalles        = $car_data->detalles;
                $car->conekta         = $conekta;
                $data->resultado      = 'OK';
                $data->mensaje        = '¡Carrito del usuario disponible!';
                $data->detalles       = $car;
            }
            else if ($estatus_carrito == 0)
            {
                $rol              = $usuario_car->rol;
                $carrito_nuevo_id = 0;
                if ($rol == 'alumno')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoAlumno($idusuario);
                }
                else if ($rol == 'coordinador_dominio')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoCoordinadorDominio($idusuario);
                }
                else if ($rol == 'coordinador_zona')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoCoordinadorZona($idusuario);
                }
                else if ($rol == 'coordinador_subzona')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoCoordinadorSubzona($idusuario);
                }
                else if ($rol == 'coordinador_escuela')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoCoordinadorEscuela($idusuario);
                }
                if ($carrito_nuevo_id > 0)
                {
                    $carrito_activo = $carrito->obtenerCarrito($carrito_nuevo_id);
                    if ($carrito_activo)
                    {
                        $car->idcarrito       = $carrito_activo->idcarrito;
                        $car->idusuario       = $carrito_activo->idusuario;
                        $car->tipo            = $carrito_activo->tipo;
                        $car->max_1_articulo  = $carrito_activo->max_1_articulo;
                        $car->total_articulos = $carrito_activo->total_articulos;
                        $car->subtotal_precio     = $carrito_activo->subtotal_precio;
                        $car->descuento_precio    = $carrito_activo->descuento_precio;
                        $car->impuesto_precio     = $carrito_activo->impuesto_precio;
                        $car->total_envio    = $carrito_activo->total_envio;
                        $car->total_precio    = $carrito_activo->total_precio;
                        $car->estatus         = $carrito_activo->estatus;
                        $car_data             = obtenerCarritoDetalle($carrito_activo->idcarrito);
                        $car->detalles        = $car_data->detalles;
                        $car->conekta         = $conekta;
                        $data->resultado      = 'OK';
                        $data->mensaje        = '¡Carrito del usuario creado (carrito activo anterior cerrado)!';
                        $data->detalles       = $car;
                    }
                }
                else
                {
                    $data->resultado = 'ERROR';
                    $data->mensaje   = '¡Problema al crear el carrito del usuario (carrito activo anterior cerrado)!';
                    $data->detalles  = null;
                }
            }
        }
        else
        {
            $rol              = $usuario_car->rol;
            $carrito_nuevo_id = 0;
            if ($rol == 'alumno')
            {
                $carrito_nuevo_id = $carrito->crearCarritoAlumno($idusuario);
            }
            else if ($rol == 'coordinador_dominio')
            {
                $carrito_nuevo_id = $carrito->crearCarritoCoordinadorDominio($idusuario);
            }
            else if ($rol == 'coordinador_zona')
            {
                $carrito_nuevo_id = $carrito->crearCarritoCoordinadorZona($idusuario);
            }
            else if ($rol == 'coordinador_subzona')
            {
                $carrito_nuevo_id = $carrito->crearCarritoCoordinadorSubzona($idusuario);
            }
            else if ($rol == 'coordinador_escuela')
            {
                $carrito_nuevo_id = $carrito->crearCarritoCoordinadorEscuela($idusuario);
            }
            if ($carrito_nuevo_id > 0)
            {
                $carrito_activo = $carrito->obtenerCarrito($carrito_nuevo_id);
                if ($carrito_activo)
                {
                    $car->idcarrito       = $carrito_activo->idcarrito;
                    $car->idusuario       = $carrito_activo->idusuario;
                    $car->tipo            = $carrito_activo->tipo;
                    $car->max_1_articulo  = $carrito_activo->max_1_articulo;
                    $car->total_articulos = $carrito_activo->total_articulos;
                    $car->subtotal_precio     = $carrito_activo->subtotal_precio;
                    $car->descuento_precio    = $carrito_activo->descuento_precio;
                    $car->impuesto_precio     = $carrito_activo->impuesto_precio;
                    $car->total_envio    = $carrito_activo->total_envio;
                    $car->total_precio    = $carrito_activo->total_precio;
                    $car->estatus         = $carrito_activo->estatus;
                    $car_data             = obtenerCarritoDetalle($carrito_activo->idcarrito);
                    $car->detalles        = $car_data->detalles;
                    $car->conekta         = $conekta;
                    $data->resultado      = 'OK';
                    $data->mensaje        = '¡Carrito del usuario creado (carrito activo nuevo creado)!';
                    $data->detalles       = $car;
                }
            }
            else
            {
                $data->resultado = 'ERROR';
                $data->mensaje   = '¡Problema al crear el carrito del usuario (carrito activo nuevo)!';
                $data->detalles  = null;
            }
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos del usuario no disponibles!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerCarrito($idcarrito)
// Descripción:
// Obtiene un carrito por ID de carrito
// Notas:
// Si el usuario no tiene un carrito, se creará uno nuevo y le será asignado con las propiedades y permisos definidos por el rol del usuario
function obtenerCarrito($idcarrito)
{
    $conekta = conekta_obtenerDatosCONEKTA();
    $carrito  = new Carrito();
    $data     = new stdClass();
    $car      = new stdClass();
    $car_data = new stdClass();
    $rspta    = $carrito->obtenerCarrito($idcarrito);
    if ($rspta)
    {
        $car->idcarrito       = $rspta->idcarrito;
        $car->idventa         = $rspta->idventa;
        $car->idusuario       = $rspta->idusuario;
        $car->tipo            = $rspta->tipo;
        $car->max_1_articulo  = $rspta->max_1_articulo;
        $car->total_articulos = $rspta->total_articulos;
        $car->subtotal_precio     = $rspta->subtotal_precio;
        $car->descuento_precio    = $rspta->descuento_precio;
        $car->impuesto_precio     = $rspta->impuesto_precio;
        $car->total_envio    = $rspta->total_envio;
        $car->total_precio    = $rspta->total_precio;
        $car->estatus         = $rspta->estatus;
        $car_data             = obtenerCarritoDetalle($rspta->idcarrito);
        $car->detalles        = $car_data->detalles;
        $car->conekta         = $conekta;
        $data->resultado      = 'OK';
        $data->mensaje        = '¡Carrito disponible!';
        $data->detalles       = $car;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Carrito no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// validarCarrito($idcarrito)
// Descripción:
// Valida un carrito para pasar al paso de pago
// Notas:
// N/A
function validarCarrito($idcarrito)
{
    $carrito  = new Carrito();
    $data     = new stdClass();
    $car      = new stdClass();
    $car_data = new stdClass();
    $rspta    = $carrito->obtenerCarrito($idcarrito);
    if ($rspta)
    {
        if ($rspta->estatus == 1)
        {
            $car_data = obtenerCarritoDetalle($rspta->idcarrito);
            if ($car_data->resultado == 'OK' && count($car_data->detalles) > 0 && $rspta->total_precio > 0)
            {
                $data->resultado = 'OK';
                $data->mensaje   = '¡El carrito está listo para pagarse!';
                $data->detalles  = $car;
            }
            else if ($car_data->resultado == 'OK' && count($car_data->detalles) == 0)
            {
                $data->resultado = 'ERROR';
                $data->mensaje   = '¡El carrito está vacío!';
                $data->detalles  = null;
            }
            else if ($car_data->resultado == 'OK' && $rspta->total_precio == 0)
            {
                $data->resultado = 'ERROR';
                $data->mensaje   = '¡El carrito no está actualizado!';
                $data->detalles  = null;
            }
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡El carrito está cerrado!';
            $data->detalles  = null;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Carrito no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerCarritoDetalle($idcarrito)
// Descripción:
// Obtiene los detalles de un carrito por ID de carrito
// Notas:
// N/A
function obtenerCarritoDetalle($idcarrito)
{
    $carrito = new Carrito();
    $data    = new stdClass();
    $rspta   = $carrito->obtenerCarritoDetalle($idcarrito);
    if ($rspta)
    {
        $arts = Array();
        while ($reg = $rspta->fetch_object())
        {
            $entry                       = new stdClass();
            $entry->idcarrito_detalle    = $reg->idcarrito_detalle;
            $entry->idcarrito            = $reg->idcarrito;
            $entry->idprograma           = $reg->idprograma;
            $entry->idarticulo           = $reg->idarticulo;
            $entry->imagen               = $reg->imagen;
            $entry->isbn                 = $reg->isbn;
            $entry->nombre               = $reg->nombre;
            $entry->descripcion          = $reg->descripcion;
            $entry->serie                = $reg->serie;
            $entry->nivel                = $reg->nivel;
            $entry->cantidad             = $reg->cantidad;
            $entry->precio               = $reg->precio;
            $entry->descuento_porcentaje = $reg->descuento_porcentaje;
            $entry->descuento_valor      = $reg->descuento_valor;
            $entry->precio_descuento     = $reg->precio_descuento;
            $entry->precio_total         = $reg->precio_total;
            array_push($arts, $entry);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Detalle del carrito disponible!';
        $data->detalles  = $arts;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Detalle del carrito no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerArticuloEnPrograma($idarticulo, $idprograma)
// Descripción:
// Obtiene un artículo en un programa
// Notas:
// N/A
function obtenerArticuloEnPrograma($idarticulo, $idprograma)
{
    $tienda = new Tienda();
    $data   = new stdClass();
    $art    = new stdClass();
    $rspta  = $tienda->obtenerArticuloEnPrograma($idarticulo, $idprograma);
    if ($rspta)
    {
        $art->idprograma_articulo  = $rspta->idprograma_articulo;
        $art->idprograma           = $rspta->idprograma;
        $art->idarticulo           = $rspta->idarticulo;
        $art->idlista_precio       = $rspta->idlista_precio;
        $art->isbn                 = $rspta->isbn;
        $art->nombre               = $rspta->nombre;
        $art->descripcion          = $rspta->descripcion;
        $art->serie                = $rspta->serie;
        $art->nivel                = $rspta->nivel;
        $art->precio               = $rspta->precio;
        $art->descuento_porcentaje = $rspta->descuento_porcentaje;
        $art->descuento_valor      = $rspta->descuento_valor;
        $art->precio_descuento     = $rspta->precio_descuento;
        $data->resultado           = 'OK';
        $data->mensaje             = '¡Libro en programa disponible!';
        $data->detalles            = $art;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Libro en programa no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// agregarArticuloAlCarrito($idcarrito, $idprograma, $idarticulo, $cantidad)
// Descripción:
// Agrega un artículo como detalle de un carrito
// Notas:
// N/A
function agregarArticuloAlCarrito($idcarrito, $idprograma, $idarticulo, $cantidad)
{
    $data                = new stdClass();
    $carrito             = obtenerCarrito($idcarrito);
    $detalle_actualizado = false;
    $detalle_agregado    = false;
    $min_articulos       = 1;
    $max_articulos       = 10000;
    if ($carrito->resultado == 'OK')
    {
        if ($carrito->detalles->estatus == 1)
        {
            $max_1_articulo  = $carrito->detalles->max_1_articulo;
            $total_articulos = $carrito->detalles->total_articulos;
            if ($max_1_articulo == 0)
            {
                $detalles   = $carrito->detalles->detalles;
                $encontrado = false;
                for ($i = 0; $i < count($detalles); $i++)
                {
                    if ($detalles[$i]->idarticulo == $idarticulo)
                    {
                        $encontrado                   = true;
                        $encontrado_idcarrito_detalle = $detalles[$i]->idcarrito_detalle;
                        $encontrado_idarticulo        = $detalles[$i]->idarticulo;
                        $encontrado_cantidad          = $detalles[$i]->cantidad;
                        break;
                    }
                }
                if ($encontrado == true)
                {
                    $cantidad = $encontrado_cantidad + $cantidad;
                    if ($cantidad > $max_articulos)
                    {
                        $data->resultado = 'ERROR';
                        $data->mensaje   = '¡La cantidad de libros por nivel excedería el límite permitido (máximo ' . $max_articulos . ' libro(s)), no es posible agregar más libros!';
                        $data->detalles  = $carrito->detalles;
                        return $data;
                    }
                    else if ($cantidad < $min_articulos)
                    {
                        $data->resultado = 'ERROR';
                        $data->mensaje   = '¡La cantidad de libros por nivel sería menor a la permitida (mínimo ' . $min_articulos . ' libro(s)), no es posible continuar, por favor revisa la cantidad deseada!';
                        $data->detalles  = $carrito->detalles;
                        return $data;
                    }
                    $articulo_programa     = obtenerArticuloEnPrograma($encontrado_idarticulo, $idprograma);
                    $carrito_actualizar    = new Carrito();
                    $carrito_detalle_nuevo = $carrito_actualizar->actualizarArticuloEnCarrito($idcarrito, $encontrado_idcarrito_detalle, $idprograma, $idarticulo, $articulo_programa->detalles->isbn, $articulo_programa->detalles->nombre, $articulo_programa->detalles->descripcion, $articulo_programa->detalles->serie, $articulo_programa->detalles->nivel, $cantidad, $articulo_programa->detalles->precio, $articulo_programa->detalles->descuento_porcentaje, $articulo_programa->detalles->descuento_valor, $articulo_programa->detalles->precio_descuento, $articulo_programa->detalles->precio_descuento * $cantidad);
                    $detalle_actualizado   = true;
                }
                else
                {
                    $articulo_programa     = obtenerArticuloEnPrograma($idarticulo, $idprograma);
                    $carrito_agregar       = new Carrito();
                    $carrito_detalle_nuevo = $carrito_agregar->agregarArticuloAlCarrito($idcarrito, $idprograma, $idarticulo, $articulo_programa->detalles->isbn, $articulo_programa->detalles->nombre, $articulo_programa->detalles->descripcion, $articulo_programa->detalles->serie, $articulo_programa->detalles->nivel, $cantidad, $articulo_programa->detalles->precio, $articulo_programa->detalles->descuento_porcentaje, $articulo_programa->detalles->descuento_valor, $articulo_programa->detalles->precio_descuento, $articulo_programa->detalles->precio_descuento * $cantidad);
                    if ($carrito_detalle_nuevo > 0)
                    {
                        $detalle_agregado = true;
                    }
                }
                if ($detalle_actualizado == true || $detalle_agregado == true)
                {
                    $carrito = obtenerCarrito($idcarrito);
                    if ($carrito->resultado == 'OK')
                    {
                        $detalles        = $carrito->detalles->detalles;
                        $total_articulos = 0;
                        $total_precio    = 0;
                        for ($i = 0; $i < count($detalles); $i++)
                        {
                            $total_articulos += (float) $detalles[$i]->cantidad;
                            $total_precio += (float) $detalles[$i]->precio_total;
                        }
                        $subtotal_precio = $total_precio;
                        $descuento_precio = 0;
                        $impuesto_precio = 0;
                        $total_envio = 0.01;
                        $carrito_act = new Carrito();
                        $carrito_act->actualizarCarrito($idcarrito, $total_articulos, $subtotal_precio, $descuento_precio, $impuesto_precio, $total_envio, $total_envio + $total_precio);
                        $carrito = obtenerCarrito($idcarrito);
                        if ($carrito->resultado == 'OK')
                        {
                            if ($detalle_actualizado == true)
                            {
                                $data->resultado = 'OK';
                                $data->mensaje   = '¡Libro actualizado en el carrito!';
                                $data->detalles  = $carrito->detalles;
                            }
                            else if ($detalle_agregado == true)
                            {
                                $data->resultado = 'OK';
                                $data->mensaje   = '¡Libro agregado al carrito!';
                                $data->detalles  = $carrito->detalles;
                            }
                        }
                        else
                        {
                            $data->resultado = 'ADVERTENCIA';
                            $data->mensaje   = '¡Problema interno al actualizar el carrito posterior a agregar el libro!';
                            $data->detalles  = $carrito->detalles;
                        }
                    }
                    else
                    {
                        $data->resultado = 'ADVERTENCIA';
                        $data->mensaje   = '¡Problema interno al obtener el carrito posterior a agregar el libro!';
                        $data->detalles  = $carrito->detalles;
                    }
                }
                else
                {
                    $data->resultado = 'ADVERTENCIA';
                    $data->mensaje   = '¡Problema interno al agregar el libro al carrito! (m1=0)';
                    $data->detalles  = $carrito->detalles;
                }
            }
            else if ($max_1_articulo == 1)
            {
                $carr_vac              = vaciarCarrito($idcarrito);
                $detalles              = $carrito->detalles->detalles;
                $articulo_programa     = obtenerArticuloEnPrograma($idarticulo, $idprograma);
                $carrito_actualizar    = new Carrito();
                $cantidad              = 1;
                $carrito_detalle_nuevo = $carrito_actualizar->agregarArticuloAlCarrito($idcarrito, $idprograma, $idarticulo, $articulo_programa->detalles->isbn, $articulo_programa->detalles->nombre, $articulo_programa->detalles->descripcion, $articulo_programa->detalles->serie, $articulo_programa->detalles->nivel, $cantidad, $articulo_programa->detalles->precio, $articulo_programa->detalles->descuento_porcentaje, $articulo_programa->detalles->descuento_valor, $articulo_programa->detalles->precio_descuento, $articulo_programa->detalles->precio_descuento * $cantidad);
                if ($carrito_detalle_nuevo > 0)
                {
                    $carrito = obtenerCarrito($idcarrito);
                    if ($carrito->resultado == 'OK')
                    {
                        $detalles        = $carrito->detalles->detalles;
                        $total_articulos = 0;
                        $total_precio    = 0;
                        for ($i = 0; $i < count($detalles); $i++)
                        {
                            $total_articulos += (int) $detalles[$i]->cantidad;
                            $total_precio += (float) $detalles[$i]->precio_total;
                        }
                        $subtotal_precio = $total_precio;
                        $descuento_precio = 0;
                        $impuesto_precio = 0;
                        $total_envio = 0.01;
                        $carrito_act = new Carrito();
                        $carrito_act->actualizarCarrito($idcarrito, $total_articulos, $subtotal_precio, $descuento_precio, $impuesto_precio, $total_envio, $total_envio + $total_precio);
                        $carrito = obtenerCarrito($idcarrito);
                        if ($carrito->resultado == 'OK')
                        {
                            $data->resultado = 'OK';
                            $data->mensaje   = '¡Libro agregado y carrito actualizado!';
                            $data->detalles  = $carrito->detalles;
                        }
                        else
                        {
                            $data->resultado = 'ADVERTENCIA';
                            $data->mensaje   = '¡Problema interno al actualizar el carrito posterior a agregar el libro!';
                            $data->detalles  = $carrito->detalles;
                        }
                    }
                    else
                    {
                        $data->resultado = 'ERROR';
                        $data->mensaje   = '¡Problema interno al obtener el carrito posterior a agregar el libro!';
                        $data->detalles  = $carrito->detalles;
                    }
                }
                else
                {
                    $data->resultado = 'ERROR';
                    $data->mensaje   = '¡Problema interno al agregar el libro al carrito!  (m1=1)';
                    $data->detalles  = $carrito->detalles;
                }
            }
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡El carrito no se encuentra abierto, no es posible agregar el libro!';
            $data->detalles  = $carrito->detalles;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $carrito->mensaje;
        $data->null;
    }
    return $data;
}

// eliminarArticuloDelCarrito($idcarrito, $idarticulo)
// Descripción:
// Elimina un artículo del carrito
// Notas:
// N/A
function eliminarArticuloDelCarrito($idcarrito, $idarticulo)
{
    $data    = new stdClass();
    $carrito = obtenerCarrito($idcarrito);
    if ($carrito->resultado == 'OK')
    {
        if ($carrito->detalles->estatus == 1)
        {
            $carrito_actualizar    = new Carrito();
            $carrito_detalle_nuevo = $carrito_actualizar->eliminarArticuloDelCarrito($idcarrito, $idarticulo);
            $detalle_actualizado   = true;
            if ($detalle_actualizado == true || $detalle_agregado == true)
            {
                $carrito = obtenerCarrito($idcarrito);
                if ($carrito->resultado == 'OK')
                {
                    $detalles        = $carrito->detalles->detalles;
                    $total_articulos = 0;
                    $total_precio    = 0;
                    for ($i = 0; $i < count($detalles); $i++)
                    {
                        $total_articulos += (float) $detalles[$i]->cantidad;
                        $total_precio += (float) $detalles[$i]->precio_total;
                    }
                    $subtotal_precio = $total_precio;
                    $descuento_precio = 0;
                    $impuesto_precio = 0;
                    $total_envio = 0.01;
                    $carrito_act = new Carrito();
                    $carrito_act->actualizarCarrito($idcarrito, $total_articulos, $subtotal_precio, $descuento_precio, $impuesto_precio, $total_envio, $total_envio + $total_precio);
                    $carrito = obtenerCarrito($idcarrito);
                    if ($carrito->resultado == 'OK')
                    {
                        $data->resultado = 'OK';
                        $data->mensaje   = '¡Libro eliminado del carrito!';
                        $data->detalles  = $carrito->detalles;
                    }
                    else
                    {
                        $data->resultado = 'ADVERTENCIA';
                        $data->mensaje   = '¡Problema interno al actualizar el carrito posterior a eliminar el libro!';
                        $data->detalles  = $carrito->detalles;
                    }
                }
                else
                {
                    $data->resultado = 'ADVERTENCIA';
                    $data->mensaje   = '¡Problema interno al obtener el carrito posterior a eliminar el libro!';
                    $data->detalles  = $carrito->detalles;
                }
            }
            else
            {
                $data->resultado = 'ADVERTENCIA';
                $data->mensaje   = '¡Problema interno al eliminar el libro del carrito!';
                $data->detalles  = $carrito->detalles;
            }
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡El carrito no se encuentra abierto, no es posible eliminar el libro!';
            $data->detalles  = $carrito->detalles;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $carrito->mensaje;
        $data->null;
    }
    return $data;
}

// vaciarCarrito($idcarrito)
// Descripción:
// Vacía un carrito
// Notas:
// N/A
function vaciarCarrito($idcarrito)
{
    $carrito = new Carrito();
    $data    = new stdClass();
    $rspta   = $carrito->vaciarCarrito($idcarrito);
    if ($rspta)
    {
        $carrito_act = new Carrito();
        $carrito_act->actualizarCarrito($idcarrito, 0, 0, 0, 0, 0, 0);
        $carrito = obtenerCarrito($idcarrito);
        if ($carrito->resultado == 'OK')
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡El carrito se encuentra vacío!';
            $data->detalles  = $carrito->detalles;
        }
        else
        {
            $data->resultado = 'ADVERTENCIA';
            $data->mensaje   = '¡Problema interno al actualizar el carrito posterior a haberlo vaciado!';
            $data->detalles  = $carrito->detalles;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al vaciar el carrito!';
    }
    return $data;
}

// pagarCarritoTarjeta($idcarrito, $token)
// Descripción:
// $idcarrito es el id del carrito a pagar
// Notas:
// Utiliza CONEKTA para realizar el pago mediante TARJETA
// Creará un registro de pago y uno de venta con estatus APROBADO
function pagarCarritoTarjeta($idcarrito, $token)
{
    // Preparar todo
    $data = new stdClass();
    $tienda = 'CONEKTA_TARJETA';
    
    // ¿El carrito existe?
    $carrito = obtenerCarrito($idcarrito);
    if ($carrito->resultado == 'ERROR')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito está cerrado?
    if ($carrito->detalles->estatus == 0)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está cerrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito está pagado?
    if ($carrito->detalles->idventa !== NULL)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está pagado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito tiene detalles?
    $carrito_detalles = $carrito->detalles->detalles;
    if (count($carrito_detalles) == 0)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está vacío!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El usuario del carrito existe?
    $idusuario   = $carrito->detalles->idusuario;
    $usuario_obj = new Usuario();
    $usuario     = $usuario_obj->obtenerUsuario($idusuario);
    if (!$usuario)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    $usuario_dominio_id  = $usuario->iddominio;
    $usuario_escuela_id  = $usuario->usuario_idescuela;
    $usuario_programa_id = $usuario->usuario_idprograma;
    $curso_idcurso = $usuario->usuario_idcurso;

    // ¿El dominio del usuario del carrito existe?
    $dominio_obj = new Dominio();
    $dominio     = $dominio_obj->obtenerDominio($usuario_dominio_id);
    if (!$dominio)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El dominio del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La escuela del usuario del carrito existe?
    $escuela_obj = new Escuela();
    $escuela     = $escuela_obj->obtenerEscuela($usuario_escuela_id);
    if (!$escuela)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La escuela del usuario del carrito no fue encontrada!';
        $data->detalles  = null;
        return $data;
    }
    $escuela_distribuidor_id = $escuela->iddistribuidor;
    
    // ¿La escuela del usuario del carrito tiene un distribuidor?
    if (!$escuela_distribuidor_id)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La escuela del usuario del carrito no tiene un distribuidor asignado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El distribuidor de la escuela del usuario del carrito existe?
    $distribuidor_obj = new Distribuidor();
    $distribuidor     = $distribuidor_obj->obtenerDistribuidor($escuela_distribuidor_id);
    if (!$distribuidor)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El distribuidor de la escuela del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El programa del usuario del carrito existe?
    $programa_obj = new Programa();
    $programa     = $programa_obj->obtenerPrograma($usuario_programa_id);
    if (!$programa)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El programa del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación del curso existe?
    $consignacion_obj = new Consignacion();
    $consignacion     = $consignacion_obj->obtenerConsignacionPorIDCurso($curso_idcurso);
    if (!$consignacion)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La consignación del curso no fue encontrada!';
        $data->detalles  = null;
        return $data;
    }
    $consignacion_idconsignacion = $consignacion->idconsignacion;
    $consignacion_idventa = $consignacion->idventa;
    $consignacion_estatus = $consignacion->estatus;
    $venta_fecha_entrega_prevista = $consignacion->fecha_entrega_prevista;
    
    // ¿El ID de la consignación coincide con el del alumno?
    if (!($usuario->usuario_idconsignacion == $consignacion_idconsignacion))
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La consignación del curso no coincide con la del alumno!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está en pendiente?
    // Significa que la consignación del coordinador está pendiente
    if ($consignacion_estatus == 0)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Tu escuela aún no cuenta con un servicio de venta, porfavor ponte en contacto con el coordinador de Inglés de tu escuela!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está en revisión?
    // Significa que la consignación del coordinador está en proceso de revisión
    if ($consignacion_estatus == 1)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Tu escuela aún no cuenta con un servicio de venta aprobado, porfavor ponte en contacto con el coordinador de Inglés de tu escuela!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está rechazada?
    // Significa que la consignación del coordinador está fue rechazada
    else if ($consignacion_estatus == 3)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Tu escuela aún no cuenta con un servicio de venta aprobado, porfavor ponte en contacto con el coordinador de Inglés de tu escuela!';
        $data->detalles  = null;
        return $data;
    }
    
    // Obtener el modo de CONEKTA
    $conekta = conekta_obtenerDatosCONEKTA();
    if ($conekta->resultado == 'ERROR')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $conekta->mensaje;
        $data->detalles  = null;
        return $data;
    }
    $venta_modo = $conekta->detalles->modo;
    
    // Generar el pago mediante TARJETA
    $venta_tipo_pago = 'Tarjeta';
    $pago_respuesta = new stdClass();
    $pago_respuesta = conekta_generarPagoTarjeta($carrito, $usuario, $escuela, $token);
    if ($pago_respuesta->resultado == 'ERROR')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $pago_respuesta->mensaje;
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El registro del pago realmente existe?
    $rspta_idpago = $pago_respuesta->detalles->idpago;
    $pago_obj = new Pago();
    $pago     = $pago_obj->obtenerReferenciaPago($rspta_idpago);
    if (!$pago)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El registro del pago no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    $reg_pago_tienda = $pago->pago_tienda;
    $reg_pago_proveedor = $pago->pago_proveedor;
    $reg_pago_referencia = $pago->pago_referencia;
    $reg_pago_total = $pago->pago_total;
    $reg_pago_concepto = $pago->pago_concepto;
    
    // Datos de la venta
    $venta_tipo = 'venta';
    $venta_tipo_rol = $carrito->detalles->tipo;
    $venta_fecha_hora = date('Y-m-d G:i:s');
    $venta_total_articulos = $carrito->detalles->total_articulos;
    $venta_subtotal = $carrito->detalles->subtotal_precio;
    $venta_descuento = $carrito->detalles->descuento_precio;
    $venta_impuesto = $carrito->detalles->impuesto_precio;
    $venta_envio = $carrito->detalles->total_envio;
    $venta_total = $carrito->detalles->total_precio;
    
    // Datos del comprador
    $comprador_nombre = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
    $comprador_correo_electronico = $usuario->email;
    $comprador_matricula = $usuario->matricula;
    $comprador_telefono = $usuario->telefono;
    $comprador_entrega_a = '';
    $comprador_entrega_a .= 'Comprador: ' . $comprador_nombre . '\n';
    $comprador_entrega_a .= 'Correo Electrónico: ' . $comprador_correo_electronico . '\n';
    $comprador_entrega_a .= 'Matrícula: ' . $comprador_matricula . '\n';
    $comprador_entrega_a .= 'Télefono: ' . $comprador_telefono;
    
    // Datos de la escuela
    $entrega_nombre = $escuela->nombre;
    $entrega_campus = $escuela->campus;
    $entrega_calle = $escuela->calle . ($escuela->num_exterior ? ' # Exterior ' . $escuela->num_exterior : '') . ($escuela->num_interior ? ' # Interior ' . $escuela->num_interior : '');
    $entrega_ciudad = $escuela->ciudad;
    $entrega_estado = $escuela->estado;
    $entrega_codigo_postal = $escuela->codigo_postal;
    $entrega_entrega_en = '';
    $entrega_entrega_en .= 'Escuela: ' . $entrega_nombre . '\n';
    $entrega_entrega_en .= 'Calle: ' . $entrega_calle . '\n';
    $entrega_entrega_en .= 'Ciudad: ' . $entrega_ciudad . '\n';
    $entrega_entrega_en .= 'Estado: ' . $entrega_estado . '\n';
    $entrega_entrega_en .= 'Código Postal: ' . $entrega_codigo_postal;
    
    // Crear la venta
    $venta_obj = new Venta();
    $rspta_idventa = $venta_obj->crearVenta(
        $usuario_dominio_id,
        $usuario_escuela_id,
        $usuario_programa_id,
        $escuela_distribuidor_id,
        $curso_idcurso,
        $consignacion_idconsignacion,
        $idusuario,
        $idcarrito,
        $rspta_idpago,
        $venta_modo,
        $venta_tipo,
        $venta_tipo_rol,
        $venta_tipo_pago,
        $tienda,
        $reg_pago_tienda,
        $reg_pago_proveedor,
        $reg_pago_referencia,
        $reg_pago_total,
        $reg_pago_concepto,
        $entrega_entrega_en,
        $comprador_entrega_a,
        $entrega_nombre,
        $entrega_campus,
        $entrega_calle,
        $entrega_ciudad,
        $entrega_estado,
        $entrega_codigo_postal,
        $comprador_nombre,
        $comprador_correo_electronico,
        $comprador_matricula,
        $comprador_telefono,
        $venta_fecha_hora,
        $venta_fecha_entrega_prevista,
        $venta_total_articulos,
        $venta_subtotal,
        $venta_descuento,
        $venta_impuesto,
        $venta_envio,
        $venta_total
        );
    if ($rspta_idventa > 0)
    {
        // Asignar el ID de la venta al carrito
        $carrito_obj = new Carrito();
        $carrito_obj->actualizarCarritoEstablecerIDVentaIDPagoYCerrarCarrito($idcarrito, $rspta_idventa, $rspta_idpago);
        $carrito = obtenerCarrito($idcarrito);
        if ($carrito->resultado == 'OK')
        {
            // Convertir los detalles del carrito en detalles de la venta
            for ($i = 0; $i < count($carrito_detalles); $i++)
            {
                $det_idprograma = $carrito_detalles[$i]->idprograma;
                $det_idarticulo = $carrito_detalles[$i]->idarticulo;
                $det_articulo_nivel = $carrito_detalles[$i]->nivel;
                $det_articulo_nombre = $carrito_detalles[$i]->nombre;
                $det_articulo_descripcion = $carrito_detalles[$i]->descripcion;
                $det_cantidad = $carrito_detalles[$i]->cantidad;
                $det_precio = $carrito_detalles[$i]->precio;
                $det_descuento_porcentaje = $carrito_detalles[$i]->descuento_porcentaje;
                $det_descuento_valor = $carrito_detalles[$i]->descuento_valor;
                $det_precio_descuento = $carrito_detalles[$i]->precio_descuento;
                $det_precio_total = $carrito_detalles[$i]->precio_total;
                
                $rspta_detalle = $venta_obj->agregarArticuloAVenta(
                    $rspta_idventa,
                    $det_idprograma,
                    $det_idarticulo,
                    $det_articulo_nivel,
                    $det_articulo_nombre,
                    $det_articulo_descripcion,
                    $det_cantidad,
                    $det_precio,
                    $det_descuento_porcentaje,
                    $det_descuento_valor,
                    $det_precio_descuento,
                    $det_precio_total
                );
                if (!($rspta_detalle > 0))
                {
                    $data->resultado = 'ERROR';
                    $data->mensaje   = '¡Problema interno al convertir un detalle de carrito en detalle de venta!';
                    $data->detalles  = null;
                    return $data;
                }
            }
            
            $detalles_venta = new stdClass();
            $detalles_venta->idventa = $rspta_idventa;
            $detalles_venta->idpago = $rspta_idpago;
            
            $referencia_tipo = '';
            if ($tienda == 'CONEKTA_OXXOPay') {
                $referencia_tipo = 'Referencia Pago OXXO';
            } else if ($tienda == 'CONEKTA_SPEI') {
                $referencia_tipo = 'Referencia Pago SPEI';
            }
            else if ($tienda == 'CONEKTA_TARJETA') {
                $referencia_tipo = 'Referencia Tarjeta';
            }
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPGET, 1);
            curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_SEND_EMAILS_SALES);
            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
            curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($curl, CURLOPT_POSTFIELDS, ['saleID' => $rspta_idventa, 'type' => $referencia_tipo]);
            curl_exec($curl);
            if (curl_error($curl))
            {
                $error_msg = curl_error($curl);
            }
            if (!isset($error_msg))
            {
                $data->resultado = 'OK';
                $data->mensaje   = '¡Carrito convertido en venta!';
                $data->detalles  = $detalles_venta;
            }
            else
            {
                $data->resultado = 'ADVERTENCIA';
                $data->mensaje   = '¡Carrito convertido en venta, pero ocurrió un problema con la notificación!';
                $data->detalles  = $detalles_venta;
            }
            curl_close($curl);
            return $data;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡Problema interno al asignar el ID de venta y/o ID de pago al carrito!';
            $data->detalles  = null;
            return $data;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al crear el registro de venta!';
        $data->detalles  = null;
        return $data;
    }
}

// pagarCarritoTienda($idcarrito, $tienda)
// Descripción:
// $idcarrito es el id del carrito a pagar
// Notas:
// Utiliza CONEKTA para realizar el pago mediante OXXO o SPEI
// Creará un registro de pago y uno de venta con estatus PENDIENTE
function pagarCarritoTienda($idcarrito, $tienda)
{
    // Preparar todo
    $data = new stdClass();
    
    // ¿El carrito existe?
    $carrito = obtenerCarrito($idcarrito);
    if ($carrito->resultado == 'ERROR')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito está cerrado?
    if ($carrito->detalles->estatus == 0)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está cerrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito está pagado?
    if ($carrito->detalles->idventa !== NULL)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está pagado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito tiene detalles?
    $carrito_detalles = $carrito->detalles->detalles;
    if (count($carrito_detalles) == 0)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está vacío!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El usuario del carrito existe?
    $idusuario   = $carrito->detalles->idusuario;
    $usuario_obj = new Usuario();
    $usuario     = $usuario_obj->obtenerUsuario($idusuario);
    if (!$usuario)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    $usuario_dominio_id  = $usuario->iddominio;
    $usuario_escuela_id  = $usuario->usuario_idescuela;
    $usuario_programa_id = $usuario->usuario_idprograma;
    $curso_idcurso = $usuario->usuario_idcurso;

    // ¿El dominio del usuario del carrito existe?
    $dominio_obj = new Dominio();
    $dominio     = $dominio_obj->obtenerDominio($usuario_dominio_id);
    if (!$dominio)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El dominio del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La escuela del usuario del carrito existe?
    $escuela_obj = new Escuela();
    $escuela     = $escuela_obj->obtenerEscuela($usuario_escuela_id);
    if (!$escuela)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La escuela del usuario del carrito no fue encontrada!';
        $data->detalles  = null;
        return $data;
    }
    $escuela_distribuidor_id = $escuela->iddistribuidor;
    
    // ¿La escuela del usuario del carrito tiene un distribuidor?
    if (!$escuela_distribuidor_id)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La escuela del usuario del carrito no tiene un distribuidor asignado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El distribuidor de la escuela del usuario del carrito existe?
    $distribuidor_obj = new Distribuidor();
    $distribuidor     = $distribuidor_obj->obtenerDistribuidor($escuela_distribuidor_id);
    if (!$distribuidor)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El distribuidor de la escuela del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El programa del usuario del carrito existe?
    $programa_obj = new Programa();
    $programa     = $programa_obj->obtenerPrograma($usuario_programa_id);
    if (!$programa)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El programa del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación del curso existe?
    $consignacion_obj = new Consignacion();
    $consignacion     = $consignacion_obj->obtenerConsignacionPorIDCurso($curso_idcurso);
    if (!$consignacion)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La consignación del curso no fue encontrada!';
        $data->detalles  = null;
        return $data;
    }
    $consignacion_idconsignacion = $consignacion->idconsignacion;
    $consignacion_idventa = $consignacion->idventa;
    $consignacion_estatus = $consignacion->estatus;
    $venta_fecha_entrega_prevista = $consignacion->fecha_entrega_prevista;
    
    // ¿El ID de la consignación coincide con el del alumno?
    if (!($usuario->usuario_idconsignacion == $consignacion_idconsignacion))
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La consignación del curso no coincide con la del alumno!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está en pendiente?
    // Significa que la consignación del coordinador está pendiente
    if ($consignacion_estatus == 0)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Tu escuela aún no cuenta con un servicio de venta, porfavor ponte en contacto con el coordinador de Inglés de tu escuela!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está en revisión?
    // Significa que la consignación del coordinador está en proceso de revisión
    if ($consignacion_estatus == 1)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Tu escuela aún no cuenta con un servicio de venta aprobado, porfavor ponte en contacto con el coordinador de Inglés de tu escuela!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está rechazada?
    // Significa que la consignación del coordinador está fue rechazada
    else if ($consignacion_estatus == 3)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Tu escuela aún no cuenta con un servicio de venta aprobado, porfavor ponte en contacto con el coordinador de Inglés de tu escuela!';
        $data->detalles  = null;
        return $data;
    }
    
    // Obtener el modo de CONEKTA
    $conekta = conekta_obtenerDatosCONEKTA();
    if ($conekta->resultado == 'ERROR')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $conekta->mensaje;
        $data->detalles  = null;
        return $data;
    }
    $venta_modo = $conekta->detalles->modo;
    
    $venta_tipo_pago = '';
    
    // ¿Pagar mediante qué tienda?
    $pago_respuesta = new stdClass();
    if ($tienda == 'CONEKTA_OXXOPay')
    {
        $venta_tipo_pago = 'OXXOPay';
        
        // Generar el pago mediante OXXO
        $pago_respuesta = conekta_generarPagoOXXO($carrito, $usuario, $escuela);
        if ($pago_respuesta->resultado == 'ERROR')
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = $pago_respuesta->mensaje;
            $data->detalles  = null;
            return $data;
        }
    }
    else if ($tienda == 'CONEKTA_SPEI')
    {
        $venta_tipo_pago = 'SPEI';
        
        // Generar el pago mediante SPEI
        $pago_respuesta = conekta_generarPagoSPEI($carrito, $usuario, $escuela);
        if ($pago_respuesta->resultado == 'ERROR')
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = $pago_respuesta->mensaje;
            $data->detalles  = null;
            return $data;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La tienda destino del pago no es válida!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El registro del pago realmente existe?
    $rspta_idpago = $pago_respuesta->detalles->idpago;
    $pago_obj = new Pago();
    $pago     = $pago_obj->obtenerReferenciaPago($rspta_idpago);
    if (!$pago)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El registro del pago no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    $reg_pago_tienda = $pago->pago_tienda;
    $reg_pago_proveedor = $pago->pago_proveedor;
    $reg_pago_referencia = $pago->pago_referencia;
    $reg_pago_total = $pago->pago_total;
    $reg_pago_concepto = $pago->pago_concepto;
    
    // Datos de la venta
    $venta_tipo = 'venta';
    $venta_tipo_rol = $carrito->detalles->tipo;
    $venta_fecha_hora = date('Y-m-d G:i:s');
    $venta_total_articulos = $carrito->detalles->total_articulos;
    $venta_subtotal = $carrito->detalles->subtotal_precio;
    $venta_descuento = $carrito->detalles->descuento_precio;
    $venta_impuesto = $carrito->detalles->impuesto_precio;
    $venta_envio = $carrito->detalles->total_envio;
    $venta_total = $carrito->detalles->total_precio;
    
    // Datos del comprador
    $comprador_nombre = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
    $comprador_correo_electronico = $usuario->email;
    $comprador_matricula = $usuario->matricula;
    $comprador_telefono = $usuario->telefono;
    $comprador_entrega_a = '';
    $comprador_entrega_a .= 'Comprador: ' . $comprador_nombre . '\n';
    $comprador_entrega_a .= 'Correo Electrónico: ' . $comprador_correo_electronico . '\n';
    $comprador_entrega_a .= 'Matrícula: ' . $comprador_matricula . '\n';
    $comprador_entrega_a .= 'Télefono: ' . $comprador_telefono;
    
    // Datos de la escuela
    $entrega_nombre = $escuela->nombre;
    $entrega_campus = $escuela->campus;
    $entrega_calle = $escuela->calle . ($escuela->num_exterior ? ' # Exterior ' . $escuela->num_exterior : '') . ($escuela->num_interior ? ' # Interior ' . $escuela->num_interior : '');
    $entrega_ciudad = $escuela->ciudad;
    $entrega_estado = $escuela->estado;
    $entrega_codigo_postal = $escuela->codigo_postal;
    $entrega_entrega_en = '';
    $entrega_entrega_en .= 'Escuela: ' . $entrega_nombre . '\n';
    $entrega_entrega_en .= 'Calle: ' . $entrega_calle . '\n';
    $entrega_entrega_en .= 'Ciudad: ' . $entrega_ciudad . '\n';
    $entrega_entrega_en .= 'Estado: ' . $entrega_estado . '\n';
    $entrega_entrega_en .= 'Código Postal: ' . $entrega_codigo_postal;
    
    // Crear la venta
    $venta_obj = new Venta();
    $rspta_idventa = $venta_obj->crearVenta(
        $usuario_dominio_id,
        $usuario_escuela_id,
        $usuario_programa_id,
        $escuela_distribuidor_id,
        $curso_idcurso,
        $consignacion_idconsignacion,
        $idusuario,
        $idcarrito,
        $rspta_idpago,
        $venta_modo,
        $venta_tipo,
        $venta_tipo_rol,
        $venta_tipo_pago,
        $tienda,
        $reg_pago_tienda,
        $reg_pago_proveedor,
        $reg_pago_referencia,
        $reg_pago_total,
        $reg_pago_concepto,
        $entrega_entrega_en,
        $comprador_entrega_a,
        $entrega_nombre,
        $entrega_campus,
        $entrega_calle,
        $entrega_ciudad,
        $entrega_estado,
        $entrega_codigo_postal,
        $comprador_nombre,
        $comprador_correo_electronico,
        $comprador_matricula,
        $comprador_telefono,
        $venta_fecha_hora,
        $venta_fecha_entrega_prevista,
        $venta_total_articulos,
        $venta_subtotal,
        $venta_descuento,
        $venta_impuesto,
        $venta_envio,
        $venta_total
        );
    if ($rspta_idventa > 0)
    {
        // Asignar el ID de la venta al carrito
        $carrito_obj = new Carrito();
        $carrito_obj->actualizarCarritoEstablecerIDVentaIDPagoYCerrarCarrito($idcarrito, $rspta_idventa, $rspta_idpago);
        $carrito = obtenerCarrito($idcarrito);
        if ($carrito->resultado == 'OK')
        {
            // Convertir los detalles del carrito en detalles de la venta
            for ($i = 0; $i < count($carrito_detalles); $i++)
            {
                $det_idprograma = $carrito_detalles[$i]->idprograma;
                $det_idarticulo = $carrito_detalles[$i]->idarticulo;
                $det_articulo_nivel = $carrito_detalles[$i]->nivel;
                $det_articulo_nombre = $carrito_detalles[$i]->nombre;
                $det_articulo_descripcion = $carrito_detalles[$i]->descripcion;
                $det_cantidad = $carrito_detalles[$i]->cantidad;
                $det_precio = $carrito_detalles[$i]->precio;
                $det_descuento_porcentaje = $carrito_detalles[$i]->descuento_porcentaje;
                $det_descuento_valor = $carrito_detalles[$i]->descuento_valor;
                $det_precio_descuento = $carrito_detalles[$i]->precio_descuento;
                $det_precio_total = $carrito_detalles[$i]->precio_total;
                
                $rspta_detalle = $venta_obj->agregarArticuloAVenta(
                    $rspta_idventa,
                    $det_idprograma,
                    $det_idarticulo,
                    $det_articulo_nivel,
                    $det_articulo_nombre,
                    $det_articulo_descripcion,
                    $det_cantidad,
                    $det_precio,
                    $det_descuento_porcentaje,
                    $det_descuento_valor,
                    $det_precio_descuento,
                    $det_precio_total
                );
                if (!($rspta_detalle > 0))
                {
                    $data->resultado = 'ERROR';
                    $data->mensaje   = '¡Problema interno al convertir un detalle de carrito en detalle de venta!';
                    $data->detalles  = null;
                    return $data;
                }
            }
            
            $detalles_venta = new stdClass();
            $detalles_venta->idventa = $rspta_idventa;
            $detalles_venta->idpago = $rspta_idpago;
            
            $referencia_tipo = '';
            if ($tienda == 'CONEKTA_OXXOPay') {
                $referencia_tipo = 'Referencia Pago OXXO';
            } else if ($tienda == 'CONEKTA_SPEI') {
                $referencia_tipo = 'Referencia Pago SPEI';
            }
            else if ($tienda == 'CONEKTA_TARJETA') {
                $referencia_tipo = 'Referencia Tarjeta';
            }
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPGET, 1);
            curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_SEND_EMAILS_SALES);
            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
            curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($curl, CURLOPT_POSTFIELDS, ['saleID' => $rspta_idventa, 'type' => $referencia_tipo]);
            curl_exec($curl);
            if (curl_error($curl))
            {
                $error_msg = curl_error($curl);
            }
            if (!isset($error_msg))
            {
                $data->resultado = 'OK';
                $data->mensaje   = '¡Carrito convertido en venta!';
                $data->detalles  = $detalles_venta;
            }
            else
            {
                $data->resultado = 'ADVERTENCIA';
                $data->mensaje   = '¡Carrito convertido en venta, pero ocurrió un problema con la notificación!';
                $data->detalles  = $detalles_venta;
            }
            curl_close($curl);
            return $data;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡Problema interno al asignar el ID de venta y/o ID de pago al carrito!';
            $data->detalles  = null;
            return $data;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al crear el registro de venta!';
        $data->detalles  = null;
        return $data;
    }
}

// pagarCarritoConsignacion($idcarrito)
// Descripción:
// $idcarrito es el id del carrito a pagar
// Notas:
// Generará un registro de consignación
// Creará un registro de pago y uno de venta con estatus PENDIENTE
function pagarCarritoConsignacion($idcarrito)
{
    // Preparar todo
    $data = new stdClass();
    
    // ¿El carrito existe?
    $carrito = obtenerCarrito($idcarrito);
    if ($carrito->resultado == 'ERROR')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito está cerrado?
    if ($carrito->detalles->estatus == 0)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está cerrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito está pagado?
    if ($carrito->detalles->idventa !== NULL)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está pagado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito tiene detalles?
    $carrito_detalles = $carrito->detalles->detalles;
    if (count($carrito_detalles) == 0)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El carrito está vacío!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El carrito es de tipo consignación?
    $carrito_tipo = $carrito->detalles->tipo;
    if (!($carrito_tipo == 'coordinador_dominio' || $carrito_tipo == 'coordinador_zona' || $carrito_tipo == 'coordinador_subzona' || $carrito_tipo == 'coordinador_escuela'))
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El tipo del carrito no permite la consignación!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El usuario del carrito existe?
    $idusuario   = $carrito->detalles->idusuario;
    $usuario_obj = new Usuario();
    $usuario     = $usuario_obj->obtenerUsuario($idusuario);
    if (!$usuario)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    $usuario_dominio_id  = $usuario->iddominio;
    $usuario_escuela_id  = $usuario->usuario_idescuela;
    $usuario_programa_id = $usuario->usuario_idprograma;
    $curso_idcurso = $usuario->usuario_idcurso;

    // ¿El dominio del usuario del carrito existe?
    $dominio_obj = new Dominio();
    $dominio     = $dominio_obj->obtenerDominio($usuario_dominio_id);
    if (!$dominio)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El dominio del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La escuela del usuario del carrito existe?
    $escuela_obj = new Escuela();
    $escuela     = $escuela_obj->obtenerEscuela($usuario_escuela_id);
    if (!$escuela)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La escuela del usuario del carrito no fue encontrada!';
        $data->detalles  = null;
        return $data;
    }
    $escuela_distribuidor_id = $escuela->iddistribuidor;
    
    // ¿La escuela del usuario del carrito tiene un distribuidor?
    if (!$escuela_distribuidor_id)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La escuela del usuario del carrito no tiene un distribuidor asignado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El distribuidor de la escuela del usuario del carrito existe?
    $distribuidor_obj = new Distribuidor();
    $distribuidor     = $distribuidor_obj->obtenerDistribuidor($escuela_distribuidor_id);
    if (!$distribuidor)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El distribuidor de la escuela del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El programa del usuario del carrito existe?
    $programa_obj = new Programa();
    $programa     = $programa_obj->obtenerPrograma($usuario_programa_id);
    if (!$programa)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El programa del usuario del carrito no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación del curso existe?
    $consignacion_obj = new Consignacion();
    $consignacion     = $consignacion_obj->obtenerConsignacionPorIDCurso($curso_idcurso);
    if (!$consignacion)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La consignación del curso no fue encontrada!';
        $data->detalles  = null;
        return $data;
    }
    $consignacion_idconsignacion = $consignacion->idconsignacion;
    $consignacion_idventa = $consignacion->idventa;
    $consignacion_estatus = $consignacion->estatus;
    $venta_fecha_entrega_prevista = $consignacion->fecha_entrega_prevista;
    
    // ¿El ID de la consignación coincide con el del coordinador?
    if (!($usuario->usuario_idconsignacion == $consignacion_idconsignacion))
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La consignación del curso no coincide con la del coordinador!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya cuenta con una venta asignada?
    if ($consignacion_idventa > -1)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡La consignación ya ha sido registrada previamente!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está en revisión?
    if ($consignacion_estatus == 1)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Ya hay una consignación en proceso de revisión, si requieres una nueva, ponte en contacto con nosotros en la sección Ayuda!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está aprobada?
    else if ($consignacion_estatus == 2)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Ya hay una consignación previamente aprobada, si requieres una nueva, ponte en contacto con nosotros en la sección Ayuda!';
        $data->detalles  = null;
        return $data;
    }
    
    // ¿La consignación ya está rechazada?
    else if ($consignacion_estatus == 3)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Ya hay una consignación previamente rechazada, si requieres una nueva, ponte en contacto con nosotros en la sección Ayuda!';
        $data->detalles  = null;
        return $data;
    }
    
    $venta_tipo_pago = 'CONSIGNACION';
    $tienda = 'CONSIGNACION';
    
    // Obtener el modo de CONSIGNACION
    $consig = consignacion_obtenerDatosCONSIGNACION();
    if ($consig->resultado == 'ERROR')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $consig->mensaje;
        $data->detalles  = null;
        return $data;
    }
    $venta_modo = $consig->detalles->modo;
    
    // Generar el pago mediante CONSIGNACION
    $pago_respuesta = consignacion_generarPagoCONSIGNACION($carrito, $usuario, $escuela, $consignacion);
    if ($pago_respuesta->resultado == 'ERROR')
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $pago_respuesta->mensaje;
        $data->detalles  = null;
        return $data;
    }
    
    // ¿El registro del pago realmente existe?
    $rspta_idpago = $pago_respuesta->detalles->idpago;
    $pago_obj = new Pago();
    $pago     = $pago_obj->obtenerReferenciaPago($rspta_idpago);
    if (!$pago)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El registro del pago no fue encontrado!';
        $data->detalles  = null;
        return $data;
    }
    $reg_pago_tienda = $pago->pago_tienda;
    $reg_pago_proveedor = $pago->pago_proveedor;
    $reg_pago_referencia = $pago->pago_referencia;
    $reg_pago_total = $pago->pago_total;
    $reg_pago_concepto = $pago->pago_concepto;
    
    // Datos de la venta
    $venta_tipo = 'consignacion';
    $venta_tipo_rol = $carrito->detalles->tipo;
    $venta_fecha_hora = date('Y-m-d G:i:s');
    $venta_total_articulos = $carrito->detalles->total_articulos;
    $venta_subtotal = $carrito->detalles->subtotal_precio;
    $venta_descuento = $carrito->detalles->descuento_precio;
    $venta_impuesto = $carrito->detalles->impuesto_precio;
    $venta_envio = $carrito->detalles->total_envio;
    $venta_total = $carrito->detalles->total_precio;
    
    // Datos del comprador
    $comprador_nombre = $usuario->nombre . ' ' . $usuario->apellido_paterno . ' ' . $usuario->apellido_materno;
    $comprador_correo_electronico = $usuario->email;
    $comprador_matricula = $usuario->matricula;
    $comprador_telefono = $usuario->telefono;
    $comprador_entrega_a = '';
    $comprador_entrega_a .= 'Comprador: ' . $comprador_nombre . '\n';
    $comprador_entrega_a .= 'Correo Electrónico: ' . $comprador_correo_electronico . '\n';
    $comprador_entrega_a .= 'DNI: ' . $comprador_matricula . '\n';
    $comprador_entrega_a .= 'Télefono: ' . $comprador_telefono;
    
    // Datos de la escuela
    $entrega_nombre = $escuela->nombre;
    $entrega_campus = $escuela->campus;
    $entrega_calle = $escuela->calle . ($escuela->num_exterior ? ' # Exterior ' . $escuela->num_exterior : '') . ($escuela->num_interior ? ' # Interior ' . $escuela->num_interior : '');
    $entrega_ciudad = $escuela->ciudad;
    $entrega_estado = $escuela->estado;
    $entrega_codigo_postal = $escuela->codigo_postal;
    $entrega_entrega_en = '';
    $entrega_entrega_en .= 'Escuela: ' . $entrega_nombre . '\n';
    $entrega_entrega_en .= 'Calle: ' . $entrega_calle . '\n';
    $entrega_entrega_en .= 'Ciudad: ' . $entrega_ciudad . '\n';
    $entrega_entrega_en .= 'Estado: ' . $entrega_estado . '\n';
    $entrega_entrega_en .= 'Código Postal: ' . $entrega_codigo_postal;
    
    // Crear la venta
    $venta_obj = new Venta();
    $rspta_idventa = $venta_obj->crearVenta(
        $usuario_dominio_id,
        $usuario_escuela_id,
        $usuario_programa_id,
        $escuela_distribuidor_id,
        $curso_idcurso,
        $consignacion_idconsignacion,
        $idusuario,
        $idcarrito,
        $rspta_idpago,
        $venta_modo,
        $venta_tipo,
        $venta_tipo_rol,
        $venta_tipo_pago,
        $tienda,
        $reg_pago_tienda,
        $reg_pago_proveedor,
        $reg_pago_referencia,
        $reg_pago_total,
        $reg_pago_concepto,
        $entrega_entrega_en,
        $comprador_entrega_a,
        $entrega_nombre,
        $entrega_campus,
        $entrega_calle,
        $entrega_ciudad,
        $entrega_estado,
        $entrega_codigo_postal,
        $comprador_nombre,
        $comprador_correo_electronico,
        $comprador_matricula,
        $comprador_telefono,
        $venta_fecha_hora,
        $venta_fecha_entrega_prevista,
        $venta_total_articulos,
        $venta_subtotal,
        $venta_descuento,
        $venta_impuesto,
        $venta_envio,
        $venta_total
        );
    if ($rspta_idventa > 0)
    {
        // Asignar el ID de la venta al carrito
        $carrito_obj = new Carrito();
        $carrito_obj->actualizarCarritoEstablecerIDVentaIDPagoYCerrarCarrito($idcarrito, $rspta_idventa, $rspta_idpago);
        $carrito = obtenerCarrito($idcarrito);
        if ($carrito->resultado == 'OK')
        {
            // Convertir los detalles del carrito en detalles de la venta
            for ($i = 0; $i < count($carrito_detalles); $i++)
            {
                $det_idprograma = $carrito_detalles[$i]->idprograma;
                $det_idarticulo = $carrito_detalles[$i]->idarticulo;
                $det_articulo_nivel = $carrito_detalles[$i]->nivel;
                $det_articulo_nombre = $carrito_detalles[$i]->nombre;
                $det_articulo_descripcion = $carrito_detalles[$i]->descripcion;
                $det_cantidad = $carrito_detalles[$i]->cantidad;
                $det_precio = $carrito_detalles[$i]->precio;
                $det_descuento_porcentaje = $carrito_detalles[$i]->descuento_porcentaje;
                $det_descuento_valor = $carrito_detalles[$i]->descuento_valor;
                $det_precio_descuento = $carrito_detalles[$i]->precio_descuento;
                $det_precio_total = $carrito_detalles[$i]->precio_total;
                
                $rspta_detalle = $venta_obj->agregarArticuloAVenta(
                    $rspta_idventa,
                    $det_idprograma,
                    $det_idarticulo,
                    $det_articulo_nivel,
                    $det_articulo_nombre,
                    $det_articulo_descripcion,
                    $det_cantidad,
                    $det_precio,
                    $det_descuento_porcentaje,
                    $det_descuento_valor,
                    $det_precio_descuento,
                    $det_precio_total
                );
                if (!($rspta_detalle > 0))
                {
                    $data->resultado = 'ERROR';
                    $data->mensaje   = '¡Problema interno al convertir un detalle de carrito en detalle de venta!';
                    $data->detalles  = null;
                    return $data;
                }
            }
            
            // Establecer el estatus de la consignación
            $act_consignacion = new Consignacion();
            $rspta_act_consignacion = $act_consignacion->establecerConsignacionEstatusRevision($consignacion_idconsignacion, $rspta_idventa);
            $rspta_act_consignacion = $act_consignacion->establecerConsignacionCantidadRequerida($consignacion_idconsignacion, $venta_total_articulos);
            
            $detalles_venta = new stdClass();
            $detalles_venta->idventa = $rspta_idventa;
            $detalles_venta->idpago = $rspta_idpago;
            
            $referencia_tipo = 'Solicitud CONSIGNACION';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HEADER, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPGET, 1);
            curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_SEND_EMAILS_CONSIGNMENTS);
            curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
            curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
            curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($curl, CURLOPT_POSTFIELDS, ['consignmentID' => $rspta_idventa, 'type' => $referencia_tipo]);
            curl_exec($curl);
            if (curl_error($curl))
            {
                $error_msg = curl_error($curl);
            }
            if (!isset($error_msg))
            {
                $data->resultado = 'OK';
                $data->mensaje   = '¡Carrito convertido en venta!';
                $data->detalles  = $detalles_venta;
            }
            else
            {
                $data->resultado = 'ADVERTENCIA';
                $data->mensaje   = '¡Carrito convertido en venta, pero ocurrió un problema con la notificación!';
                $data->detalles  = $detalles_venta;
            }
            curl_close($curl);
            return $data;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡Problema interno al asignar el ID de venta y/o ID de pago al carrito!';
            $data->detalles  = null;
            return $data;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al crear el registro de venta!';
        $data->detalles  = null;
        return $data;
    }
}

?>