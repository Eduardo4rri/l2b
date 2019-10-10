<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Dominio
{
    public function __construct()
    {
    
    }
    // obtenerDominio($iddominio)
    // Descripción:
    // Devuelve todos los campos de un dominio por ID
    // Notas:
    // N/A
    public function obtenerDominio($iddominio)
    {
        $sql = "SELECT * FROM dominio d WHERE d.iddominio = '$iddominio'";
        return ejecutarConsultaSimpleFila($sql);
    }
    // obtenerDominioPorNombre($dominio)
    // Descripción:
    // Devuelve todos los campos de un dominio por nombre, comparando por mayúsculas
    // Notas:
    // N/A
    public function obtenerDominioPorNombre($dominio)
    {
        $sql = "SELECT * FROM dominio d WHERE UPPER(d.nombre) = UPPER('$dominio')";
        return ejecutarConsultaSimpleFila($sql);
    }
}

?>