<?php
include_once "mainfile.php";
if (empty($_SERVER['QUERY_STRING']) || $_SERVER['QUERY_STRING'] == "istr") {
	$eo = "and";
	$skill[] = "nessuno";
	$in = "";
	$c = "";
	$s = "";
} else {
	$eo = $_REQUEST['eo'];
	$skill = $_REQUEST['skill'];
	$in = $_REQUEST['in'];
	$c = $_REQUEST['c'];
	$s = $_REQUEST['s'];
}
$eo2 = $_REQUEST['eo2'] ?? null;
$eo3 = $_REQUEST['eo3'] ?? null;
$affl = $_REQUEST['affl'] ?? null;
$staff = $_REQUEST['staff'] ?? null;
$ico = $_REQUEST['ico'] ?? null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Star Trek CCG DataBase</title>
<link rel="stylesheet" href="style.css" type="text/css">
<script type="text/javascript">
function apri()
{
 window.open("legenda.html","legenda","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=300,height=400");
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
<table cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#FFFFFF">
 <tr valign="middle" align="center">
  <td class="ang1h">Selettore di Navi<br /></td>
  <td bgcolor="#CFCFBB">
   <form action="navsel.php" method="get"><br />
   <br /><b>Ricerca nave</b> &nbsp; <input name="stringa" type="text" size="15" />
   <input type="hidden" name="in" value="" />
   <input type="hidden" name="c" value="" />
   <input type="hidden" name="s" value="" />
   <input type="submit" value="cerca" />
   </form><br />
  </td>
  <td class="ang2h"></td>
 </tr>
</table>
<table class="bar" cellpadding="0" cellspacing="0" width="99%" align="center">
 <tr valign="middle">
  <td width="15%" nowrap> &nbsp; &nbsp; <a class="help" href="navsel.php?istr" title="Istruzioni">Istruzioni</a> &nbsp; <a class="help" onClick="apri()" title="Legenda icone e colori">Legenda</a></td>
  <td>&nbsp;</td>
 </tr>
</table>
<table width="99%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" align="center">
 <tr>
  <td style="height: 20px"></td>
 </tr>
 <tr>
  <td></td>
  <td>
   <form action="navsel.php" method="get">
   <table align="center" cellpadding="3" width="100%">
<?php
if ($QUERY_STRING == 'istr') {
?>
    <tr>
     <td colspan="5">
Si possono selezionare: abilit&agrave;, affiliazione, richieste di staff e icone. Per abilit&agrave;, staff e icone si pu&ograve; scegliere se le selezioni vadano considerate tutte (&quot;e&quot;) oppure in alternativa (&quot;o&quot;). Per le affiliazioni invece la selezione &egrave; necessariamente in alternativa (&egrave; sottinteso un &quot;o&quot;).
<br />Si pu&ograve; anche limitare la selezione al personale universale, ed indicare un valore minimo per i tre attributi.
<br />Per effettuare scelte multiple occore premere il tasto &quot;Ctrl&quot; mentre si clicca sulla voce scelta.
<br />Nota: per inserire le carte nel mazzo, occorre <a href="user.php" target="MAZZO">registrarsi</a>
     </td>
    </tr>
<?php
}
?>
    <tr class="tit1" align="center">
     <td>Equipaggiamento</td><td width="50%" colspan="2">Affiliazione</td><td>Staff</td><td>Icona</td>
    </tr>
    <tr valign="top">
     <td rowspan="2">	
      <select multiple name="skill[]" size="7">
<?php
foreach ($EQ as $v) {
	echo "<option value=\"".$v."\"";
	if (is_array($skill) && in_array($v, $skill)) echo " selected";
	echo ">".$v."</option>\n";
}
?>
      </select>
     </td>
     <td valign="top" colspan="2">
      <table width="100%">
       <tr align="center">
<?php
$n = 0;
foreach ($NAFF as $v) {
	echo "<td class=\"c".$v."\"><input name=\"affl[]\" type=\"checkbox\" value=\"".$v."\"";
	if (is_array($affl) && in_array($v, $affl)) echo " checked";
	echo "></td>";
	if ($n == 5) echo "</tr>\n<tr align=\"center\">\n";
	$n++;
}
?>
       </tr>
      </table>
     </td>
     <td rowspan="2">
      <select multiple name="staff[]" size="7">
       <option value="nessuna">Nessuna Richiesta</option>
<?php
foreach ($STAFF as $k=>$v) {
	echo "<option value=\"[".$k."]\"";
	if (is_array($staff) && in_array("[".$k."]", $staff)) echo " selected";
	echo ">[".$k."] ".$v."</option>\n";
}
?>
      </select>
     </td>
     <td rowspan="2">
      <select multiple name="ico[]" size="7">
<?php
foreach ($NICO as $v) {
	echo "<option value=\"[".$v."]\"";
	if (is_array($ico) && in_array("[".$v."]", $ico)) echo " selected";
	echo ">[".$v."]</option>\n";
}
?>
      </select>
     </td>
    </tr>
    <tr align="center">
     <td>
      <input type="checkbox" name="un" value="v"<?php if (isset($un)) echo  " checked" ?> />
      <span class="w">v</span>
     </td>
     <td>
      <table align="center">
       <tr>
        <td>RANGE</td><td><input name="in" size="2"<?php if ($in) echo " value=\"".$in."\"" ?> /></td>
        <td>WEAPONS</td><td><input name="c" size="2"<?php if ($c) echo " value=\"".$c."\"" ?> /></td>
        <td>SHIELDS</td><td><input name="s" size="2"<?php if ($s) echo " value=\"".$s."\"" ?> /></td>
       </tr>
      </table>
     </td>
    </tr>
    <tr align="center">
     <td>
      <input name="eo" type="radio" value="and"<?php if ($eo == "and" || !$eo) echo " checked" ?> />e
      <input name="eo" type="radio" value="or"<?php if ($eo == "or") echo " checked" ?> />o
     </td>
     <td colspan="2"><input type="submit" value="cerca" /></td>
     <td>
      <input name="eo2" type="radio" value="and"<?php if ($eo2 == "and" || !$eo2) echo " checked" ?> />e
      <input name="eo2" type="radio" value="or"<?php if ($eo2 == "or") echo " checked" ?> />o
     </td>
     <td>
      <input name="eo3" type="radio" value="and"<?php if ($eo3 == "and" || !$eo3) echo " checked" ?> />e
      <input name="eo3" type="radio" value="or"<?php if ($eo == "or") echo " checked" ?> />o
     </td>
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
<table cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#FFFFFF">
 <tr>
  <td class="ang1"></td>
  <td></td>
  <td class="ang2"></td>
 </tr>
 <tr>
  <td colspan="3">
<?php

$where = "WHERE 1 ";

///////// aggiunta affiliazione alle condizioni di where ///////

if (isset($affl[0])) {
	$where .= "AND ((aff='".$affl[0]."' OR aff2='".$affl[0]."')";
	if (isset($affl[1])) {
		$size = sizeof($affl);
		for ($i = 1; $i < $size; $i++) {
			$where .= "OR (aff='".$affl[$i]."' OR aff2='".$affl[$i]."')";
		}
	} 
	$where .= ")";
}

/////////// aggiunta skill alle condizioni di where ////////

if (isset($skill)) {
	$where .= " AND (testo LIKE '%".$skill[0]."%'";
	if (isset($skill[1])) {
		$size = sizeof($skill);
		for ($i = 1; $i < $size; $i++) {
			$where .= " ".$eo." testo LIKE '%".$skill[$i]."%'";
		}
	}
	$where .= ")";
}

///////// aggiunta staff alle condizioni di where /////////

if (isset($staff)) {
	if ($staff[0] == "nessuna") {
		$where .= " AND staff=''";
	} else {
		$where .= " AND (staff LIKE '%".$staff[0]."%'";
		if (isset($staff[1])) {
			$size = sizeof($staff);
			for ($i = 1; $i < $size; $i++) {
				$where .= " ".$eo2." staff LIKE '%".$staff[$i]."%'";
			}
		}
		$where .= ")";
	}
}

///////// aggiunta icone alle condizioni di where /////////

if (isset($ico)) {
	$where .= " AND (icone LIKE '%".$ico[0]."%'";
	if (isset($icon[1])) {
		$size = sizeof($ico);
		for ($i = 1; $i < sizeiof($ico); $i++) {
			$where .= $eo3." icone LIKEe '%".$ico[$i]."%'";
		}
	}
	$where .= ")";
}

///////// aggiunta universale alle condizioni di where ////////

if (isset($un)) {
	$where .=" AND un='v'";
}

///////// aggiunta attributi alle condizioni di where /////////

if ($in) $where .= " AND r>=".$in;
if ($c) $where .= " AND w>=".$c;
if ($s) $where .= " AND s>=".$s;

/**************
*	query
*	  o 
*	ricerca
***************/

$order = " ORDER BY aff,nome";
if (isset($affl[0]) and !(isset($affl[1]))) {
	$order = "ORDER BY nome";
}

if (isset($stringa)) {
	if (!$stringa) $stringa = "niente";
	$where = "WHERE nome LIKE '%".$stringa."%'";
}

$query = "SELECT * FROM navi n LEFT JOIN erti e ON e.id=n.id LEFT JOIN testo2 t ON e.id=t.id ".$where." ".$order;
dbconnect();
$result = mysqli_query($link, $query);
#echo "<h4>query = ".$query."</h4>";

$j2 = 0;
while($r = mysqli_fetch_array($result)) {
	$a[$j2]["un"] = $r["un"];
	$a[$j2]["nome"] = $r["nome"];
	$a[$j2]["aff"] = $r["aff"];
	$a[$j2]["aff2"] = $r["aff2"];
	$a[$j2]["rar"] = $r["rar"];
	$a[$j2]["classe"] = $r["classe"];
	$a[$j2]["testo"] = $r["testo"];
	$a[$j2]["testosp"] = $r["testosp"];
	$a[$j2]["r"] = $r["r"];
	$a[$j2]["w"] = $r["w"];
	$a[$j2]["s"] = $r["s"];
	$a[$j2]["staff"] = $r["staff"];
	$a[$j2]["icone"] = $r["icone"];
	$a[$j2]["id"] = $r["id"];
	$a[$j2]["ediz"] = substr($a[$j2]["id"], 0, 3);
	$j2++;
}

mysqli_free_result($result);
mysqli_close($link);

/// scrittura a video delle opzioni di where scelte ///

if (isset($stringa)) echo "&nbsp;Risultati della ricerca di <b>".$stringa."</b>";

if (isset($skill)) {
	echo "&nbsp; Equipaggiamento scelto: ";
	echo implode(", ", $skill);	
	if (isset($skill[1])) {
		if ($eo == "and") echo " (tutte)<br />";
		if ($eo == "or") echo " (almeno una)<br />";
	} else echo "<br />";
}

if (isset($ico)) {
	echo "&nbsp; Icone scelte: ";
	echo implode(", ", $ico);
	if (isset($ico[1])) {
		if ($eo2 == "and") echo " (tutte)<br />";
		if ($eo2 == "or") echo " (almeno una)<br />";
	} else echo "<br />";
}

if (isset($staff)) {
	echo "&nbsp; Staff: ";
	echo implode(", ", $staff);
	if (isset($staff[1])) {
		if ($eo3 == "and") echo " (tutte)<br />";
		if ($eo3 == "or") echo " (almeno una)<br />";
	} else echo "<br />";
}

/// scrittura a video numerosita` risultato ///

if (!$j2) echo "<br />&nbsp; Nessuna nave trovata<br />\n";
elseif ($j2 >= 1) {
	if ($j2 == 1) echo "<br />&nbsp; 1 trovato<br />\n";
	else echo "<br />&nbsp; $j2 trovati<br />\n";

//////////// output tabella ///////////////

?>
<form action="user.php" name="lista" target="MAZZO">
<table width="100%">
 <tr class="tit2">
  <td width="10"><input type="checkbox" name="CheckAll" onClick="ToggleCheckAll()"></td><td class="t"><b>Nome</b></td>
  <td>R</td><td>Classe</td>
  <td align="center" width="15">R</td>
  <td align="center" width="15">W</td>
  <td align="center" width="15">S</td>
  <td width="40%">Equipaggiamento</td>
  <td>Staff</td>
  <td width="20">Icone</td>
  <td>Ediz</td>
 </tr>
<?php
	for ($i = 0; $i < $j2; $i++) {
		echo "<tr valign=\"top\"><td class=\"t\" width=\"10\"><";
		cbox($a[$i]["id"]);
		echo "VALUE=\"".$a[$i]["id"]."\"></td><td class=\"".strtolower($a[$i]["aff"])."\">";
		if ($a[$i]["un"]) echo "<span class=\"w\">".$a[$i]["un"]."</span> ";
		if ($a[$i]["aff2"]) echo "<span class=\"".strtolower($a[$i]["aff2"])."\">&nbsp; &nbsp;</span> ";
		echo $a[$i]["nome"]."</td><td class=\"a\">".$a[$i]["rar"]."</td><td class=\"a\">".$a[$i]["classe"]."</td>";
		echo "<td class=\"".strtolower($a[$i]["aff"])."\" width=\"15\" align=\"center\">".$a[$i]["r"]."</td>";
		echo "<td class=\"".strtolower($a[$i]["aff"])."\" width=\"15\" align=\"center\">".$a[$i]["w"]."</td>";
		echo "<td class=\"".strtolower($a[$i]["aff"])."\" width=\"15\" align=\"center\">".$a[$i]["s"]."</td>";
		echo"<td class=\"a\" width=\"40%\">".$a[$i]["testo"]." ".$a[$i]["testosp"]."</td><td class=\"a\">".$a[$i]["staff"]."</td><td class=\"a\" width=\"20\">".$a[$i]["icone"]."</td><td class=\"a\">".$a[$i]["ediz"]."</td></tr>\n";
	}
	echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"7d\" />";
	echo "<input type=\"hidden\" name=\"op\" value=\"insert\" /></td></tr>\n";
	echo "</table><br />&nbsp;<input type=\"submit\" value=\"Aggiungi al mazzo\" /></form>";
}

include "footer.php";
?>
</body>
</html>
