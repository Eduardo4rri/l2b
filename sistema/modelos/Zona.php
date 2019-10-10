<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Zona
{
    public function __construct()
    {
        
    }
    
    ///////////////////////////////////////////////////////
    // FUNCIONES ESPECIALES PARA COORDINADORES DE DOMINIO
    ///////////////////////////////////////////////////////
    
    // DOMINIO_obtenerZonasDeDominio($iddominio)
    // Descripción:
    // Obtiene zonas por dominio.
    // Notas:
    // N/A
    public function DOMINIO_obtenerZonasDeDominio($iddominio)
    {
        $sql = "SELECT DISTINCT(z.idzona), z.nombre, z.color_hex FROM zona z WHERE z.iddominio = '$iddominio'";
        return ejecutarConsulta($sql);
    }
    
    // DOMINIO_obtenerSubzonasDeZona($idzona)
    // Descripción:
    // Obtiene subzonas por dominio.
    // Notas:
    // N/A
    public function DOMINIO_obtenerSubzonasDeZona($idzona)
    {
        $sql = "SELECT DISTINCT(sz.idsubzona), sz.idestado, sz.estado_codigo, sz.estado_nombre FROM subzona sz WHERE sz.idzona = '$idzona'";
        return ejecutarConsulta($sql);
    }
    
    // DOMINIO_obtenerEscuelasDeSubzona($idsubzona)
    // Descripción:
    // Obtiene escuelas de la subzona
    // Notas:
    // N/A
    public function DOMINIO_obtenerEscuelasDeSubzona($idsubzona)
    {
        $sql = "SELECT DISTINCT(e.idescuela), e.alias, e.nombre, e.ciudad, e.estado, d.nombre AS 'distribuidor', e.fecha_placement_test_inicio AS placement_test, e.fecha_curso_inicio AS curso_periodo, e.fecha_entrega_venta_en_linea_inicio AS entrega_material FROM ( ( escuela e LEFT JOIN distribuidor d ON e.iddistribuidor = d.iddistribuidor ) LEFT JOIN subzona_escuela sze ON sze.idescuela = e.idescuela ) WHERE sze.idsubzona = '$idsubzona'";
        return ejecutarConsulta($sql);
    }
    
    ////////////////////////////////////////////////////
    // FUNCIONES ESPECIALES PARA COORDINADORES DE ZONA
    ////////////////////////////////////////////////////
    
    // ZONA_obtenerZonasDeUsuarioCoordinadorDeZona($idusuario)
    // Descripción:
    // Obtiene las zonas del usuario coordinador de zona
    // Notas:
    // N/A
    public function ZONA_obtenerZonasDeUsuarioCoordinadorDeZona($idusuario)
    {
        $sql = "SELECT DISTINCT(z.idzona), z.nombre AS zona, z.color_hex FROM nav_usuario nu LEFT JOIN zona z ON z.idzona = nu.idzona WHERE nu.idusuario = '$idusuario'";
        //SELECT DISTINCT(z.idzona), z.nombre, z.color_hex FROM zona z WHERE z.idusuario = '$idusuario'
        return ejecutarConsulta($sql);
    }
    
    // ZONA_obtenerSubzonasDeZona($idzona)
    // Descripción:
    // Obtiene las subzonas de la zona
    // Notas:
    // N/A
    public function ZONA_obtenerSubzonasDeZona($idzona)
    {
        $sql = "SELECT DISTINCT(sz.idsubzona), sz.idestado, sz.estado_codigo, sz.estado_nombre FROM subzona sz WHERE sz.idzona = '$idzona'";
        return ejecutarConsulta($sql);
    }
    
    // ZONA_obtenerEscuelasDeSubzona($idsubzona)
    // Descripción:
    // Obtiene las escuelas de la subzona
    // Notas:
    // N/A
    public function ZONA_obtenerEscuelasDeSubzona($idsubzona)
    {
        $sql = "SELECT DISTINCT(e.idescuela), e.alias, e.nombre, e.ciudad, e.estado, d.nombre AS 'distribuidor', e.fecha_placement_test_inicio AS placement_test, e.fecha_curso_inicio AS curso_periodo, e.fecha_entrega_venta_en_linea_inicio AS entrega_material FROM ( ( escuela e LEFT JOIN distribuidor d ON e.iddistribuidor = d.iddistribuidor ) LEFT JOIN subzona_escuela sze ON sze.idescuela = e.idescuela ) WHERE sze.idsubzona = '$idsubzona'";
        return ejecutarConsulta($sql);
    }
    
    ///////////////////////////////////////////////////////
    // FUNCIONES ESPECIALES PARA COORDINADORES DE SUBZONA
    ///////////////////////////////////////////////////////
    
    // SUBZONA_obtenerZonasDeUsuarioCoordinadorDeSubzona($idusuario)
    // Descripción:
    // Obtiene zonas de usuario coordinador de subzona
    // Notas:
    // N/A
    public function SUBZONA_obtenerZonasDeUsuarioCoordinadorDeSubzona($idusuario)
    {
        
        $sql = "SELECT DISTINCT(z.idzona), z.nombre, z.color_hex FROM nav_usuario nu LEFT JOIN zona z ON z.idzona = nu.idzona JOIN subzona sz ON z.idzona = sz.idzona WHERE nu.idusuario = '$idusuario'";
        //SELECT DISTINCT(z.idzona), z.nombre, z.color_hex FROM zona z JOIN subzona sz ON z.idzona = sz.idzona WHERE sz.idusuario =
        return ejecutarConsulta($sql);
    }
    
    // SUBZONA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeSubzona($idzona, $idusuario)
    // Descripción:
    // Obtiene las subzonas por zona y por usuario coordinador de subzona
    // Notas:
    // N/A
    public function SUBZONA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeSubzona($idzona, $idusuario)
    {
        $sql = "SELECT DISTINCT(sz.idsubzona), sz.idestado, sz.estado_codigo, sz.estado_nombre FROM nav_usuario nu LEFT JOIN subzona sz ON sz.idzona = nu.idzona WHERE nu.idzona = '$idzona' AND nu.idusuario = '$idusuario'";
        //SELECT DISTINCT(sz.idsubzona), sz.idestado, sz.estado_codigo, sz.estado_nombre FROM subzona sz WHERE sz.idzona = '$idzona' AND sz.idusuario = '$idusuario'
        return ejecutarConsulta($sql);
    }
    
    // SUBZONA_obtenerEscuelasDeSubzona($idsubzona)
    // Descripción:
    // Obtiene las escuelas de las subzonas 
    // Notas:
    // N/A
    public function SUBZONA_obtenerEscuelasDeSubzona($idsubzona)
    {
        $sql = "SELECT DISTINCT(e.idescuela), e.alias, e.nombre, e.ciudad, e.estado, d.nombre AS 'distribuidor', e.fecha_placement_test_inicio AS placement_test, e.fecha_curso_inicio AS curso_periodo, e.fecha_entrega_venta_en_linea_inicio AS entrega_material FROM ( ( escuela e LEFT JOIN distribuidor d ON e.iddistribuidor = d.iddistribuidor ) LEFT JOIN subzona_escuela sze ON sze.idescuela = e.idescuela ) WHERE sze.idsubzona = '$idsubzona'";
        return ejecutarConsulta($sql);
    }
    
    ///////////////////////////////////////////////////////
    // FUNCIONES ESPECIALES PARA COORDINADORES DE ESCUELA
    ///////////////////////////////////////////////////////
    
    // ESCUELA_obtenerZonasDeUsuarioCoordinadorDeEscuela($idusuario)
    // Descripción:
    // Obtiene escuelas del usuario coordinador de zona por subzonas
    // Notas:
    // N/A
    public function ESCUELA_obtenerZonasDeUsuarioCoordinadorDeEscuela($idusuario)
    {
        $sql = "SELECT DISTINCT(z.idzona), z.nombre, z.color_hex FROM nav_usuario nu LEFT JOIN zona z ON z.idzona = nu.idzona JOIN subzona sz ON nu.idzona = sz.idzona JOIN subzona_escuela sze ON sz.idsubzona = sze.idsubzona WHERE nu.idusuario = '$idusuario'";
        //SELECT DISTINCT(z.idzona), z.nombre, z.color_hex FROM (zona z JOIN subzona sz ON z.idzona = sz.idzona) JOIN subzona_escuela sze ON sz.idsubzona = sze.idsubzona WHERE sz.idusuario = '$idusuario'
        return ejecutarConsulta($sql);
    }
    
    // ESCUELA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeEscuela($idzona, $idusuario)
    // Descripción:
    // Obtiene las escuelas de la subzona del usuario coordinador de zona
    // Notas:
    // N/A
    public function ESCUELA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeEscuela($idzona, $idusuario)
    {
        $sql = "SELECT DISTINCT(sz.idsubzona), sz.idestado, sz.estado_codigo, sz.estado_nombre FROM nav_usuario nu LEFT JOIN subzona sz ON sz.idzona = nu.idzona JOIN subzona_escuela sze ON sz.idsubzona = sze.idsubzona WHERE nu.idzona = '$idzona' AND nu.idusuario = '$idusuario'";
        //SELECT DISTINCT(sz.idsubzona), sz.idestado, sz.estado_codigo, sz.estado_nombre FROM subzona sz JOIN subzona_escuela sze ON sz.idsubzona = sze.idsubzona WHERE sz.idzona = '$idzona' AND sze.idusuario = '$idusuario'
        return ejecutarConsulta($sql);
    }
    
    // ESCUELA_obtenerEscuelasDeSubzonaDeUsuarioCoordinadorDeEscuela($idsubzona, $idusuario)
    // Descripción:
    // Obtiene escuelas del usuario coordinador de subzona
    // Notas:
    // N/A
    public function ESCUELA_obtenerEscuelasDeSubzonaDeUsuarioCoordinadorDeEscuela($idsubzona, $idusuario)
    {
        $sql = "SELECT DISTINCT(e.idescuela), e.alias, e.nombre, e.ciudad, e.estado, d.nombre AS 'distribuidor', e.fecha_placement_test_inicio AS placement_test, e.fecha_curso_inicio AS curso_periodo, e.fecha_entrega_venta_en_linea_inicio AS entrega_material FROM nav_usuario nu LEFT JOIN subzona_escuela se ON se.idsubzona = nu.idsubzona JOIN escuela e ON se.idescuela = e.idescuela LEFT JOIN distribuidor d ON e.iddistribuidor = d.iddistribuidor WHERE se.idsubzona = '$idsubzona' AND nu.idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }
}

?>