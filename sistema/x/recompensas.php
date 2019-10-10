<?php
session_start();
ob_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/controladores/recompensas.php';
header('Access-Control-Allow-Origin: links2books.com');
header('Access-Control-Allow-Headers: access');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: json');

switch ($_POST['op'])
{
    case 'obtenerRecompensasLibro':
        $rspta = obtenerRecompensasLibro();
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
    case 'obtenerRecompensasCurso':
        $rspta = obtenerRecompensasCurso();
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
    case 'obtenerRecompensasMaterial':
        $rspta = obtenerRecompensasMaterial();
        echo json_encode($rspta, JSON_NUMERIC_CHECK);
        break;
}

ob_end_flush();
?>