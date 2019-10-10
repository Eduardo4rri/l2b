<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Venta
{
    protected $modo = null;
    
    public function __construct()
    {
        $this->modo = PRO_MODO_VENTAS;
    }
    
    // crearVenta($iddominio, $idescuela, $idprograma, $iddistribuidor, $idcurso, $idconsignacion, $idusuario, $idcarrito, $idpago, $modo, $tipo, $tipo_rol, $tipo_pago, $tipo_tienda, $pago_tienda, $pago_proveedor, $pago_referencia, $pago_total, $pago_concepto, $entrega_en, $entrega_a, $entrega_escuela, $entrega_campus, $entrega_calle, $entrega_ciudad, $entrega_estado, $entrega_codigo_postal, $comprador_nombre, $comprador_correo_electronico, $comprador_matricula, $comprador_telefono, $fecha_hora, $fecha_entrega_prevista, $total_articulos, $subtotal, $descuento, $impuesto, $envio, $total)
    // Descripción:
    // Crea una venta
    // Notas:
    // N/A
    public function crearVenta(
        $iddominio,
        $idescuela,
        $idprograma,
        $iddistribuidor,
        $idcurso,
        $idconsignacion,
        $idusuario,
        $idcarrito,
        $idpago,
        $modo,
        $tipo,
        $tipo_rol,
        $tipo_pago,
        $tipo_tienda,
        $pago_tienda,
        $pago_proveedor,
        $pago_referencia,
        $pago_total,
        $pago_concepto,
        $entrega_en,
        $entrega_a,
        $entrega_escuela,
        $entrega_campus,
        $entrega_calle,
        $entrega_ciudad,
        $entrega_estado,
        $entrega_codigo_postal,
        $comprador_nombre,
        $comprador_correo_electronico,
        $comprador_matricula,
        $comprador_telefono,
        $fecha_hora,
        $fecha_entrega_prevista,
        $total_articulos,
        $subtotal,
        $descuento,
        $impuesto,
        $envio,
        $total
        )
    {
        $sql = "INSERT INTO venta (
            iddominio,
            idescuela,
            idprograma,
            iddistribuidor,
            idcurso,
            idconsignacion,
            idusuario,
            idcarrito,
            idpago,
            modo,
            tipo,
            tipo_rol,
            tipo_pago,
            tipo_tienda,
            pago_tienda,
            pago_proveedor,
            pago_referencia,
            pago_total,
            pago_concepto,
            entrega_en,
            entrega_a,
            entrega_escuela,
            entrega_campus,
            entrega_calle,
            entrega_ciudad,
            entrega_estado,
            entrega_codigo_postal,
            comprador_nombre,
            comprador_correo_electronico,
            comprador_matricula,
            comprador_telefono,
            fecha_hora,
            fecha_entrega_prevista,
            total_articulos,
            subtotal,
            descuento,
            impuesto,
            envio,
            total,
            estatus_pago,
            estatus_pago_leyenda,
            estatus_entrega,
            estatus_entrega_leyenda,
            activo,
            validacion
            ) VALUES (
                '$iddominio',
                '$idescuela',
                '$idprograma',
                '$iddistribuidor',
                '$idcurso',
                '$idconsignacion',
                '$idusuario',
                '$idcarrito',
                '$idpago',
                '$modo',
                '$tipo',
                '$tipo_rol',
                '$tipo_pago',
                '$tipo_tienda',
                '$pago_tienda',
                '$pago_proveedor',
                '$pago_referencia',
                '$pago_total',
                '$pago_concepto',
                '$entrega_en',
                '$entrega_a',
                '$entrega_escuela',
                '$entrega_campus',
                '$entrega_calle',
                '$entrega_ciudad',
                '$entrega_estado',
                '$entrega_codigo_postal',
                '$comprador_nombre',
                '$comprador_correo_electronico',
                '$comprador_matricula',
                '$comprador_telefono',
                '$fecha_hora',
                '$fecha_entrega_prevista',
                '$total_articulos',
                '$subtotal',
                '$descuento',
                '$impuesto',
                '$envio',
                '$total',
                '0',
                'PENDIENTE',
                '0',
                'SIN ENTREGAR',
                '1',
                '1'
                )";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // agregarArticuloAVenta($idventa, $idprograma, $idarticulo, $articulo_nivel, $articulo_nombre, $articulo_descripcion, $cantidad, $precio, $descuento_porcentaje, $descuento_valor, $precio_descuento, $precio_total)
    // Descripción:
    // Agrega un articulo a la venta
    // Notas:
    // N/A
    public function agregarArticuloAVenta(
        $idventa,
        $idprograma,
        $idarticulo,
        $articulo_nivel,
        $articulo_nombre,
        $articulo_descripcion,
        $cantidad,
        $precio,
        $descuento_porcentaje,
        $descuento_valor,
        $precio_descuento,
        $precio_total
        )
    {
        $sql = "INSERT INTO venta_detalle (
            idventa,
            idprograma,
            idarticulo,
            articulo_nivel,
            articulo_nombre,
            articulo_descripcion,
            cantidad,
            precio,
            descuento_porcentaje,
            descuento_valor,
            precio_descuento,
            precio_total
            ) VALUES (
                '$idventa',
                '$idprograma',
                '$idarticulo',
                '$articulo_nivel',
                '$articulo_nombre',
                '$articulo_descripcion',
                '$cantidad',
                '$precio',
                '$descuento_porcentaje',
                '$descuento_valor',
                '$precio_descuento',
                '$precio_total'
                )";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // obtenerVenta($idventa)
    // Descripción:
    // Obtiene una venta
    // Notas:
    // N/A
    public function obtenerVenta($idventa)
    {
        $sql = "SELECT v.idventa, v.idescuela, v.iddistribuidor, v.idusuario, v.idcarrito, v.idpago, v.idprograma, v.idcurso, v.modo, v.tipo, v.tipo_rol, v.entrega_escuela, v.entrega_campus, v.entrega_calle, v.entrega_ciudad, v.entrega_estado, v.entrega_codigo_postal, v.comprador_nombre, v.comprador_correo_electronico, v.comprador_matricula, v.comprador_telefono, v.fecha_hora, v.fecha_entrega_prevista, v.estatus_pago_leyenda, v.total_articulos, v.subtotal, v.descuento, v.impuesto, v.envio, v.total FROM venta v WHERE v.idventa = '$idventa'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerVentaDetalle($idventa)
    // Descripción:
    // Obtiene el detalle de una venta
    // Notas:
    // N/A
    public function obtenerVentaDetalle($idventa)
    {
        $sql = "SELECT v_d.idventa_detalle, v_d.idventa, v_d.idarticulo, v_d.articulo_nivel, v_d.articulo_nombre, v_d.articulo_descripcion, v_d.cantidad, v_d.precio, v_d.descuento_porcentaje, v_d.descuento_valor, v_d.precio_descuento, v_d.precio_total FROM venta_detalle v_d WHERE v_d.idventa = '$idventa'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentaDetalleConImagen($idventa)
    // Descripción:
    // Obtiene el detalle con imagen de una venta
    // Notas:
    // N/A
    public function obtenerVentaDetalleConImagen($idventa)
    {
        $sql = "SELECT v_d.idventa_detalle, v_d.idventa, v_d.idarticulo, v_d.articulo_nivel, v_d.articulo_nombre, v_d.articulo_descripcion, v_d.cantidad, v_d.precio, v_d.descuento_porcentaje, v_d.descuento_valor, v_d.precio_descuento, v_d.precio_total, a.imagen FROM ( venta_detalle v_d LEFT JOIN articulo a ON v_d.idarticulo = a.idarticulo ) WHERE v_d.idventa = '$idventa'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerPDFVenta($idventa)
    // Descripción:
    // Obtiene el PDF de una venta
    // Notas:
    // N/A
    public function obtenerPDFVenta($idventa)
    {
        $sql = "SELECT v.idventa, v.pdf_base_64 FROM venta v WHERE v.idventa = '$idventa'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // actualizarDatosDeFacturacion($idusuario, $idventa, $usuario_rfc , $usuario_email, $datos_adicionales, $libro, $nombre_usuario, $usuario_telefono, $calle, $numero_exterior, $numero_interior, $colonia, $delegacion, $ciudad, $pais, $codigo_postal)
    // Descripción:
    // Actualiza los datos de facturación de una venta
    // Notas:
    // N/A
    public function actualizarDatosDeFacturacion($idusuario, $idventa, $usuario_rfc , $usuario_email, $datos_adicionales, $libro, $nombre_usuario, $usuario_telefono, $calle, $numero_exterior, $numero_interior, $colonia, $delegacion, $ciudad, $pais, $codigo_postal)
    {
        $sql = "INSERT INTO solicitud_factura (idusuario, idventa, nombre_articulo, nombre_usuario, usuario_rfc, calle, numero_exterior, numero_interior, colonia, delegacion, ciudad, pais, codigo_postal, telefono, usuario_email, usuario_notas) VALUES ('$idusuario', '$idventa', '$libro', '$nombre_usuario', '$usuario_rfc', '$calle', '$numero_exterior', '$numero_interior', '$colonia', '$delegacion', '$ciudad', '$pais', '$codigo_postal', '$usuario_telefono', '$usuario_email', '$datos_adicionales')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacion($idescuela, $idcurso, $idconsignacion)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacion($idescuela, $idcurso, $idconsignacion)
    {
        $sql = "SELECT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v.tipo_rol = 'alumno' AND (v.estatus_pago = 0 OR v.estatus_pago = 1)";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacionNivelPorAsignar($idescuela, $idcurso, $idconsignacion)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación con un nivel por asignar
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionNivelPorAsignar($idescuela, $idcurso, $idconsignacion)
    {
        $sql = "SELECT DISTINCT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v LEFT JOIN venta_detalle v_d ON v.idventa = v_d.idventa WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v_d.articulo_nivel = 'NIVEL POR ASIGNAR' AND v.tipo_rol = 'alumno' AND (v.estatus_pago = 0 OR v.estatus_pago = 1)";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacionNivelPorAsignarEstatus($idescuela, $idcurso, $idconsignacion, $pago_estatus)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación con un nivel por asignar y con un estatus de pago
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionNivelPorAsignarEstatus($idescuela, $idcurso, $idconsignacion, $pago_estatus)
    {
        $sql = "SELECT DISTINCT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v LEFT JOIN venta_detalle v_d ON v.idventa = v_d.idventa WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v_d.articulo_nivel = 'NIVEL POR ASIGNAR' AND v.tipo_rol = 'alumno' AND v.estatus_pago = '$pago_estatus'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacionEstatus($idescuela, $idcurso, $idconsignacion, $pago_estatus)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación y con un estatus de pago
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionEstatus($idescuela, $idcurso, $idconsignacion, $pago_estatus)
    {
        $sql = "SELECT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v.tipo_rol = 'alumno' AND v.estatus_pago = '$pago_estatus'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentasEscuelaCursoConsignacionEstatusEntrega($idescuela, $idcurso, $idconsignacion, $entrega_estatus)
    // Descripción:
    // Obtiene las ventas de una escuela en un curso en una consignación y con un estatus de entrega
    // Notas:
    // Corregido para tipo de venta VENTA y modo de venta
    public function obtenerVentasEscuelaCursoConsignacionEstatusEntrega($idescuela, $idcurso, $idconsignacion, $entrega_estatus)
    {
        $sql = "SELECT v.idventa, v.comprador_nombre, v.comprador_matricula, v.tipo_pago, v.pago_concepto, v.pago_referencia, v.estatus_pago, v.estatus_pago_leyenda, v.pago_fecha_hora, v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v WHERE v.modo = '$this->modo' AND v.tipo = 'venta' AND v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND v.tipo_rol = 'alumno' AND v.estatus_pago = '1' AND v.estatus_entrega = '$entrega_estatus'";
        return ejecutarConsulta($sql);
    }
    
    // establecerEstatusEntregaVentaEntregadaEscuelaCursoConsignacionEstatus($idescuela, $idcurso, $idconsignacion, $idventa, $fecha_entrega)
    // Descripción:
    // Establece el estatus de una venta en ENTREGADO y la fecha de entrega en una escuela en un curso en una consignación
    // Notas:
    // Corregido para tipo de venta VENTA
    public function establecerEstatusEntregaVentaEntregadaEscuelaCursoConsignacionEstatus($idescuela, $idcurso, $idconsignacion, $idventa, $fecha_entrega)
    {
        $sql = "UPDATE venta SET estatus_entrega = '1', estatus_entrega_leyenda = 'ENTREGADO', fecha_entrega = '$fecha_entrega' WHERE v.tipo = 'venta' AND idescuela = '$idescuela' AND idcurso = '$idcurso' AND v.idconsignacion = '$idconsignacion' AND idventa = '$idventa'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerEstatusEntregaVentaEscuelaCursoEstatus($idescuela, $idcurso, $idventa)
    // Descripción:
    // Obtiene el estatus de entrega de una venta en una escuela en un curso
    // Notas:
    // N/A
    public function obtenerEstatusEntregaVentaEscuelaCursoEstatus($idescuela, $idcurso, $idventa)
    {
        $sql = "SELECT v.estatus_entrega, v.estatus_entrega_leyenda, v.fecha_entrega FROM venta v WHERE v.idescuela = '$idescuela' AND v.idcurso = '$idcurso' AND v.idventa = '$idventa'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // establecerEstatusEntregaVentaEntregadaEscuelaCursoEstatus($idescuela, $idcurso, $idventa, $fecha_entrega)
    // Descripción:
    // Establece el estatus de entrega de una venta y la fecha de entrega en una escuela en un curso
    // Notas:
    // N/A
    public function establecerEstatusEntregaVentaEntregadaEscuelaCursoEstatus($idescuela, $idcurso, $idventa, $fecha_entrega)
    {
        $sql = "UPDATE venta SET estatus_entrega = '1', estatus_entrega_leyenda = 'ENTREGADO', fecha_entrega = '$fecha_entrega' WHERE idescuela = '$idescuela' AND idcurso = '$idcurso' AND idventa = '$idventa'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentaPorIDPago($idpago)
    // Descripción:
    // Obtiene una venta por ID de pago
    // Notas:
    // N/A
    public function obtenerVentaPorIDPago($idpago)
    {
        $sql = "SELECT v.idventa, v.idescuela, v.iddistribuidor, v.idusuario, v.idcarrito, v.idpago, v.modo, v.tipo, v.entrega_escuela, v.entrega_campus, v.entrega_calle, v.entrega_ciudad, v.entrega_estado, v.entrega_codigo_postal, v.comprador_nombre, v.comprador_correo_electronico, v.comprador_matricula, v.comprador_telefono, v.fecha_hora, v.fecha_entrega_prevista, v.estatus_pago_leyenda, v.total_articulos, v.subtotal, v.descuento, v.impuesto, v.envio, v.total FROM venta v WHERE v.idpago = '$idpago'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // actualizarEstatusVenta($idventa, $estatus, $estatus_leyenda, $pago_fecha_hora)
    // Descripción:
    // Actualiza el estatus de una venta
    // Notas:
    // N/A
    public function actualizarEstatusVenta($idventa, $estatus, $estatus_leyenda, $pago_fecha_hora)
    {
        $sql = "UPDATE venta SET estatus_pago = '$estatus', estatus_pago_leyenda = '$estatus_leyenda', pago_fecha_hora = '$pago_fecha_hora' WHERE idventa = '$idventa'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarVentaConcepto($idventa, $concepto)
    // Descripción:
    // Actualiza el concepto de tu pago
    // Notas:
    // N/A
    public function actualizarVentaConcepto($idventa, $pago_concepto)
    {
        $sql = "UPDATE venta SET pago_concepto = '$pago_concepto' WHERE idventa = '$idventa'";
        return ejecutarConsulta($sql);
    }

    // actualizarVentaDetalle($idventa_detalle, $idarticulo, $articulo_nombre, $articulo_descripcion, $articulo_nivel)
    // Descripción:
    // Actualiza los datos de un detalle de carrito
    // Notas:
    // N/A
    public function actualizarVentaDetalle($idventa_detalle, $idarticulo, $articulo_nombre, $articulo_descripcion, $articulo_nivel)
    {
        $sql = "UPDATE venta_detalle SET idarticulo = '$idarticulo', articulo_nombre = '$articulo_nombre', articulo_descripcion = '$articulo_descripcion', articulo_nivel = '$articulo_nivel' WHERE idventa_detalle = '$idventa_detalle'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerVentaParaCambioArticulo($idventa)
    // Descripción:
    // Obtiene la venta seleccinada para el cambio de articulo
    // Notas:
    // N/A
    public function obtenerVentaParaCambioArticulo($idventa)
    {
        $sql = "SELECT v.idventa, v.idprograma, v.comprador_nombre, v.comprador_matricula, vd.idarticulo, vd.articulo_nombre FROM venta v INNER JOIN venta_detalle vd ON vd.idventa = v.idventa WHERE v.idventa = '$idventa'";
        return ejecutarConsultaSimpleFila($sql);
    }
}

?>