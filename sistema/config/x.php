<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SECCIÓN CONFIGURABLE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Establecer el TimeZone para la ejecución de los X
date_default_timezone_set('America/Mexico_City');

// Establecer el tiempo de expiración de los tokens
define('PRO_TOKEN_TIMEOUT', 1800);

// Modo de las ventas
define('PRO_MODO_VENTAS', 'PRODUCCION');

// Debug de los X
define('PRO_DEBUG_X', true);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// NO MODIFICAR A PARTIR DE ESTE PUNTO
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Conexiones a endpoints externos para notificaciones
define('PRO_ENDPOINT_SEND_EMAILS_USERS', 'crm.wisdomlakes.com:8080/links2bo_books_admin/api/crud/send_email_user.php');
define('PRO_ENDPOINT_SEND_EMAILS_SALES', 'crm.wisdomlakes.com:8080/links2bo_books_admin/api/crud/send_email_sale.php');
define('PRO_ENDPOINT_SEND_EMAILS_CONSIGNMENTS', 'crm.wisdomlakes.com:8080/links2bo_books_admin/api/crud/send_email_consignment.php');
define('PRO_ENDPOINT_SEND_EMAILS_HELP', 'crm.wisdomlakes.com:8080/links2bo_books_admin/api/crud/send_email_help.php');
define('PRO_ENDPOINT_GENERATE_PDF', 'crm.wisdomlakes.com:8080/links2bo_books_admin/api/crud/generate_sale_pdf.php');

// ¿Debugeando los X?
if (PRO_DEBUG_X == true)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

?>