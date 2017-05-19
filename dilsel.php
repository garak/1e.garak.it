<?php
$ABIL = ["INTEGRITY", "CUNNING", "STRENGTH"];
include_once "mainfile.php";

if (empty($_SERVER['QUERY_STRING']) || $_SERVER['QUERY_STRING'] == "istr") {
	$eo = "and";
	$skill = ["xyz"];
	$_REQUEST['ps'][] = "e";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Star Trek CCG - selettore dilemmi</title>
<link rel="stylesheet" href="style.css" type="text/css">
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
</head>
<body>
<br />
<table cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#ffffff">
 <tr align="center">
  <td class="ang1h"><br />Selettore di Dilemmi<br /></td>
  <td bgcolor="#cfcfbb">
   <form action="dilsel.php" method="get"><br />
   <b>Ricerca dilemma</b> &nbsp; <input name="stringa" type="text" size="15">
   <input type="hidden" name="eo2" value="" />
   <input type="submit" value="cerca" />
   </form><br />
  </td>
  <td class="ang2h"></td>
 </tr>
</table>
<table class="bar" cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#fefefe">
 <tr valign="middle" bgcolor="#dedebb">
  <td width="15%" nowrap> &nbsp; &nbsp; <a class="help" href="dilsel.php?istr" title="Istruzioni">Istruzioni</A> &nbsp; <a class="help" onClick="apri()" title="Legenda icone e colori">Legenda</a></td>
  <td>&nbsp;</td>
 </tr>
</table>
<table width="99%" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" align="center">
 <tr>
  <td style="height: 20px"></td>
 </tr>
 <tr>
  <td width="10"></td>
  <td>
<?php
if ($_SERVER['QUERY_STRING'] == 'istr') {
?>
   <table>
    <tr>
     <td>
	Si possono selezionare: le abilit&agrave; richieste (compresi i 3 attributi), scegliendo se le selezioni vadano considerate tutte (&quot;e&quot;) oppure in alternativa (&quot;o&quot;). 
	<br />Si possono anche scegliere il tipo di dilemma e limitare la selezione ai dilemmi muro (quelli che non si scartano finch&eacute; non sono risolti), ai dilemmi che uccidono e a quelli con punti. (Nota: il tipo dilemma viene selezionato in alternativa, mentre le altre scelte sono considerate tutte).
	<br />Per effettuare scelte multiple occore premere il tasto &quot;Ctrl&quot; mentre si clicca sulla voce scelta.
	<br />Nota: per inserire le carte nel mazzo, occorre <a href="user.php" target="MAZZO">registrarsi</a>
     </td>
    </tr>
   </table>
<?php
}
?>
   <form action="dilsel.php" method="get">
   <table align="center" cellpadding="3">
    <tr class="tit1" align="center">
     <td>Richieste</td>
     <td>Tipo</td>
    </tr>
    <tr>
     <td>	
      <select multiple name="skill[]" size="10">
<?php
foreach ($ABIL as $v) {
	echo "<option value=\"".$v."\"";
	if (is_array($_REQUEST['skill']) && in_array($v, $_REQUEST['skill'])) echo " selected";
	echo ">".$v."</option>\n";
}
?>
      </select>
      </td>
      <td valign="top">
       <img src="img/pixel.gif" width="200" height="1" alt="" /><br /> &nbsp;
<?php

echo "<input name=\"ps[]\" value=\"p\" type=\"checkbox\"";
if (is_array($_REQUEST['ps']) && $_REQUEST['ps'][0] == 'p') echo " checked";
echo " />Pianeta";
echo "<br /> &nbsp; <input name=\"ps[]\" value=\"s\" type=\"checkbox\"";
if (isset($_REQUEST['ps'])) {
	foreach ($_REQUEST['ps'] as $v) {
		if ($v == 's') echo " checked";
	}
}
echo ">Spazio";
echo "<br /> &nbsp; <input name=\"ps[]\" value=\"e\" type=\"checkbox\"";
if (isset($_REQUEST['ps'])) {
	foreach ($_REQUEST['ps'] as $v) {
		if ($v == 'e') echo " checked";
	}
}
echo ">Entrambi";
echo "<hr />";
echo "&nbsp; <input name=\"tipo[]\" value=\"w\" type=\"checkbox\"";
if (isset($_REQUEST['tipo']) && $_REQUEST['tipo'][0] == 'w') echo " checked";
echo ">Dilemma muro";
echo "<br /> &nbsp; <input name=\"tipo[]\" value=\"k\" type=\"checkbox\"";
if (isset($_REQUEST['tipo'])) {
	foreach ($_REQUEST['tipo'] as $v) {
		if ($v == 'k') echo " checked";
	}
}
echo ">Dilemma che uccide";
echo "<br /> &nbsp; <input name=\"punti\" value=\"point\" type=\"checkbox\"";
if (isset($_REQUEST['punti'])) echo " checked";
echo ">Dilemma con punti";
?>
     </td>
    </tr>
    <tr align="center">
     <td>
      <input name="eo" type="radio" value="and"<?php if (empty($_REQUEST['eo']) || $_REQUEST['eo'] == 'and') echo "checked" ?> />e
      <input name="eo" type="radio" value="or"<?php if ($_REQUEST['eo'] == 'or') echo "checked" ?> />o
     </td>
     <td><input type="submit" value="cerca" /></td>
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
 </tr>
 <tr>
  <td colspan="4">
<?php

$where = "WHERE 1 ";

/////////// aggiunta skill alle condizioni di where ////////

if (isset($_REQUEST['skill'])) {
	$where .=" AND (";
	$sizeskill = sizeof($_REQUEST['skill']);
	for ($i = 0; $i < $sizeskill; $i++) {
		if ($_REQUEST['skill'][$i] == "Biology") $where .= "testo LIKE '% Biology%'";
		else $where .= "testo LIKE '%".$_REQUEST['skill'][$i]."%'";
		if (isset($_REQUEST['skill'][$i+1])) $where .= " ".$eo." ";
	}
	$where .= ")";
}


///////// aggiunta pianeta/spazio alle condizioni di where /////////

$where .= " AND (";
if (isset($_REQUEST['ps'])) {
	$sizeps = sizeof($_REQUEST['ps']);
	for ($i = 0; $i < $sizeps; $i++) {
		$k = $i + 1;
		$where .= "tipod='".$_REQUEST['ps'][$i]."'";
		if (isset($_REQUEST['ps'][$k])) $where .= " OR ";
	}
} else {
	$where .= "1";
}
$where .= ")";

///////// aggiunta tipo alle condizioni di where /////////

if (isset($tipo)) {
	foreach ($tipo as $v) {
		$where .= " AND tipo2 LIKE '%".$v."%'";
	}
}

if (isset($punti)) {
	$where .= " AND ((icone <>'' AND icone<'[AU]') OR tipo2 LIKE '%p%')";
}

$where .= " AND tipod <>'Q'";

//////// query //////////
////////  o   ////////
//////// ricerca ///////

$query = "SELECT * FROM dilemmi d LEFT JOIN erti e ON e.id=d.id	LEFT JOIN testo t ON e.id=t.id ";

if (isset($stringa)) {
	if (!$stringa) $stringa = "niente";
	$query .= "WHERE nome LIKE '%".$stringa."%' AND tipod <>'Q' ORDER BY nome";
} else {
	$query .= $where." ORDER BY nome";
}

dbconnect();

$result = mysqli_query($link, $query);
//echo "<h4>query = $query</h4>";

$j2 = 0;
while ($r = mysqli_fetch_array($result)) {
	$a[$j2]["nome"] = $r["nome"];
	$a[$j2]["rar"] = $r["rar"];
	$a[$j2]["tipo"] = $r["tipod"];
	$a[$j2]["icone"] = $r["icone"];
	$a[$j2]["testo"] = $r["testo"];
	$a[$j2]["id"] = $r["id"];
	$a[$j2]["ediz"] = substr($a[$j2]["id"], 0, 3);
	$j2++;
}

mysqli_free_result($result);
mysqli_close($link);


/// scrittura a video delle opzioni di where scelte ///

if (isset($skill) && $skill[0] != 'xyz') {
	echo "&nbsp; Richieste scelte: ";
	echo implode(", ", $skill);
#	$sizeskill = sizeof($skill);
#	for ($k = 0; $k < $sizeskill; $k++) {
#		echo $skill[$k];
#		if (isset($skill[$k+1])) echo ", ";
#	}
	if (isset($skill[1])) {
		if ($eo == "and") echo " (tutte)<br />\n";
		if ($eo == "or") echo " (almeno una)<br />\n";
	} else echo "<br />\n";
}


/// scrittura a video numerosita` risultato ///

if (!$j2) echo "<br />&nbsp; Nessun dilemma trovato<br /><br />\n";
else {
	echo "<br />&nbsp; ".$j2;
	echo $j2 > 1 ? " trovati" : " trovato";
	echo "<br /><br />\n";

	//////////// output tabella ///////////////

	echo "<form action=\"user.php\" name=\"lista\" target=\"MAZZO\">\n";
	echo "<table width=\"100%\">\n";
	echo "<tr class=\"tit2\">\n<td width=\"10\"><input type=\"checkbox\" name=\"CheckAll\" onClick=\"ToggleCheckAll()\"></td><td>Nome</td>";
	echo "<td>Rar</td>";
	echo "<td>Tipo</td>";
	echo "<td align=\"center\" width=\"15\">Icone</td>";
	echo "<td align=\"center\" width=\"50%\">Testo</td>";
	echo "<td>Ediz</td>\n</tr>\n";

	for ($i = 0; $i < $j2; $i++) {
		echo "<tr valign=\"top\">\n<td class=\"t\" width=\"10\"><";
		cbox($a[$i]["id"]);
		echo "VALUE=\"".$a[$i]["id"]."\"></TD><TD CLASS=\"a\">";
		echo $a[$i]["nome"]."</td><td class=\"a\">".$a[$i]["rar"]."</td><td class=\"a\">".$a[$i]["tipo"]."</td><td class=\"a\">".$a[$i]["icone"]."</td><td class=\"a\" width=\"50%\">".$a[$i]["testo"]."</td><td class=\"a\">".$a[$i]["ediz"]."</td></tr>\n";
	}
	echo "<tr><td><input type=\"hidden\" NAME=\"op\" VALUE=\"insert\" />";
	echo "<input type=\"hidden\" name=\"gruppo\" VALUE=\"1s\" /></td></tr>\n";
	echo "</table>\n<br />&nbsp;<input type=\"submit\" value=\"Aggiungi al mazzo\" />\n</form>\n";
}

include "footer.php";
?>
</body>
</html>
