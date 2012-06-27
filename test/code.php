<?php

// Script that display the source codes ...

include_once("vars.php");
$title = "<h1>".$info["name"]." - {Source Codes}</h1>";
foreach($info as $i => $x){ $footer .= $i." => ".$x." | "; }

$files = scandir(".");
foreach($files as $key => $value){
    $file = substr($value,0,-4);
    if (substr($value,-4) == ".php") {
        $link = "<a href=\"?file=" . $file . "\">" . $value . "</a>";
        if (isset($_GET['file']) && $file == $_GET['file']) {
            $code = file_get_contents($file . ".php");
            if ($_GET['show'] == "txt") {
                header("Content-type: text/plain; charset=iso-8859-1");
                echo $code; die();
            }
            $nav .= "<b>" . $link . "</b> | ";
            $comment = "
                <a href=\"?file=".$_GET['file']."&show=txt\" target=\"_blank\">View this code as txt</a>
                <small>&nbsp;(right click and 'save as' for downloading)</small>
                ";
        } else { $nav .= $link . " | "; }
    }
}
$head   = "Back to <a href=\"index.php\">API index</a><br /><br />";
$nav    = $head . "Nav: <a href=\"?\">X</a> => | " . $nav;
$footer = ereg_replace(
    "[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]",
    "<a href=\"\\0\" target=\"_blank\">\\0</a>",
    "Footer: ".$footer
);
if (!isset($code)) { $code = "Choose a file in the nav to get them code lines."; }

echo ($title.$nav."\n<hr />\n".$comment."\n<hr />\n".highlight_string($code, true)."\n<hr />\n".$footer);

?>