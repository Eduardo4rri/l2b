<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/cuenta.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 07/Agosto/2019
    case 'listarVentasDeAlumno':
        $idalumno = isset($_POST['idalumno']) ? $_POST['idalumno'] : null;
        echo json_encode(listarVentasDeAlumno($idalumno), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 07/Agosto/2019
    case 'listarVentasDeAlumnoPorCurso':
        $idalumno = isset($_POST['idalumno']) ? $_POST['idalumno'] : null;
        $idcurso = isset($_POST['idcurso']) ? $_POST['idcurso'] : null;
        echo json_encode(listarVentasDeAlumnoPorCurso($idalumno, $idcurso), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 07/Agosto/2019
    case 'listarVentasDeCoordinadorPorEscuelaYCurso':
        $idescuela = isset($_POST['idescuela']) ? $_POST['idescuela'] : null;
        $idcurso = isset($_POST['idcurso']) ? $_POST['idcurso'] : null;
        echo json_encode(listarVentasDeCoordinadorPorEscuelaYCurso($idescuela, $idcurso), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 07/Agosto/2019
    case 'obtenerVentasEnConsignacion':
        $idescuela = isset($_POST['idescuela']) ? $_POST['idescuela'] : null;
        $idcurso = isset($_POST['idcurso']) ? $_POST['idcurso'] : null;
        $idconsignacion = isset($_POST['idconsignacion']) ? $_POST['idconsignacion'] : null;
        echo json_encode(obtenerVentasEnConsignacion($idescuela, $idcurso, $idconsignacion), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 24/Agosto/2019
    case 'obtenerVentasEnConsignacionParaEntrega':
        $idescuela = isset($_POST['idescuela']) ? $_POST['idescuela'] : null;
        $idcurso = isset($_POST['idcurso']) ? $_POST['idcurso'] : null;
        $idconsignacion = isset($_POST['idconsignacion']) ? $_POST['idconsignacion'] : null;
        echo json_encode(obtenerVentasEnConsignacionParaEntrega($idescuela, $idcurso, $idconsignacion), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 07/Agosto/2019
    case 'enviarMensajeDeAyuda':
        $idusuario = isset($_POST['idusuario']) ? $_POST['idusuario'] : null;
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
        $correo = isset($_POST['correo']) ? $_POST['correo'] : null;
        $datos_adicionales = isset($_POST['datos_adicionales']) ? $_POST['datos_adicionales'] : null;
        echo json_encode(enviarMensajeDeAyuda($idusuario, $nombre, $correo, $datos_adicionales), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>