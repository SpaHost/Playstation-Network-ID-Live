<?php
//
// Playstation-Network-ID-Live / 2013
// Autor       : Lorenzo J Gonzalez
// Web         : http://www.spahost.es
// Email       : soporte@spahost.es
//

// Definicion de seguridad
if(!defined('psnid_live_')) die('No esta permitido acceder a esta pagina.');

// Guardamos el request en variable
if ($_REQUEST[psnid]) {
  $laid = $_REQUEST[psnid];
} else {
  $laid = 'DjYXA';
}

// script a procesar
$cachepage = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cachefile = cache.md5($cachepage).'.'.$cacheext;

// Engañamos al servidor de psnapi
ini_set("user_agent","Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)");
ini_set("max_execution_time", 50);

?>