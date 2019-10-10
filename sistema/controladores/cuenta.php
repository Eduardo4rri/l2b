<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Cuenta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Venta.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/VentaNivel.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Escuela.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Curso.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Consignacion.php';

//////////////////////////
// FUNCIONES PARA ALUMNOS
//////////////////////////

// listarVentasDeAlumno($idalumno)
// Descripción:
// Obtiene una lista de las ventas de un alumno de tipo VENTA
// Notas:
// Corregido para tipo de venta
function listarVentasDeAlumno($idalumno)
{
    $cuenta = new Cuenta();
    $data   = new stdClass();
    $rspta  = $cuenta->listarVentasDeAlumno($idalumno);
    if ($rspta)
    {
        $ventas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($ventas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de ventas disponible!';
        $data->detalles  = $ventas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de ventas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// listarVentasDeAlumnoPorCurso($idalumno, $idcurso)
// Descripción:
// Obtiene una lista de los ventas de un alumno de tipo VENTA en un curso
// Notas:
// Corregido para tipo de venta
function listarVentasDeAlumnoPorCurso($idalumno, $idcurso)
{
    $cuenta = new Cuenta();
    $data   = new stdClass();
    $rspta  = $cuenta->listarVentasDeAlumnoPorCurso($idalumno, $idcurso);
    if ($rspta)
    {
        $ventas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($ventas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de ventas disponible!';
        $data->detalles  = $ventas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de ventas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

/////////////////////////////////
// FUNCIONES PARA COORDINADORES
/////////////////////////////////

// listarVentasDeCoordinadorPorEscuelaYCurso($idescuela, $idcurso)
// Descripción:
// Obtiene una lista de los ventas de un coordinador de tipo CONSIGNACION en una escuela y en un curso
// Notas:
// Corregido para tipo de venta
function listarVentasDeCoordinadorPorEscuelaYCurso($idescuela, $idcurso)
{
    $consignacion = new Consignacion();
    $data   = new stdClass();
    $consignaciones = $consignacion->obtenerTodasConsignacionesAprobadasPorIDCurso($idcurso);
    if (!$consignaciones)
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de consignaciones no disponible!';
        $data->detalles  = null;
        return $data;
    }
    $arreglo_consignaciones_ventas = Array();
    while ($reg = $consignaciones->fetch_object())
    {
        $c   = $reg;
        $consignacion_idconsignacion = $c->idconsignacion;
        $ventas = obtenerVentasEnConsignacion($idescuela, $idcurso, $consignacion_idconsignacion);
        array_push($arreglo_consignaciones_ventas, $ventas->detalles);
    }
    $data->resultado = 'OK';
    $data->mensaje   = '¡Lista de ventas disponible!';
    $data->detalles  = $arreglo_consignaciones_ventas;
    return $data;
}

// obtenerVentasEnConsignacion($idescuela, $idcurso, $idconsignacion)
// Descripción:
// Obtiene una lista de los ventas en una escuela en un curso y en una consignación
// Notas:
// Corregido para tipo de venta
function obtenerVentasEnConsignacion($idescuela, $idcurso, $idconsignacion)
{
    $data  = new stdClass();
    $thot  = new stdClass();
    
    // Obtener los datos de la escuela
    $escuela = new Escuela();
    $escuela_datos = $escuela->obtenerEscuela($idescuela);
    $thot->idescuela = $idescuela;
    $thot->escuela_alias = $escuela_datos->alias;
    $thot->escuela_nombre = $escuela_datos->nombre;
    $thot->idcurso = $idcurso;
    $thot->idconsignacion = $idconsignacion;
    
    // Obtener los datos del curso
    $curso = new Curso();
    $curso_datos = $curso->obtenerCurso($idcurso);
    $thot->curso_nombre = $curso_datos->nombre;
    
    // Obtener los datos de la consignación
    $consignacion = new Consignacion();
    $consignacion_datos = $consignacion->obtenerConsignacion($idconsignacion);
    
    // Obtener los niveles de la consignacion
    $consignacion_idventa = $consignacion_datos->idventa;
    $thot->idventa = $consignacion_idventa;
    $consignacion_niveles = $consignacion->obtenerConsignacionVentaDetalles($consignacion_idventa);
    
    // Por cada nivel de la consignación, obtener las ventas
    $arreglo_consignaciones_niveles = Array();
    while ($reg = $consignacion_niveles->fetch_object())
    {
        $thot_nivel = new stdClass();
        
        $concepto_nivel = $reg->articulo_nivel;
        $thot_nivel->nivel = $concepto_nivel;
        
        $rspta_totales_solicitados = $consignacion->obtenerConsignacionVentaDetallesNivel($consignacion_idventa, $concepto_nivel)->cantidad;
        
        // estatus 0 = PENDIENTE
        // estatus 1 = PAGADA
        // estatus entrega 0 = SIN ENTREGAR
        // estatus entrega 1 = ENTREGADO
        
        $venta = new VentaNivel();
        $rspta_totales  = $venta->obtenerVentasEscuelaCursoConsignacionNivel($idescuela, $idcurso, $idconsignacion, $concepto_nivel);
        $rspta_pagadas  = $venta->obtenerVentasEscuelaCursoConsignacionEstatusNivel($idescuela, $idcurso, $idconsignacion, 1, $concepto_nivel);
        $rspta_por_pagar  = $venta->obtenerVentasEscuelaCursoConsignacionEstatusNivel($idescuela, $idcurso, $idconsignacion, 0, $concepto_nivel);
        $rspta_entregadas  = $venta->obtenerVentasEscuelaCursoConsignacionEstatusEntregaNivel($idescuela, $idcurso, $idconsignacion, 1, $concepto_nivel);
        $rspta_por_entregar  = $venta->obtenerVentasEscuelaCursoConsignacionEstatusEntregaNivel($idescuela, $idcurso, $idconsignacion, 0, $concepto_nivel);
        
        $totales_datos = Array();
        $thot_nivel->totales_total = 0;
        if ($rspta_totales)
        {
            while ($reg = $rspta_totales->fetch_object())
            {
                array_push($totales_datos, $reg);
            }
            $thot_nivel->totales_total = count($totales_datos);
        }
        
        $pagadas_datos = Array();
        $thot_nivel->totales_pagadas = 0;
        if ($rspta_pagadas)
        {
            while ($reg = $rspta_pagadas->fetch_object())
            {
                array_push($pagadas_datos, $reg);
            }
            $thot_nivel->totales_pagadas = count($pagadas_datos);
        }
        
        $por_pagar_datos = Array();
        $thot_nivel->totales_por_pagar = 0;
        if ($rspta_por_pagar)
        {
            while ($reg = $rspta_por_pagar->fetch_object())
            {
                array_push($por_pagar_datos, $reg);
            }
            $thot_nivel->totales_por_pagar = count($por_pagar_datos);
        }
        
        $entregadas_datos = Array();
        $thot_nivel->totales_entregadas = 0;
        if ($rspta_entregadas)
        {
            while ($reg = $rspta_entregadas->fetch_object())
            {
                array_push($entregadas_datos, $reg);
            }
            $thot_nivel->totales_entregadas = count($entregadas_datos);
        }
        
        $por_entregar_datos = Array();
        $thot_nivel->totales_por_entregar = 0;
        if ($rspta_por_entregar)
        {
            while ($reg = $rspta_por_entregar->fetch_object())
            {
                array_push($por_entregar_datos, $reg);
            }
            $thot_nivel->totales_por_entregar = count($por_entregar_datos);
        }
        
        $thot_nivel->totales_solicitados = $rspta_totales_solicitados;
        $thot_nivel->totales_inventario = $thot_nivel->totales_solicitados - $thot_nivel->totales_entregadas;
        $thot_nivel->ventas = $totales_datos;
        array_push($arreglo_consignaciones_niveles, $thot_nivel);
    }
    
    $venta = new VentaNivel();
    $rspta_nivel_por_asignar  = $venta->obtenerVentasEscuelaCursoConsignacionNivelPorAsignar($idescuela, $idcurso, $idconsignacion);
    $nivel_por_asignar_datos = Array();
    $thot->totales_nivel_por_asignar = 0;
    if ($rspta_nivel_por_asignar)
    {
        while ($reg = $rspta_nivel_por_asignar->fetch_object())
        {
            array_push($nivel_por_asignar_datos, $reg);
        }
        $thot->totales_nivel_por_asignar = count($nivel_por_asignar_datos);
    }
    $rspta_no_pagadas_nivel_por_asignar  = $venta->obtenerVentasEscuelaCursoConsignacionNivelPorAsignarEstatus($idescuela, $idcurso, $idconsignacion, 0);
    $no_pagadas_nivel_por_asignar_datos = Array();
    $thot->totales_nivel_por_asignar_no_pagadas = 0;
    if ($rspta_no_pagadas_nivel_por_asignar)
    {
        while ($reg = $rspta_no_pagadas_nivel_por_asignar->fetch_object())
        {
            array_push($no_pagadas_nivel_por_asignar_datos, $reg);
        }
        $thot->totales_nivel_por_asignar_no_pagadas = count($no_pagadas_nivel_por_asignar_datos);
    }
    $rspta_pagadas_nivel_por_asignar  = $venta->obtenerVentasEscuelaCursoConsignacionNivelPorAsignarEstatus($idescuela, $idcurso, $idconsignacion, 1);
    $pagadas_nivel_por_asignar_datos = Array();
    $thot->totales_nivel_por_asignar_pagadas = 0;
    if ($rspta_pagadas_nivel_por_asignar)
    {
        while ($reg = $rspta_pagadas_nivel_por_asignar->fetch_object())
        {
            array_push($pagadas_nivel_por_asignar_datos, $reg);
        }
        $thot->totales_nivel_por_asignar_pagadas = count($pagadas_nivel_por_asignar_datos);
    }
    
    $thot->niveles = $arreglo_consignaciones_niveles;
    $data->resultado = 'OK';
    $data->mensaje   = '¡Lista de ventas disponible!';
    $data->detalles  = $thot;
    return $data;
}

// obtenerVentasEnConsignacionParaEntrega($idescuela, $idcurso, $idconsignacion)
// Descripción:
// Obtiene una lista de los ventas en una escuela en un curso y en una consignación para la entrega
// Notas:
// Corregido para tipo de venta
function obtenerVentasEnConsignacionParaEntrega($idescuela, $idcurso, $idconsignacion)
{
    $data  = new stdClass();
    $thot  = new stdClass();
    
    // Obtener los datos de la escuela
    $escuela = new Escuela();
    $escuela_datos = $escuela->obtenerEscuela($idescuela);
    $thot->escuela_alias = $escuela_datos->alias;
    $thot->escuela_nombre = $escuela_datos->nombre;
    
    // Obtener los datos del curso
    $curso = new Curso();
    $curso_datos = $curso->obtenerCurso($idcurso);
    $thot->curso_nombre = $curso_datos->nombre;
    
    // Obtener los datos de la consignación
    $consignacion = new Consignacion();
    $consignacion_datos = $consignacion->obtenerConsignacion($idconsignacion);
    
    // estatus 0 = PENDIENTE
    // estatus 1 = PAGADA
    // estatus entrega 0 = SIN ENTREGAR
    // estatus entrega 1 = ENTREGADO
    
    $venta = new Venta();
    $rspta_totales  = $venta->obtenerVentasEscuelaCursoConsignacion($idescuela, $idcurso, $idconsignacion);
    $rspta_pagadas  = $venta->obtenerVentasEscuelaCursoConsignacionEstatus($idescuela, $idcurso, $idconsignacion, 1);
    $rspta_por_pagar  = $venta->obtenerVentasEscuelaCursoConsignacionEstatus($idescuela, $idcurso, $idconsignacion, 0);
    $rspta_entregadas  = $venta->obtenerVentasEscuelaCursoConsignacionEstatusEntrega($idescuela, $idcurso, $idconsignacion, 1);
    $rspta_por_entregar  = $venta->obtenerVentasEscuelaCursoConsignacionEstatusEntrega($idescuela, $idcurso, $idconsignacion, 0);
    
    $thot->totales_solicitados = $consignacion_datos->cantidad_requerida;
    
    $totales_datos = Array();
    $thot->totales_total = 0;
    if ($rspta_totales)
    {
        while ($reg = $rspta_totales->fetch_object())
        {
            array_push($totales_datos, $reg);
        }
        $thot->totales_total = count($totales_datos);
    }
    
    $pagadas_datos = Array();
    $thot->totales_pagadas = 0;
    if ($rspta_pagadas)
    {
        while ($reg = $rspta_pagadas->fetch_object())
        {
            array_push($pagadas_datos, $reg);
        }
        $thot->totales_pagadas = count($pagadas_datos);
    }
    
    $por_pagar_datos = Array();
    $thot->totales_por_pagar = 0;
    if ($rspta_por_pagar)
    {
        while ($reg = $rspta_por_pagar->fetch_object())
        {
            array_push($por_pagar_datos, $reg);
        }
        $thot->totales_por_pagar = count($por_pagar_datos);
    }
    
    $entregadas_datos = Array();
    $thot->totales_entregadas = 0;
    if ($rspta_entregadas)
    {
        while ($reg = $rspta_entregadas->fetch_object())
        {
            array_push($entregadas_datos, $reg);
        }
        $thot->totales_entregadas = count($entregadas_datos);
    }
    
    $por_entregar_datos = Array();
    $thot->totales_por_entregar = 0;
    if ($rspta_por_entregar)
    {
        while ($reg = $rspta_por_entregar->fetch_object())
        {
            array_push($por_entregar_datos, $reg);
        }
        $thot->totales_por_entregar = count($por_entregar_datos);
    }
    
    $rspta_nivel_por_asignar  = $venta->obtenerVentasEscuelaCursoConsignacionNivelPorAsignar($idescuela, $idcurso, $idconsignacion);
    $nivel_por_asignar_datos = Array();
    $thot->totales_nivel_por_asignar = 0;
    if ($rspta_nivel_por_asignar)
    {
        while ($reg = $rspta_nivel_por_asignar->fetch_object())
        {
            array_push($nivel_por_asignar_datos, $reg);
        }
        $thot->totales_nivel_por_asignar = count($nivel_por_asignar_datos);
    }
    $rspta_no_pagadas_nivel_por_asignar  = $venta->obtenerVentasEscuelaCursoConsignacionNivelPorAsignarEstatus($idescuela, $idcurso, $idconsignacion, 0);
    $no_pagadas_nivel_por_asignar_datos = Array();
    $thot->totales_nivel_por_asignar_no_pagadas = 0;
    if ($rspta_no_pagadas_nivel_por_asignar)
    {
        while ($reg = $rspta_no_pagadas_nivel_por_asignar->fetch_object())
        {
            array_push($no_pagadas_nivel_por_asignar_datos, $reg);
        }
        $thot->totales_nivel_por_asignar_no_pagadas = count($no_pagadas_nivel_por_asignar_datos);
    }
    $rspta_pagadas_nivel_por_asignar  = $venta->obtenerVentasEscuelaCursoConsignacionNivelPorAsignarEstatus($idescuela, $idcurso, $idconsignacion, 1);
    $pagadas_nivel_por_asignar_datos = Array();
    $thot->totales_nivel_por_asignar_pagadas = 0;
    if ($rspta_pagadas_nivel_por_asignar)
    {
        while ($reg = $rspta_pagadas_nivel_por_asignar->fetch_object())
        {
            array_push($pagadas_nivel_por_asignar_datos, $reg);
        }
        $thot->totales_nivel_por_asignar_pagadas = count($pagadas_nivel_por_asignar_datos);
    }
    
    $thot->idescuela = $idescuela;
    $thot->idcurso = $idcurso;
    $thot->idconsignacion = $idconsignacion;
    $thot->idventa = $consignacion_datos->idventa;
    $thot->totales_inventario = $consignacion_datos->cantidad_requerida - $thot->totales_entregadas;
    $thot->ventas = $totales_datos;
    
    $data->resultado = 'OK';
    $data->mensaje   = '¡Lista de ventas disponible!';
    $data->detalles  = $thot;
    return $data;
}

//////////////////////////////////
// FUNCIONES GENÉRICAS
/////////////////////////////////

// enviarMensajeDeAyuda($idusuario, $nombre, $correo, $datos_adicionales)
// Descripción:
// Envia mensaje de ayuda de los usuarios
// Notas:
// Se usa cuando el usuario tenga dudas o problemas con la plataforma
function enviarMensajeDeAyuda($idusuario, $nombre, $correo, $datos_adicionales)
{
    $cuenta = new Cuenta();
    $data    = new stdClass();
    $rspta   = $cuenta->enviarMensajeDeAyuda($idusuario, $nombre, $correo, $datos_adicionales);
    if ($rspta > 0)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_SEND_EMAILS_HELP);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['helpID' => $rspta]);
        curl_exec($curl);
        if (curl_error($curl))
        {
            $error_msg = curl_error($curl);
        }
        if (!isset($error_msg))
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡Solicitud de ayuda enviada!';
            $data->detalles  = null;
        }
        else
        {
            $data->resultado = 'ADVERTENCIA';
            $data->mensaje   = '¡Solicitud de ayuda enviada, pero ocurrió un problema con la notificación!';
            $data->detalles  = null;
        }
        curl_close($curl);
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al guardar la solicitud de ayuda!';
        $data->detalles  = null;
    }
    return $data;
}

?>