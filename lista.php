<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Garak's Star Trek CCG DataBase</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<script type="text/javascript" src="form.js"></script>
</head>
<body>
<br />
<?php
include_once "funzione.php";
dbconnect();

$txtjoin = "";
$txt2join = "";
$ctext = "";
$ctextn = "";
$ctexta = "";

if (isset($_REQUEST['testo'])) {
	$txtjoin = "left join testo t on a.id=t.id";
	$txt2join = "left join testo2 t on a.id=t.id";
	$ctext = "<td class=\"t\"><b>Abilit&agrave;</b></td>";
	$ctextn = "<td class=\"t\"><b>Equip. Speciale</b></td>";
	$ctexta = "<td class=\"t\"><b>Testo</b></td>";
}

$ediz = $_REQUEST['ediz'];
$rar = $_REQUEST['rar'];
$tipo = $_REQUEST['tipo'];

if (!$ediz && !$rar) $ctrl = "e0r0";    //// controllo su edizione e rarita` ///////
if (!$ediz &&  $rar) $ctrl = "e0r1";
if ( $ediz && !$rar) $ctrl = "e1r0";
if ( $ediz &&  $rar) $ctrl = "e1r1";

switch ($ctrl) {                        //// impostazione flag per edizione e rarita` ////
	case "e0r0": $clausola = "where 1"; $crar = "<td class=\"t\"><b>Rar</b></td>"; $cediz = "<td class=\"t\"><b>Ediz</b></td>"; break;
	case "e0r1": $clausola = "where rar='$rar'"; $cediz="<td class=\"t\"><b>Ediz</b></td>"; break;
	case "e1r0": $clausola = "where substring(a.id,1,3)='$ediz'"; $crar = "<td class=\"t\"><b>Rar</b></td>"; break;
	case "e1r1": $clausola = "where substring(a.id,1,3)='$ediz' and rar='$rar'"; break;
}

OpenTable2();

?>
<div align="center"><a class="help" href="javascript:apri('legenda.html')" title="Legenda icone e colori">Legenda</a></div>
<?php

if (!isset($tipo)) {        //// se tipo non e` stato impostato... ////
	$notipo = 1;
	tabella('art');
	tabella('dilemmi');
	tabella('doo');	
	tabella('equ');
	tabella('eve');
	tabella('inc');
	tabella('installazioni');
	tabella('int');
	tabella('obj');
	tabella('siti');
	tabella('tattiche');
	tabella('tri');
	tabella('tro');
	tabella('personale');
	tabella('navi');
	tabella('tl');
	tabella('missioni');
}

if (isset($tipo)) {         //// se tipo e` stato impostato... ////
	$notipo = 0;
	tabella($tipo);
}

?> 
  </td>
 </tr>
 <tr>
  <td class="ang3"></td>
  <td></td>
  <td class="ang4"></td>
 </tr>
</table>
<br />
</body>
</html>
