<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/usuario.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 06/Agosto/2019
    case 'actualizarUsuario':
        $idusuario            = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        $nombre               = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        $apellido_paterno     = isset($_POST['apellido_paterno']) ? limpiarCadena($_POST['apellido_paterno']) : '';
        $apellido_materno     = isset($_POST['apellido_materno']) ? limpiarCadena($_POST['apellido_materno']) : '';
        $telefono             = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : '';
        $login                = isset($_POST['login']) ? limpiarCadena($_POST['login']) : '';
        $matricula            = isset($_POST['matricula']) ? limpiarCadena($_POST['matricula']) : '';
        $terminos_condiciones = isset($_POST['terminos_condiciones']) ? limpiarCadena($_POST['terminos_condiciones']) : '';
        $idescuela            = isset($_POST['idescuela']) ? limpiarCadena($_POST['idescuela']) : '';
        $idprograma           = isset($_POST['idprograma']) ? limpiarCadena($_POST['idprograma']) : '';
        $idcurso              = isset($_POST['idcurso']) ? limpiarCadena($_POST['idcurso']) : '';
        $idconsignacion       = isset($_POST['idconsignacion']) ? limpiarCadena($_POST['idconsignacion']) : '';
        echo json_encode(actualizarUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $telefono, $login, $matricula, $terminos_condiciones, $idescuela, $idprograma, $idcurso, $idconsignacion), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'actualizarUsuarioClave':
        $idusuario = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        $clave     = isset($_POST['clave']) ? limpiarCadena($_POST['clave']) : '';
        echo json_encode(actualizarUsuarioClave($idusuario, $clave), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'actualizarUsuarioDistribuidorDistribuidor':
        $idusuario            = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        $alias                = isset($_POST['alias']) ? limpiarCadena($_POST['alias']) : '';
        $nombre               = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        $apellido_paterno     = isset($_POST['apellido_paterno']) ? limpiarCadena($_POST['apellido_paterno']) : '';
        $apellido_materno     = isset($_POST['apellido_materno']) ? limpiarCadena($_POST['apellido_materno']) : '';
        $clave                = isset($_POST['clave']) ? limpiarCadena($_POST['clave']) : '';
        $matricula            = isset($_POST['matricula']) ? limpiarCadena($_POST['matricula']) : '';
        $telefono             = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : '';
        $estado               = isset($_POST['estado']) ? limpiarCadena($_POST['estado']) : '';
        $ciudad               = isset($_POST['ciudad']) ? limpiarCadena($_POST['ciudad']) : '';
        $colonia              = isset($_POST['colonia']) ? limpiarCadena($_POST['colonia']) : '';
        $calle                = isset($_POST['calle']) ? limpiarCadena($_POST['calle']) : '';
        $num_exterior         = isset($_POST['num_exterior']) ? limpiarCadena($_POST['num_exterior']) : '';
        $num_interior         = isset($_POST['num_interior']) ? limpiarCadena($_POST['num_interior']) : '';
        $codigo_postal        = isset($_POST['codigo_postal']) ? limpiarCadena($_POST['codigo_postal']) : '';
        $terminos_condiciones = isset($_POST['terminos_condiciones']) ? limpiarCadena($_POST['terminos_condiciones']) : '';
        echo json_encode(actualizarUsuarioDistribuidorDistribuidor($idusuario, $alias, $nombre, $apellido_paterno, $apellido_materno, $telefono, $estado, $ciudad, $calle, $colonia, $num_exterior, $num_interior, $codigo_postal), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'actualizarUsuarioDistribuidorUsuario':
        $idusuario            = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        $alias                = isset($_POST['alias']) ? limpiarCadena($_POST['alias']) : '';
        $nombre               = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        $apellido_paterno     = isset($_POST['apellido_paterno']) ? limpiarCadena($_POST['apellido_paterno']) : '';
        $apellido_materno     = isset($_POST['apellido_materno']) ? limpiarCadena($_POST['apellido_materno']) : '';
        $clave                = isset($_POST['clave']) ? limpiarCadena($_POST['clave']) : '';
        $matricula            = isset($_POST['matricula']) ? limpiarCadena($_POST['matricula']) : '';
        $telefono             = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : '';
        $estado               = isset($_POST['estado']) ? limpiarCadena($_POST['estado']) : '';
        $ciudad               = isset($_POST['ciudad']) ? limpiarCadena($_POST['ciudad']) : '';
        $colonia              = isset($_POST['colonia']) ? limpiarCadena($_POST['colonia']) : '';
        $calle                = isset($_POST['calle']) ? limpiarCadena($_POST['calle']) : '';
        $num_exterior         = isset($_POST['num_exterior']) ? limpiarCadena($_POST['num_exterior']) : '';
        $num_interior         = isset($_POST['num_interior']) ? limpiarCadena($_POST['num_interior']) : '';
        $codigo_postal        = isset($_POST['codigo_postal']) ? limpiarCadena($_POST['codigo_postal']) : '';
        $terminos_condiciones = isset($_POST['terminos_condiciones']) ? limpiarCadena($_POST['terminos_condiciones']) : '';
        echo json_encode(actualizarUsuarioDistribuidorUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $clave, $matricula, $telefono, $estado, $ciudad, $codigo_postal, $terminos_condiciones), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'obtenerUsuario':
        $idusuario = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        echo json_encode(obtenerUsuario($idusuario));
        break;
        
    // Revisado 06/Agosto/2019
    case 'actualizarDatosDistribuidor':
        $idusuario            = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : '';
        $alias                = isset($_POST['alias']) ? limpiarCadena($_POST['alias']) : '';
        $nombre               = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        $telefono             = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : '';
        $estado               = isset($_POST['estado']) ? limpiarCadena($_POST['estado']) : '';
        $ciudad               = isset($_POST['ciudad']) ? limpiarCadena($_POST['ciudad']) : '';
        $colonia              = isset($_POST['colonia']) ? limpiarCadena($_POST['colonia']) : '';
        $calle                = isset($_POST['calle']) ? limpiarCadena($_POST['calle']) : '';
        $num_exterior         = isset($_POST['num_exterior']) ? limpiarCadena($_POST['num_exterior']) : '';
        $num_interior         = isset($_POST['num_interior']) ? limpiarCadena($_POST['num_interior']) : '';
        $codigo_postal        = isset($_POST['codigo_postal']) ? limpiarCadena($_POST['codigo_postal']) : '';
        echo json_encode(actualizarDatosDistribuidor($idusuario, $alias, $nombre, $telefono, $estado, $ciudad, $colonia, $calle, $num_exterior, $num_interior, $codigo_postal), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>