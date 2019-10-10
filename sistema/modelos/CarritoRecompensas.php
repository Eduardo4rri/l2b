<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class CarritoRecompensas
{
    public function __construct()
    {
        
    }
    
    // crearCarritoRecompensasCoordinadorDominio($idcoordinador)
    // Descripción:
    // Crea el carrito de recompensas para el coordinador de dominio.
    // Notas:
    // N/A
    public function crearCarritoRecompensasCoordinadorDominio($idcoordinador)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo, activo) VALUES ('$idcoordinador', 'coordinador_dominio_recompensas', '0', '1')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // crearCarritoRecompensasCoordinadorZona($idcoordinador)
    // Descripción:
    // Crea el carrito de recompensas para el coordinador de zona.
    // Notas:
    // N/A
    public function crearCarritoRecompensasCoordinadorZona($idcoordinador)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo, activo) VALUES ('$idcoordinador', 'coordinador_zona_recompensas', '0', '1')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // crearCarritoRecompensasCoordinadorSubzona($idcoordinador)
    // Descripción:
    // Crea el carrito de recompensas para el coordinador de subzona.
    // Notas:
    // N/A
    public function crearCarritoRecompensasCoordinadorSubzona($idcoordinador)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo, activo) VALUES ('$idcoordinador', 'coordinador_subzona_recompensas', '0', '1')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // crearCarritoRecompensasCoordinadorEscuela($idcoordinador)
    // Descripción:
    // Crea el carrito de recompensas para el coordinador de escuela.
    // Notas:
    // N/A
    public function crearCarritoRecompensasCoordinadorEscuela($idcoordinador)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo, activo) VALUES ('$idcoordinador', 'coordinador_escuela_recompensas', '0', '1')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // obtenerCarritoRecompensasDeUsuario($idusuario)
    // Descripción:
    // Obtiene el carrito de recompensas del usuario.
    // Notas:
    // N/A
    public function obtenerCarritoRecompensasDeUsuario($idusuario)
    {
        $sql = "SELECT * FROM carrito c WHERE c.idusuario = '$idusuario' AND (c.tipo = 'coordinador_dominio_recompensas' OR c.tipo = 'coordinador_zona_recompensas' OR c.tipo = 'coordinador_subzona_recompensas' OR c.tipo = 'coordinador_escuela_recompensas')";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerCarritoRecompensas($idcarrito)
    // Descripción:
    // Obtiene el carrito de recompensas.
    // Notas:
    // N/A
    public function obtenerCarritoRecompensas($idcarrito)
    {
        $sql = "SELECT * FROM carrito c WHERE c.idcarrito = '$idcarrito' AND (c.tipo = 'coordinador_dominio_recompensas' OR c.tipo = 'coordinador_zona_recompensas' OR c.tipo = 'coordinador_subzona_recompensas' OR c.tipo = 'coordinador_escuela_recompensas')";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerCarritoRecompensasActivoDeUsuario($idusuario)
    // Descripción:
    // Obtiene el carrito de recompensas del usuario si el carrito esta activo.
    // Notas:
    // N/A
    public function obtenerCarritoRecompensasActivoDeUsuario($idusuario)
    {
        $sql = "SELECT * FROM carrito c WHERE c.idusuario = '$idusuario' AND c.activo = 1 AND (c.tipo = 'coordinador_dominio_recompensas' OR c.tipo = 'coordinador_zona_recompensas' OR c.tipo = 'coordinador_subzona_recompensas' OR c.tipo = 'coordinador_escuela_recompensas')";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerCarritoRecompensasActivo($idcarrito)
    // Descripción:
    // Obtiene el carrito de recompensas si esta activo.
    // Notas:
    // N/A
    public function obtenerCarritoRecompensasActivo($idcarrito)
    {
        $sql = "SELECT * FROM carrito c WHERE c.idcarrito = '$idcarrito' AND c.activo = 1 AND (c.tipo = 'coordinador_dominio_recompensas' OR c.tipo = 'coordinador_zona_recompensas' OR c.tipo = 'coordinador_subzona_recompensas' OR c.tipo = 'coordinador_escuela_recompensas')";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerCarritoRecompensasDetalle($idcarrito)
    // Descripción:
    // Obtiene el detalle del carrito de recompensas.
    // Notas:
    // N/A
    public function obtenerCarritoRecompensasDetalle($idcarrito)
    {
        $sql = "SELECT * FROM carrito_detalle c_d WHERE c_d.idcarrito = '$idcarrito'";
        return ejecutarConsulta($sql);
    }
    
    // agregarRecompensaAlCarritoRecompensas($idcarrito, $idrecompensa, $nombre, $descripcion, $cantidad, $precio, $precio_total)
    // Descripción:
    // Agrega recompensas a un carrito de recompensas.
    // Notas:
    // N/A
    public function agregarRecompensaAlCarritoRecompensas($idcarrito, $idrecompensa, $nombre, $descripcion, $cantidad, $precio, $precio_total)
    {
        $sql = "INSERT INTO carrito_detalle (idcarrito, idprograma, idarticulo, idrecompensa, nombre, descripcion, cantidad, precio, precio_total) VALUES ('$idcarrito', '-1', '-1', '$idrecompensa', '$nombre', '$descripcion', $cantidad, $precio, $precio_total)";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // eliminarRecompensaDelCarritoRecompensas($idcarrito, $idrecompensa)
    // Descripción:
    // Eliminar recompensas a un carrito de recompensas.
    // Notas:
    // N/A
    public function eliminarRecompensaDelCarritoRecompensas($idcarrito, $idrecompensa)
    {
        $sql = "DELETE FROM carrito_detalle WHERE idcarrito = '$idcarrito' AND idrecompensa = '$idrecompensa'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerCantidadDeRecompensaEnCarritoRecompensas($idcarrito, $idrecompensa)
    // Descripción:
    // Obtiene la cantidad de recompensas en el carrito de recompensas.
    // Notas:
    // N/A
    public function obtenerCantidadDeRecompensaEnCarritoRecompensas($idcarrito, $idrecompensa)
    {
        $sql = "SELECT c_d.cantidad FROM carrito_detalle c_d WHERE c_d.idcarrito = '$idcarrito' AND c_d.idrecompensa = '$idrecompensa'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // actualizarRecompensaEnCarritoRecompensas($idcarrito, $idcarrito_detalle, $idrecompensa, $nombre, $descripcion, $cantidad, $precio, $precio_total)
    // Descripción:
    // Actualiza las recompensas en el carrito de recompensas.
    // Notas:
    // N/A
    public function actualizarRecompensaEnCarritoRecompensas($idcarrito, $idcarrito_detalle, $idrecompensa, $nombre, $descripcion, $cantidad, $precio, $precio_total)
    {
        $sql = "UPDATE carrito_detalle SET nombre = '$nombre', descripcion = '$descripcion', cantidad = $cantidad, precio = $precio, precio_total = $precio_total WHERE idcarrito = '$idcarrito' AND idcarrito_detalle = '$idcarrito_detalle' AND idrecompensa = '$idrecompensa'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarCarritoRecompensas($idcarrito, $total_articulos, $total_precio)
    // Descripción:
    // Actualiza el carrito de recompensas.
    // Notas:
    // N/A
    public function actualizarCarritoRecompensas($idcarrito, $total_articulos, $total_precio)
    {
        $sql = "UPDATE carrito SET total_articulos = $total_articulos, total_precio = $total_precio WHERE idcarrito = '$idcarrito'";
        return ejecutarConsulta($sql);
    }
    
    // vaciarCarritoRecompensas($idcarrito)
    // Descripción:
    // Vacia el carrito de recompensas.
    // Notas:
    // N/A
    public function vaciarCarritoRecompensas($idcarrito)
    {
        $sql = "DELETE FROM carrito_detalle WHERE idcarrito = '$idcarrito'";
        return ejecutarConsulta($sql);
    }
}

?>