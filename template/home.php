<?php
//
// Playstation-Network-ID-Live / 2013
// Autor       : Lorenzo J Gonzalez
// Web         : http://www.spahost.es
// Email       : soporte@spahost.es
//

// Definicion de seguridad
if(!defined('psnid_live_')) die('No esta permitido acceder a esta pagina.');

// Direcciones de psnapi
$file = "http://www.psnapi.com.ar/ps3/api/psn.asmx/getPSNID?sPSNID=$laid";
$file_games = "http://www.psnapi.com.ar/ps3/api/psn.asmx/getGames?sPSNID=$laid";

// carga el archivo
$xml = simplexml_load_string(file_get_contents($file)) or die ("No se pudo cargar el archivo XML!");

// tiene aceco a la informacion del archivo XML
if ($xml->Plus == 'true') {
  $plus = '<img src="http://blog.es.playstation.com/wp-content/themes/scee/images/ps-plus-overlay.png" alt="">';
} else {
  $plus = '';
}

if ($xml->Online == 'true') {
  $status_online = 'Online';
} else {
  $status_online = 'Offline';
}

$barra_prog = $xml->Progress.'%&nbsp;Completado';

// Cuerpo de la pagina
echo '
  <div class="container">
    <div class="page-header" style="margin-top:90px;">
      <h2>',ucwords($laid),'
      <small>',$plus,' ',$status_online,'</small></h2>
      <div class="pull-right" style="margin-top:-80px;">
        <span class="span2">
          <h3>
            <img src="http://webassets.scea.com/playstation/img/profile_level_icon.png" alt="">
            <span style="margin-top:3px;">'.$xml->Level.'</span> <small>',$xml->Trophies->Total,' Trofeos</small>
          </h3>
          <div class="progress progress-striped active">
            <div class="bar" style="width: '.$xml->Progress.'%;">
              <span style="margin-left:35px; color: black;">'.$barra_prog.'</span>
            </div>
          </div>
        </span>
        <span class="span1">
          <img src="http://img820.imageshack.us/img820/1966/trophybronze.png" alt=""> '.$xml->Trophies->Bronze.'</br>
          <img src="http://img818.imageshack.us/img818/8299/trophysilver.png" alt=""> '.$xml->Trophies->Silver.'</br>
          <img src="http://img89.imageshack.us/img89/3056/trophygold.png" alt=""> '.$xml->Trophies->Gold.'</br>
          <img src="http://img828.imageshack.us/img828/1274/trophyplatinum.png" alt=""> '.$xml->Trophies->Platinum.'</br>
        </span>
        <span class="thumbnail span1">
          <img src="',$xml->Avatar,'" alt="',$xml->ID,'" />
        </span>
      </div>
    </div>
    <div class="span12">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th></th>
            <th>Titulo</th>
            <th>Progreso</th>
            <th>Trofeos</th>
            <th><img src="http://img820.imageshack.us/img820/1966/trophybronze.png" alt=""></th>
            <th><img src="http://img818.imageshack.us/img818/8299/trophysilver.png" alt=""></th>
            <th><img src="http://img89.imageshack.us/img89/3056/trophygold.png" alt=""></th>
            <th><img src="http://img828.imageshack.us/img828/1274/trophyplatinum.png" alt=""></th>
          </tr>
        </thead>';
  sleep(5);
  $psn_perfil2 = new DOMDocument();
  $psn_perfil2->load( 'http://www.psnapi.com.ar/ps3/api/psn.asmx/getGames?sPSNID='.$laid );

  $psnjuego2 = $psn_perfil2->getElementsByTagName( "Game" );
  foreach( $psnjuego2 as $psnj ) {

  $imgjuegos = $psnj->getElementsByTagName( "Image" );
  $imgjuego = $imgjuegos->item(0)->nodeValue;

  $nomjueg = $psnj->getElementsByTagName( "Title" );
  $nombjuego = $nomjueg->item(0)->nodeValue;

  $gantro = $psnj->getElementsByTagName( "Earned" );
  $gantrof = $gantro->item(0)->nodeValue;

  $totro = $psnj->getElementsByTagName( "TotalTrophies" );
  $totaltro = $totro->item(0)->nodeValue;

  $progres = $psnj->getElementsByTagName( "Progress" );
  $progress = $progres->item(0)->nodeValue;

  $jueplat = $psnj->getElementsByTagName( "Platinum" );
  $juegplat = $jueplat->item(0)->nodeValue;

  $juegold = $psnj->getElementsByTagName( "Gold" );
  $jueggold = $juegold->item(0)->nodeValue;

  $juesil = $psnj->getElementsByTagName( "Silver" );
  $jueggsil = $juesil->item(0)->nodeValue;

  $juebron = $psnj->getElementsByTagName( "Bronze" );
  $juegbron = $juebron->item(0)->nodeValue;

  echo '
        </thead>
        <tr>
          <td>
            <div class="thumbnail" style="background-color: #737373;"><img src="' .$imgjuego. '" width="120"></div>
          </td>
          <td>
            <h4>'.$nombjuego.'</h4>
          </td>
          <td>
            <div class="progress progress-striped active">
              <div class="bar" style="width: '.$progress.'%;">
                <span style="margin-left:15px; color: black;">'.$progress.'%&nbsp;Completado</span>
              </div>
            </div>
          </td>
          <td>
            '.$gantrof.' trofeos de '.$totaltro.'
          </td>
          <td>
            '.$juegbron.'
          </td>
          <td>
            '.$jueggsil.'
          </td>
          <td>
            '.$jueggold.'
          </td>
          <td>
            '.$juegplat.'
          </td>
        </tr>';

  }
echo '
      </tbody>
    </table>
    </div>
  </div>';

?>