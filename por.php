<?
header('Content-type: image/jpeg');
$cant=($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:32;
$total=round((($cant/100)*150));
$img=imagecreatetruecolor(150,10);
$verde=imagecolorallocate($img,51, 175, 41);
$negro=imagecolorallocate($img,0, 0, 0);
$amarillo=imagecolorallocate($img,251, 222, 94);
imagefilledrectangle($img,1,1,148,8,$verde); 
imagefilledrectangle($img,$total,1,148,8,$amarillo);
imagerectangle($img,$total,0,150,10,$negro); 
imagerectangle($img,0,0,150,10,$negro); 
imagejpeg($img);
imagedestroy($img);
exit;
?>