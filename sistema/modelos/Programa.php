<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Programa
{
    public function __construct()
    {
        
    }
    
    // obtenerPrograma($idprograma)
    // Descripción:
    // Obtiene un programa
    // Notas:
    // N/A
    public function obtenerPrograma($idprograma)
    {
        $sql = "SELECT * FROM programa p WHERE p.idprograma = '$idprograma'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // listarProgramaCursosDominio($iddominio)
    // Descripción:
    // Obtiene una lista de los cursos de un programa en un dominio
    // Notas:
    // N/A
    function listarProgramaCursosDominio($iddominio)
    {
         $sql= "SELECT DISTINCT  c.idcurso, c.nombre AS 'curso_nombre', p.nombre as 'programa_nombre' FROM curso c LEFT JOIN programa p ON p.idprograma = c.idprograma WHERE p.iddominio = '$iddominio'";   
         return ejecutarConsulta($sql);
    }
    
    // listarProgramaCursosEscuela($idescuela)
    // Descripción:
    // Obtiene una lista de los cursos de un programa en una escuela
    // Notas:
    // N/A
    function listarProgramaCursosEscuela($idescuela)
    {
         $sql= "SELECT DISTINCT c.idcurso, c.nombre AS 'curso_nombre' FROM ( curso c LEFT JOIN ( programa_escuela p_e LEFT JOIN escuela e ON p_e.idescuela = e.idescuela ) ON c.idprograma = p_e.idprograma ) WHERE e.idescuela = '$idescuela'";   
         return ejecutarConsulta($sql);
    }
}

?>