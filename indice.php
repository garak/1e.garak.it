<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="it">
<head>
<title>Garak's Star Trek CCG DataBase</title>
<link rel="stylesheet" href="style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
</head>
<body>
<br />
<table cellpadding="1" cellspacing="0" width="99%" align="center">
 <tr>
  <td class="ang1h" align="center">
   GARAK'S<br /> STAR TREK CCG<br /> DATABASE<br /> [UNOFFICIAL]
  </td>
  <td bgcolor="#cfcfbb" align="center">
   <form action="cerca.php" target="MAIN" method="post">
   <b>Ricerca carta</b> &nbsp; <input name="stringa" type="text" size="15" />
   <input type="submit" value="cerca" />
   </form>
  </td>
  <td class="ang2h"></td>
 </tr>
</table>
<table class="bar" cellpadding="2" cellspacing="0" width="99%" align="center">
 <tr valign="middle">
  <td width="10%" nowrap> &nbsp; <a href="/2e/send.php"><img src="/img/mail.gif" alt="Scrivi a Garak" title="Scrivi a Garak" /></a>
   &nbsp;<a href="info.php?garak" title="Chi è Garak">Garak</a> <a href="info.php?stccg" title="Cos'è Star Trek CCG">Star Trek CCG</a>
  </td> 
  <td align="center" width="70%">http://www.garak.it/1e&nbsp; &nbsp;
  </td>
  <td align="right" width="15%" nowrap>
   <b><?php 
include_once 'mainfile.php';
dbconnect();
setlocale (LC_TIME, 'it_IT');
echo strftime('%d %B %Y');
if (isset($user)) {
	cookiedecode($user);
	$login = "Mazzi di ".ucfirst($cookie[1]);
} else {
	$login = "Login";
}
?></b>
  </td>
  <td>&nbsp;</td>
 </tr>
</table>
<table width="99%" cellpadding="0" cellspacing="0" align="center" bgcolor="#FFFFFF">
 <tr>
  <td colspan="7" style="height: 15px"></td>
 </tr>
 <tr valign="top">
  <td width="10">&nbsp;</td>
  <td width="150">
   <div class="menu1">Selettori</div>
   <table cellpadding="0" cellspacing="0" width="150">
    <tr valign="top">
     <td>
      <strong><big>·</big></strong> <a href="persel.php" target="MAIN" title="Selettore di Personale">Personale</a><br />
      <strong><big>·</big></strong> <a href="navsel.php" target="MAIN" title="Selettore di Navi">Navi</a><br />
      <strong><big>·</big></strong> <a href="missel.php" target="MAIN" title="Selettore di Missioni">Missioni</a><br />
      <strong><big>·</big></strong> <a href="dilsel.php" target="MAIN" title="Selettore di Dilemmi">Dilemmi</a><br />
     </td>
    </tr>
   </table>
   <br /><br />
   <div class="menu1">Gestione Mazzi</div>
   <br />&nbsp;<a href="user.php" target="MAZZI"><?php echo $login ?></a>
   <br /><br />
   <div class="menu1">Dati</div>
<?php

$sql = "SELECT COUNT(*) FROM erti";
$result = mysqli_query($link, $sql);
$carte = mysqli_fetch_row($result);
$sql = "SELECT COUNT(*) FROM users";
$result = mysqli_query($link, $sql);
$utenti = mysqli_fetch_row($result);
$sql = "SELECT COUNT(*) FROM doppie";
$result = mysqli_query($link, $sql);
$doppie = mysqli_fetch_row($result);

echo "<br /><small>Il DataBase contiene attualmente <big>".$carte[0]."</big> carte. ";
echo "Ci sono <big>".$utenti[0]."</big> utenti registrati, che scambiano <big>".$doppie[0]."</big> carte doppie.</small>\n";
?>
   <br /><br />
   <div class="menu1">Regole</div>
   <br />
   <form action="regole.php" method="get">
   <select size="1" name="ediz">
    <option selected value="rulebook">Set Base</option>
    <option value="au">Alternate Un.</option>
    <option value="qc">Q Continuum</option>
    <option value="fajor">Fajo Coll.</option>
    <option value="fc">First Contact</option>
    <option value="dsn">Deep Space 9</option>
    <option value="td">The Dominion</option>
    <option value="bog">Blaze of Glory</option>
    <option value="roa">Rules of Acq.</option>
    <option value="ttwt">The Trouble...</option>
    <option value="mm">Mirror, Mirror</option>
    <option value="voy">Voyager</option>
    <option value="tb" disabled>The Borg</option>
    <option value="ha">Holodeck Adv.</option>
    <option value="tmp" disabled>The Motion Pict.</option>
   </select>
   <input type="submit" value="OK" />
   </form>
   <hr />
   <br />
   <div align="center">
   <a href="stccgg02.zip" title="Archivio di traduzioni di carte e regole">Star Trek CCG Archive</a><br />(di Vincenzo Gargiulo)
   <br /><br />
   <a href="http://gilda.it/dsx" target="_top" title="Deep Space X, where X = number of players present"><img src="/img/dsx.png" align="middle" height="31" width="88" alt="Deep Space X, where X = number of players present" /></a>
   <br /><br />
   <a href="http://www.stic.it/" target="_top" title="Star Trek Italian Club"><img src="/img/sociostic.png" align="middle" height="31" width="88" alt="Star Trek Italian Club" /></a>
   </div>
  </td>
  <td width="10">&nbsp;</td>
  <td>
   <div class="menu2">Benvenuto su garak.it!</div>
   <p class="std">
<b>ATTENZIONE: per il momento questa parte del sito non viene pi&ugrave aggiornata.</b><br />
   Sei appena entrato nel sito italiano dedicato al gioco di carte di Star Trek, noto soprattutto come Star Trek Customizable Card Game 
   (abbreviato STCCG oppure Star Trek CCG), un fantastico gioco prodotto dall'americana Decipher. Qui potrai trovare, oltre alla traduzione di tutte 
   le carte in lingua italiana, diversi strumenti che permettono di costruire mazzi e soprattutto un tramite con gli altri giocatori e 
   collezionisti per gli scambi di carte doppie.
   <br /><br />
   </p>
   <div class="menu2">Istruzioni</div>
   <p class="std">
  In alto si possono selezionare a piacere le tre voci di consultazione (da nessuna a tutte e tre) e premere il tasto. Deselezionando la voce
  &quot;testo&quot; si ottiene una lista pi&ugrave; concisa (e quindi pi&ugrave; veloce). Dalla lista o da uno dei selettori si possono
  inserire le carte scelte nel proprio mazzo oppure nella propria lista di doppie e mancanti (&egrave; necessario <a href="user.php" target="MAZZO">registrarsi</a>).
  Per costruire il mazzo &egrave; molto utile utilizzare i quattro selettori (i link sono a sinistra). 
  Enjoy!
   <br /><br />
   </p>
   <div class="menu2">For English speaking people</div>
   <p class="std">
  This site is intended for italian speaking people. I would like very much to build an english section, because the instruments I builded can
  be useful for all (follow the link marked as &quot;Personale&quot; in the upper left column and see). If someone wants to help me, a form is 
  avalaible to contact me, by clicking on the mail link. 
   <br /><br />   
   </p>
   <div class="menu2">Nota</div>
   <p class="std">
    Il DataBase &egrave; completo, ma data la grande mole di dati ed il lasso di tempo relativamente breve in cui sono stati inseriti, potrebbe presentare alcune imprecisioni.
    <br />Qualsiasi segnalazione, anche di un minimo errore, &egrave; pi&ugrave; che gradita! Scrivete a <a href="send.php">Garak</a>.
    <br /><br />
   </p>
   <div class="menu2">Il sondaggio</div>
   <p class="std">
    I sondaggi sono stati sospesi.
    <br />Vedi i <a href="poll.php" target="MAIN">sondaggi passati</a><br />
<?php
#include_once "poll_fun.php";
#poll(6);
?>
   </p>
   <br />
  </td>
  <td width="10">&nbsp;</td>
  <td bgcolor="#FFFFFF" valign="top" width="175">
   <div class="menu1">Update History</div>
   <br />
   <table cellspacing="1" cellpadding="1"> 
<?php
$hist = empty($_REQUEST['hist']) ? 6 : $_REQUEST['hist'];
$sql = "SELECT data,testo FROM history ORDER BY data DESC LIMIT ".$hist;
$result = mysqli_query($link, $sql);
while ($r = mysqli_fetch_array($result)) {
	$td = explode("-",$r["data"]);
	echo "<tr valign=\"top\"><td bgcolor=\"#dedebb\">".strftime("%d %B %Y",mktime(0,0,0,$td[1],$td[2],$td[0]))."</td></tr>\n";
	echo "<tr><td>".$r["testo"]."</td></tr>\n";
}
mysqli_free_result($result);
mysqli_close($link);

echo "</table><br />\n";
if ($hist==6) echo "&nbsp; <a href=\"indice.php?hist=100\" target=\"MAIN\">History completa</a>";
?>
  </td>
  <td width="10">&nbsp;</td>
 </tr>
</table>
<table width="99%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" align="center">
 <tr>
  <td class="ang3"></td>
  <td></td>
  <td class="ang4"></td>
 </tr>
</table>
<br />
<table width="99%" cellpadding="0" cellspacing="0" bgcolor="#ffffff" align="center">
 <tr>
  <td class="ang1"></td>
  <td></td>
  <td class="ang2"></td>
 </tr>
 <tr align="center">
  <td width="100%" colspan="3">
   <a href="http://www.php.net" target="_blank"><img src="/img/php-small.png" alt="Powered by PHP" hspace="10" /></a>
   <a href="http://www.mysql.com" target="blank"><img src="/img/mysqllogo.png" alt="Powered by mySQL" hspace="10" /></a>
   <br /><br />
   <small>
   &nbsp;STAR TREK and All Related Elements TM &amp; &copy; 2000 Paramount Pictures. All Rights Reserved. STAR TREK: THE NEXT GENERATION, DEEP SPACE NINE, VOYAGER and FIRST CONTACT are trademarks of and all characters and related marks are trademarks of Paramount Pictures.
   <br />&nbsp;Game Elements, Packaging, Designs and Rules TM &amp; &copy; 1999 Decipher Inc. All Rights Reserved. Decipher, Customizable Card Game, Alternate Universe, Expand Your Power in the Universe, and The Art of Great Games are trademarks of Decipher, Inc. 
   <br />THIS WEB SITE IS NOT PRODUCED OR ENDORSED BY DECIPHER, INC. OR PARAMOUNT PICTURES</small>
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
