<?php

// This is a script for an api check
// make a call by cron job for a time by time api check
// like ./test.php?email=my%40mail.xy&pwd=mypwd&name=mypsnid

// includes
include_once('vars.php');
include_once('functions.php');

// inizialise vars
$sources = array("us","eumypsn","euforums");

function testErrorReport($mail,$msg) { mail($mail, "GetId Test Error Report", $msg); }

if (!isset($_GET['sessionId'])) {
    
    // variable for the error reporting
    $errorReport = "";
    
    // user data [responsed by get]
    $usrMail = $_GET['email'];
    $usrPwd  = $_GET['pwd'];
    $usrName = $_GET['name'];    
    
    // inizialise vars
    $signInUrl = "https://store.playstation.com/external/login.action";
    $thisUrl = "http://".$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"];
    $scriptUrl = preg_replace("/test.php/","out.php",$thisUrl);
    $postData = "?returnURL=".urlencode($thisUrl)."&loginName=".urlencode($usrMail)."&password=".urlencode($usrPwd);
    $cookies = array();
    $referer = $PSLogURL.$thisUrl;
    $signInUrl = $signInUrl.$postData;
    
    // sign in and get return content
    $content = getContent($signInUrl,1,$cookies,$referer,$userAgent);
    
    // successfully signed in?
    $regex = '/<span class="error">(.*)<\/span>/is';
    preg_match_all($regex, $content, $error, PREG_SET_ORDER);
    if (isset($error[0][1])) { $errorReport .= "Error [SignIn]: ".$error[0][1]."\n"; }

    // is a sessionId returned?
    $regex = '/\?sessionId=([\w]*)/is';
    preg_match_all($regex, $content, $sessid, PREG_SET_ORDER);
    if (isset($sessid[0][1])) { $sessionId = $sessid[0][1]; } 
    else { $errorReport .= "Error [sessId]: No sessionId returned\n"; }
    
    // check for the API output foreach source
    foreach(array_keys($sources) as $i) {
        $psnid = file_get_contents($scriptUrl."?sessionId=".$sessionId."&source=".$sources[$i]);
        if ($psnid != $usrName) {
            $errorReport .= "Error [".$sources[$i]."]: Wrong PSN-ID => saw '".$psnid."' instead of '".$usrName."'\n";
        }
    }
    
    if ($errorReport != "") { testErrorReport($usrMail,$errorReport); }
}

?>