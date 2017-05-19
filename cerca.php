<?php $stringa = $_REQUEST['stringa'] ?? "Picard" ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Garak's Star Trek CCG DataBase</title>
<link rel="stylesheeT" href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
</head>
<body>
<br /><br />
<table cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#ffffff">
 <tr>
  <td class="ang1"></td>
  <td></td>
  <td class="ang2"></td>
 </tr>
 <tr>
  <td colspan="3">
   <br />
&nbsp; Risultati della ricerca di <b> <?php echo htmlentities($stringa) ?></b>
(cliccando sul tipo carta, la si inserisce nel mazzo)
   <br /><br />
   <table width="100%">
    <tr class="tit1"><td>Nome</td><td>Rar</td><td>Tipo</td><td>Testo</td><td>Icone</td><td>Ediz</td></tr>
<?php
include_once "mainfile.php";
dbconnect();

$cerca = "SELECT e.id,nome,rar,tipo,icone,
 t.testo AS testoa,t2.testo as testop,t2.testosp AS testosp
 FROM erti e LEFT JOIN testo2 t2 ON e.id=t2.id
 LEFT JOIN testo t ON e.id=t.id
WHERE nome like '%".mysqli_real_escape_string($stringa)."%' ORDER BY tipo,nome";
$result = @mysqli_query($link, $cerca) or die("errore nella query");

while ($r = mysqli_fetch_array($result)) {
	echo "<tr valign=\"top\">\n<td class=\"a\">".$r["nome"]."</td><td class=\"a\">".$r["rar"]."</td><td class=\"a\"><a href=\"user.php?op=insert&amp;per[]=".$r["id"]."&amp;gruppo=";

	switch ($r["tipo"]) {
	case "mis": echo "2m"; break;
	case "sit": echo "2m"; break;
	case "fac": echo "1s"; break;
	case "dil": echo "1s"; break;
	case "tac": echo "5b"; break;
	default: echo "7d"; break;
	}
	echo "\" title=\"Inserisci nel mazzo\" target=\"MAZZO\">".trad($r["tipo"])."</a></td><td class=\"a\" width=\"50%\">";

	if (isset($r["testoa"])) echo $r["testoa"];
	if (isset($r["testop"])) echo $r["testop"]." ".$r["testosp"];
	 echo "</td><td class=\"a\">".$r["icone"]."</td><td class=\"a\">".substr($r["id"],0,3)."</td></tr>\n";
}
mysqli_free_result($result);
mysqli_close();
?>
   </table>
   <br /><br />
   <br />&nbsp; Nuova ricerca:
   <form action="cerca.php" target="MAIN" method="get">
   &nbsp; <input name="stringa" type="text" size="15" />
   <input type="submit" value="cerca" />
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
</body>
</html>
