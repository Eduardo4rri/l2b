<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Carrito
{
    public function __construct()
    {
        
    }
    
    // crearCarritoAlumno($idalumno)
    // Descripción:
    // Crea un carrito de tipo ALUMNO
    // Notas:
    // N/A
    public function crearCarritoAlumno($idalumno)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo) VALUES ('$idalumno', 'alumno', '1')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // crearCarritoCoordinadorDominio($idcoordinador)
    // Descripción:
    // Crea un carrito de tipo COORDINADOR DE DOMINIO
    // Notas:
    // N/A
    public function crearCarritoCoordinadorDominio($idcoordinador)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo) VALUES ('$idcoordinador', 'coordinador_dominio', '0')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // crearCarritoCoordinadorZona($idcoordinador)
    // Descripción:
    // Crea un carrito de tipo COORDINADOR DE ZONA
    // Notas:
    // N/A
    public function crearCarritoCoordinadorZona($idcoordinador)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo) VALUES ('$idcoordinador', 'coordinador_zona', '0')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // crearCarritoCoordinadorSubzona($idcoordinador)
    // Descripción:
    // Crea un carrito de tipo COORDINADOR DE SUBZONA
    // Notas:
    // N/A
    public function crearCarritoCoordinadorSubzona($idcoordinador)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo) VALUES ('$idcoordinador', 'coordinador_subzona', '0')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // crearCarritoCoordinadorEscuela($idcoordinador)
    // Descripción:
    // Crea un carrito de tipo COORDINADOR DE ESCUELA
    // Notas:
    // N/A
    public function crearCarritoCoordinadorEscuela($idcoordinador)
    {
        $sql = "INSERT INTO carrito (idusuario, tipo, max_1_articulo) VALUES ('$idcoordinador', 'coordinador_escuela', '0')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // obtenerCarritoDeUsuario($idusuario)
    // Descripción:
    // Obtiene un carrito por ID de usuario
    // Notas:
    // Si el usuario no tiene un carrito, se creará uno nuevo y le será asignado con las propiedades y permisos definidos por el rol del usuario
    public function obtenerCarritoDeUsuario($idusuario)
    {
        $sql = "SELECT * FROM carrito c WHERE c.idusuario = '$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerCarrito($idcarrito)
    // Descripción:
    // Obtiene un carrito por ID de carrito
    // Notas:
    // N/A
    public function obtenerCarrito($idcarrito)
    {
        $sql = "SELECT * FROM carrito c WHERE c.idcarrito = '$idcarrito'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerCarritoActivoDeUsuario($idusuario)
    // Descripción:
    // Obtiene un carrito activo por ID de usuario
    // Notas:
    // N/A
    public function obtenerCarritoActivoDeUsuario($idusuario)
    {
        $sql = "SELECT * FROM carrito c WHERE c.idusuario = '$idusuario' AND c.estatus = 1";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerCarritoDetalle($idcarrito)
    // Descripción:
    // Obtiene los detalles de un carrito por ID de carrito
    // Notas:
    // N/A
    public function obtenerCarritoDetalle($idcarrito)
    {
        $sql = "SELECT c_d.*, a.imagen FROM ( carrito_detalle c_d LEFT JOIN articulo a ON c_d.idarticulo = a.idarticulo ) WHERE c_d.idcarrito = '$idcarrito'";
        return ejecutarConsulta($sql);
    }
    
    // agregarArticuloAlCarrito($idcarrito, $idprograma, $idarticulo, $isbn, $nombre, $descripcion, $serie, $nivel, $cantidad, $precio, $descuento_porcentaje, $descuento_valor, $precio_descuento, $precio_total)
    // Descripción:
    // Agrega un artículo como detalle de un carrito
    // Notas:
    // N/A
    public function agregarArticuloAlCarrito($idcarrito, $idprograma, $idarticulo, $isbn, $nombre, $descripcion, $serie, $nivel, $cantidad, $precio, $descuento_porcentaje, $descuento_valor, $precio_descuento, $precio_total)
    {
        $sql = "INSERT INTO carrito_detalle (idcarrito, idprograma, idarticulo, isbn, nombre, descripcion, serie, nivel, cantidad, precio, descuento_porcentaje, descuento_valor, precio_descuento, precio_total) VALUES ('$idcarrito', '$idprograma', '$idarticulo', '$isbn', '$nombre', '$descripcion', '$serie', '$nivel', $cantidad, $precio, $descuento_porcentaje, $descuento_valor, $precio_descuento, $precio_total)";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // eliminarArticuloDelCarrito($idcarrito, $idarticulo)
    // Descripción:
    // Elimina un artículo del carrito
    // Notas:
    // N/A
    public function eliminarArticuloDelCarrito($idcarrito, $idarticulo)
    {
        $sql = "DELETE FROM carrito_detalle WHERE idcarrito = '$idcarrito' AND idarticulo = '$idarticulo'";
        return ejecutarConsulta($sql);
    }
    
    // vaciarCarrito($idcarrito)
    // Descripción:
    // Vacía un carrito
    // Notas:
    // N/A
    public function vaciarCarrito($idcarrito)
    {
        $sql = "DELETE FROM carrito_detalle WHERE idcarrito = '$idcarrito'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerCantidadDeArticuloEnCarrito($idcarrito, $idarticulo)
    // Descripción:
    // Obtiene la cantidad de un artículo en un carrito
    // Notas:
    // N/A
    public function obtenerCantidadDeArticuloEnCarrito($idcarrito, $idarticulo)
    {
        $sql = "SELECT c_d.cantidad FROM carrito_detalle c_d WHERE c_d.idcarrito = '$idcarrito' AND c_d.idarticulo = '$idarticulo'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // actualizarArticuloEnCarrito($idcarrito, $idcarrito_detalle, $idprograma, $idarticulo, $isbn, $nombre, $descripcion, $serie, $nivel, $cantidad, $precio, $descuento_porcentaje, $descuento_valor, $precio_descuento, $precio_total)
    // Descripción:
    // Actualiza un artículo en un carrito
    // Notas:
    // N/A
    public function actualizarArticuloEnCarrito($idcarrito, $idcarrito_detalle, $idprograma, $idarticulo, $isbn, $nombre, $descripcion, $serie, $nivel, $cantidad, $precio, $descuento_porcentaje, $descuento_valor, $precio_descuento, $precio_total)
    {
        $sql = "UPDATE carrito_detalle SET isbn = '$isbn', nombre = '$nombre', descripcion = '$descripcion', serie = '$serie', nivel = '$nivel', cantidad = $cantidad, precio = $precio, descuento_porcentaje = $descuento_porcentaje, descuento_valor = $descuento_valor, precio_descuento = $precio_descuento, precio_total = $precio_total WHERE idcarrito = '$idcarrito' AND idcarrito_detalle = '$idcarrito_detalle' AND idprograma = '$idprograma' AND idarticulo = '$idarticulo'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarCarrito($idcarrito, $total_articulos, $subtotal_precio, $descuento_precio, $impuesto_precio, $total_envio, $total_precio)
    // Descripción:
    // Actualiza los totales en un carrito
    // Notas:
    // N/A
    public function actualizarCarrito($idcarrito, $total_articulos, $subtotal_precio, $descuento_precio, $impuesto_precio, $total_envio, $total_precio)
    {
        $sql = "UPDATE carrito SET total_articulos = $total_articulos, subtotal_precio = $subtotal_precio, descuento_precio = $descuento_precio, impuesto_precio = $impuesto_precio, total_envio = $total_envio, total_precio = $total_precio WHERE idcarrito = '$idcarrito'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarCarritoEstablecerIDVentaIDPagoYCerrarCarrito($idcarrito, $idventa, $idpago)
    // Descripción:
    // Cierra un carrito y agrega un ID de venta y ID de pago al carrito
    // Notas:
    // N/A
    public function actualizarCarritoEstablecerIDVentaIDPagoYCerrarCarrito($idcarrito, $idventa, $idpago)
    {
        $sql = "UPDATE carrito SET idventa = '$idventa', idpago = '$idpago', estatus = '0', estatus_leyenda = 'CERRADO' WHERE idcarrito = '$idcarrito'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarCarritoDetalle($idcarrito_detalle, $idarticulo, $isbn, $nombre, $descripcion, $serie, $nivel)
    // Descripción:
    // Actualiza los datos de un detalle de carrito
    // Notas:
    // N/A
    public function actualizarCarritoDetalle($idcarrito_detalle, $idarticulo, $isbn, $nombre, $descripcion, $serie, $nivel)
    {
        $sql = "UPDATE carrito_detalle SET idarticulo = '$idarticulo', isbn = '$isbn', nombre = '$nombre', descripcion = '$descripcion', serie = '$serie', nivel = '$nivel' WHERE idcarrito_detalle = '$idcarrito_detalle'";
        return ejecutarConsulta($sql);
    }
    
}

?>