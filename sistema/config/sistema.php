<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// SECCIÓN CONFIGURABLE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Datos de la aplicación
define('PRO_ORGANIZACION_NOMBRE', 'Links2Academy');
define('PRO_ORGANIZACION_WEB', 'links2books.com');
define('PRO_NOMBRE', 'Links2Books');
define('PRO_EMPRESA', 'i Vision On S.A. de C.V.');
define('PRO_WEB', 'links2books.com');
define('PRO_ANIOS', '2019');
define('PRO_EMAIL_CONTACTO', 'bookhelp@ivisionon.com');
define('PRO_EMAIL_SOPORTE', 'bookhelp@ivisionon.com');
define('PRO_EMAIL_FACTURAS', 'bookinvoice@ivisionon.com');

// Conexiones a los videos de ayuda
define('PRO_VIDEO_ALUMNO_COMPRAS', 'https://www.youtube.com/embed/faIV_yQxTS8');
define('PRO_VIDEO_COORDINADOR_COMPRAS', 'https://www.youtube.com/embed/faIV_yQxTS8');
define('PRO_VIDEO_COORDINADOR_ENTREGAS', 'https://www.youtube.com/embed/faIV_yQxTS8');

// Modo debug
define('PRO_DEBUG', true);
define('PRO_DEBUG_MENSAJE', 'Debugeando en LiquidWeb');
define('PRO_DEBUG_SUBDOMINIO', 'tecnm'); 
define('PRO_DEBUG_DOMINIO', 'links2books.com');

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// NO MODIFICAR A PARTIR DE ESTE PUNTO
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Banderas para activar o desactivar las páginas de la tienda
define('PAGINA_TIENDA', true);

// Banderas para activar o desactivar las páginas de alumnos
define('PAGINA_ALUMNO_CUENTA', true);

// Banderas para activar o desactivar las páginas en coordinador
define('PAGINA_COORDINADOR_CUENTA', true);
define('PAGINA_COORDINADOR_CURSO', false);
define('PAGINA_COORDINADOR_ESCUELA', false);
define('PAGINA_COORDINADOR_RECOMPENSAS', false);
define('PAGINA_COORDINADOR_ESCUELA_ENTREGA', true);

// Banderas para activar o desactivar las páginas de distribuidor
define('PAGINA_DISTRIBUIDOR_CUENTA', true);
define('PAGINA_DISTRIBUIDOR_DASHBOARD', true);

// Bandera para el mensaje de la espera de notificaciones de emails
define('MENSAJE_NOTIFICACION_ESPERA_EMAIL', true);
define('MENSAJE_NOTIFICACION_ESPERA_EMAIL_TEXTO', '<i class="fas fa-envelope-open-text"></i> <strong>Las notificaciones a tu correo pueden tardar de 3 a 5 minutos en llegar, no olvides revisar en tu bandeja de SPAM.</strong>');

// Bandera para el mensaje del costo de envío
define('MENSAJE_NOTIFICACION_COSTO_ENVIO', true);
define('MENSAJE_NOTIFICACION_COSTO_ENVIO_TEXTO', '<i class="fas fa-money-bill-alt"></i> <strong>¡El costo de envío es de tan sólo 1 centavo (0.01 MXN)!</strong>');

// Establecer el TimeZone para todo el sitio durante la ejecución de los scripts
date_default_timezone_set('America/Mexico_City');

// Token para forzar el uso de los archivos javascript más recientes
$token = uniqid();

// Determinar el dominio, subdominio  y protocolos a usar
$host        = '';
$host_ip     = $_SERVER['SERVER_ADDR'];
$host_name   = $_SERVER['HTTP_HOST'];
$host_puerto = $_SERVER['SERVER_PORT'];
if ($host_ip == $host_name)
{
    // Conectado por IP
    $host = PRO_DEBUG_SUBDOMINIO . '.' . PRO_DEBUG_DOMINIO;
}
else
{
    // Conectado por dominio
    $host = $host_name;
}
$host_datos     = explode('.', $host);
$host_protocolo = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $host_puerto == 443) ? "https://" : "http://");
$pagina         = $_SERVER['REQUEST_URI'];
$pagina_datos   = explode('/', $pagina);
$dominio        = $host_datos[count($host_datos) - 1] . '.' . $host_datos[count($host_datos) - 1];

// ¿Debugeando un subdominio en particular?
if (PRO_DEBUG == true && PRO_DEBUG_SUBDOMINIO != '')
{
    $subdominio = PRO_DEBUG_SUBDOMINIO;
}
else
{
    $subdominio = (count($host_datos) > 1 ? $host_datos[0] : '');
}
$url = $host_protocolo . $host . $pagina;

// Cargar el logo y videos del subdominio
if ($subdominio == 'uach')
{
    $subdominio_imagen = 'subdominio_uach_400x400.png';
    $_SESSION['web_subdominio_video_alumno_compras'] = '';
}
else if ($subdominio == 'tecnm')
{
    $subdominio_imagen = 'subdominio_tecnm_400x400.png';
    $_SESSION['web_subdominio_video_alumno_compras'] = 'https://www.youtube.com/embed/QeKjFbHNVEw';
}
else if ($subdominio == 'cgut')
{
    $subdominio_imagen = 'subdominio_cgut_400x400.png';
    $_SESSION['web_subdominio_video_alumno_compras'] = 'https://www.youtube.com/embed/faIV_yQxTS8';
}
else if ($subdominio == 'unid')
{
    $subdominio_imagen = 'subdominio_unid_400x400.png';
    $_SESSION['web_subdominio_video_alumno_compras'] = '';
}
else if ($subdominio == 'uqroo')
{
    $subdominio_imagen = 'subdominio_uqroo_400x400.png';
    $_SESSION['web_subdominio_video_alumno_compras'] = 'https://www.youtube.com/embed/DXp8tXF2LFo';
}
else if ($subdominio == 'anahuac')
{
    $subdominio_imagen = 'subdominio_anahuac_400x400.png';
    $_SESSION['web_subdominio_video_alumno_compras'] = 'https://www.youtube.com/embed/DXp8tXF2LFo';
}
else if ($subdominio == 'myschool')
{
    $subdominio_imagen = 'subdominio_myschool_400x400.jpg';
    $_SESSION['web_subdominio_video_alumno_compras'] = '';
}
else
{
    $subdominio_imagen = 'subdominio_debug_400x400.jpg';
    $_SESSION['web_subdominio_video_alumno_compras'] = '';
}

// Cargar en $_SESSION las variables web necesarias
$_SESSION['web_dominio']           = $dominio;
$_SESSION['web_subdominio']        = $subdominio;
$_SESSION['web_subdominio_imagen'] = $subdominio_imagen;
$_SESSION['web_carpeta']           = ($pagina_datos[count($pagina_datos) - 2] == '' ? 'public_html' : $pagina_datos[count($pagina_datos) - 2]);
$_SESSION['web_pagina']            = $pagina_datos[count($pagina_datos) - 1];
$_SESSION['web_url']               = $url;
$_SESSION['web_host']              = $host;
$_SESSION['web_host_ip']           = $host_ip;
$_SESSION['web_host_puerto']       = $host_puerto;
$_SESSION['web_host_protocolo']    = $host_protocolo;

// URLs por defecto
define('PRO_URL_LOGOUT', '../logout.php');
define('PRO_URL_SESION_CADUCADA', '../sesion-caducada.php');
define('PRO_URL_403', '../403.php');
define('PRO_URL_404', '../404.php');

// ¿Modo debug activado?
if (PRO_DEBUG == true)
{
    echo '<pre>';
    echo PRO_DEBUG_MENSAJE . '<br>';
    echo 'SERVER => $_SESSION: ';
    print_r($_SESSION);
    echo '</pre>';
}

?>