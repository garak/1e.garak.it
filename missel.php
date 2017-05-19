<?php
include_once "mainfile.php";
if (!$_SERVER['QUERY_STRING'] || $_SERVER['QUERY_STRING'] == "istr") {
	$eo = "and";
	$eo2 = "and";
	$affl[] = "m";
	$ps[] = "p";
	$ps[] = "s";
}
$ico = @$_REQUEST['ico'];
$skill = @$_REQUEST['skill'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Garak's Star Trek CCG - selettore missioni</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<script type="text/javascript">
function apri()
{
 window.open ("legenda.html","legenda","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=300,height=400");
}

function ToggleCheckAll()
{
 var sa=false;
 if(document.lista.CheckAll.checked)
 sa=true;
 for (var i=0;i<document.lista.elements.length;i++)
 {
  var e = document.lista.elements[i];
  if (sa) {e.checked=true}
  else {e.checked=false}
 }
}
</script>
</head>
<body>
<br />
<table cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#ffffff">
 <tr valign="middle" align="center">
  <td class="ang1h">
   <br />Selettore di Missioni<br /><br />
  </td>
  <td bgcolor="#cfcfbb">
   <form action="missel.php" method="get">
   <b>Ricerca missione</b> &nbsp;
   <input name="stringa" type="text" size="15" />
   <input type="hidden" name="eo2" value="" />
   <input type="submit" value="cerca" />
   </form>
  </td>
  <td class="ang2h"></td>
 </tr>
</table>
<table class="bar" cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#fefefe">
 <tr valign="middle">
  <td width="15%" nowrap>
   &nbsp; &nbsp; <a class="help" href="missel.php?istr" title="Istruzioni">Istruzioni</a> &nbsp; <a class="help" onClick="apri()" title="Legenda icone e colori">Legenda</a>
  </td>
  <td>&nbsp;</td>
 </tr>
</table>
<table width="99%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" align="center">
 <tr>
  <td style="height: 20px"></td>
 </tr>
 <tr>
  <td width="10"></td>
  <td>
   <form action="missel.php" method="GET">
   <table align="center" cellpadding="3">
<?php
if ($_SERVER['QUERY_STRING'] == 'istr') {
?>
	<tr>
     <td colspan="5">
      Si possono selezionare: abilit&agrave;, affiliazione e quadrante. Per abilit&agrave; e affiliazione si pu&ograve; scegliere se le selezioni vadano considerate tutte (&quot;e&quot;) oppure in alternativa (&quot;o&quot;).
	Per il quadrante invece la selezione &egrave; necessariamente in alternativa (&egrave; sottinteso un &quot;o&quot;).
	Si possono includere nella selezione le missioni senza icone di affiliazione, ma con la dicitura &quot;Qualsiasi SdS&quot; o &quot;Qualsiasi equipaggio&quot; (rettangolo nero).
	<br />Si pu&ograve; anche limitare la selezione alle missioni universali, ai pianeti o allo spazio, nonch&eacute; indicare un valore minimo per i punti.
	<br />Per effettuare scelte multiple occore premere il tasto &quot;Ctrl&quot; mentre si clicca sulla voce scelta.
	<br />Nota: per inserire le carte nel mazzo, occorre <a href="user.php" target="MAZZO">registrarsi</a>.
     </td>
    </tr>
<?php
}
?>
    <tr class="tit1" align="center">
     <td>Abilit&agrave;</td><td>Affiliazione</td><td>Quadrante</td></tr>
    <tr valign="top">
     <td rowspan="2">	
      <select multiple name="skill[]" size="10">
<?php
foreach ($ABIL as $v) {
	echo "<option value=\"".$v."\"";
	if (is_array($skill) && in_array($v,$skill)) echo " selected";
	echo ">".$v."</option>\n";
}
?>
      </select>
     </td>
     <td>
      <table width="365">
       <tr align="center">
        <td bgcolor="#000000">
         <input type="checkbox" name="quals"<?php if ($quals) echo " checked" ?> />
        </td>
<?php
$n = 0;
foreach ($MAFF as $v) {
	echo "<td class=\"c".$v."\"><input name=\"affl[]\" type=\"checkbox\" value=\"".$v."\"";
	if (is_array($affl) && in_array($v, $affl)) echo " checked"; 
	echo "></td>\n";
	if ($n == 4) echo "</tr>\n<tr align=\"center\">\n";
	$n++;
}
?>
       </tr>
      </table>
     </td>
     <td>
      <select multiple name="ico[]" size="4">
<?php
foreach ($MICO as $k=>$v) {
	echo "<option value=\"[".$k."]\"";
	if (is_array($ico) && in_array("[".$k."]", $ico)) echo " selected"; 
	echo ">";
	echo $k ? "[" : "&nbsp; &nbsp;";
	echo $k;
	echo $k ? "] " : "&nbsp; &nbsp;";
	echo $v."</option>\n";
}
?>
      </select>
     </td>
    </tr>
    <tr>
     <td align="center">
      <input name="eo2" type="radio" value="and"<?php if (!$eo2 || $eo2 == "and") echo " checked" ?> />e
      <input name="eo2" type="radio" value="or"<?php if ($eo2 == "or") echo " checked" ?> />o
     </td>
     <td align="center">
      <input name="ps[]" value="p" type="checkbox"<?php if (isset($ps) && $ps[0] == 'p') echo " checked" ?> />
      <acronym title="Pianeta">P</acronym>
      <input name="ps[]" value="s" type="checkbox"<?php 
if (is_array($ps)) {
	$size = sizeof($ps);
	for ($i = 0; $i < $size; $i++) {
		if ($ps[$i] == 's') echo " checked";
	}
}
?> />
      <acronym title="Spazio">S</acronym>
      <input type="checkbox" name="un" value="v"<?php if (isset($un)) echo  " checked" ?> /> <font class="w">v</font>
     </td>
    </tr>
    <tr align="center">
     <td>
      <input name="eo" type="radio" value="and" checked />e
      <input name="eo" type="radio" value="or" />o
     </td>
     <td><input type="submit" value="cerca" /></td>
     <td>Almeno <input name="pt" size="2" value="<?php if (isset($pt)) echo "$pt" ?>" /> Punti</td>
    </tr>
   </table>
   </form>
  </td>
 </tr>
 <tr>
  <td class="ang3"></td>
  <td></td>
  <td class="ang4"></td>
 </tr>
</table>
<br />
<table cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#ffffff">
 <tr>
  <td class="ang1"></td>
  <td></td>
  <td class="ang2"></td>
 <tr>
  <td colspan="3">
<?php

$where = "WHERE 1 ";

/////////// aggiunta skill alle condizioni di where ////////

if (isset($skill)) {
	$where .= " AND (";
	$size = sizeof($skill);
	for ($i = 0; $i < $size; $i++) {
		if ($skill[$i] == "Biology" || $skill[$i] == "Physics") {
			$where .= "(testo LIKE '".$skill[$i]."%' OR testo LIKE '% ".$skill[$i]."%')";
		} else {
			$where .= "(testo LIKE '%".$skill[$i]."%')";
		}
		if (isset($skill[$i+1])) $where .= " ".$eo." ";
	} 
	$where .= ")";
}

///////// aggiunta affiliazione alle condizioni di where /////////

	
if ($quals) $affl[] = "Quals";

if (is_array($affl)) {
	$where .= " AND (";
	$size = sizeof($affl);
	for ($i = 0; $i < $size; $i++) {
		$where .= "((aff LIKE '%".$affl[$i]." %' OR aff LIKE '%".$affl[$i]."' ) AND aff NOT LIKE '%non ".$affl[$i]."%')";
		if (isset($affl[$i+1])) $where .= " ".$eo2." ";
	}
	$where .= ")";
}

///////// aggiunta quadrante alle condizioni di where /////////
if (isset($ico)) {
	if ($ico[0] == "[]") {
		$where .= " AND (icone=''";
	} else {
		$where .= " AND (icone LIKE '%".$ico[0]."%'";
	}
	if (isset($ico[1])) {
		$size = sizeof($ico);
		for ($i = 1; $i < $size; $i++) {
			$where .= "or icone LIKE '%".$ico[$i]."%'";
		}
	}
	$where .= ")";
}

///////// aggiunta universale alle condizioni di where ////////

if (isset($un)) $where .= " AND un='v'";


///////// aggiunta pianeta/spazio alle condizioni di where /////////

$where .= " AND (";
if (isset($ps)) {
	$size = sizeof($ps);
	for ($i = 0; $i < $size; $i++) {
 		$k = $i + 1;
		$where .= "tipom='$ps[$i]'";
		if (isset($ps[$k])) $where .= " OR ";
	}
} else {
	$where .= "0";
}
$where .= ")";

///////// aggiunta punti alle condizioni di where ////////

if (isset($pt)) {
	if ($pt) {
		$where .= " AND punti>=".$pt;
	}
}

//////// query //////////
////////  o    ////////
//////// ricerca ///////

if (isset($stringa)) {
	if (!$stringa) $stringa = "niente";
	$query = "SELECT * FROM missioni m LEFT JOIN erti e ON e.id=m.id LEFT JOIN testo2 t ON e.id=t.id WHERE nome LIKE '%".$stringa."%' ORDER BY nome";
} else {
	$query = "SELECT * FROM missioni m LEFT JOIN erti e ON e.id=m.id LEFT JOIN testo2 t ON e.id=t.id ".$where." ORDER BY nome";
}

dbconnect();
$result = mysqli_query($link, $query);
#echo "<h4>query = $query</h4>";

$j2 = 0;
while ($r = mysqli_fetch_array($result)) {
	$a[$j2]["un"] = $r["un"];
	$a[$j2]["nome"] = $r["nome"];
	$a[$j2]["aff"] = $r["aff"];
	$a[$j2]["rar"] = $r["rar"];
	$a[$j2]["tipo"] = $r["tipom"];
	$a[$j2]["testo"] = $r["testo"];
	$a[$j2]["testosp"] = $r["testosp"];
	$a[$j2]["span"] = $r["span"];
	$a[$j2]["punti"] = $r["punti"];
	$a[$j2]["icone"] = $r["icone"];
	$a[$j2]["id"] = $r["id"];
	$a[$j2]["ediz"] = substr($a[$j2]["id"], 0, 3);
	$j2++;
}
mysqli_free_result($result);
mysqli_close($link);

/// scrittura a video delle opzioni di where scelte ///

if (is_array($skill)) {
	echo "&nbsp; Abilit&agrave; scelte: ";
	echo implode(", ", $skill);	
	if (isset($skill[1])) {
		if ($eo == "and") echo " (tutte)<br />";
		if ($eo == "or") echo " (almeno una)<br />";
	} else echo "<br />";
}

if (is_array($ico)) {
	if ($ico[0] == "[]") $ico[0] = "Alfa";
	echo "&nbsp; Quadrante scelto: ";
	echo implode(", ", $ico);
	echo "<br />";
}


/// scrittura a video numerosita` risultato ///

if (!$j2) {
	echo "<br />&nbsp; Nessuna missione trovata<br /><br />\n";
} else {
	if ($j2 == 1) echo "<br/>&nbsp; 1 trovata<br /><br />\n";
	else echo "<br />&nbsp; ".$j2." trovate<br /><br />\n";

	//////////// output tabella ///////////////

?>
   <form action="user.php" name="lista" target="MAZZO" method="post">
   <table width="100%">
    <tr class="tit2"><td width="10"><input type="checkbox" name="CheckAll" onClick="ToggleCheckAll()"></td><td>Nome</td>
    <td>Rar</td>
    <td>Tip</td>
    <td>Aff</td>
    <td align="center" width="45%">Abilit&agrave;</td>
    <td align="center" width="15">Span</td>
    <td align="center" width="15">Punti</td>
    <td>Icone</td>
    <td>Ediz</td>
   </tr>
<?php
	for ($i = 0; $i < $j2; $i++) {
		echo "<tr valign=\"top\"><td class=\"t\" width=\"10\"><";
		cbox($a[$i]["id"]);
		echo "value=\"".$a[$i]["id"]."\"></td><td class=\"a\">";
		if ($a[$i]["un"]) echo "<font class=\"w\">".$a[$i]["un"]."</font> ";
		echo $a[$i]["nome"]."</td><td class=\"a\">".$a[$i]["rar"]."</td><td class=\"a\">".$a[$i]["tipo"]."</td><td class=\"a\">".$a[$i]["aff"]."</td><td class=\"a\" width=\"45%\">".$a[$i]["testo"]." ".$a[$i]["testosp"]."</td><td class=\"a\" width=\"15\">".$a[$i]["span"]."</td><td class=\"a\">".$a[$i]["punti"]."</td><td class=\"a\">".$a[$i]["icone"]."</td><td class=\"a\">".$a[$i]["ediz"]."</td></tr>\n";
	}
	echo "<tr><td><input type=\"hidden\" name=\"op\" value=\"insert\">";
	echo "<input type=\"hidden\" name=\"gruppo\" value=\"2m\"></td></tr>\n";
	echo "</table>\n<br />&nbsp;<input type=\"submit\" value=\"Aggiungi al mazzo\">\n</form>";
}

include "footer.php";
?>
</body>
</html>
