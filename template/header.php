<?php
//
// Playstation-Network-ID-Live / 2013
// Autor       : Lorenzo J Gonzalez
// Web         : http://www.spahost.es
// Email       : soporte@spahost.es
//

// Definicion de seguridad
if(!defined('psnid_live_')) die('No esta permitido acceder a esta pagina.');

// Cabecera
echo '
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#"><img src="/img/playstation_logo.png" alt="" border="0">Playstation Network ID Live</a>
        <div class="nav-collapse collapse">
          <p class="navbar-text pull-right">
            <i class="icon-question-sign icon-white"></i> <a href="#comofunciona" data-toggle="modal">Como funciona?</a>
          </p>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>
  <div id="comofunciona" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="comofunciona" aria-hidden="true">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="comofunciona">Como funciona?</h3>
    </div>
    <div class="modal-body">
      <p>Solamente debes añadir tu id de Playstation Network según se puede ver en el siguiente ejemplo:</p>
      <img src="/img/searchbar.jpg" alt=""><br>
      <p>Tenemos que escribir "id-" más nuestra Id y pulsar enter, con esto se generará nuestra pagina con nuestros datos!!!</p>
      <img src="/img/pagecopy.jpg" alt=""><br>
      <p><b>Asi de fácil!</b></p>
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
    </div>
  </div>';

?>