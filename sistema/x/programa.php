<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/programa.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    // Revisado 09/Agosto/2019
    case 'listarProgramaCursosDominio':
        $iddominio = isset($_POST['iddominio']) ? $_POST['iddominio'] : null;
        echo json_encode(listarProgramaCursosDominio($iddominio), JSON_NUMERIC_CHECK);
        break;
    
    // Revisado 09/Agosto/2019
    case 'listarProgramaCursosEscuela':
        $idescuela = isset($_POST['idescuela']) ? $_POST['idescuela'] : null;
        echo json_encode(listarProgramaCursosEscuela($idescuela), JSON_NUMERIC_CHECK);
        break;
        
    // Revisado 18/Septiembre/2019
    case 'listarProgramaCursosEscuelaConTotales':
        $idescuela = isset($_POST['idescuela']) ? $_POST['idescuela'] : null;
        echo json_encode(listarProgramaCursosEscuelaConTotales($idescuela), JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>