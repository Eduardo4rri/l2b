<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/CarritoRecompensas.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Recompensas.php';

// obtenerCarritoRecompensasDeUsuario($idusuario)
// Descripción:
// Obtiene los datos del carrito de recompensas de un usuario con propiedades customizadas sin prefijo
// Notas:
// Si el usuario no tiene un carrito de recompensas, se creará uno nuevo y le será asignado con las propiedades y permisos definidos por el rol del usuario
function obtenerCarritoRecompensasDeUsuario($idusuario)
{
    $usuario  = new Usuario();
    $carrito  = new CarritoRecompensas();
    $data     = new stdClass();
    $car      = new stdClass();
    $car_data = new stdClass();
    $usuario  = $usuario->obtenerUsuario($idusuario);
    if ($usuario)
    {
        $carrito_activo = $carrito->obtenerCarritoRecompensasActivoDeUsuario($idusuario);
        if ($carrito_activo)
        {
            $estatus_carrito = $carrito_activo->estatus;
            if ($estatus_carrito == 1)
            {
                $car->idcarrito         = $carrito_activo->idcarrito;
                $car->idusuario         = $carrito_activo->idusuario;
                $car->tipo              = $carrito_activo->tipo;
                $car->total_recompensas = $carrito_activo->total_articulos;
                $car->total_precio      = $carrito_activo->total_precio;
                $car->estatus           = $carrito_activo->estatus;
                $car_data               = obtenerCarritoRecompensasDetalle($carrito_activo->idcarrito);
                $car->detalles          = $car_data->detalles;
                $data->resultado        = 'OK';
                $data->mensaje          = '¡Carrito de recompensas del usuario disponible!';
                $data->detalles         = $car;
            }
            else if ($estatus_carrito == 0)
            {
                $rol              = $usuario->rol;
                $carrito_nuevo_id = 0;
                if ($rol == 'coordinador_dominio')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoRecompensasCoordinadorDominio($idusuario);
                }
                else if ($rol == 'coordinador_zona')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoRecompensasCoordinadorZona($idusuario);
                }
                else if ($rol == 'coordinador_subzona')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoRecompensasCoordinadorSubzona($idusuario);
                }
                else if ($rol == 'coordinador_escuela')
                {
                    $carrito_nuevo_id = $carrito->crearCarritoRecompensasCoordinadorEscuela($idusuario);
                }
                if ($carrito_nuevo_id > 0)
                {
                    $carrito_activo = $carrito->obtenerCarritoRecompensas($carrito_nuevo_id);
                    if ($carrito_activo)
                    {
                        $car->idcarrito         = $carrito_activo->idcarrito;
                        $car->idusuario         = $carrito_activo->idusuario;
                        $car->tipo              = $carrito_activo->tipo;
                        $car->total_recompensas = $carrito_activo->total_articulos;
                        $car->total_precio      = $carrito_activo->total_precio;
                        $car->estatus           = $carrito_activo->estatus;
                        $car_data               = obtenerCarritoRecompensasDetalle($carrito_activo->idcarrito);
                        $car->detalles          = $car_data->detalles;
                        $data->resultado        = 'OK';
                        $data->mensaje          = '¡Carrito de recompensas del usuario creado (carrito activo anterior cerrado)!';
                        $data->detalles         = $car;
                    }
                }
                else
                {
                    $data->resultado = 'ERROR';
                    $data->mensaje   = '¡Problema al crear el carrito de recompensas del usuario (carrito activo anterior cerrado)!';
                    $data->detalles  = null;
                }
            }
        }
        else
        {
            $rol              = $usuario->rol;
            $carrito_nuevo_id = 0;
            if ($rol == 'coordinador_dominio')
            {
                $carrito_nuevo_id = $carrito->crearCarritoRecompensasCoordinadorDominio($idusuario);
            }
            else if ($rol == 'coordinador_zona')
            {
                $carrito_nuevo_id = $carrito->crearCarritoRecompensasCoordinadorZona($idusuario);
            }
            else if ($rol == 'coordinador_subzona')
            {
                $carrito_nuevo_id = $carrito->crearCarritoRecompensasCoordinadorSubzona($idusuario);
            }
            else if ($rol == 'coordinador_escuela')
            {
                $carrito_nuevo_id = $carrito->crearCarritoRecompensasCoordinadorEscuela($idusuario);
            }
            if ($carrito_nuevo_id > 0)
            {
                $carrito_activo = $carrito->obtenerCarritoRecompensas($carrito_nuevo_id);
                if ($carrito_activo)
                {
                    $car->idcarrito         = $carrito_activo->idcarrito;
                    $car->idusuario         = $carrito_activo->idusuario;
                    $car->tipo              = $carrito_activo->tipo;
                    $car->total_recompensas = $carrito_activo->total_articulos;
                    $car->total_precio      = $carrito_activo->total_precio;
                    $car->estatus           = $carrito_activo->estatus;
                    $car_data               = obtenerCarritoRecompensasDetalle($carrito_activo->idcarrito);
                    $car->detalles          = $car_data->detalles;
                    $data->resultado        = 'OK';
                    $data->mensaje          = '¡Carrito de recompensas del usuario creado (carrito activo nuevo creado)!';
                    $data->detalles         = $car;
                }
            }
            else
            {
                $data->resultado = 'ERROR';
                $data->mensaje   = '¡Problema al crear el carrito de recompensas del usuario (carrito activo nuevo)!';
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

// obtenerCarritoRecompensas($idcarrito)
// Descripción:
// Obtiene los datos de un carrito de recompensas
// Notas:
// Incluye los detalles del carrito de recompensas (recompensas)
function obtenerCarritoRecompensas($idcarrito)
{
    $carrito  = new CarritoRecompensas();
    $data     = new stdClass();
    $car      = new stdClass();
    $car_data = new stdClass();
    $rspta    = $carrito->obtenerCarritoRecompensas($idcarrito);
    if ($rspta)
    {
        $car->idcarrito         = $rspta->idcarrito;
        $car->idusuario         = $rspta->idusuario;
        $car->tipo              = $rspta->tipo;
        $car->total_recompensas = $rspta->total_articulos;
        $car->total_precio      = $rspta->total_precio;
        $car->estatus           = $rspta->estatus;
        $car_data               = obtenerCarritoRecompensasDetalle($rspta->idcarrito);
        $car->detalles          = $car_data->detalles;
        $data->resultado        = 'OK';
        $data->mensaje          = '¡Carrito de recompensas disponible!';
        $data->detalles         = $car;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Carrito de recompensas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// validarCarritoRecompensas($idcarrito)
// Descripción:
// Valida un carrito de recompensas para pasar al paso de canje
// Notas:
// La validación consiste en revisar el estatus del carrito de recompensas y el número de recompensas en él
function validarCarritoRecompensas($idcarrito)
{
    $carrito  = new CarritoRecompensas();
    $data     = new stdClass();
    $car      = new stdClass();
    $car_data = new stdClass();
    $rspta    = $carrito->obtenerCarritoRecompensas($idcarrito);
    if ($rspta)
    {
        if ($rspta->estatus == 1)
        {
            $car_data = obtenerCarritoRecompensasDetalle($rspta->idcarrito);
            if ($car_data->resultado == 'OK' && count($car_data->detalles) > 0 && $rspta->total_precio > 0)
            {
                $data->resultado = 'OK';
                $data->mensaje   = '¡El carrito de recompensas está listo para canjearse!';
                $data->detalles  = $car;
            }
            else if ($car_data->resultado == 'OK' && count($car_data->detalles) == 0)
            {
                $data->resultado = 'ERROR';
                $data->mensaje   = '¡El carrito de recompensas está vacío!';
                $data->detalles  = null;
            }
            else if ($car_data->resultado == 'OK' && $rspta->total_precio == 0)
            {
                $data->resultado = 'ERROR';
                $data->mensaje   = '¡El carrito de recompensas no está actualizado!';
                $data->detalles  = null;
            }
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡El carrito de recompensas está cerrado!';
            $data->detalles  = null;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Carrito de recompensas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerCarritoRecompensasDetalle($idcarrito)
// Descripción:
// Obtiene los detalles (recompensas) de un carrito de recompensas con propiedades customizadas sin prefijo
// Notas:
// N/A
function obtenerCarritoRecompensasDetalle($idcarrito)
{
    $carrito = new CarritoRecompensas();
    $data    = new stdClass();
    $rspta   = $carrito->obtenerCarritoRecompensasDetalle($idcarrito);
    if ($rspta > 0)
    {
        $arts = Array();
        while ($reg = $rspta->fetch_object())
        {
            $entry                       = new stdClass();
            $entry->idcarrito_detalle    = $reg->idcarrito_detalle;
            $entry->idcarrito            = $reg->idcarrito;
            $entry->idrecompensa         = $reg->idrecompensa;
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
        $data->mensaje   = '¡Detalle del carrito de recompensas disponible!';
        $data->detalles  = $arts;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Detalle del carrito de recompensas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// h_obtenerRecompensa($idrecompensa)
// Descripción:
// Obtiene una recompensa con propiedades customizadas sin prefijo
// Notas:
// N/A
function h_obtenerRecompensa($idrecompensa)
{
    $recompensa = new Recompensas();
    $data       = new stdClass();
    $art        = new stdClass();
    $rspta      = $recompensa->obtenerRecompensa($idrecompensa);
    if ($rspta)
    {
        $art->iddominio    = $rspta->iddominio;
        $art->idrecompensa = $rspta->idrecompensa;
        $art->nombre       = $rspta->nombre;
        $art->categoria    = $rspta->categoria;
        $art->descripcion  = $rspta->descripcion;
        $art->costo        = $rspta->costo;
        $data->resultado   = 'OK';
        $data->mensaje     = '¡Recompensa disponible!';
        $data->detalles    = $art;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Recompensa no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// agregarRecompensaAlCarritoRecompensas($idcarrito, $idrecompensa, $cantidad)
// Descripción:
// Agrega una recompensa al carrito de recompensas y actualiza los totales
// Notas:
// Realiza validaciones para agregar o reemplazar una recompensa en el carrito de recompensas en base al tipo del carrito de recompensas
function agregarRecompensaAlCarritoRecompensas($idcarrito, $idrecompensa, $cantidad)
{
    $data                = new stdClass();
    $carrito             = obtenerCarritoRecompensas($idcarrito);
    $detalle_actualizado = false;
    $detalle_agregado    = false;
    $min_articulos       = 1;
    $max_recompensas     = 1000;
    if ($carrito->resultado == 'OK')
    {
        if ($carrito->detalles->estatus == 1)
        {
            $total_recompensas = $carrito->detalles->total_recompensas;
            $detalles          = $carrito->detalles->detalles;
            $encontrado        = false;
            for ($i = 0; $i < count($detalles); $i++)
            {
                if ($detalles[$i]->idrecompensa == $idrecompensa)
                {
                    $encontrado                   = true;
                    $encontrado_idcarrito_detalle = $detalles[$i]->idcarrito_detalle;
                    $encontrado_idrecompensa      = $detalles[$i]->idrecompensa;
                    $encontrado_cantidad          = $detalles[$i]->cantidad;
                    break;
                }
            }
            if ($encontrado == true)
            {
                $cantidad = $encontrado_cantidad + $cantidad;
                if ($cantidad > $max_recompensas)
                {
                    $data->resultado = 'ERROR';
                    $data->mensaje   = '¡La cantidad de recompensas excedería el límite permitido (máximo ' . $max_recompensas . ' recompensa(s)), no es posible agregar más recompensas!';
                    $data->detalles  = $carrito->detalles;
                    return $data;
                }
                else if ($cantidad < $min_articulos)
                {
                    $data->resultado = 'ERROR';
                    $data->mensaje   = '¡La cantidad de recompensas sería menor a la permitida (mínimo ' . $min_articulos . ' recompensa(s)), no es posible continuar, por favor revisa la cantidad deseada!';
                    $data->detalles  = $carrito->detalles;
                    return $data;
                }
                $articulo_recompensa   = h_obtenerRecompensa($encontrado_idrecompensa);
                $carrito_actualizar    = new CarritoRecompensas();
                $carrito_detalle_nuevo = $carrito_actualizar->actualizarRecompensaEnCarritoRecompensas($idcarrito, $encontrado_idcarrito_detalle, $idrecompensa, $articulo_recompensa->detalles->nombre, $articulo_recompensa->detalles->descripcion, $cantidad, $articulo_recompensa->detalles->costo, $articulo_recompensa->detalles->costo * $cantidad);
                $detalle_actualizado   = true;
            }
            else
            {
                $articulo_recompensa   = h_obtenerRecompensa($idrecompensa);
                $carrito_agregar       = new CarritoRecompensas();
                $carrito_detalle_nuevo = $carrito_agregar->agregarRecompensaAlCarritoRecompensas($idcarrito, $idrecompensa, $articulo_recompensa->detalles->nombre, $articulo_recompensa->detalles->descripcion, $cantidad, $articulo_recompensa->detalles->costo, $articulo_recompensa->detalles->costo * $cantidad);
                if ($carrito_detalle_nuevo > 0)
                {
                    $detalle_agregado = true;
                }
            }
            if ($detalle_actualizado == true || $detalle_agregado == true)
            {
                $carrito = obtenerCarritoRecompensas($idcarrito);
                if ($carrito->resultado == 'OK')
                {
                    $detalles          = $carrito->detalles->detalles;
                    $total_recompensas = 0;
                    $total_precio      = 0;
                    for ($i = 0; $i < count($detalles); $i++)
                    {
                        $total_recompensas += (float) $detalles[$i]->cantidad;
                        $total_precio += (float) $detalles[$i]->precio_total;
                    }
                    $carrito_act = new CarritoRecompensas();
                    $carrito_act->actualizarCarritoRecompensas($idcarrito, $total_recompensas, $total_precio);
                    $carrito = obtenerCarritoRecompensas($idcarrito);
                    if ($carrito->resultado == 'OK')
                    {
                        if ($detalle_actualizado == true)
                        {
                            $data->resultado = 'OK';
                            $data->mensaje   = '¡Recompensa actualizada en el carrito de recompensas!';
                            $data->detalles  = $carrito->detalles;
                        }
                        else if ($detalle_agregado == true)
                        {
                            $data->resultado = 'OK';
                            $data->mensaje   = '¡Recompensa agregada al carrito de recompensas!';
                            $data->detalles  = $carrito->detalles;
                        }
                    }
                    else
                    {
                        $data->resultado = 'ADVERTENCIA';
                        $data->mensaje   = '¡Problema interno al actualizar el carrito de recompensas posterior a agregar la recompensa!';
                        $data->detalles  = $carrito->detalles;
                    }
                }
                else
                {
                    $data->resultado = 'ADVERTENCIA';
                    $data->mensaje   = '¡Problema interno al obtener el carrito de recompensas posterior a agregar la recompensa!';
                    $data->detalles  = $carrito->detalles;
                }
            }
            else
            {
                $data->resultado = 'ADVERTENCIA';
                $data->mensaje   = '¡Problema interno al agregar la recompensa al carrito de recompensas! (m1=0)';
                $data->detalles  = $carrito->detalles;
            }
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡El carrito de recompensas no se encuentra abierto, no es posible agregar la recompensa!';
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

// eliminarRecompensaDelCarritoRecompensas($idcarrito, $idrecompensa)
// Descripción:
// Elimina una recompensa del carrito de recompensas y actualiza los totales
// Notas:
// Realiza validaciones para comprobar el estatus del carrito de recompensas y que este exista
function eliminarRecompensaDelCarritoRecompensas($idcarrito, $idrecompensa)
{
    $data    = new stdClass();
    $carrito = obtenerCarritoRecompensas($idcarrito);
    if ($carrito->resultado == 'OK')
    {
        if ($carrito->detalles->estatus == 1)
        {
            $carrito_actualizar    = new CarritoRecompensas();
            $carrito_detalle_nuevo = $carrito_actualizar->eliminarRecompensaDelCarritoRecompensas($idcarrito, $idrecompensa);
            $detalle_actualizado   = true;
            if ($detalle_actualizado == true || $detalle_agregado == true)
            {
                $carrito = obtenerCarritoRecompensas($idcarrito);
                if ($carrito->resultado == 'OK')
                {
                    $detalles          = $carrito->detalles->detalles;
                    $total_recompensas = 0;
                    $total_precio      = 0;
                    for ($i = 0; $i < count($detalles); $i++)
                    {
                        $total_recompensas += (float) $detalles[$i]->cantidad;
                        $total_precio += (float) $detalles[$i]->precio_total;
                    }
                    $carrito_act = new CarritoRecompensas();
                    $carrito_act->actualizarCarritoRecompensas($idcarrito, $total_recompensas, $total_precio);
                    $carrito = obtenerCarritoRecompensas($idcarrito);
                    if ($carrito->resultado == 'OK')
                    {
                        $data->resultado = 'OK';
                        $data->mensaje   = '¡Recompensa eliminada del carrito de recompensas!';
                        $data->detalles  = $carrito->detalles;
                    }
                    else
                    {
                        $data->resultado = 'ADVERTENCIA';
                        $data->mensaje   = '¡Problema interno al actualizar el carrito de recompensas posterior a eliminar la recompensa!';
                        $data->detalles  = $carrito->detalles;
                    }
                }
                else
                {
                    $data->resultado = 'ADVERTENCIA';
                    $data->mensaje   = '¡Problema interno al obtener el carrito de recompensas posterior a eliminar la recompensa!';
                    $data->detalles  = $carrito->detalles;
                }
            }
            else
            {
                $data->resultado = 'ADVERTENCIA';
                $data->mensaje   = '¡Problema interno al eliminar la recompensa del carrito de recompensas!';
                $data->detalles  = $carrito->detalles;
            }
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡El carrito de recompensas no se encuentra abierto, no es posible eliminar la recompensa!';
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

// vaciarCarritoRecompensas($idcarrito)
// Descripción:
// Vacía el carrito de recompensas y actualiza los totales
// Notas:
// Realiza validaciones para comprobar el estatus del carrito de recompensas y que este exista
function vaciarCarritoRecompensas($idcarrito)
{
    $carrito = new CarritoRecompensas();
    $data    = new stdClass();
    $rspta   = $carrito->vaciarCarritoRecompensas($idcarrito);
    if ($rspta)
    {
        $carrito_act = new CarritoRecompensas();
        $carrito_act->actualizarCarritoRecompensas($idcarrito, 0, 0);
        $carrito = obtenerCarritoRecompensas($idcarrito);
        if ($carrito->resultado == 'OK')
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡El carrito de recompensas se encuentra vacío!';
            $data->detalles  = $carrito->detalles;
        }
        else
        {
            $data->resultado = 'ADVERTENCIA';
            $data->mensaje   = '¡Problema interno al actualizar el carrito de recompensas posterior a haberlo vaciado!';
            $data->detalles  = $carrito->detalles;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al vaciar el carrito de recompensas!';
    }
    return $data;
}

// canjearCarritoRecompensas($idcarrito, $tarjeta_nombre, $tarjeta_numero, $tarjeta_expiracion_mes, $tarjeta_expiracion_anio, $tarjeta_cvv)
// Descripción:
// Canjea el carrito de recompensas, creará un registro de venta con estatus PENDIENTE
// Notas:
// El servicio se realiza en un servidor FileMaker externo para realizar el pago mediante un plugin y generá un PDF así bien bonito :3, también realiza las validaciones pertinentes
function canjearCarritoRecompensas($idcarrito, $tarjeta_nombre, $tarjeta_numero, $tarjeta_expiracion_mes, $tarjeta_expiracion_anio, $tarjeta_cvv)
{
    $data          = new stdClass();
    $curl          = curl_init();
    //curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => 'http://crm.wisdomlakes.com:8080/links2bo_books/api/crud/pay_cart.php', CURLOPT_POST => 1, CURLOPT_POSTFIELDS => ['cartID' => $idcarrito, 'cardName' => $tarjeta_nombre, 'cardNumber' => $tarjeta_numero, 'cardExpirationMonth' => $tarjeta_expiracion_mes, 'cardExpirationYear' => $tarjeta_expiracion_anio, 'cardCVV' => $tarjeta_cvv]]);
    $curl_response = json_decode(curl_exec($curl));
    $curl_error    = curl_error($curl);
    curl_close($curl);
    if ($curl_error)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $curl_error;
        $data->detalles  = null;
    }
    else if ($curl_response->fm_code == 0)
    {
        if ($curl_response->fm_result->result == 'OK')
        {
            $data->resultado = 'OK';
            $data->mensaje   = $curl_response->fm_message;
            $data->detalles  = $curl_response->fm_result->data;
        }
        if ($curl_response->fm_result->result == 'WARNING')
        {
            $data->resultado = 'WARNING';
            $data->mensaje   = $curl_response->fm_result->details;
            $data->detalles  = $curl_response->fm_result->data;
        }
        if ($curl_response->fm_result->result == 'ERROR')
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = $curl_response->fm_result->details;
            $data->detalles  = $curl_response->fm_result->data;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $curl_response->fm_message;
        $data->detalles  = null;
    }
    return $data;
}

?>