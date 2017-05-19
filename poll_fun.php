<?php

function poll ($id)
{
 $query = "SELECT pollID,pollTitle,voti FROM poll_desc WHERE pollID=".$id;
 $result = mysql_query($query);
 $r = mysql_fetch_array($result);
 echo "<form method=\"get\" action=\"poll_voto.php\">";
 echo "<b>".$r["pollTitle"]."</b><br>\n";
 mysql_free_result($result);
 $query = "SELECT * FROM poll_data WHERE pollID=".$id;
 $result = mysql_query($query);
 while ($r=mysql_fetch_array($result)) {
  echo "<br><input type=\"radio\" name=\"voto\" value=\"".$r["voteID"]."\">".$r["optionText"]."\n";
 }
 echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
 echo "<p><input type=\"submit\" value=\"Vota\"> <font size=-2>[ <a href=\"poll_voto.php?id=$id\" target=\"MAIN\">Risultati</a>";     
 echo " | <a href=\"poll.php\" target=\"MAIN\">Altri Sondaggi</a> ]</font>";
 echo "</form>\n";

 mysql_free_result($result);
}

?>
