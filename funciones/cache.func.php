<?php
//
// Playstation-Network-ID-Live / 2013
// Autor       : Lorenzo J Gonzalez
// Web         : http://www.spahost.es
// Email       : soporte@spahost.es
//

// Definicion de seguridad
if(!defined('psnid_live_')) die('No esta permitido acceder a esta pagina.');

// calculamos el tiempo del cache
if (@file_exists($cachefile)) {
    $cachelast = @filemtime($cachefile);
} else {
    $cachelast = 0;
}
@clearstatcache();

// Mostramos el archivo si aun no vence
if (time() - $cachetime <$cachelast) {
    @readfile($cachefile);
    exit();
}

?>