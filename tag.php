<?php

function LoadPNG($imgname){
$im = @imagecreatefrompng($imgname);
 /* Attempt to open */
if (!$im) {
 /* See if it failed */
$im  = imagecreatetruecolor(150, 30);
 /* Create a blank image */
$bgc = imagecolorallocate($im, 255, 255, 255);
$tc  = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
       /* Output an errmsg */       
imagestring($im, 1, 5, 5, "Error loading $imgname", $tc);
}
return $im;
}$im = @LoadPNG('base.png');
header("Content-type: image/png");
$background_color = imagecolorallocate($im, 255, 355, 255);
$text_color = imagecolorallocate($im, 0, 255, 0);
imagestring($im, 2, 110, 65, " SITE STATISTICS: ", $text_color);
imagestring($im, 2, 110, 83, " FORUM STATISTICS: ", $text_color);
imagestring($im, 2, 225, 83,  "Threads: 213 ", $text_color);
imagestring($im, 2, 300, 83,  "Posts: 123", $text_color);
imagestring($im, 2, 365, 83,  "Users: 213", $text_color);
imagestring($im, 2, 225, 65,  "Games: 123", $text_color);
imagestring($im, 2, 300, 65,  "Cheats: 123", $text_color);
imagestring($im, 2, 365, 65,  "Reviews: 123", $text_color);
imagestring($im, 2, 450, 65,  "Files: 123", $text_color);imagepng($im);imagedestroy($im);
?>