<?php

include "header.php";
include_once "mainfile.php";

OpenTable();

if (isset($_REQUEST['ctrl'])) {		// Invio messaggio

	if ($text && $nome && $email) {
		$to = "garak@tiscali.it";
		$testo = "Messaggio inviato dal sito GSTCCGDB.\nIP: ".$REMOTE_HOST." (".$REMOTE_ADDR.")\nBrowser: ".$HTTP_USER_AGENT."\n\n".$text;
		$header = "From: ".$nome." <".$email.">\nX-Mailer: PHP ".phpversion();
		mail($to, "[Garak] ".stripslashes($subject), stripslashes($testo), $header); 
		echo "La tua email &egrave; stata inviata.<br />&nbsp; Grazie per avermi scritto, ti risponder&ograve; al pi&ugrave; presto.";
	} else {
		echo "<b>INVIO FALLITO</b><br /><br />Devi riempire tutti i campi!";
		echo "<br /><a href=\"javascript:history.go(-1)\">Torna indietro</a>.";
	}

} else if ($dest) {		// Form messaggio di scambi

	dbconnect();
	$query = "SELECT * FROM users WHERE uname='$uname'";
	$result = mysqli_query($link, $query);
	$r = mysqli_fetch_array($result);
	if ($r["uorder"]) $from = 0;
	else $from = $r["email"];

	echo "</td></tr>\n<form action=\"".$PHP_SELF."\" method=\"post\">\n"; 
	echo "<tr><td width=\"10%\">Da:</td><td>$uname</td><td>";
	if ($from) echo "<".$from.">";
	else echo "(E-mail privata)";
	echo "</td></tr>\n";
	echo "<tr><td width=\"10%\">A:</td><td>$dest</td><td>";

	$query = "SELECT * FROM users WHERE uname='$dest'";
	$result = mysqli_query($link, $query);
	$r = mysqli_fetch_array($result);
	if ($r["uorder"]) $to = 0;
	else $to = $r["email"];
	if ($to) echo "<".$to.">";
	else echo "(E-mail privata)";
	echo "</td></tr>\n";
	echo "<tr><td width=\"10%\">Oggetto:</td><td>[Garak] <input type=\"text\" name=\"subject\" size=\"30\" maxlength=\"30\" value=\"Scambio carte\"></td></tr>\n";
	echo "<tr><td colspan=\"2\"><textarea name=\"text\" rows=\"8\" cols=\"60\" maxlength=\"200\">";

	# $query="";
	# messaggio

	echo "</textarea></td></tr>";
	echo "<input type=\"hidden\" name=\"ctrl\" value=\"1\">";
	echo "<tr><td></td><td><br /><input type=\"submit\" VALUE=\"INVIA\"></td></tr>\n</form><tr><td>";

} else {			// Form messaggio per Garak

	echo "<form action=\"".$PHP_SELF."\" method=\"post\">\n"; 
	echo "<table>\n";
	echo "<tr><td width=\"10%\">Nome:</td><td><input type=\"text\" name=\"nome\" size=\"30\" maxlength=\"30\"></td></tr>";
	echo "<tr><td width=\"10%\">E-mail:</td><td><input type=\"text\" name=\"email\" size=\"30\" maxlength=\"30\"></td></tr>";
	echo "<tr><td width=\"10%\">Oggetto:</td><td><input type=\"text\" name=\"subject\" size=\"30\" maxlength=\"30\" value=\"Star Trek CCG\"></td></tr>";
	echo "<tr><td colspan=\"2\"><textarea name=\"text\" rows=\"8\" cols=\"60\" maxlength=\"200\"></textarea></td></tr>";
	echo "<tr><td><input type=\"hidden\" name=\"ctrl\" value=\"1\"></td>";
	echo "<td><br /><input type=\"submit\" value=\"INVIA\"></td></tr>\n</table>\n</form>\n";
}

CloseTable();
include "footer.php";
?> 
</body>
</html>
