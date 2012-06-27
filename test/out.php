<?php

// php error reporting
if ($_GET['error'] == "1") { error_reporting(E_ALL); } else { error_reporting(0); }

// includes
include_once('vars.php');
include_once('functions.php');

// inizialise variables
$source = "";
if (isset($_GET['source'])) { $source = $_GET['source']; }

// get psnid by sessionid
if (isset($_GET['sessionId'])) {
    $psnid = getPsnId($_GET['sessionId'],$source);
    include_once('stats.php'); statsStore();
    echo $psnid;
}

?>