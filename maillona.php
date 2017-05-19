<?php
// per mandare un messaggio a tutti gli utenti del sito...

die();
include "mainfile.php";
dbconnect();

$res = mysql_query("SELECT email FROM users");

$to = "";
while ($r = mysql_fetch_array($res)) {
	$to .= $r[0].",";
}

echo $to;

?>
