<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Recompensas
{
    public function __construct()
    {
        
    }
    
    // obtenerRecompensasLibro()
    // Descripción:
    // Obtiene las recompensas que tengan la categoria de libro.
    // Notas:
    // N/A
    public function obtenerRecompensasLibro()
    {
        $sql = "SELECT * FROM recompensa WHERE categoria = 'libro'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerRecompensasCurso()
    // Descripción:
    // Obtiene las recompensas que tengan la categoria de curso.
    // Notas:
    // N/A
    public function obtenerRecompensasCurso()
    {
        $sql = "SELECT * FROM recompensa WHERE categoria = 'curso'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerRecompensasMaterial()
    // Descripción:
    // Obtiene las recompensas que tengan la categoria de material.
    // Notas:
    // N/A
    public function obtenerRecompensasMaterial()
    {
        $sql = "SELECT * FROM recompensa WHERE categoria = 'material'";
        return ejecutarConsulta($sql);
    }
    
    // recompensasSeleccionadas($idrecompensa)
    // Descripción:
    // Muestra la recompensa.
    // Notas:
    // N/A
    public function recompensasSeleccionadas($idrecompensa)
    {
        $sql = "SELECT costo FROM recompensa WHERE idrecompensa = '$idrecompensa'";
        return ejecutarConsulta($sql);
    }
    
    // obtenerRecompensa($idrecompensa)
    // Descripción:
    // Obtiene la recompensa.
    // Notas:
    // N/A
    public function obtenerRecompensa($idrecompensa)
    {
        $sql = "SELECT * FROM recompensa WHERE idrecompensa = '$idrecompensa'";
        return ejecutarConsultaSimpleFila($sql);
    }
}

?>