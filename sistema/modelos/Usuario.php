<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/sistema/config/mysql.php";

class Usuario
{
    public function __construct()
    {
        
    }
    
    // loginAlumno($login, $clave, $dominio)
    // Descripción:
    // Realiza el login de un alumno
    // Notas:
    // Se usará para devolver un objeto cuyas propiedades serán customizadas con prefijo 'usuario_'
    public function loginAlumno($login, $clave, $dominio)
    {
        $sql = "SELECT u.iddominio, u.idusuario, u.usuario_idescuela, u.usuario_idprograma, u.usuario_idcurso, u.usuario_idconsignacion, u.rol, u.nombre, u.apellido_paterno, u.apellido_materno, u.email, u.login, u.telefono, u.matricula, u.clave, u.ciudad, u.estado, u.codigo_postal, u.terminos_condiciones, u.dominio, u.sesion_activa, u.token, e.nombre AS 'escuela_nombre', p.nombre AS 'programa_nombre', p.nivel AS 'programa_nivel' FROM ( usuario u LEFT JOIN escuela e ON u.usuario_idescuela = e.idescuela ) LEFT JOIN programa p on u.usuario_idprograma = p.idprograma WHERE u.activo = '1' AND u.validacion = '1' AND u.rol = 'alumno' AND u.login = '$login' AND u.clave = '$clave' AND u.dominio = '$dominio'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // loginCoordinador($login, $clave, $dominio)
    // Descripción:
    // Realiza el login de un coordinador
    // Notas:
    // Se usará para devolver un objeto cuyas propiedades serán customizadas con prefijo 'usuario_'
    public function loginCoordinador($login, $clave, $dominio)
    {
        $sql = "SELECT u.iddominio, u.idusuario, u.usuario_idescuela, u.usuario_idprograma, u.usuario_idcurso, u.usuario_idconsignacion, u.rol, u.nombre, u.apellido_paterno, u.apellido_materno, u.email, u.login, u.telefono, u.matricula, u.clave, u.ciudad, u.estado, u.codigo_postal, u.terminos_condiciones, u.dominio, u.token, e.nombre AS 'escuela_nombre', p.nombre AS 'programa_nombre', p.nivel AS 'programa_nivel' FROM ( usuario u LEFT JOIN escuela e ON u.usuario_idescuela = e.idescuela ) LEFT JOIN programa p on u.usuario_idprograma = p.idprograma WHERE u.activo = '1' AND u.validacion = '1' AND ( u.rol = 'coordinador_dominio' OR u.rol = 'coordinador_zona' OR u.rol = 'coordinador_subzona' OR u.rol = 'coordinador_escuela' ) AND u.login = '$login' AND u.clave = '$clave' AND u.dominio = '$dominio'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // loginDistribuidor($login, $clave, $dominio)
    // Descripción:
    // Realiza el login de un distribuidor
    // Notas:
    // Se usará para devolver un objeto cuyas propiedades serán customizadas con prefijo 'usuario_'
    public function loginDistribuidor($login, $clave, $dominio)
    {
        $sql = "SELECT u.iddominio, u.idusuario, u.usuario_idescuela, u.usuario_idprograma, u.usuario_idcurso, u.usuario_idconsignacion, u.rol, u.nombre, u.apellido_paterno, u.apellido_materno, u.email, u.login, u.telefono, u.matricula, u.clave, u.ciudad, u.estado, u.codigo_postal, u.terminos_condiciones, u.dominio, u.token, e.nombre AS 'escuela_nombre', p.nombre AS 'programa_nombre', p.nivel AS 'programa_nivel' FROM ( usuario u LEFT JOIN escuela e ON u.usuario_idescuela = e.idescuela ) LEFT JOIN programa p on u.usuario_idprograma = p.idprograma WHERE u.activo = '1' AND u.validacion = '1' AND ( u.rol = 'distribuidor_dominio' OR u.rol = 'distribuidor_zona' OR u.rol = 'distribuidor_subzona' OR u.rol = 'distribuidor_escuela' ) AND u.login = '$login' AND u.clave = '$clave' AND u.dominio = '$dominio'";
        return ejecutarConsultaSimpleFila($sql);
    }

    // loginSinSubdominio($login, $clave)
    // Descripción:
    // Realiza el login de un distribuidor
    // Notas:
    // Se usará para devolver un objeto cuyas propiedades serán customizadas con prefijo 'usuario_'
    public function loginSinSubdominio($login, $clave)
    {
        $sql = "SELECT u.iddominio, u.idusuario, u.usuario_idescuela, u.usuario_idprograma, u.usuario_idcurso, u.usuario_idconsignacion, u.rol, u.nombre, u.apellido_paterno, u.apellido_materno, u.email, u.login, u.telefono, u.matricula, u.clave, u.ciudad, u.estado, u.codigo_postal, u.terminos_condiciones, u.dominio, u.token, e.nombre AS 'escuela_nombre', p.nombre AS 'programa_nombre', p.nivel AS 'programa_nivel' FROM ( usuario u LEFT JOIN escuela e ON u.usuario_idescuela = e.idescuela ) LEFT JOIN programa p on u.usuario_idprograma = p.idprograma WHERE u.activo = '1' AND u.validacion = '1' AND ( u.rol = 'coordinador_dominio' OR u.rol = 'coordinador_zona' OR u.rol = 'coordinador_subzona' OR u.rol = 'coordinador_escuela' ) AND u.login = '$login' AND u.clave = '$clave'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // validarLoginDisponible($login, $dominio)
    // Descripción:
    // Valida que un email esté disponible en un dominio
    // Notas:
    // N/A
    public function validarLoginDisponible($login, $dominio)
    {
        $sql = "SELECT u.login FROM usuario u WHERE u.login = '$login' AND UPPER(u.dominio) = UPPER('$dominio')";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerUsuario($idusuario)
    // Descripción:
    // Obtiene un usuario
    // Notas:
    // Se usará para devolver un objeto cuyas propiedades serán customizadas con prefijo 'usuario_'
    public function obtenerUsuario($idusuario)
    {
        $sql = "SELECT u.idusuario, u.iddominio, u.usuario_idescuela, u.usuario_idprograma, u.usuario_idcurso, u.usuario_idconsignacion, u.rol, u.nombre, u.token, u.token_expira, u.token_ultimo, u.apellido_paterno, u.apellido_materno, u.email, u.login, u.telefono, u.matricula, u.clave, u.ciudad, u.estado, u.codigo_postal, u.terminos_condiciones, u.dominio, e.nombre AS 'escuela_nombre', p.nombre AS 'programa_nombre', p.nivel AS 'programa_nivel' FROM ( usuario u LEFT JOIN escuela e ON u.usuario_idescuela = e.idescuela ) LEFT JOIN programa p on u.usuario_idprograma = p.idprograma WHERE u.idusuario = '$idusuario'";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // obtenerIDUsuario($login, $dominio)
    // Descripción:
    // Obtiene un usuario por email y dominio
    // Notas:
    // N/A
    public function obtenerIDUsuario($login, $dominio)
    {
        $sql = "SELECT u.idusuario, u.iddominio, u.usuario_idescuela, u.usuario_idprograma, u.usuario_idcurso, u.usuario_idconsignacion, u.rol, u.nombre, u.token, u.token_expira, u.token_ultimo, u.apellido_paterno, u.apellido_materno, u.email, u.login, u.telefono, u.matricula, u.clave, u.ciudad, u.estado, u.codigo_postal, u.terminos_condiciones, u.dominio, e.nombre AS 'escuela_nombre', p.nombre AS 'programa_nombre', p.nivel AS 'programa_nivel' FROM ( usuario u LEFT JOIN escuela e ON u.usuario_idescuela = e.idescuela ) LEFT JOIN programa p on u.usuario_idprograma = p.idprograma WHERE u.login = '$login' AND UPPER(u.dominio) = UPPER('$dominio')";
        return ejecutarConsultaSimpleFila($sql);
    }
    
    // registrarAlumno($iddominio, $nombre, $apellido_paterno, $apellido_materno, $telefono, $matricula, $login, $clave, $dominio)
    // Descripción:
    // Registra a un alumno
    // Notas:
    // N/A
    public function registrarAlumno($iddominio, $nombre, $apellido_paterno, $apellido_materno, $telefono, $matricula, $login, $clave, $dominio)
    {
        $sql = "INSERT INTO usuario (iddominio, rol, nombre, apellido_paterno, apellido_materno ,telefono, matricula, email, login, clave, dominio, terminos_condiciones) VALUES ('$iddominio', 'alumno', '$nombre', '$apellido_paterno', '$apellido_materno', '$telefono', '$matricula', '$login', '$login', '$clave', '$dominio', '1')";
        return ejecutarConsulta_retornarID($sql);
    }
    
    // actualizarUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $telefono, $matricula, $terminos_condiciones, $idescuela, $idprograma, $idcurso, $idconsignacion)
    // Descripción:
    // Actualiza los datos de un usuario
    // Notas:
    // N/A
    public function actualizarUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $telefono, $login,$matricula, $terminos_condiciones, $idescuela, $idprograma, $idcurso, $idconsignacion)
    {
        $sql = "UPDATE usuario SET nombre = '$nombre', apellido_paterno = '$apellido_paterno', apellido_materno = '$apellido_materno', telefono = '$telefono',  login = '$login', email='$login', matricula = '$matricula', terminos_condiciones = '$terminos_condiciones', usuario_idescuela = '$idescuela', usuario_idprograma = '$idprograma', usuario_idcurso = '$idcurso', usuario_idconsignacion = '$idconsignacion' WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarUsuarioClave($idusuario, $clave)
    // Descripción:
    // Actualiza la contraseña de un usuario
    // Notas:
    // N/A
    public function actualizarUsuarioClave($idusuario, $clave)
    {
        $sql = "UPDATE usuario SET clave = '$clave' WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarUsuarioDistribuidorDistribuidor($idusuario, $alias, $nombre, $apellido_paterno, $apellido_materno, $telefono, $estado, $ciudad, $calle, $colonia, $num_exterior, $num_interior, $codigo_postal)
    // Descripción:
    // Actualiza los datos de un usuario distribuidor en la tabla distribuidor
    // Notas:
    // Es parte del proceso para actualizar los datos de un distribuidor ya que sus datos se reparten en las tablas de usuario y distribuidor
    public function actualizarUsuarioDistribuidorDistribuidor($idusuario, $alias, $nombre, $apellido_paterno, $apellido_materno, $telefono, $estado, $ciudad, $calle, $colonia, $num_exterior, $num_interior, $codigo_postal)
    {
        $updateNombre = $nombre . '' . $apellido_paterno . '' . $apellido_materno;
        $sql          = "UPDATE distribuidor SET alias = '$alias', nombre = '$updateNombre', telefono_contacto = '$telefono', estado = '$estado', ciudad = '$ciudad', calle = '$calle', colonia = '$colonia', num_exterior = '$num_exterior', num_interior =  '$num_interior', codigo_postal = '$codigo_postal' WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarUsuarioDistribuidorUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $clave, $matricula, $telefono, $estado, $ciudad, $codigo_postal, $terminos_condiciones)
    // Descripción:
    // Actualiza los datos de un usuario distribuidor en la tabla usuario
    // Notas:
    // Es parte del proceso para actualizar los datos de un distribuidor ya que sus datos se reparten en las tablas de usuario y distribuidor
    public function actualizarUsuarioDistribuidorUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $clave, $matricula, $telefono, $estado, $ciudad, $codigo_postal, $terminos_condiciones)
    {
        $sql = "UPDATE usuario SET nombre = '$nombre', apellido_paterno = '$apellido_paterno', apellido_materno = '$apellido_materno', clave = '$clave', matricula = '$matricula', telefono = '$telefono', estado = '$estado', ciudad = '$ciudad', codigo_postal = '$codigo_postal', terminos_condiciones = '$terminos_condiciones' WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarDatosDistribuidor($idusuario, $alias, $nombre, $telefono, $estado, $ciudad, $colonia, $calle, $num_exterior, $num_interior, $codigo_postal)
    // Descripción:
    // Actualiza los datos de un distribuidor en la tabla usuario
    // Notas:
    // Es parte del proceso para actualizar los datos de un distribuidor ya que sus datos se reparten en las tablas de usuario y distribuidor
    public function actualizarDatosDistribuidor($idusuario, $alias, $nombre, $telefono, $estado, $ciudad, $colonia, $calle, $num_exterior, $num_interior, $codigo_postal)
    {
        $sql = "UPDATE distribuidor SET alias = '$alias', nombre = '$nombre', telefono_contacto = '$telefono', estado = '$estado', ciudad = '$ciudad', calle = '$calle', colonia = '$colonia', num_exterior = '$num_exterior', num_interior =  '$num_interior', codigo_postal = '$codigo_postal' WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }
    
    // actualizarUsuarioTokenTimestamp($idusuario, $usuario_token, $usuario_token_expira, $usuario_token_ultimo)
    // Descripción:
    // Actualiza el token de un usuario
    // Notas:
    // N/A
    public function actualizarUsuarioTokenTimestamp($idusuario, $usuario_token, $usuario_token_expira, $usuario_token_ultimo)
    {
        $sql = "UPDATE usuario SET token = '$usuario_token', token_expira = '$usuario_token_expira', token_ultimo = '$usuario_token_ultimo' WHERE idusuario = '$idusuario'";
        return ejecutarConsulta($sql);
    }
    
    // verificarTokenDeUsuario($token)
    // Descripción:
    // Verifica que un usuario tenga un token
    // Notas:
    // N/A
    public function verificarTokenDeUsuario($token){
        $sql = "SELECT token, token_expira FROM usuario WHERE token = '$token'";
        return ejecutarConsultaSimpleFila($sql);
    }
}

?>