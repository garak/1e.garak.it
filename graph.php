<?php
if ($totale>0) $perc = round(($voto/$totale)*100,2);
else $perc = $voto;
Header("Content-Type: image/jpeg");
$im = ImageCreateFromJPEG("img/barra.jpg");
$blue = ImageColorAllocate($im, 8, 63, 206);
ImageFilledRectangle($im, 0, 3, ($perc*2), 9, $blue);
ImageJPEG($im);
?>
