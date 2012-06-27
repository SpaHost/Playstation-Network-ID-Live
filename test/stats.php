<?php

// variables
$statsFile = "stats/log.txt";
$statsPsnOk = 0; if ($psnid != "0") { $statsPsnOk = 1; }

// store the data for the api statistics
function statsStore() {
    
    // inizialise variables
    global $statsFile, $statsPsnOk;
    $file = $statsFile; $array = array($statsPsnOk);
    $string = time();
    
    // store data
    foreach(array_keys($array) as $s) { $string .= "," . $array[$s]; }
    $string .= ";\n";
    $fp = fopen($file, "a+");
    $write = fputs($fp, $string);
    fclose($fp);
    
    return 0;
    
}

?>