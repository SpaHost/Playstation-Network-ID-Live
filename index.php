<?php
//
// Playstation-Network-ID-Live / 2011
// Autor       : Lorenzo J Gonzalez
// Web         : http://www.spahost.es
// Email       : soporte@spahost.es
//

// Settings
$cachedir = 'cache/';   // directorio de cache
$cachetime = 860000;   // duración del cache
$cacheext = 'cache';   // extensión de cache
// script a procesar
$cachepage = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$cachefile = $cachedir.md5($cachepage).'.'.$cacheext;
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
ob_start();

  if ($_REQUEST[psnid]) {
	$laid = $_REQUEST[psnid];
	}
// Variables
$PSLogURL = "https://store.playstation.com/external/index.vm?returnURL=";
$ThisURL = "http://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];

// Cabecera Web
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title>Playstation-Network-ID-Live (v0.1)</title>
<link rel="stylesheet" type="text/css" media="screen" href="style.css"/> 
</head>
<body>
<div id="body_container">
 <div id="header_container">
  <div id="ps_logo"><a href="/psn"><img src="img/playstation_logo.png" alt="" border="0"></a></div>
  <div id="ps_login">';
  if (isset($_GET['sessionId'])) {
    $laid = getpsnid($_GET['sessionId']);
    echo '<span class="ps_login">Bienvenido, <b>' . $laid . '</b> ...</span>';
} else {
    echo '<span class="ps_login">Entrar en PSN: <a class="ps_login" href="' . $PSLogURL . $ThisURL.'">Entrar</a></span>';
}
echo'</div>
 </div>';



function getpsnid($sessId) {
    $sources = array("us","eumypsn","euforums"); $psnid = "0";
    for ($i=0;isset($sources[$i]) && !isPsnIdValid($psnid);$i++) {
        $url = "http://api.geekweb.org/psn/getid/out.php?sessionId=" . $sessId . "&source=" . $sources[$i];
        $psnid = file_get_contents($url);
    }
    return $psnid;
}

function isPsnIdValid($psnid) {
    $regex = '/([a-z].{2,15})/i';
    preg_match_all($regex, $psnid, $newid, PREG_SET_ORDER);
    if (isset($newid[0][1]) && $psnid == $newid[0][1]) { return true; } 
    return false;
}

// pone el nombre del archivo y si lo tienes en otro directorio
// asegurate de ponerlo, por ejemplo asi "/directorio/fino.xml
$file = "http://www.psnapi.com.ar/ps3/api/psn.asmx/getPSNID?sPSNID=$laid";

// carga el archivo
$xml = simplexml_load_file($file) or die ("No se pudo cargar el archivo XML!");

// tiene aceco a la informacion del archivo XML
if ( $xml->Plus == 'true' ){
$plus = '<img class="img_plus" src="http://blog.es.playstation.com/wp-content/themes/scee/images/ps-plus-overlay.png" alt="">';
} else {
$plus = '';
}

echo '
  <div id="info_tag">
   <div id="tag_izq">
    <div id="tag_izq_top"><span class="tag_id">'.$xml->ID.'</span>'.$plus.'</div>
    <div id="tag_izq_bot">
	 <div id="tag_izq_bot_izq">
	  <img src="http://img820.imageshack.us/img820/1966/trophybronze.png" alt=""> '.$xml->Trophies->Bronze.'</br>
	  <img src="http://img818.imageshack.us/img818/8299/trophysilver.png" alt=""> '.$xml->Trophies->Silver.'</br>
	  <img src="http://img89.imageshack.us/img89/3056/trophygold.png" alt=""> '.$xml->Trophies->Gold.'</br>
	  <img src="http://img828.imageshack.us/img828/1274/trophyplatinum.png" alt=""> '.$xml->Trophies->Platinum.'</br>
	 </div>
	 <div id="tag_izq_bot_der">
	  Number of Games: '.$xml->Level.'</br>
	  Total Score: '.$xml->Progress.'%</br>
	  Total Trophies: '.$xml->Trophies->Total.'</div>
	</div>
   </div>
   <div id="tag_der"><img src="'.$xml->Avatar.'" border="0" width="100"></div>
  </div>
 </div>
</div>';


/**
  $psn_perfil = new DOMDocument();
  $psn_perfil->load( 'http://www.psnapi.com.ar/ps3/api/psn.asmx/getPSNID?sPSNID='.$laid );
  
  $psnid = $psn_perfil->getElementsByTagName( "PSNId" );
  foreach( $psnid as $psn )
  {
  $avatars = $psn->getElementsByTagName( "Avatar" );
  $avatar = $avatars->item(0)->nodeValue;
  
  $ids = $psn->getElementsByTagName( "ID" );
  $id = $ids->item(0)->nodeValue;
  
  $levels  = $psn->getElementsByTagName( "Level" );
  $level = $levels->item(0)->nodeValue;

  $progress = $psn->getElementsByTagName( "Progress" );
  $progres = $progress->item(0)->nodeValue;
  
  $ntrofeoss = $psn->getElementsByTagName( "Total" );
  $ntrofeos = $ntrofeoss->item(0)->nodeValue;
  
  
  echo '<img src="'.$avatar.'" border="0" width="100"></br>
  Tu PSN es: '.$id.'</br>
  Has alcanzado el nivel '.$level.' ('.$progres.'%) con '.$ntrofeos.' trofeos.';
  }
 **/

?>


			
			</br></br>Ultimos juegos jugados en Playstation Network
			<? 
			

// Lectura del archivo XML - Detalles globales de PSNID
  $psn_perfil2 = new DOMDocument();
  $psn_perfil2->load( 'http://www.psnapi.com.ar/ps3/api/psn.asmx/getGames?sPSNID='.$laid );
  
  $psnjuego2 = $psn_perfil2->getElementsByTagName( "Game" );
  foreach( $psnjuego2 as $psnj )
  {
  $imgjuegos = $psnj->getElementsByTagName( "Image" );
  $imgjuego = $imgjuegos->item(0)->nodeValue;
  
  $nomjueg = $psnj->getElementsByTagName( "Title" );
  $nombjuego = $nomjueg->item(0)->nodeValue;
  
  $gantro = $psnj->getElementsByTagName( "Earned" );
  $gantrof = $gantro->item(0)->nodeValue;
  
  $totro = $psnj->getElementsByTagName( "TotalTrophies" );
  $totaltro = $totro->item(0)->nodeValue;
  
  $jueplat = $psnj->getElementsByTagName( "Platinum" );
  $juegplat = $jueplat->item(0)->nodeValue;

  $juegold = $psnj->getElementsByTagName( "Gold" );
  $jueggold = $juegold->item(0)->nodeValue;

  $juesil = $psnj->getElementsByTagName( "Silver" );
  $jueggsil = $juesil->item(0)->nodeValue;

  $juebron = $psnj->getElementsByTagName( "Bronze" );
  $juegbron = $juebron->item(0)->nodeValue;

  echo '<table align="left" border="0"><tr><td><div align="center"><img src="' .$imgjuego. '" width="120"></div></td>
<td>'.$nombjuego.'</td>
<td>Total trofeos: '.$gantrof.'/'.$totaltro.' <img src="http://img828.imageshack.us/img828/1274/trophyplatinum.png">: '.$juegplat.' <img src="http://img89.imageshack.us/img89/3056/trophygold.png">: '.$jueggold.' <img src="http://img818.imageshack.us/img818/8299/trophysilver.png">: '.$jueggsil.' <img src="http://img820.imageshack.us/img820/1966/trophybronze.png">: '.$juegbron.'</td>
</div></tr></table>';
  }

// Pie de pagina

echo '</body></html>';  


// Generamos el nuevo archivo cache
$fp = @fopen($cachefile, 'w');
// guardamos el contenido del buffer
@fwrite($fp, ob_get_contents());
@fclose($fp);
ob_end_flush();


?>