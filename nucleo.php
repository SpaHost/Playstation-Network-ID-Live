<?php
//
// Playstation-Network-ID-Live / 2013
// Autor       : Lorenzo J Gonzalez
// Web         : http://www.spahost.es
// Email       : soporte@spahost.es
//

// Definicion de seguridad
if(!defined('psnid_live_')) die('No esta permitido acceder a esta pagina.');

// Carpeta del programa
if (function_exists ( 'realpath' ) and @realpath ( dirname ( __FILE__ ) ) !== FALSE) {
  $c_s = str_replace ( '', '/', realpath ( dirname ( __FILE__ ) ) );
}

// Variables de carpetas
define ( 'ext',      '.' . pathinfo ( __FILE__, PATHINFO_EXTENSION ) );       // Extension
define ( 'extf',     '.func.' . pathinfo ( __FILE__, PATHINFO_EXTENSION ) );  // Extension de Funcion
define ( 'bdir',     $c_s . '/' );                                            // Carpeta root
define ( 'cache',    $c_s . '/cache/');                                       // Carpeta cache
define ( 'func',     $c_s . '/funciones/' );                                  // Carpeta Funciones
define ( 'temp',     $c_s . '/template/' );                                   // Carpeta Template

// Insertamos datos de configuracion
include bdir.'config'.ext;
include func.'secure'.extf;
include func.'cache'.extf;

// Iniciamos el cacheo
ob_start();

// Incluimos el codigo
include func.'header'.extf;
include temp.'header'.ext;
include temp.'home'.ext;
include temp.'pie'.ext;

// Generamos el nuevo archivo cache
$fp = @fopen($cachefile, 'w');
// Guardamos el contenido del buffer
@fwrite($fp, ob_get_contents());
@fclose($fp);
ob_end_flush();

?>