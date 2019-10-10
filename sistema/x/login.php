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
    case 'login':
        $login   = isset($_POST['login']) ? limpiarCadena($_POST['login']) : '';
        $clave   = isset($_POST['clave']) ? limpiarCadena($_POST['clave']) : '';
        $dominio = isset($_POST['dominio']) ? limpiarCadena($_POST['dominio']) : '';
        echo json_encode(login($login, $clave, $dominio), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 06/Agosto/2019
    case 'recuperarPassword':
        $login = isset($_POST['login']) ? limpiarCadena($_POST['login']) : '';
        $dominio = isset($_POST['dominio']) ? limpiarCadena($_POST['dominio']) : '';
        echo json_encode(recuperarPassword($login, $dominio), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'validarLoginDisponible':
        $login = isset($_POST['login']) ? limpiarCadena($_POST['login']) : '';
        $dominio          = isset($_POST['dominio']) ? limpiarCadena($_POST['dominio']) : '';
        echo json_encode(validarLoginDisponible($login, $dominio), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'validarLoginRegistrado':
        $login = isset($_POST['login']) ? limpiarCadena($_POST['login']) : '';
        $dominio          = isset($_POST['dominio']) ? limpiarCadena($_POST['dominio']) : '';
        echo json_encode(validarLoginRegistrado($login, $dominio), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 06/Agosto/2019
    case 'registrarAlumno':
        $nombre           = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : '';
        $apellido_paterno = isset($_POST['apellido_paterno']) ? limpiarCadena($_POST['apellido_paterno']) : '';
        $apellido_materno = isset($_POST['apellido_materno']) ? limpiarCadena($_POST['apellido_materno']) : '';
        $telefono         = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : '';
        $matricula        = isset($_POST['matricula']) ? limpiarCadena($_POST['matricula']) : '';
        $login            = isset($_POST['login']) ? limpiarCadena($_POST['login']) : '';
        $clave            = isset($_POST['clave']) ? limpiarCadena($_POST['clave']) : '';
        $dominio          = isset($_POST['dominio']) ? limpiarCadena($_POST['dominio']) : '';
        echo json_encode(registrarAlumno($nombre, $apellido_paterno, $apellido_materno,$telefono ,$matricula , $login, $clave, $dominio), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>