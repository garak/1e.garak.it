<?php
include_once "mainfile.php";
if (empty($_SERVER['QUERY_STRING']) || $_SERVER['QUERY_STRING'] == "istr") {
	$eo = "and";
	$skill[] = "nessuna";
	$in = "";
	$c = "";
	$s = "";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Garak's Star Trek CCG DataBase</title>
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
 for (var i=0;i<document.lista.elements.length;i++) {
  var e = document.lista.elements[i];
  if (sa) {e.checked=true}
  else {e.checked=false}
 }
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
</head>
<body>
<br /><br />
<table cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#ffffff">
 <tr valign="middle" align="center">
  <td class="ang1h">Selettore di Personale</td>
  <td bgcolor="#cfcfbb" align="center">
   <form action="persel.php" method="get"><br />
   <b>Ricerca carta personale</b> &nbsp; 
   <input name="stringa" type="text" size="15" />
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
  <td width="15%" nowrap> &nbsp; &nbsp; <a class="help" href="persel.php?istr" title="Istruzioni">Istruzioni</a> &nbsp; <a class="help" onClick="apri()" title="Legenda icone e colori">Legenda</a></td>
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
   <form action="persel.php" method="get">
   <table align="center" cellpadding="3">
<?php
if ($_SERVER['QUERY_STRING'] == 'istr') {
?>
    <tr>
     <td colspan="5">
Si possono selezionare: abilit&agrave;, affiliazione, icone da includere ed icone da escludere. Per abilit&agrave; e icone si pu&ograve; scegliere se le selezioni vadano considerate tutte (&quot;e&quot;) oppure in alternativa (&quot;o&quot;). Per le affiliazioni invece la selezione &egrave; necessariamente in alternativa (&egrave; sottinteso un &quot;o&quot;).
<br />Si pu&ograve; anche limitare la selezione al personale universale, ai Mission Specialist o ai Support Personnel, ed indicare un valore minimo per i tre attributi.
<br />Per effettuare scelte multiple occore premere il tasto &quot;Ctrl&quot; mentre si clicca sulla voce scelta.
<br />Nota: per inserire le carte nel mazzo, occorre <a href="user.php" target="MAZZO">registrarsi</a>
     </td>
    </tr>
<?php
}
?>
    <tr class="tit1" align="center">
     <td>Abilit&agrave;</td>
     <td colspan="2">Affiliazione</td>
     <td>Icona</td>
     <td>NO Icona</td>
    </tr>
    <tr>
     <td rowspan="2">	
      <select multiple name="skill[]" size="10" class="std">
<?php
foreach ($ABIL as $v) {
	echo "<option value=\"".$v."\"";
	if (is_array($skill) && in_array($v, $skill)) echo " selected";
	echo ">".$v."</option>\n";
}
?>
      </select>
     </td>
	 <td valign="top" colspan="2">
      <table align="center" width="100%">
       <tr align="center">
<?php

foreach ($AFF as $v) {
	echo "<td class=\"c".$v."\"><input name=\"affl[]\" type=\"checkbox\" value=\"".$v."\"";
	if (is_array($affl) && in_array($v, $affl)) echo " checked";
	echo " /></td>";
	if ($n == 5) echo "</tr><tr align=\"center\">\n";
	$n++;
} 
?>
	   </tr>
	  </table>
     </td>
     <td rowspan="2">
      <select multiple name="ico[]" size="10">
<?php 
foreach ($ICONE as $k => $v) {
	echo "<option value=\"[".$k."]\"";
	if (isset($ico) && is_array($ico) && in_array("[".$k."]", $ico)) echo " selected";
	echo ">[".$k."] ".$v."</option>\n";
}
?>
      </select>
     </td>
     <td rowspan="2">
      <select multiple name="icon[]" size="10">
<?php
foreach ($ICONE as $k => $v) {
	echo "<option value=\"[".$k."]\"";
	if (isset($icon) && is_array($icon) && in_array("[".$k."]", $icon)) echo " selected";
	echo ">[".$k."]</option>\n";
}
?>
      </select>
     </td>
    </tr>
    <tr align="left">
     <td width="60%">
       &nbsp; &nbsp; <input type="checkbox" name="un" value="v"<?php if (isset($un)) echo  " checked" ?> /> <font class="w">v</font> (universale)
       <br /> &nbsp; &nbsp; <input type="checkbox" name="ms" value="1"<?php if (isset($ms) && $ms == 1) echo  " checked" ?> /> Mission Specialist
       <br /> &nbsp; &nbsp; <input type="checkbox" name="ms" value="2"<?php if (isset($ms) && $ms == 2) echo  " checked" ?> /> Support Personnel
       <br /> &nbsp; &nbsp; <input type="checkbox" name="hq" value="1"<?php if (!empty($hq)) echo  " checked" ?> /> Gratis agli HQ
     </td>
 	 <td>
	  <table align="center">
       <tr>
	    <td>INTEGRITY</td>
		<td><input name="in" class="i" type="text" size="2" maxlength="2"<?php if ($in) echo " value=\"".$in."\"" ?> />
        </td>
	   </tr>
       <tr>
        <td>CUNNING</td>
        <td><input name="c" class="c" type="text" size="2" maxlength="2"<?php if ($c) echo " value=\"".$c."\"" ?> />
        </td>
	   </tr>
       <tr>
        <td>STRENGTH</td>
        <td><input name="s" class="s" type="text" size="2" maxlength="2"<?php if ($s) echo " value=\"".$s."\"" ?> />
        </td>
       </tr>
      </table>
     </td>
    </tr>
    <tr align="center">
     <td>
      <input name="eo" type="radio" value="and"<?php if (!isset($eo) || $eo == "and") echo " checked" ?> />e
      <input name="eo" type="radio" value="or"<?php if (isset($eo) && $eo == "or") echo " checked" ?> />o
     </td>
     <td colspan="2"><input type="submit" value="cerca" /></td>
     <td>
      <input name="eo2" type="radio" value="and"<?php if (!isset($eo2) || $eo2 == "and") echo " checked" ?> />e
      <input name="eo2" type="radio" value="or"<?php if (isset($eo2) && $eo2 == "or") echo " checked" ?> />o
     </td>
     <td>
      <input name="eo3" type="radio" value="and"<?php if (!isset($eo3) || $eo3 == "and") echo " checked" ?> />e
      <input name="eo3" type="radio" value="or"<?php if (isset($eo3) && $eo3 == "or") echo " checked" ?> />o
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
	$where .= " AND (";
	$size = sizeof($affl);
	for ($i = 0; $i < $size; $i++) {
		$where .= "aff='".$affl[$i]."' OR aff2='".$affl[$i]."'";
		if (isset($affl[$i+1])) $where .= " OR ";
	}
	$where .= ")";
}

/////////// aggiunta skill alle condizioni di where ////////

if (isset($skill)) {
	$where .= " AND (";
	$size = sizeof($skill);
	for ($i = 0; $i < $size; $i++) {
		$cl = substr($skill[$i], 0, 1);
		$cla = substr($skill[$i], 0, 2);
		$clm = $cl."m";
		$clc = $cl."c";
		$cls = $cl."s";
		if ($skill[$i] == "CIVILIAN" || $skill[$i] == "ENGINEER" || $skill[$i] == "MEDICAL" || $skill[$i] == "OFFICER" || $skill[$i] == "SCIENCE" || $skill[$i] == "V.I.P.") {
			$where .= "(testo like '%".$skill[$i]."%' OR class='".$cl."' OR class='".$clm."' OR class='".$clc."' OR class='".$cls."')";
		} elseif ($skill[$i] == "SECURITY" or $skill[$i] == "ANIMAL") {
			$where .= "(testo LIKE '%".$skill[$i]."%' OR class='".$cla."')";
		} elseif ($skill[$i] == "Biology" or $skill[$i] == "Physics") {
			$where .= "(testo LIKE '".$skill[$i]."%' OR testo LIKE '% ".$skill[$i]."%')";
		} else {
			$where .= "(testo LIKE '%".$skill[$i]."%')";
		}
		if (isset($skill[$i+1])) $where.= " $eo ";
	} 
	$where .= ")";
}

///////// aggiunta icone alle condizioni di where /////////

if (isset($ico)) {
	$where .= " AND (";
	$size = sizeof($ico);
	for ($i = 0; $i < $size; $i++) {
		$where .= "icone LIKE '%".$ico[$i]."%'";
		if (isset($ico[$i+1])) $where .= " ".$eo2." ";
	}
	$where .= ")";
}

///////// aggiunta no-icone alle condizioni di where /////////

if (isset($icon)) {
	$where .= " AND (";
	$size = sizeof($icon);
	for ($i = 0; $i < $size; $i++) {
		$where .= "icone NOT LIKE '%".$icon[$i]."%'";
		if (isset($icon[$i+1])) $where .= " ".$eo3." ";
	}
	$where .= ")";
}

///////// aggiunta universale alle condizioni di where ////////

if (isset($un)) $where .= " AND un='v'";


///////// aggiunta attributi alle condizioni di where /////////

if ($in) $where .= " AND i>=".$in;
if ($c) $where .= " AND c>=".$c;
if ($s) $where .= " AND s>=".$s;


/**********************
*      query          *
*        o            *
*     ricerca         *
**********************/

$order = " ORDER BY aff,nome";
if (isset($affl[0]) && !(isset($affl[1]))) $order = " ORDER BY nome";

if (isset($hq) && $hq == 1) {
	$sql = "SELECT * FROM hq LEFT JOIN personale p ON p.id=hq.per LEFT JOIN erti e ON e.id=p.id LEFT JOIN testo2 t ON e.id=t.id ";
} else {
	$sql = "SELECT * FROM personale p LEFT JOIN erti e ON e.id=p.id LEFT JOIN testo2 t ON e.id=t.id ";
}

if (isset($stringa)) {
	if (!$stringa) $stringa = "niente"; 
	$sql .= "WHERE nome like '%".$stringa."%' ORDER BY aff,nome";
} else {
	$sql .= $where.$order;
}

dbconnect();
$result = mysqli_query($sql);
#echo "<h4>query = ".$sql."</h4>";

if (isset($ms)) {		// se mission specialist o support personnel selezionato
	$j = 0;
	$j2 = 0;
	while ($r = mysqli_fetch_array($result)) {
		$abi[$j] = $r["testo"];                // memorizza le abilità in una variabile
		$ts[$j] = $r["testosp"];
		$abis[$j] = explode(" ", $abi[$j]);	// le separa e le mette in un vettore
		sort($abis[$j]);			// ordina il vettore
		$k = sizeof($abis[$j]) - 1;
		if ($abis[$j][$k] == "x2") array_pop($abis[$j]);	// toglie l'ultimo oggetto se è "x2"
		$nabi[$j] = sizeof($abis[$j]);                  // conta gli oggetti rimasti
		if ($nabi[$j] == $ms && $ts[$j] == "") {	// se mis. spec. o sup. pers.
			$a[$j2]["un"] = $r["un"];
			$a[$j2]["nome"] = $r["nome"];
			$a[$j2]["aff"] = $r["aff"];
			$a[$j2]["aff2"] = $r["aff2"];
			$a[$j2]["rar"] = $r["rar"];
			$a[$j2]["class"] = $r["class"];
			$a[$j2]["testo"] = $abi[$j];
			$a[$j2]["testosp"] = $ts[$j];
			$a[$j2]["i"] = $r["i"];
			$a[$j2]["c"] = $r["c"];
			$a[$j2]["s"] = $r["s"];
			$a[$j2]["icone"] = $r["icone"];
			$a[$j2]["id"] = $r["id"];
			$a[$j2]["ediz"] = substr($a["$j2"]["id"], 0, 3);
			$j2++;
		}
		$j++;
	}
} else {
	$j2 = 0;
	while($r = mysqli_fetch_array($result)) {
		$a[$j2]["un"] = $r["un"];
		$a[$j2]["nome"] = $r["nome"];
		$a[$j2]["aff"] = $r["aff"];
		$a[$j2]["aff2"] = $r["aff2"];
		$a[$j2]["rar"] = $r["rar"];
		$a[$j2]["class"] = $r["class"];
		$a[$j2]["testo"] = $r["testo"];
		$a[$j2]["testosp"] = $r["testosp"];
		$a[$j2]["i"] = $r["i"];
		$a[$j2]["c"] = $r["c"];
		$a[$j2]["s"] = $r["s"];
		$a[$j2]["icone"] = $r["icone"];
		$a[$j2]["id"] = $r["id"];
		$a[$j2]["ediz"] = substr($a["$j2"]["id"], 0, 3);
		$j2++;
	}
}
mysqli_free_result($result);
mysqli_close($link);

/// scrittura a video delle opzioni di where scelte ///

if (isset($stringa)) {
	echo "&nbsp;Risultati della ricerca di <b>".$stringa."</b>";
}

if (isset($skill)) {
	echo "&nbsp; Abilit&agrave; scelte: ";
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

if (isset($icon)) {
	echo "&nbsp; Icone escluse: ";
	echo implode(", ", $icon);	
	if (isset($icon[1])) {
		if ($eo3 == "and") echo " (tutte)<br />";
		if ($eo3 == "or") echo " (almeno una)<br />";
	} else echo "<br />";
}

/// scrittura a video numerosita` risultato ///

if (!$j2) echo "<br />&nbsp; Nessun personale trovato<br />\n";
elseif ($j2 >= 1) {
	if ($j2 == 1) echo "<br />&nbsp; 1 trovato<br /><br />\n";
	else echo "<br />&nbsp; $j2 trovati<br /><br /\n";

	//////////// output tabella ///////////////

	echo "<form action=\"user.php\" name=\"lista\" target=\"MAZZO\" method=\"get\">\n
	<table width=\"100%\">\n
	<tr class=\"tit2\"><td width=\"10\"><input type=\"checkbox\" name=\"CheckAll\" onClick=\"ToggleCheckAll()\" /></td>
	<td>Nome</td><td>R</td><td>Cl</td><td align=\"center\" width=\"15\">I</td><td align=\"center\" width=\"15\">C</td>
	<td align=\"center\" width=\"15\">S</td><td width=\"50%\">Abilit&agrave;</td><td>Icone</td><td>Ediz</td></tr>\n";

	for ($i = 0; $i < $j2; $i++) {
		echo "<tr valign=\"top\"><td class=\"t\" width=\"10\"><";
		cbox($a[$i][id]);
		echo "value=\"".$a[$i]["id"]."\"></td><td class=\"".strtolower($a[$i]["aff"])."\">";
		if ($a[$i]["un"]) echo "<font class=\"w\">".$a[$i]["un"]."</font> ";
		if ($a[$i]["aff2"]) echo "<span class=\"".strtolower($a[$i]["aff2"])."\">&nbsp; &nbsp;</span> ";
		echo $a[$i]["nome"]."</td><td class=\"a\">".$a[$i]["rar"]."</td><td class=\"a\">".$a[$i]["class"]."</td><td class=\"i\" width=\"15\">".$a[$i]["i"]."</td><td class=\"u\" width=\"15\">".$a[$i]["c"]."</td><td class=\"s\" width=\"15\">".$a[$i]["s"]."</td><td class=\"a\" width=\"50%\">".$a[$i]["testo"]." ".simboli($a[$i][testosp])."</td><td class=\"a\">".$a[$i]["icone"]."</td><td class=\"a\">".$a[$i]["ediz"]."</td></tr>\n";
	}
	echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"7d\" /></td></tr>\n";
	echo "</table>\n<br />&nbsp;<input type=\"submit\" value=\"Aggiungi al mazzo\" />";
	echo "<input type=\"hidden\" name=\"op\" value=\"insert\" />\n</form>\n";
}

include "footer.php";
?>
</body>
</html>
