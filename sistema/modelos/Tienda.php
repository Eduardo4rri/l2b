<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Tienda
{
    public function __construct()
    {
        
    }
    
    // listarEscuelasPorAliasNombre($alias, $nombre, $dominio)
    // Descripción:
    // Obtiene una lista de escuelas filtradas por alias o por nombre en un dominio
    // Notas:
    // Se usa para la selección de escuela en el paso de registro de la tienda
    public function listarEscuelasPorAliasNombre($alias, $nombre, $dominio)
    {
        $sql = "SELECT * FROM escuela e WHERE e.activo = '1' AND e.validacion = '1' AND UPPER(e.dominio) = UPPER('$dominio')";
        if ($alias)
        {
            $sql = $sql . " AND alias LIKE '%$alias%'";
        }
        if ($nombre)
        {
            $sql = $sql . " AND nombre LIKE '%$nombre%'";
        }
        return ejecutarConsulta($sql);
    }
    
    // listarEscuelasPorDireccion($estado, $ciudad, $codigo_postal, $dominio)
    // Descripción:
    // Obtiene una lista de escuelas filtradas por estado, ciudad o código postal en un dominio
    // Notas:
    // Se usa para la selección de escuela en el paso de registro de la tienda
    public function listarEscuelasPorDireccion($estado, $ciudad, $codigo_postal, $dominio)
    {
        $sql = "SELECT * FROM escuela e WHERE e.activo = '1' AND e.validacion = '1' AND UPPER(e.dominio) = UPPER('$dominio')";
        if ($estado)
        {
            $sql = $sql . " AND estado LIKE '%$estado%'";
        }
        if ($ciudad)
        {
            $sql = $sql . " AND ciudad LIKE '%$ciudad%'";
        }
        if ($codigo_postal)
        {
            $sql = $sql . " AND codigo_postal LIKE '%$codigo_postal%'";
        }
        return ejecutarConsulta($sql);
    }
    
    // listarProgramasPorEscuela($idescuela)
    // Descripción:
    // Obtiene una lista de los programas de una escuela
    // Notas:
    // Se usa para la selección de escuela en el paso de registro de la tienda
    public function listarProgramasPorEscuela($idescuela)
    {
        $sql = "SELECT pe.idprograma, pe.idescuela, p.alias, p.nombre, p.nivel, p.descripcion, c.idcurso, c.nombre AS curso, cons.idconsignacion, cons.nombre AS consignacion FROM ( ( ( programa_escuela pe LEFT JOIN programa p ON pe.idprograma = p.idprograma ) LEFT JOIN curso c ON c.idprograma = p.idprograma ) LEFT JOIN consignacion cons ON cons.idconsignacion = c.idconsignacion ) WHERE pe.idescuela = '$idescuela'";
        return ejecutarConsulta($sql);
    }
    
    // listarNivelesPorPrograma($idprograma)
    // Descripción:
    // Obtiene una lista de los niveles de un programa
    // Notas:
    // Se usa para la selección de programa en el paso de registro de la tienda
    public function listarNivelesPorPrograma($idprograma)
    {
        $sql = "SELECT DISTINCT p_a.nivel FROM programa_articulo p_a WHERE p_a.idprograma = '$idprograma' ORDER BY p_a.orden ASC";
        return ejecutarConsulta($sql);
    }
    
    // listarArticulosPorProgramaYNivel($idprograma, $nivel)
    // Descripción:
    // Obtiene un articulo en un programa y un nivel
    // Notas:
    // Se usa para la selección de programa en el paso de registro de la tienda
    public function listarArticulosPorProgramaYNivel($idprograma, $nivel)
    {
        $sql = "SELECT a.idarticulo, a.isbn, a.nombre, a.descripcion, a.serie, a.nivel, a.imagen, a.componentes, pa.precio, pa.descuento_porcentaje, pa.descuento_valor, pa.precio_descuento FROM ( programa_articulo pa LEFT JOIN articulo a ON pa.idarticulo = a.idarticulo ) WHERE pa.idprograma = '$idprograma' AND pa.nivel = '$nivel'";
        return ejecutarConsulta($sql);
    }
    
    // listarArticulosPorProgramaYNivelSinImagen($idprograma, $nivel)
    // Descripción:
    // Obtiene un articulo en un programa y un nivel sin imágenes
    // Notas:
    // Se usa para la selección de programa en el paso de registro de la tienda
    public function listarArticulosPorProgramaYNivelSinImagen($idprograma, $nivel)
    {
        $sql = "SELECT a.idarticulo, a.isbn, a.nombre, a.descripcion, a.serie, a.nivel, a.componentes, pa.precio, pa.descuento_porcentaje, pa.descuento_valor, pa.precio_descuento FROM ( programa_articulo pa LEFT JOIN articulo a ON pa.idarticulo = a.idarticulo ) WHERE pa.idprograma = '$idprograma' AND pa.nivel = '$nivel'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerArticuloEnPrograma($idarticulo, $idprograma)
    // Descripción:
    // Obtiene un objeto con los detalles de un artículo en un programa
    // Notas:
    // Se usa para la selección de programa en el paso de registro de la tienda
    public function obtenerArticuloEnPrograma($idarticulo, $idprograma)
    {
        $sql = "SELECT pa.idprograma_articulo, pa.idprograma, pa.idarticulo, pa.idlista_precio, a.isbn, a.nombre, a.descripcion, a.serie, a.nivel, a.imagen, a.componentes, pa.precio, pa.descuento_porcentaje, pa.descuento_valor, pa.precio_descuento FROM ( programa_articulo pa LEFT JOIN articulo a ON pa.idarticulo = a.idarticulo ) WHERE pa.idprograma = '$idprograma' AND pa.idarticulo = '$idarticulo'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
}

?>