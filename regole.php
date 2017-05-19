<?php
$fatte = array("ttwt", "mm", "tb", "ha", "tmp");
if (isset($_GET['ediz']) && in_array($_GET['ediz'], $fatte))
{
  $url = "/regole/?exp=".$_GET['ediz'];
}
elseif (isset($_GET['ediz']))
{
  $url = "http://web.tiscali.it/stccg/regole/".$_GET['ediz'].".htm";
}
if (isset($url)) 
{
  header("Location: ".$url);
}
else
{
  echo "ERRORE!";
}
