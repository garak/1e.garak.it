<?php

include_once "mainfile.php";
dbconnect();

cookiedecode($user);
$utente = $cookie[1];

$query = "select idmazzo,user from mazzi where user='$utente' and idmazzo='$mid'";
$result = mysql_query($query);
if (mysql_num_rows($result)<1 && $utente!="garak") die("Accesso non autorizzato");
mysql_free_result($result);

$query = "select user,nomemazzo from mazzi where idmazzo=$mid";
$result = mysql_query($query);
list($user,$nomemazzo) = mysql_fetch_row($result);
mysql_free_result($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Garak's STCCG DataBase - MAZZO <?php echo "$nomemazzo DI $user"; ?></title>
<link rel="STYLESHEET" HREF="style.css" TYPE="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
</head>
<body>
<table width="640" cellpadding="0" cellspacing="1" bgcolor="#000000"><tr><td>
<table width="640" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF"><tr><td align="center">
<?php

$query = "select * from mazzo m left join erti e on m.id=e.id left join personale p on m.id=p.id left join navi n on m.id=n.id left join testo2 t on p.id=t.id where idmazzo=$mid order by gruppo,tipo,p.aff,n.aff,nome";
$result = mysql_db_query("garak",$query);
$i = 0;
while ($r = mysql_fetch_array($result)) {
	$ar["un"][$i] = $r["un"];
	$ar["nome"][$i] = $r["nome"];
	$ar["rar"][$i] = $r["rar"];
	$ar["id"][$i] = $r["id"];
	$ar["tipo"][$i] = $r["tipo"];
	$ar["gruppo"][$i] = $r["gruppo"];
	$i++;
}
mysql_free_result($result);
mysql_close();

echo "<table cellspacing=\"0\" cellpadding=\"0\">\n";
echo "<tr><td>Mazzo: $nomemazzo</td><td></td><td>Autore: $user</td></tr>\n";
echo "<tr><td valign=\"top\"><img src=\"img/pixel.gif\" width=\"250\" height=\"1\" hspace=\"0\" alt=\"\" /><table width=\"100%\">";
#echo "<tr><td></td><td><B>Nome</b></TD><td><B>Rar &nbsp;</b></TD><td><B>Ediz</b></TD></TR>\n";
#echo "<tr><td width=\"40\"></td><td></td><td colspan=\"2\"></td></tr>\n";

for ($k = 0; $k < $i; $k++) {
	if (!$k) {
		echo "<tr><td colspan=3><br><b>".strtoupper(trad($ar["gruppo"][$k]))."</b></td></tr>\n";
		echo "<tr><td colspan=3 align=\"center\"><b>".trad($ar["tipo"][$k])."</b></td></tr>\n";
	} else if ($ar["gruppo"][$k]<>$ar["gruppo"][$k-1]) { ///se cambio gruppo/// 
		if ($ar["gruppo"][$k]=="7d") echo "</table></td><td>&nbsp; &nbsp; &nbsp; &nbsp;</td><td valign=\"top\"><img src=\"img/pixel.gif\" width=\"250\" height=\"1\" hspace=\"0\" alt=\"\" /><table width=\"100%\">"; 
		echo "<tr><td colspan=3 align=\"left\"><br><b>".strtoupper(trad($ar["gruppo"][$k]))."</b></td></tr>\n";
		echo "<tr><td colspan=3 align=\"center\"><b>".trad($ar["tipo"][$k])."</b></td></tr>\n";
	} else if ($ar["tipo"][$k]<>$ar["tipo"][$k-1]) {  ///se cambio tipo///
		echo "<tr><td colspan=\"3\" align=\"center\"><b>".trad($ar["tipo"][$k])."</b></td></tr>\n";
	}
	echo "<tr><td>";
	if ($ar["un"][$k]) echo "<font class=\"w\">".$ar["un"][$k]."</font> ";
	echo "<font size=1>".$ar["nome"][$k]."</font></td><td><font size=1>".$ar["rar"][$k]."</font></td><td><font size=1>".substr($ar["id"][$k],0,3)."</font></td></tr>\n";
}
?>
</table>
</td></tr></table>
</td></tr></table>
</td></tr></table>
</body>
</html>
