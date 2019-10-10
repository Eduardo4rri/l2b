<?php

////////////////////////////////////////////////////////
// Conexión a la base de datos en MySQL
// Puedes editar ;)
////////////////////////////////////////////////////////
define('DB_HOST', 'localhost');
define('DB_NAME', 'links2books_books');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_ENCODE', 'utf8');
////////////////////////////////////////////////////////

////////////////////////////////////////////////////////
// No modificar o te rompo las piernas
// ¿Entendiste?
////////////////////////////////////////////////////////
$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
mysqli_query($conexion, 'SET NAMES "' . DB_ENCODE . '"');
if (mysqli_connect_errno())
{
	printf("Falló la conexión a la base de datos: %s\n", mysqli_connect_error());
	exit();
}

// Devuelve 1 o varias filas en un arreglo, usar while ($reg = $rspta->fetch_object()) para convertir cada fila en un objeto
function ejecutarConsulta($sql)
{
	global $conexion;
	$query = $conexion->query($sql);
	return $query;
}

// Devuelve 1 fila convertida en un objeto
function ejecutarConsultaSimpleFila($sql)
{
	global $conexion;
	$query = $conexion->query($sql);
	$row = $query->fetch_object();
	return $row;
}

// Inserta y devuelve el ID del registro insertado
function ejecutarConsulta_retornarID($sql)
{
	global $conexion;
	$query = $conexion->query($sql);
	return $conexion->insert_id;
}

// Limpia la cadena
function limpiarCadena($str)
{
	global $conexion;
	$str = mysqli_real_escape_string($conexion, trim($str));
	return htmlspecialchars($str);
}

?>