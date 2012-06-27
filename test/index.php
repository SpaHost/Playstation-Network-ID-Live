<?php

include_once ("vars.php");

$outURL = ereg_replace("index","out",$ThisURL);

$information = "
    Created by: ".$info['creator']." | 
    <a href=\"".$info['sourced']."\">Sourced by</a> | 
    Licence: ".$info['licence']." | 
    Last update: ".$info['update']." | 
    <a href=\"code.php\">Source Codes</a>
";

?>
<html>
    <head>
        <title><? echo $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
          <meta name="description" content="<? echo $title; ?>">
          <meta name="keywords" content="PSN, API, Playstation Network">
          <meta name="author" content="Kilian Waser">
          <meta name="publisher" content="Kilian Waser">
          <meta name="copyright" content="Geekweb.org">
          <meta name="page-topic" content="<? echo $title; ?>">
          <meta http-equiv="content-type" content="text/html;charset=iso-8859-1">
    </head>
    <body>
        <h1><? echo $title; ?></h1>
        <? echo $information; ?><hr />
        
        <h2>Introduction</h2>
        Sony has an official <a href="<? echo ($PSLogURL); ?>" target="_blank">'External PSN Sign In'</a> page.
        You can set your own site as the returnURL by GET.
        The site forwards to your site on a successfull sign in with a sessionId by GET.
        But there is no official public API to convert the sessionId into a user specific value (like the PSN-ID). 
        This API here converts a valid sessionId into the proper PSN-ID. 
        So everyone is able to use the Playstation Network SignIn for their own sites. 
        Click <a href="<? echo ($PSLogURL . $outURL); ?>" target="_blank">here</a> and sign in for a simple test.

        <hr />
        
        <h2>Get the output</h2>
        <b><? echo $outURL; ?></b>
        with the following GET parameters:
        <ul>
            <li>
                (*) <b>sessionId</b>=<em>[any sessionId]</em><br />
                <em><? echo $outURL; ?></em>?<b>sessionId=[YourSessionId]</b>
                <br /><br />
            </li>
            <li>
                <b>source</b>=<em>[us|eumypsn|euforums]</em><br />
                The api can get the proper PSN-ID by different sources.<br />
                Choose the once you want to get the PSN-ID from.<br />
                ('us' is the default value)<br />
                Example1: <em><? echo $outURL; ?></em>?sessionId=[YourSessionId]&<b>source=us</b><br />
                Example2: <em><? echo $outURL; ?></em>?sessionId=[YourSessionId]&<b>source=eumypsn</b><br />
                Example3: <em><? echo $outURL; ?></em>?sessionId=[YourSessionId]&<b>source=euforums</b><br />
                <br />
            </li>
            <li>
                <b>error</b>=<em>[0,1]</em><br />
                This parameter handles the PHP error outputs.<br />
                ('0' is the default value.)<br />
                Example1: <em><? echo $outURL; ?></em>?sessionId=[YourSessionId]&<b>error=0</b>
                (output no php errors by <em>error_reporting(0);</em>)
                <br />
                Example2: <em><? echo $outURL; ?></em>?sessionId=[YourSessionId]&<b>error=1</b>
                (output all php errors by <em>error_reporting(E_ALL);</em>)
                <br />
                <br />
            </li>
        </ul>
        (*) => Mandatory parameters
        
        <hr />
        
        <h2>A small example for using this API</h2>
        If you want to use this function on your own site, 
        create a php file on your server and type in the following code:<br />
<?
$codexamp = "<"."?

// Example for using the PSNAPI.ORG GetId API

$"."PSLogURL = \"https://store.playstation.com/external/index.vm?returnURL=\";
$"."ThisURL = \"http://\".$"."_SERVER[\"HTTP_HOST\"].$"."_SERVER[\"SCRIPT_NAME\"];

function getpsnid($"."sessId) {
    $"."sources = array(\"us\",\"eumypsn\",\"euforums\"); $"."psnid = \"0\";
    for ($"."i=0;isset($"."sources[$"."i]) && !isPsnIdValid($"."psnid);$"."i++) {
        $"."url = \"" . $outURL . "?sessionId=\" . $"."sessId . \"&source=\" . $"."sources[$"."i];
        $"."psnid = file_get_contents($"."url);
    }
    return $"."psnid;
}

function isPsnIdValid($"."psnid) {
    $"."regex = '/([a-z].{2,15})/i';
    preg_match_all($"."regex, $"."psnid, $"."newid, PREG_SET_ORDER);
    if (isset($"."newid[0][1]) && $"."psnid == $"."newid[0][1]) { return true; } 
    return false;
}

if (isset($"."_GET['sessionId'])) {
    // get the proper psnid by the given sessionId
    $"."psnid = getpsnid($"."_GET['sessionId']);
    // TODO: connect with your user management here
    echo (\"Hi, <b>\" . $"."psnid . \"</b> ...\");
} else {
    // forward to the official external psn sign in page
    // with your page url as returnURL by GET
    header (\"Location: \" . $"."PSLogURL . $"."ThisURL);
}

?".">";
?>
        <code><? echo highlight_string($codexamp, true); ?></code>
        
        <br /><br />
        <hr />
        <? echo $information; ?>
    </body>
</html>