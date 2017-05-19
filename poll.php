<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Star Trek CCG DataBase</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#505050" topmargin="0">
<p><br>
<table class=std cellpadding="0" cellspacing="0" width="99%" border="0" align="center" bgcolor="#ffffff">
<tr valign="top">
<td bgcolor="#ffffff"><img height="16" hspace="0" src="img/corner-top-left.gif" width="17" align="left"></td>
<td bgcolor="#ffffff"></td>
<td bgcolor="#ffffff"><img height="17" hspace="0" src="img/corner-top-right.gif" width="17" align="right"></td>
</tr>
<tr><td colspan="3">
&nbsp;Sondaggi
<ul>
<?php
include_once "mainfile.php";
dbconnect();

///////////visualizza elenco sondaggi//////////////

$id = intval($_REQUEST['id'] ?? 0);
$voto = intval($_REQUEST['voto'] ?? 0);

if (empty($id)) {
	$query = "SELECT * FROM poll_desc";
	$result = mysqli_query($link, $query);
	$i = 0;
	while ($r = mysqli_fetch_array($result)) {
		$poll[$i]['id'] = $r['pollID'];
		$poll[$i]['tit'] = $r['pollTitle'];
		$poll[$i]['inizio'] = $r['inizio'];
	//	$poll[$i][fine] = $r[fine];
		$poll[$i]['voti'] = $r['voti'];
		$i++;
	}
/* 
 $oggi=getdate();
 $m=$oggi["mon"];$g=$oggi["mday"];$a=$oggi["year"];
 $data=date("d/m/Y",mktime(12,0,0,$m,$g,$a);
*/
	foreach ($poll as $v) {
		list($annoi,$mesei,$giornoi) = explode('-',$v['inizio']);
		$datai = date("d/m/Y",mktime(12,0,0,$mesei,$giornoi,$annoi));
		echo "<li><a href=\"poll.php?id=".$v['id']."\">".$v['tit']."</a> (dal $datai - ".$v['voti']." voti)\n";
 	}
}

/////////////visualizza sondaggio selezionato////////////

if (!empty($id) && empty($voto)) {
 $query = "SELECT pollID,pollTitle,voti FROM poll_desc WHERE pollID=".$id;
 $result = mysqli_query($link, $query);
 $r = mysqli_fetch_array($result);
 echo "<form method=\"get\" action=\"poll_voto.php\">\n";
 echo "<b>".$r['pollTitle']."</b>";
 mysqli_free_result($result);
 $query = "SELECT * FROM poll_data WHERE pollID=".$id;
 $result = mysqli_query($link, $query);
 while ($r = mysqli_fetch_array($result)) {
 	echo "<p><input type=Radio name=\"voto\" value=\"".$r['voteID']."\">".$r['optionText']."\n";
 }
 echo "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";

 echo "<p><font size=-2><a href=\"poll_voto.php?id=".$id."\">Risultati</a></font>";     
 echo " | <font size=-2><a href=\"poll.php\">Altri Sondaggi</a></font>";
 echo "<p><input type=\"submit\" value=\"Vota\"></form>";
}

mysqli_free_result($result);
mysqli_close($link);
?>

</td></tr>
<tr valign=bottom>
<td><img height="17" hspace="0" src="img/corner-bottom-left.gif" width="17" align="left"></td>
<td width="100%">&nbsp;</td>
<td><img height="17" hspace="0" src="img/corner-bottom-right.gif" width="17" align="right"></td>
</tr>
</table>
<p>
</body>
</html>
