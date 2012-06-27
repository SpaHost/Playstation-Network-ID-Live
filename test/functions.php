<?php

// get PSN-ID by a valid sessionId
function getPsnId($sessionId,$source) {
    if (!$source || $source == "") { global $defaultSource; $source = $defaultSource; }
    switch ($source) {
        case "us": $psnid = getPsnIdByUs($sessionId); break;
        case "eumypsn": $psnid = getPsnIdByEuMyPsn($sessionId); break;
        case "euforums": $psnid = getPsnIdByEuForums($sessionId); break;
        default: $psnid = "0";
    }
    return $psnid;
}

// FUNCTION: get content by an url (using fsockopen)
function getContent($url,$methodId=0,$cookies,$referer,$useragent) {
    $regex = "/([a-z]*):\/\/([\w\.\-]*)[\/]{1}([\w\.\-\/]*)[\?]?([\w\.%&=]*)/i";
    preg_match_all($regex, $url, $urlsplit, PREG_PATTERN_ORDER);
    $protocol = $urlsplit[1][0]; $root = $urlsplit[2][0]; $get = $urlsplit[3][0];
    if (isset($urlsplit[4])) { $params = $urlsplit[4][0]; }
    if ($protocol == "https") { $port = 443; $prefix = "ssl://"; } else { $port = 80; $prefix = ""; }
    if ($methodId == 1) { $method = "POST"; } else { $method = "GET"; }
    $httplog = fsockopen($prefix.$root, $port, $errno, $errstr, 12);
    fputs($httplog, "GET /" . $get . "?" . $params . " HTTP/1.0\r\n");
    fputs($httplog, "Host: " . $root . "\r\n");
    $cookie = "";
    foreach(array_keys($cookies) as $c){ $cookie .= $c."=".$cookies[$c]."; "; }
    fputs($httplog, "Cookie: " . substr($cookie,0,-2) . "\r\n");
    fputs($httplog, "Referer: " . $referer . "\r\n");
    fputs($httplog, "User-Agent: " . $useragent . "\r\n\r\n");
    $code = "";
    while (!feof($httplog)) { $code .= fgets($httplog, 1000000) . "\n"; } fclose($httplog);
    return $code;
}

// FUNCTION: get cookies from page content
function getCookies($content) {
    $cookies = array();
    preg_match_all("/Set-Cookie:([^=]*)=([^;]*);/is", $content, $codesplit, PREG_SET_ORDER);
    foreach(array_keys($codesplit) as $subslipt){ $cookies[$codesplit[$subslipt][1]] = $codesplit[$subslipt][2]; }
    return $cookies;
}

// FUNCTION: get PSN-ID by US (http://www.us.playstation.com/)
function getPsnIdByUs($sessionId) {

    global $cookies;
    global $userAgent;

    $url = "http://us.playstation.com/uwps/HandleIFrameRequests";
    $referer = "https://store.playstation.com/external/index.vm?returnURL=" . $url;
    $url .= "?sessionId=" . $sessionId;
    $content = getContent($url,0,$cookies,$referer,$userAgent);
    $cookies = getCookies($content);
    
    $regex = "/&psHandle=([^&]*)&/";
    preg_match_all($regex, $content, $usrName, PREG_SET_ORDER);
    $psnid = $usrName[0][1]; if ($psnid == "") { $psnid = "0"; }
    
    return $psnid;
    
}

// FUNCTION: get PSN-ID by EU [MyPSN] (https://secure.eu.playstation.com/psn/mypsn/)
function getPsnIdByEuMyPsn($sessionId) {

    global $cookies;
    global $userAgent;

    $url = "https://secure.eu.playstation.com/sign-in/confirmation/";
    $referer = "https://store.playstation.com/external/index.vm?returnURL=" . $url;
    $url .= "?sessionId=" . $sessionId;
    $content = getContent($url,0,$cookies,$referer,$userAgent);
    $cookies = getCookies($content);
    
    $referer = $url;
    $url = "https://secure.eu.playstation.com/psn/mypsn/";
    $content = getContent($url,0,$cookies,$referer,$userAgent);
    
    $regex = "/Welcome, ([^ ]*) /";
    preg_match_all($regex, $content, $usrName, PREG_SET_ORDER);
    $psnid = $usrName[0][1]; if ($psnid == "") { $psnid = "0"; }    
    
    return $psnid;

}

// FUNCTION: get PSN-ID by EU [forums] (http://community.eu.playstation.com)
function getPsnIdByEuForums($sessionId) {

    $cookies = array("psnTarget"=>"forums|http://community.eu.playstation.com/playstationeu/|unset|");
    global $userAgent;
    
    $url = "https://secure.eu.playstation.com/psnauth/PSNResponse/forums/";
    $referer = "https://store.playstation.com/external/index.vm?returnURL=" . $url;
    $url .= "?sessionId=" . $sessionId;
    $content = getContent($url,0,$cookies,$referer,$userAgent);
    $cookies = getCookies($content);
    
    $referer = $url;
    $url = "http://community.eu.playstation.com/playstationeu/";
    $content = getContent($url,0,$cookies,$referer,$userAgent);
    
    $regex = "/LITHIUM.CommunityJsonObject = ([^;]*);/";
    preg_match_all($regex, $content, $json, PREG_SET_ORDER);
    $jarray = (array) json_decode($json[0][1],true);
    $psnid = $jarray['User']['login'];
    if ($psnid == "Anonymous") { $psnid = "0"; }
    
    return $psnid;
    
}

?>