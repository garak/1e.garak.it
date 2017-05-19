<?php
/*
* questo script sembra non essere piu` utilizzato
* Garak 6/8/2002 
*
*/

function userCheck($nick, $email)
{
 global $stop,$db;
 if ((!$email) || ($email=="") || (!eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email))) $stop = "<center>ERRORE: email non valida</center><br>";
 if (strrpos($uname,' ') > 0) $stop = "<center>ERRORE: l' email non pu&ograve; contenere spazi.</center>";
 if ((!$nick) || ($nick=="") || (ereg("[^a-zA-Z0-9_-]",$nick))) $stop = "<center>ERRORE:  nick non valido.</center><br>";
 if (strlen($nick) > 25) $stop = "<center>Nick troppo lungo. Non pi&ugrave; di 25 caratteri.</center>";
 if (eregi("^((root)|(adm)|(linux)|(webmaster)|(admin)|(god)|(administrator)|(administrador)|(nobody)|(anonymous)|(anonimo)|(anónimo)|(operator))$",$uname)) $stop = "<center>ERRORE: Nick riservato.";
 if (strrpos($nick,' ') > 0) $stop = "<center>Non possono esserci spazi nel nick.</center>";
 if (mysql_num_rows(mysql_query("select nick from users where nick='$nick'")) > 0) $stop = "<center>ERRORE: nick gi&agrave; utilizzato.</center><br>";
 if (mysql_num_rows(mysql_query("select email from users where email='$email'")) > 0) $stop = "<center>ERRORE: Email address already registered</center><br>";
 return($stop);
}

include_once "mainfile.php";
dbconnect();

if ($login==1) {
	$query = "select * from users where nick='$nick'";
	$result = mysql_db_query("garak",$query);
	$r = mysql_fetch_array($result);
	$dbpass = $r["pass"];
	$pass = $dbpass; //$pass=crypt($pass,substr($dbpass,0,2));
	if (strcmp($dbpass,$pass)) {Header("Location: mazzo.php?err=password&controllo=niente");}
	else {Header("Location: mazzo.php?login=1");}
	exit;
}

if ($reg==1) { 
	userCheck($nick,$email);
	if (isset($stop)) {
		Header("Location: mazzo.php?err=$stop&controllo=niente");
	} else {
		$query = "insert into users (id,nome,nick,pass) values ($id,$nome,$nick,$pass)";
		$result = mysql_db_query("garak",$query);
  		Header("Location: mazzo.php?err=niente&controllo=niente");
 	}
}

mysql_close();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Garak Star Trek CCG DataBase</TITLE>
<LINK REL="STYLESHEET" HREF="style.css" TYPE="text/css">
</HEAD>
<BODY>
</BODY>
</HTML>
