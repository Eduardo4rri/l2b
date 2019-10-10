<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/config/x.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Dominio.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Zona.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sistema/modelos/Curso.php';

// login($login, $clave, $dominio)
// Descripción:
// Realiza el login del usuario con un email (login), password (clave) y un dominio, los roles disponibles son:
// * alumno
// * coordinador_dominio
// * coordinador_zona
// * coordinador_subzona
// * coordinador_escuela
// Notas:
// Devuelve un objeto cuyas propiedades son customizadas con prefijo 'usuario_'
function login($login, $clave, $dominio)
{
    $login_encontrado      = false;
    $login_encontrado_tipo = '';
    $login_idusuario       = -1;
    $usuario               = new Usuario();
    $data                  = new stdClass();
    $usr                   = new stdClass();
    $rspta                 = $usuario->loginAlumno($login, $clave, $dominio);
    if ($rspta)
    {
        $login_encontrado                  = true;
        $login_encontrado_tipo             = $rspta->rol;
        $login_idusuario                   = $rspta->idusuario;
        $usr->usuario_iddominio            = $rspta->iddominio;
        $usr->usuario_idusuario            = $rspta->idusuario;
        $usr->usuario_idescuela            = $rspta->usuario_idescuela;
        $usr->usuario_idprograma           = $rspta->usuario_idprograma;
        $usr->usuario_idcurso              = $rspta->usuario_idcurso;
        $usr->usuario_idconsignacion       = $rspta->usuario_idconsignacion;
        $usr->usuario_rol                  = $rspta->rol;
        $usr->usuario_nombre               = $rspta->nombre;
        $usr->usuario_apellido_paterno     = $rspta->apellido_paterno;
        $usr->usuario_apellido_materno     = $rspta->apellido_materno;
        $usr->usuario_email                = $rspta->email;
        $usr->usuario_login                = $rspta->login;
        $usr->usuario_telefono             = $rspta->telefono;
        $usr->usuario_matricula            = $rspta->matricula;
        $usr->usuario_ciudad               = $rspta->ciudad;
        $usr->usuario_estado               = $rspta->estado;
        $usr->usuario_codigo_postal        = $rspta->codigo_postal;
        $usr->usuario_terminos_condiciones = $rspta->terminos_condiciones;
        $usr->usuario_escuela_nombre       = $rspta->escuela_nombre;
        $usr->usuario_programa_nombre      = $rspta->programa_nombre;
        $usr->usuario_programa_nivel       = $rspta->programa_nivel;
    }
    if ($login_encontrado == false)
    {
        $rspta = $usuario->loginCoordinador($login, $clave, $dominio);
        if ($rspta)
        {
            $login_encontrado                  = true;
            $login_encontrado_tipo             = $rspta->rol;
            $login_idusuario                   = $rspta->idusuario;
            $usr->usuario_iddominio            = $rspta->iddominio;
            $usr->usuario_idusuario            = $rspta->idusuario;
            $usr->usuario_idescuela            = $rspta->usuario_idescuela;
            $usr->usuario_idprograma           = $rspta->usuario_idprograma;
            $usr->usuario_idcurso              = $rspta->usuario_idcurso;
            $usr->usuario_idconsignacion       = $rspta->usuario_idconsignacion;
            $usr->usuario_rol                  = $rspta->rol;
            $usr->usuario_nombre               = $rspta->nombre;
            $usr->usuario_apellido_paterno     = $rspta->apellido_paterno;
            $usr->usuario_apellido_materno     = $rspta->apellido_materno;
            $usr->usuario_email                = $rspta->email;
            $usr->usuario_login                = $rspta->login;
            $usr->usuario_telefono             = $rspta->telefono;
            $usr->usuario_matricula            = $rspta->matricula;
            $usr->usuario_ciudad               = $rspta->ciudad;
            $usr->usuario_estado               = $rspta->estado;
            $usr->usuario_codigo_postal        = $rspta->codigo_postal;
            $usr->usuario_terminos_condiciones = $rspta->terminos_condiciones;
            $usr->usuario_escuela_nombre       = $rspta->escuela_nombre;
            $usr->usuario_programa_nombre      = $rspta->programa_nombre;
            $usr->usuario_programa_nivel       = $rspta->programa_nivel;
        }
    }
    if ($login_encontrado == false)
    {
        $rspta = $usuario->loginDistribuidor($login, $clave, $dominio);
        if ($rspta)
        {
            $login_encontrado                  = true;
            $login_encontrado_tipo             = $rspta->rol;
            $login_idusuario                   = $rspta->idusuario;
            $usr->usuario_iddominio            = $rspta->iddominio;
            $usr->usuario_idusuario            = $rspta->idusuario;
            $usr->usuario_idescuela            = $rspta->usuario_idescuela;
            $usr->usuario_idprograma           = $rspta->usuario_idprograma;
            $usr->usuario_idcurso              = $rspta->usuario_idcurso;
            $usr->usuario_idconsignacion       = $rspta->usuario_idconsignacion;
            $usr->usuario_rol                  = $rspta->rol;
            $usr->usuario_nombre               = $rspta->nombre;
            $usr->usuario_apellido_paterno     = $rspta->apellido_paterno;
            $usr->usuario_apellido_materno     = $rspta->apellido_materno;
            $usr->usuario_email                = $rspta->email;
            $usr->usuario_login                = $rspta->login;
            $usr->usuario_telefono             = $rspta->telefono;
            $usr->usuario_matricula            = $rspta->matricula;
            $usr->usuario_ciudad               = $rspta->ciudad;
            $usr->usuario_estado               = $rspta->estado;
            $usr->usuario_codigo_postal        = $rspta->codigo_postal;
            $usr->usuario_terminos_condiciones = $rspta->terminos_condiciones;
            $usr->usuario_escuela_nombre       = $rspta->escuela_nombre;
            $usr->usuario_programa_nombre      = $rspta->programa_nombre;
            $usr->usuario_programa_nivel       = $rspta->programa_nivel;
        }
    } 
    if ($login_encontrado == true)
    {
        $dominatrix                                    = new Dominio();
        $domdat                                        = $dominatrix->obtenerDominio($usr->usuario_iddominio);
        $usr->usuario_dominio                          = strtoupper($domdat->nombre);
        $_SESSION['usuario_idusuario']                 = $rspta->idusuario;
        $_SESSION['usuario_rol']                       = $rspta->rol;
        $_SESSION['usuario_login']                     = $rspta->login;
        $_SESSION['usuario_dominio']                   = strtoupper($domdat->nombre);
        
        ///////////////////////////////////////////////////////////////////
        // OBTENER LAS ZONAS, SUBZONAS Y ESCUELAS PARA LOS ALUMNOS
        ///////////////////////////////////////////////////////////////////
        
        if ($login_encontrado_tipo == 'alumno')
        {
            // >:3
        }
        
        ///////////////////////////////////////////////////////////////////
        // OBTENER LAS ZONAS, SUBZONAS Y ESCUELAS PARA LOS COORDINADORES
        ///////////////////////////////////////////////////////////////////
        
        else if ($login_encontrado_tipo == 'coordinador_dominio')
        {
            $zonas = DOMINIO_obtenerZonasDeDominio($usr->usuario_iddominio);
            if ($zonas->resultado == 'OK')
            {
                $zonas_arreglo = $zonas->detalles;
                for ($x = 0; $x < count($zonas_arreglo); $x++)
                {
                    $idzona                      = $zonas_arreglo[$x]->idzona;
                    $zonas_arreglo[$x]->subzonas = Array();
                    $subzonas                    = DOMINIO_obtenerSubzonasDeZona($idzona);
                    if ($subzonas->resultado == 'OK')
                    {
                        $subzonas_arreglo = $subzonas->detalles;
                        for ($y = 0; $y < count($subzonas_arreglo); $y++)
                        {
                            $idsubzona                            = $subzonas_arreglo[$y]->idsubzona;
                            $subzonas_arreglo[$y]->escuelas       = Array();
                            $subzonas_arreglo[$y]->escuelas_total = 0;
                            $escuelas                             = DOMINIO_obtenerEscuelasDeSubzona($idsubzona);
                            if ($escuelas->resultado == 'OK')
                            {
                                $escuelas_arreglo                     = $escuelas->detalles;
                                $subzonas_arreglo[$y]->escuelas       = $escuelas_arreglo;
                                $subzonas_arreglo[$y]->escuelas_total = count($escuelas_arreglo);
                            }
                        }
                        $zonas_arreglo[$x]->subzonas = $subzonas_arreglo;
                    }
                }
                $usr->usuario_zonas = $zonas->detalles;
            }
        }
        else if ($login_encontrado_tipo == 'coordinador_zona')
        {
            $zonas = ZONA_obtenerZonasDeUsuarioCoordinadorDeZona($usr->usuario_idusuario);
            if ($zonas->resultado == 'OK')
            {
                $zonas_arreglo = $zonas->detalles;
                for ($x = 0; $x < count($zonas_arreglo); $x++)
                {
                    $idzona                      = $zonas_arreglo[$x]->idzona;
                    $zonas_arreglo[$x]->subzonas = Array();
                    $subzonas                    = ZONA_obtenerSubzonasDeZona($idzona);
                    if ($subzonas->resultado == 'OK')
                    {
                        $subzonas_arreglo = $subzonas->detalles;
                        for ($y = 0; $y < count($subzonas_arreglo); $y++)
                        {
                            $idsubzona                            = $subzonas_arreglo[$y]->idsubzona;
                            $subzonas_arreglo[$y]->escuelas       = Array();
                            $subzonas_arreglo[$y]->escuelas_total = 0;
                            $escuelas                             = ZONA_obtenerEscuelasDeSubzona($idsubzona);
                            if ($escuelas->resultado == 'OK')
                            {
                                $escuelas_arreglo                     = $escuelas->detalles;
                                $subzonas_arreglo[$y]->escuelas       = $escuelas_arreglo;
                                $subzonas_arreglo[$y]->escuelas_total = count($escuelas_arreglo);
                            }
                        }
                        $zonas_arreglo[$x]->subzonas = $subzonas_arreglo;
                    }
                }
                $usr->usuario_zonas = $zonas->detalles;
            }
        }
        else if ($login_encontrado_tipo == 'coordinador_subzona')
        {
            $zonas = SUBZONA_obtenerZonasDeUsuarioCoordinadorDeSubzona($usr->usuario_idusuario);
            if ($zonas->resultado == 'OK')
            {
                $zonas_arreglo = $zonas->detalles;
                for ($x = 0; $x < count($zonas_arreglo); $x++)
                {
                    $idzona                      = $zonas_arreglo[$x]->idzona;
                    $zonas_arreglo[$x]->subzonas = Array();
                    $subzonas                    = SUBZONA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeSubzona($idzona, $usr->usuario_idusuario);
                    if ($subzonas->resultado == 'OK')
                    {
                        $subzonas_arreglo = $subzonas->detalles;
                        for ($y = 0; $y < count($subzonas_arreglo); $y++)
                        {
                            $idsubzona                            = $subzonas_arreglo[$y]->idsubzona;
                            $subzonas_arreglo[$y]->escuelas       = Array();
                            $subzonas_arreglo[$y]->escuelas_total = 0;
                            $escuelas                             = SUBZONA_obtenerEscuelasDeSubzona($idsubzona);
                            if ($escuelas->resultado == 'OK')
                            {
                                $escuelas_arreglo                     = $escuelas->detalles;
                                $subzonas_arreglo[$y]->escuelas       = $escuelas_arreglo;
                                $subzonas_arreglo[$y]->escuelas_total = count($escuelas_arreglo);
                            }
                        }
                        $zonas_arreglo[$x]->subzonas = $subzonas_arreglo;
                    }
                }
                $usr->usuario_zonas = $zonas->detalles;
            }
        }
        else if ($login_encontrado_tipo == 'coordinador_escuela')
        {
            $zonas = ESCUELA_obtenerZonasDeUsuarioCoordinadorDeEscuela($usr->usuario_idusuario);
            if ($zonas->resultado == 'OK')
            {
                $zonas_arreglo = $zonas->detalles;
                for ($x = 0; $x < count($zonas_arreglo); $x++)
                {
                    $idzona                      = $zonas_arreglo[$x]->idzona;
                    $zonas_arreglo[$x]->subzonas = Array();
                    $subzonas                    = ESCUELA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeEscuela($idzona, $usr->usuario_idusuario);
                    if ($subzonas->resultado == 'OK')
                    {
                        $subzonas_arreglo = $subzonas->detalles;
                        for ($y = 0; $y < count($subzonas_arreglo); $y++)
                        {
                            $idsubzona                            = $subzonas_arreglo[$y]->idsubzona;
                            $subzonas_arreglo[$y]->escuelas       = Array();
                            $subzonas_arreglo[$y]->escuelas_total = 0;
                            $escuelas                             = ESCUELA_obtenerEscuelasDeSubzonaDeUsuarioCoordinadorDeEscuela($idsubzona, $usr->usuario_idusuario);
                            if ($escuelas->resultado == 'OK')
                            {
                                $escuelas_arreglo                     = $escuelas->detalles;
                                $subzonas_arreglo[$y]->escuelas       = $escuelas_arreglo;
                                $subzonas_arreglo[$y]->escuelas_total = count($escuelas_arreglo);
                            }
                        }
                        $zonas_arreglo[$x]->subzonas = $subzonas_arreglo;
                    }
                }
                $usr->usuario_zonas = $zonas->detalles;
            }
        }
        
        $usuario_token            = uniqid();
        $date                     = new DateTime();
        $usuario_token_expira_pre = $date->getTimestamp() + PRO_TOKEN_TIMEOUT;
        $usuario_token_ultimo_pre = $date->getTimestamp();
        $usuario_token_expira     = date('Y-m-d H:i:s', $usuario_token_expira_pre);
        $usuario_token_ultimo     = date('Y-m-d H:i:s', $usuario_token_ultimo_pre);
        $usuario->actualizarUsuarioTokenTimestamp($usr->usuario_idusuario, $usuario_token, $usuario_token_expira, $usuario_token_ultimo);
        $usr->usuario_token               = $usuario_token;
        $usr->usuario_token_expira        = $usuario_token_expira;
        $usr->usuario_token_ultimo        = $usuario_token_ultimo;
        $_SESSION['usuario_token']        = $usr->usuario_token;
        $_SESSION['usuario_token_expira'] = $usr->usuario_token_expira;
        $_SESSION['usuario_token_ultimo'] = $usr->usuario_token_ultimo;
        $rspta_periodo                    = CURSO_obtenerCurso($rspta->usuario_idcurso);
        $usr->usuario_curso               = $rspta_periodo->detalles;
        $data->resultado                  = 'OK';
        $data->mensaje                    = '¡Login correcto!';
        $data->detalles                   = $usr;
    }
    else
    {
        $_SESSION['usuario_idusuario']                 = '';
        $_SESSION['usuario_rol']                       = '';
        $_SESSION['usuario_login']                     = '';
        $_SESSION['usuario_dominio']                   = '';
        $data->resultado                               = 'ERROR';
        $data->mensaje                                 = '¡Correo electrónico/contraseña no encontrados en ' . strtoupper($dominio) . '!';
        $data->detalles                                = null;
    }
    return $data;
}

// validarLoginDisponible($login, $dominio)
// Descripción:
// Valida que un email esté disponible en un dominio
// Notas:
// N/A
function validarLoginDisponible($login, $dominio)
{
    $usuario = new Usuario();
    $data    = new stdClass();
    $rspta   = $usuario->validarLoginDisponible($login, $dominio);
    if (!$rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Login disponible!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Login no disponible (ya se encuentra registrado)!';
        $data->detalles  = null;
    }
    return $data;
}

// validarLoginRegistrado($login, $dominio)
// Descripción:
// Valida que un email esté registrado en un dominio
// Notas:
// Se usa para enviar emails de recuperación de contraseña
function validarLoginRegistrado($login, $dominio)
{
    $usuario = new Usuario();
    $data    = new stdClass();
    $rspta   = $usuario->validarLoginDisponible($login, $dominio);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Login registrado!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Login no encontrado/registrado!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerUsuario($idusuario)
// Descripción:
// Obtiene un usuario
// Notas:
// Devuelve un objeto cuyas propiedades son customizadas con prefijo 'usuario_'
function obtenerUsuario($idusuario)
{
    $usuario                = new Usuario();
    $rspta                  = $usuario->obtenerUsuario($idusuario);
    $data                   = new stdClass();
    $usr                    = new stdClass();
    if ($rspta)
    {
        $usr->usuario_idusuario                 = $rspta->idusuario;
        $usr->usuario_iddominio                 = $rspta->iddominio;
        $usr->usuario_idescuela                 = $rspta->usuario_idescuela;
        $usr->usuario_idprograma                = $rspta->usuario_idprograma;
        $usr->usuario_idcurso                   = $rspta->usuario_idcurso;
        $usr->usuario_idconsignacion            = $rspta->usuario_idconsignacion;
        $usr->usuario_rol                       = $rspta->rol;
        $usr->usuario_nombre                    = $rspta->nombre;
        $usr->usuario_apellido_paterno          = $rspta->apellido_paterno;
        $usr->usuario_apellido_materno          = $rspta->apellido_materno;
        $usr->usuario_email                     = $rspta->email;
        $usr->usuario_login                     = $rspta->login;
        $usr->usuario_telefono                  = $rspta->telefono;
        $usr->usuario_matricula                 = $rspta->matricula;
        $usr->usuario_clave                     = $rspta->clave;
        $usr->usuario_ciudad                    = $rspta->ciudad;
        $usr->usuario_estado                    = $rspta->estado;
        $usr->usuario_codigo_postal             = $rspta->codigo_postal;
        $usr->usuario_terminos_condiciones      = $rspta->terminos_condiciones;
        $usr->usuario_dominio                   = $rspta->dominio;
        $usr->usuario_token                     = $rspta->token;
        $usr->usuario_token_expira              = $rspta->token_expira;
        $usr->usuario_token_ultimo              = $rspta->token_ultimo;
        $usr->usuario_escuela_nombre            = $rspta->escuela_nombre;
        $usr->usuario_programa_nombre           = $rspta->programa_nombre;
        $usr->usuario_programa_nivel            = $rspta->programa_nivel;
        $rspta_periodo                          = CURSO_obtenerCurso($rspta->usuario_idcurso);
        $usr->usuario_curso                     = $rspta_periodo->detalles;
        $data->resultado                        = 'OK';
        $data->mensaje                          = '¡Datos del usuario disponibles!';
        $data->detalles                         = $usr;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos del usuario no disponibles!';
        $data->detalles  = null;
    }
    return $data;
}

// obtenerIDUsuario($login, $dominio)
// Descripción:
// Obtiene un usuario por email y dominio
// Notas:
// N/A
function obtenerIDUsuario($login, $dominio)
{
    $usuario = new Usuario();
    $data    = new stdClass();
    $usr     = new stdClass();
    $rspta   = $usuario->obtenerIDUsuario($login, $dominio);
    if ($rspta)
    {
        $usr                                    = obtenerUsuario($rspta->idusuario);
        $data->resultado                        = 'OK';
        $data->mensaje                          = '¡Datos del usuario por ID disponibles!';
        $data->detalles                         = $usr;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos del usuario por ID no disponibles!';
        $data->detalles  = null;
    }
    return $data;
}

// registrarAlumno($iddominio, $nombre, $apellido_paterno, $apellido_materno, $telefono, $matricula, $login, $clave, $dominio)
// Descripción:
// Registra a un alumno
// Notas:
// N/A
function registrarAlumno($nombre, $apellido_paterno, $apellido_materno, $telefono, $matricula, $login, $clave, $dominio)
{
    $dominatrix = new Dominio();
    $usuario    = new Usuario();
    $data       = new stdClass();
    $dom        = $dominatrix->obtenerDominioPorNombre($dominio);
    if ($dom)
    {
        $iddominio        = $dom->iddominio;
        $login_disponible = validarLoginDisponible($login, $dominio);
        if ($login_disponible->resultado == 'OK')
        {
            $rspta = $usuario->registrarAlumno($iddominio, $nombre, $apellido_paterno,  $apellido_materno, $telefono, $matricula, $login, $clave, $dominio);
            if ($rspta > 0)
            {
                $idalumno = $rspta;
                $notif    = notificarRegistroAlumno($idalumno);
                if ($notif->resultado == 'OK')
                {
                    $data->resultado = 'OK';
                    $data->mensaje   = '¡Alumno registrado!';
                    $data->detalles  = null;
                }
                else
                {
                    $data->resultado = 'ADVERTENCIA';
                    $data->mensaje   = '¡Alumno registrado, pero ocurrió un error al enviar la notificación de registro!';
                    $data->detalles  = null;
                }
            }
            else
            {
                $data->resultado = 'ERROR';
                $data->mensaje   = '¡Problema interno al registrar al alumno!';
                $data->detalles  = null;
            }
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = $login_disponible->mensaje;
            $data->detalles  = null;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡El dominio especificado no existe!';
        $data->detalles  = null;
    }
    return $data;
}

// notificarRegistroAlumno($idalumno)
// Descripción:
// Envía un email de notificación de registro a un alumno
// Notas:
// El servicio se realiza en un servidor FileMaker para realizar el envío del email
function notificarRegistroAlumno($idalumno)
{
    $data = new stdClass();
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPGET, 1);
    curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_SEND_EMAILS_USERS);
    curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
    curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
    curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ['userID' => $idalumno, 'type' => 'Registro Alumno']);
    curl_exec($curl);
    if (curl_error($curl))
    {
        $error_msg = curl_error($curl);
    }
    if (!isset($error_msg))
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Notificación de registro enviada al alumno!';
        $data->detalles  = null;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $error_msg;
        $data->detalles  = null;
    }
    curl_close($curl);
    return $data;
}

// recuperarPassword($login, $dominio)
// Descripción:
// Envía un email de recuperación de password a un usuario identificado por email (login)
// Notas:
// El servicio se realiza en un servidor FileMaker para realizar el envío del email
function recuperarPassword($login, $dominio)
{
    $data    = new stdClass();
    $usuario = obtenerIDUsuario($login, $dominio);
    if ($usuario->resultado == 'OK')
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPGET, 1);
        curl_setopt($curl, CURLOPT_URL, PRO_ENDPOINT_SEND_EMAILS_USERS);
        curl_setopt($curl, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 2);
        curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($curl, CURLOPT_POSTFIELDS, ['userID' => $usuario->detalles->detalles->usuario_idusuario, 'type' => 'Recuperar Password']);
        curl_exec($curl);
        if (curl_error($curl))
        {
            $error_msg = curl_error($curl);
        }
        if (!isset($error_msg))
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡Recuperación de contraseña enviada!';
            $data->detalles  = null;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = $error_msg;
            $data->detalles  = null;
        }
        curl_close($curl);
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = $usuario->mensaje;
        $data->detalles  = null;
    }
    return $data;
}

// actualizarUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $telefono, $matricula, $terminos_condiciones, $idescuela, $idprograma, $idcurso, $idconsignacion)
// Descripción:
// Actualiza los datos de un usuario
// Notas:
// N/A
function actualizarUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $telefono, $login, $matricula, $terminos_condiciones, $idescuela, $idprograma, $idcurso, $idconsignacion)
{
    $usuario = new Usuario();
    $data    = new stdClass();
    $rspta   = $usuario->actualizarUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $telefono, $login, $matricula, $terminos_condiciones, $idescuela, $idprograma, $idcurso, $idconsignacion);
    if ($rspta)
    {
        $usuario_act = obtenerUsuario($idusuario);
        if ($usuario_act->resultado == 'OK')
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡Usuario actualizado!';
            $data->detalles  = $usuario_act->detalles;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡Datos del usuario no disponibles!';
            $data->detalles  = null;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al actualizar al usuario!';
        $data->detalles  = null;
    }
    return $data;
}

// actualizarUsuarioClave($idusuario, $clave)
// Descripción:
// Actualiza la contraseña de un usuario
// Notas:
// N/A
function actualizarUsuarioClave($idusuario, $clave)
{
    $usuario = new Usuario();
    $data    = new stdClass();
    $rspta   = $usuario->actualizarUsuarioClave($idusuario, $clave);
    if ($rspta)
    {
        $usuario_act = obtenerUsuario($idusuario);
        if ($usuario_act->resultado == 'OK')
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡Clave del usuario actualizada!';
            $data->detalles  = $usuario_act->detalles;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡Datos del usuario no disponibles!';
            $data->detalles  = null;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al actualizar la clave del usuario!';
        $data->detalles  = null;
    }
    return $data;
}

// actualizarUsuarioDistribuidorDistribuidor($idusuario, $alias, $nombre, $apellido_paterno, $apellido_materno, $telefono, $estado, $ciudad, $calle, $colonia, $num_exterior, $num_interior, $codigo_postal)
// Descripción:
// Actualiza los datos de un usuario distribuidor en la tabla distribuidor
// Notas:
// Es parte del proceso para actualizar los datos de un distribuidor ya que sus datos se reparten en las tablas de usuario y distribuidor
function actualizarUsuarioDistribuidorDistribuidor($idusuario, $alias, $nombre, $apellido_paterno, $apellido_materno, $telefono, $estado, $ciudad, $calle, $colonia, $num_exterior, $num_interior, $codigo_postal)
{
    $usuario = new Usuario();
    $data    = new stdClass();
    $rspta   = $usuario->actualizarUsuarioDistribuidorDistribuidor($idusuario, $alias, $nombre, $apellido_paterno, $apellido_materno, $telefono, $estado, $ciudad, $calle, $colonia, $num_exterior, $num_interior, $codigo_postal);
    if ($rspta)
    {
        $usuario_act = obtenerUsuario($idusuario);
        if ($usuario_act->resultado == 'OK')
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡Usuario actualizado!';
            $data->detalles  = $usuario_act->detalles;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡Datos del usuario no disponibles!';
            $data->detalles  = null;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al actualizar al usuario!';
        $data->detalles  = null;
    }
    return $data;
}

// actualizarUsuarioDistribuidorUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $clave, $matricula, $telefono, $estado, $ciudad, $codigo_postal, $terminos_condiciones)
// Descripción:
// Actualiza los datos de un usuario distribuidor en la tabla usuario
// Notas:
// Es parte del proceso para actualizar los datos de un distribuidor ya que sus datos se reparten en las tablas de usuario y distribuidor
function actualizarUsuarioDistribuidorUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $clave, $matricula, $telefono, $estado, $ciudad, $codigo_postal, $terminos_condiciones)
{
    $usuario = new Usuario();
    $data    = new stdClass();
    $rspta   = $usuario->actualizarUsuarioDistribuidorUsuario($idusuario, $nombre, $apellido_paterno, $apellido_materno, $clave, $matricula, $telefono, $estado, $ciudad, $codigo_postal, $terminos_condiciones);
    if ($rspta)
    {
        $usuario_act = obtenerUsuario($idusuario);
        if ($usuario_act->resultado == 'OK')
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡Usuario actualizado!';
            $data->detalles  = $usuario_act->detalles;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡Datos del usuario no disponibles!';
            $data->detalles  = null;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al actualizar al usuario!';
        $data->detalles  = null;
    }
    return $data;
}

// actualizarDatosDistribuidor($idusuario, $alias, $nombre, $telefono, $estado, $ciudad, $colonia, $calle, $num_exterior, $num_interior, $codigo_postal)
// Descripción:
// Actualiza los datos de un distribuidor en la tabla usuario
// Notas:
// Es parte del proceso para actualizar los datos de un distribuidor ya que sus datos se reparten en las tablas de usuario y distribuidor
function actualizarDatosDistribuidor($idusuario, $alias, $nombre, $telefono, $estado, $ciudad, $colonia, $calle, $num_exterior, $num_interior, $codigo_postal)
{
    $usuario = new Usuario();
    $data    = new stdClass();
    $rspta   = $usuario->actualizarDatosDistribuidor($idusuario, $alias, $nombre, $telefono, $estado, $ciudad, $colonia, $calle, $num_exterior, $num_interior, $codigo_postal);
    if ($rspta)
    {
        $usuario_act = obtenerUsuarioDistribuidor($idusuario);
        if ($usuario_act->resultado == 'OK')
        {
            $data->resultado = 'OK';
            $data->mensaje   = '¡Usuario actualizado!';
            $data->detalles  = $usuario_act->detalles;
        }
        else
        {
            $data->resultado = 'ERROR';
            $data->mensaje   = '¡Datos del usuario no disponibles!';
            $data->detalles  = null;
        }
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Problema interno al actualizar al usuario!';
        $data->detalles  = null;
    }
    return $data;
}

///////////////////////////////////////////////////////
// FUNCIONES ESPECIALES PARA COORDINADORES DE DOMINIO
///////////////////////////////////////////////////////

// DOMINIO_obtenerZonasDeDominio($iddominio)
// Descripción:
// Obtiene una lista con las zonas de un dominio cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function DOMINIO_obtenerZonasDeDominio($iddominio)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->DOMINIO_obtenerZonasDeDominio($iddominio);
    if ($rspta)
    {
        $zonas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($zonas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de zonas disponible!';
        $data->detalles  = $zonas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de zonas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// DOMINIO_obtenerSubzonasDeZona($idzona)
// Descripción:
// Obtiene una lista con las subzonas de una zona cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function DOMINIO_obtenerSubzonasDeZona($idzona)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->DOMINIO_obtenerSubzonasDeZona($idzona);
    if ($rspta)
    {
        $subzonas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($subzonas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de subzonas disponible!';
        $data->detalles  = $subzonas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de subzonas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// DOMINIO_obtenerEscuelasDeSubzona($idsubzona)
// Descripción:
// Obtiene una lista con las escuelas de una subzona cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function DOMINIO_obtenerEscuelasDeSubzona($idsubzona)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->DOMINIO_obtenerEscuelasDeSubzona($idsubzona);
    if ($rspta)
    {
        $escuela = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($escuela, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de escuelas disponible!';
        $data->detalles  = $escuela;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de escuelas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

////////////////////////////////////////////////////
// FUNCIONES ESPECIALES PARA COORDINADORES DE ZONA
////////////////////////////////////////////////////

// ZONA_obtenerZonasDeUsuarioCoordinadorDeZona($idusuario)
// Descripción:
// Obtiene una lista con las zonas de un usuario coordinador de zona cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function ZONA_obtenerZonasDeUsuarioCoordinadorDeZona($idusuario)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->ZONA_obtenerZonasDeUsuarioCoordinadorDeZona($idusuario);
    if ($rspta)
    {
        $zonas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($zonas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de zonas disponible!';
        $data->detalles  = $zonas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de zonas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// ZONA_obtenerSubzonasDeZona($idzona)
// Descripción:
// Obtiene una lista con las subzonas de una zona cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function ZONA_obtenerSubzonasDeZona($idzona)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->ZONA_obtenerSubzonasDeZona($idzona);
    if ($rspta)
    {
        $subzonas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($subzonas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de subzonas disponible!';
        $data->detalles  = $subzonas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de subzonas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// ZONA_obtenerEscuelasDeSubzona($idsubzona)
// Descripción:
// Obtiene una lista con las escuelas de una subzona cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function ZONA_obtenerEscuelasDeSubzona($idsubzona)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->ZONA_obtenerEscuelasDeSubzona($idsubzona);
    if ($rspta)
    {
        $escuela = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($escuela, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de escuelas disponible!';
        $data->detalles  = $escuela;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de escuelas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

///////////////////////////////////////////////////////
// FUNCIONES ESPECIALES PARA COORDINADORES DE SUBZONA
///////////////////////////////////////////////////////

// SUBZONA_obtenerZonasDeUsuarioCoordinadorDeSubzona($idusuario)
// Descripción:
// Obtiene una lista con las zonas de un usuario coordinador de subzona cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function SUBZONA_obtenerZonasDeUsuarioCoordinadorDeSubzona($idusuario)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->SUBZONA_obtenerZonasDeUsuarioCoordinadorDeSubzona($idusuario);
    if ($rspta)
    {
        $zonas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($zonas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de zonas disponible!';
        $data->detalles  = $zonas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de zonas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// SUBZONA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeSubzona($idzona, $idusuario)
// Descripción:
// Obtiene una lista con las subzonas de una zona y un coordinador de subzona cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function SUBZONA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeSubzona($idzona, $idusuario)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->SUBZONA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeSubzona($idzona, $idusuario);
    if ($rspta)
    {
        $subzonas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($subzonas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de subzonas disponible!';
        $data->detalles  = $subzonas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de subzonas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// SUBZONA_obtenerEscuelasDeSubzona($idsubzona)
// Descripción:
// Obtiene una lista con las escuelas de una subzona cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function SUBZONA_obtenerEscuelasDeSubzona($idsubzona)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->SUBZONA_obtenerEscuelasDeSubzona($idsubzona);
    if ($rspta)
    {
        $escuela = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($escuela, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de escuelas disponible!';
        $data->detalles  = $escuela;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de escuelas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

///////////////////////////////////////////////////////
// FUNCIONES ESPECIALES PARA COORDINADORES DE ESCUELA
///////////////////////////////////////////////////////

// ESCUELA_obtenerZonasDeUsuarioCoordinadorDeEscuela($idusuario)
// Descripción:
// Obtiene una lista con las zonas de un usuario coordinador de escuela cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function ESCUELA_obtenerZonasDeUsuarioCoordinadorDeEscuela($idusuario)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->ESCUELA_obtenerZonasDeUsuarioCoordinadorDeEscuela($idusuario);
    if ($rspta)
    {
        $zonas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($zonas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de zonas disponible!';
        $data->detalles  = $zonas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de zonas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// ESCUELA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeEscuela($idzona, $idusuario)
// Descripción:
// Obtiene una lista con las subzonas de una zona y un coordinador de escuela cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function ESCUELA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeEscuela($idzona, $idusuario)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->ESCUELA_obtenerSubzonasDeZonaDeUsuarioCoordinadorDeEscuela($idzona, $idusuario);
    if ($rspta)
    {
        $subzonas = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($subzonas, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de subzonas disponible!';
        $data->detalles  = $subzonas;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de subzonas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

// ESCUELA_obtenerEscuelasDeSubzonaDeUsuarioCoordinadorDeEscuela($idsubzona, $idusuario)
// Descripción:
// Obtiene una lista con las escuelas de una subzona y un coordinador de escuela cuyas propiedades no son customizadas y no tienen prefijo
// Notas:
// Fue pensada sólo para coordinadores, pero se puede extender según sea necesario, so be my fucking guest you Mr. Johny Come Lately
function ESCUELA_obtenerEscuelasDeSubzonaDeUsuarioCoordinadorDeEscuela($idsubzona, $idusuario)
{
    $zona  = new Zona();
    $data  = new stdClass();
    $rspta = $zona->ESCUELA_obtenerEscuelasDeSubzonaDeUsuarioCoordinadorDeEscuela($idsubzona, $idusuario);
    if ($rspta)
    {
        $escuela = Array();
        while ($reg = $rspta->fetch_object())
        {
            array_push($escuela, $reg);
        }
        $data->resultado = 'OK';
        $data->mensaje   = '¡Lista de escuelas disponible!';
        $data->detalles  = $escuela;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Lista de escuelas no disponible!';
        $data->detalles  = null;
    }
    return $data;
}

///////////////////////////////////////////////////////
// FUNCIONES ESPECIALES PARA CURSOS
///////////////////////////////////////////////////////

// CURSO_obtenerCurso($idcurso)
// Descripción:
// Obtiene los periodos de un curso
// Notas:
// N/A
function CURSO_obtenerCurso($idcurso)
{
    $curso = new Curso();
    $data  = new stdClass();
    $rspta = $curso->obtenerCurso($idcurso);
    if ($rspta)
    {
        $data->resultado = 'OK';
        $data->mensaje   = '¡Datos del curso disponibles!';
        $data->detalles  = $rspta;
    }
    else
    {
        $data->resultado = 'ERROR';
        $data->mensaje   = '¡Datos del curso no disponibles!';
        $data->detalles  = null;
    }
    return $data;
}

?>