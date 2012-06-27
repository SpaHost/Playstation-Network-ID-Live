<?php

// Main Variables
$info = array(
    "name"=>"GetId Script",
    "sourced"=>"http://api.geekweb.org/psn/getid/",
    "description"=>"GET PSN-ID by sessionId",
    "version"=>"0.104",
    "state"=>"stable",
    "update"=>"2010-11-07",
    "licence"=>"GNU GPL v3",
    "creator"=>"PSNAPI.ORG: http://psnapi.org/"
);

$title = "API: " . $info["description"] . " [" . $info["state"] . "] (v" . $info["version"] . ")";
$ThisURL = "http://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];
$info['codes'] = substr($ThisURL,0,strpos($ThisURL,$info['state']."/")).$info['state']."/code.php";

// default variables for url calls
$cookies = array();
$userAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
$defaultSource = "us"; // options: us, eumypsn, euforums

$PSLogURL = "https://store.playstation.com/external/index.vm?returnURL=";

?>