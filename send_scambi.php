<?php

include"header.php";
include_once "mainfile.php";
dbconnect();

echo "<form action=\"".$PHP_SELF."\" method=\"post\">\n"; 
echo "<table align=\"center\" cellpadding=\"3\">\n";

if (isset($ctrl)) {			// Invio messaggio

	if ($from && $subject && $to) {
		$query = "SELECT email,uorder FROM users WHERE uname='$from'";
		$result = mysql_query($query);
		$r = mysql_fetch_array($result);
		$mitt = $r["uorder"] ? $r["email"] : "non@rispondere.it";
		$query = "SELECT email FROM users WHERE uname='$to'";
		$result = mysql_query($query);
		$r = mysql_fetch_array($result);
		$dest = $r["email"];
		$header = "From: $from <$mitt>\nX-Mailer: PHP/".phpversion();
		if ($mitt=="non@rispondere.it") $text = "ATTENZIONE! Non rispondere direttamente a questo messaggio.\nUtilizzare il sito per scrivere a $from\n\n".$text;
		$text.= "\n------\nGarak's STCCG DataBase\nhttp://welcome.to/StarTrekCCG";
		mail($dest,"[Garak] ".stripslashes($subject),stripslashes($text),$header); 
		echo " La tua email &egrave; stata inviata con successo a ".$to;
	} else {
		echo "<b>INVIO FALLITO</b><br /><br />Devi riempire tutti i campi!";
		echo "<br /><a href=\"javascript:history.go(-1)\">Torna indietro</a>.";
	}

} else if ($dest && $mitt) {		// Form messaggio di scambi

	$query = "SELECT * FROM users WHERE uname='$mitt'";
	$result = mysql_query($query);
	$r = mysql_fetch_array($result);
	if (!$r["uorder"]) $from = 0;
	else $from = $r["email"];

	echo "<tr><td align=\"right\"><b>Da:</b></td><td align=\"right\">".ucfirst($mitt)."</td><td>";
	if ($from) echo "&lt;".$from."&gt;";
	else echo "<input type=\"text\" name=\"from\" size=\"15\"> (*)";
	echo "</td></tr>\n";
	echo "<tr><td align=\"right\"><b>A:</b></td><td align=\"right\">".ucfirst($dest)."</td><td>";

	$query = "SELECT * FROM users WHERE uname='$dest'";
	$result = mysql_query($query);
	$r = mysql_fetch_array($result);
	if (!$r["uorder"]) $to = 0;
	else $to = $r["email"];

	if ($to) echo "&lt;<a href=\"mailto:".$to."?subject=[Garak] Scambio Carte\">".$to."</a>&gt;";
	else echo "(E-mail privata)";
#	echo "</td></tr>\n";
	echo "<tr><td align=\"right\"><b>Oggetto:</b></td><td align=\"right\">[Garak]</td><td><input type=\"text\" name=\"subject\" size=\"20\" maxlength=\"30\" value=\"Scambio carte\"></TD></TR>\n";
	echo "<tr><td colspan=\"3\"><textarea name=\"text\" rows=\"8\" cols=\"40\"></textarea></td></tr>\n";
	echo "<tr><td colspan=\"3\"><input type=\"hidden\" name=\"ctrl\" value=\"1\">";
	echo "<input type=\"hidden\" name=\"from\" value=\"".$mitt."\">";
	echo "<input type=\"hidden\" name=\"to\" value=\"".$dest."\">\n";

	echo "<br /><input type=\"submit\" value=\"INVIA\"></td></tr>\n";
	if (!$from) {
		echo "<tr><td colspan=\"3\"><b>(*)</b> Hai scelto di tenere privato il tuo indirizzo e-mail. ";
		echo "Se vuoi, puoi specificare ora un indirizzo a cui ricevere una risposta. ";
		echo "Altrimenti, l' utente con cui vuoi fare lo scambio dovr&agrave; scriverti dal sito.</td></tr>\n";
	}

} else echo "errore<br />\n";	# mancanza di parametri passati

echo "</table>\n</form>\n";
include "footer.php";
?> 
</body>
</html>
