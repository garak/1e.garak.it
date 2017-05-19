<?php
include("mainfile.php");
dbconnect();

///////////////aggiorna risultati con il voto//////////
$voto = intval($_REQUEST['voto'] ?? 0);
$lastpoll = intval($_REQUEST['lastpoll'] ?? 0);
$id = intval($_REQUEST['id'] ?? 0);

if (!empty($voto))
{
 if ($lastpoll && $lastpoll == $id)
 {
  include("header.php");
  $control=1;
  echo "<p>&nbsp; Hai gi&agrave; votato per questo sondaggio.<br>&nbsp; Aspetta il prossimo!";
 }
 else
 {
  setCookie("lastpoll", $id, time()+2592000);
  $control=2;
  $query = "UPDATE poll_data SET optionCount=optionCount+1 WHERE voteID=$voto";
  $result=mysqli_query($link, $query);
  $query = "UPDATE poll_desc SET voti=voti+1 WHERE pollID=$id";
  $result=mysqli_query($link, $query);
  include("header.php");
  echo "<p>&nbsp; Grazie per aver votato";
 }
}

else {include("header.php");}
echo "<p>&nbsp; Risultati:";
echo "<table class=\"std\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\">";

$query="SELECT * FROM poll_desc WHERE pollID=$id";
$result=mysqli_query($link, $query);
$r=mysqli_fetch_array($result);
list($anno,$mese,$giorno)=explode('-',$r["inizio"]);
echo "<tr><td colspan=3><b>".$r["pollTitle"]."</b></td>";

mysqli_free_result($result);

$query="SELECT * FROM poll_data WHERE pollID=$id";
$result=mysqli_query($link, $query);
$i=0;
while ($r=mysqli_fetch_array($result))
{
 $ris["ris"][$i]=$r["optionText"];
 $ris["voti"][$i]=$r["optionCount"];
 $ris["id"][$i]=$r["voteID"];
 $i++;
}

mysqli_free_result($result);
$totale=0;
for ($i=0;$i<sizeof($ris["voti"]);$i++)
{
 $totale=$totale+$ris["voti"][$i];
}

for ($i=0;$i<sizeof($ris["voti"]);$i++)
{
 if ($totale) {$perc["id"][$i]=round(($ris["voti"][$i]/$totale)*100,2);}
 else {$perc["id"]=$ris["voti"][$i];}
 echo "<tr><td>".$ris["ris"][$i]."</td><td>".$ris["voti"][$i]." (".$perc["id"][$i]."%)</td>";
 echo "<td><img src=\"graph.php?voto=".$ris["voti"][$i]."&amp;totale=".$totale."\"></td></tr>"; 
}


echo "<tr><td><font size=\"-2\">Postato il ".date("d/m/Y",mktime(12,0,0,$mese,$giorno,$anno))."</font></td>";
echo "<td><font size=\"-2\">$totale voti totali</font></td></tr>";
echo "</table><p>";

mysqli_close();

include("footer.php");
?>

</BODY>
</HTML>
