<?php

function userCheck($uname, $email)
{
	global $stop;
	if ((!$email) || ($email=="") || (!filter_var($email, FILTER_VALIDATE_EMAIL))) $stop = "<center>ERRORE: e-mail non valida</center><br />";
	if (strrpos($uname,' ') > 0) $stop = "<center>ERRORE: l' e-mail non deve contenere spazi</center>";
	if ((!$uname) || ($uname=="") || (ereg("[^a-zA-Z0-9_-]",$uname))) $stop = "<center>ERRORE: Nickname non valido</center><br />";
	if (strlen($uname) > 25) $stop = "<center>Nickname troppo lungo. Non deve superare i 25 caratteri</center>";
	#if (eregi("^((root)|(linux)|(webmaster)|(admin)|(god)|(administrator)|(anonymous)|(anonimo))$",$uname)) $stop = "<center>ERRORE: nome riservato";
	if (strpos($uname,' ') !== false) $stop = "<center>Non possono esserci spazi nel Nickname.</center>";
	dbconnect();
	if (mysqli_num_rows(mysqli_query($link, "select uname from users where uname='$uname'")) > 0) $stop = "<center>ERRORE: Nickname gi&agrave; in uso</center><br />";
	if (mysqli_num_rows(mysqli_query($link, "select email from users where email='$email'")) > 0) $stop = "<center>ERRORE: E-mail gi&agrave; registrata</center><br />";
	return($stop);
}

function makePass()
{
	$makepass="";
	$syllables="er,in,tia,wol,fe,pre,vet,jo,nes,al,len,son,cha,ir,ler,bo,ok,tio,nar,sim,ple,bla,ten,toe,cho,co,lat,spe,ak,er,po,co,lor,pen,cil,li,ght,wh,at,the,he,ck,is,mam,bo,no,fi,ve,any,way,pol,iti,cs,ra,dio,sou,rce,sea,rch,pa,per,com,bo,sp,eak,st,fi,rst,gr,oup,boy,ea,gle,tr,ail,bi,ble,brb,pri,dee,kay,en,be,se";
	$syllable_array=explode(",", $syllables);
	srand((double)microtime()*1000000);
	for ($count=1;$count<=4;$count++) {
		if (rand()%10 == 1) {
			$makepass .= sprintf("%0.0f",(rand()%50)+1);
		} else {
			$makepass .= sprintf("%s",$syllable_array[rand()%62]);
		}
	}
	return($makepass);
}

function confirmNewUser($uname, $email, $empp)
{
	global $stop, $EditedMessage;
	include "header.php";
	filter_text($uname);
	$uname = $EditedMessage;
	userCheck($uname, $email);
	if (!$stop) {
		OpenTable();
		echo "Nome utente: $uname<br />E-mail: $email ";
		if ($empp) echo "(pubblica)<br />";
		else echo "(privata)<br />"; ?>
		<form action="user.php" method="post">
		<input type="hidden" name="uname" value="<?php echo $uname ?>">
		<input type="hidden" name="email" value="<?php echo $email ?>">
		<input type="hidden" name="empp" value="<?php echo $empp ?>">
		<br /><br /><input type="hidden" name="op" value="finish"><input type="submit" value="Finito"></form>
<?php
		CloseTable();
	} else {
		echo "$stop";
	}
	include "footer.php";
}

function finishNewUser($uname, $email, $empp) 
{
	global $stop, $makepass, $EditedMessage;
	include "header.php";
	dbconnect();
	userCheck($uname, $email);
	$user_regdate = date("M d, Y");
	if (!isset($stop)) {
		$makepass = makepass();
		$cryptpass = crypt($makepass);
		$result = mysqli_query($link, "insert into users values (NULL,'','$uname','$email','$user_regdate','$cryptpass','$makepass','$empp',0)");
		if (!$result) echo mysqli_errno(). ": ".mysqli_error(). "<br />";
		else {
			$message = "Benvenuto su Garak's STCCG DataBase!\n\n Tu o qualcun altro ha usato il tuo indirizzo e-mail ($email) per registrarsi sul sito. Le informazioni utente sono le seguenti: \n\n -Nickname: $uname\n -Password: $makepass\n\nEffettua subito un login per modificare le tue info.";
			$subject = "Password di $uname per Garak's STCCG DataBase";
			$from = "garak@tiscali.it";
			mail($email, $subject, $message, "From: $from\nX-Mailer: PHP/" . phpversion());
			OpenTable();
			echo "Ora sei registrato. Riceverai la tua password all'indirizzo e-mail che hai inserito.";
			CloseTable();
		}
	}
	else echo "$stop";
	include "footer.php";
}

function userinfo($uname, $bypass = 0)
{
	global $user, $cookie;
	if (!$bypass) cookiedecode($user);
	include "header.php";
	OpenTable3();
	echo "<div align=\"center\" style=\"text-align: center; margin-left: 50px; margin-right: 50px\">";
	if (($uname == $cookie[1]) || ($bypass == 1)) {
		echo "<font size=\"4\">Benvenuto ".ucfirst($uname)."!<br /><br /></font>";
		echo "<font size=\"2\">Questo &egrave; il tuo gestore di mazzi e di scambi<br />";
		echo "Attenzione: puoi avere quanti mazzi vuoi, ma solo uno alla volta ";
		echo "pu&ograve; essere attivo.<br />Nel tuo mazzo attivo verranno inserite le carte selezionate.";
		echo "<br />Nota: questa pagina viene aperta su un'altra finestra, in modo da";
		echo " poter utilizzare due pagine distinte, una per la scelta delle carte";
		echo " e l'altra per la gestione (del mazzo o degli scambi).</font>";
    	echo "<br /><br /><a href=\"user.php?op=edituser\" title=\"Modifica i tuoi dati\">Modifica Profilo</a>&nbsp;&nbsp;\n";
   		echo"<a href=\"user.php?op=logout\" title=\"Esci\">Logout</a>\n</div>\n";
    	CloseTable3();
   		include "footer.php";
		mazzi($user);
	}
	CloseTable();
	echo "<br /><br />";
	include "footer.php";
	echo "</body></html>";
}

function main($user)
{
	global $stop;
	if (!isset($user)) {
		include "header.php";
		if ($stop) echo "<center><h3>Login errato!</h3></center>";
		echo "</td></tr>\n<tr><td colspan=\"3\">";
		OpenTable();
?>
	<form action="user.php" method="post">
	<b>Login Utente</b><br /><br />
	<table cellpadding="1" bgcolor="#FFFFFF">
	<tr><td>Nickname</td><td><input type="text" name="uname" size="26" maxlength="25" /></td></tr>
	<tr><td>Password</td><td><input type="password" name="pass" size="21" maxlength="20" /></td></tr>
	<tr><td><input type="hidden" name="op" value="login" /></td>
	<td><input type="submit" value="Login" /></td></tr>
	</table></form>
	</td></tr>
	<tr><td>
	<form name="Register" action="user.php" method="post">
	<b>Nuovo Utente </b><br /><br />
	<table cellpadding="1" bgcolor="#FFFFFF" >
	<tr><td>Nickname </td><td><input type="text" name="uname" size="26" maxlength="25"></td></tr>
	<tr><td>E-Mail </td><td><input type="text" name="email" size="26" maxlength="60"></td></tr>
	<tr><td>E-Mail pubblica?</td><td><input type="radio" name="empp" value="0">No 
	<input type="radio" name="empp" value="1" checked>S&igrave;</td></tr>
	<input type=hidden name="op" value="new user">
	<tr><td></td><td><input type="submit" value="Registrati"></td></tr>
	</form>
	</table>
	</td></tr><tr><td>
	<font size="2">(La Password sar&agrave; inviata all'indirizzo email inserito.)<br />
	NOTA BENE: Se scegli di rendere pubblica l'e-mail, il tuo indirizzo sar&agrave; visibile solamente
	agli altri utenti e solo nel caso vogliano mandarti un messaggio per fare scambi di carte.
	In NESSUN altro caso.<br /><br />
	Attenzione: le impostazioni utente sono basate sui cookie.
	Quindi, se si accede a queste pagine da un computer pubblico, &egrave; consigliabile
	effettuare il logout dopo aver finito.
	Se invece si utilizza sempre lo stesso computer, si pu&ograve; scegliere di effettuare il logout, evitando di reinserire
	ogni volta nickname e password.<br />
	<br />Come utente registrato potrai:<br />
	<li>Creare e modificare mazzi</li>
	<li>Inserire la tua mancolista e le tue doppie</li>
	<br /><br />Registrati ora!<br />
	Le tue informazioni saranno usate solo per questo sito<br />
	Non riceverai nessuna e-mail, se non quelle necessarie per
	l'amministrazione della tua utenza.
	</td></tr><tr><td>
	<b>Hai dimenticato la tua Password?</b><br /><br />
	Purtroppo non &egrave; pi&ugrave; possibile recuperare gli account. Mi dispiace.
<?php /*	Nessun problema. Inserisci il tuo Nickname e premi invia<br />
	Informazioni per conferma<br />
  	Riceverai un codice di conferma che dovrai poi inserire qui insieme al tuo Nickname<br />
	<form action="user.php" method="post">
	Nickname: <input type="text" name="uname" size=26 maxlength=25>&nbsp;&nbsp;
	Codice di conferma: <input type="text" name="code" size=5 maxlength=6><br />
	<input type="hidden" name="op" value="mailpasswd">
	<input type="submit" value="Invia">
	</td></tr></table></td></tr></table></form>
	Basta <a href="/2e/send.php?to=garak">scrivere a Garak</a>, utilizzando l'e-mail con cui ti sei
	iscritto e comunicando il tuo nickname.
	<br />Ti verr&agrave; riassegnata la password iniziale, che potrai poi
	modificare nuovamente dopo essere rientrato.
*/ ?>
<?php
		CloseTable();
		include "footer.php";
	} elseif (isset($user)) {
		global $cookie;
		cookiedecode($user);
		dbconnect();
		userinfo($cookie[1]);
	}
}


function logout()
{
	setcookie("user");
	include "header.php";
	OpenTable();
	echo "<center><font size=\"4\">Ora sei uscito<br />La prossima volta che tornerai,
	dovrai effettuare nuovamente il <a href=\"user.php\">login</a>.<br />Arrivederci da Garak!</font></center>";
	CloseTable();
	include "footer.php";
}


function mail_password($uname, $code)
{
	$result = mysqli_query($link, "select email, pass from users where (uname='$uname')");
	if (!$result) {
		echo "<center>Spiacente, le informazioni inserite non hanno avuto riscontro</center>";
	} else {
		$host_name = getenv("REMOTE_ADDR");
		list($email, $pass) = mysqli_fetch_row($result);

		$areyou = substr($pass, 0, 5);
		if ($areyou==$code) {
		
		$newpass=makepass();
		$message = "L' utente '$uname' di Garak's STCCG DB ha questa email associata. Un utente da $host_name ha richiesto l' invio della password\n\nLa tua nuova password &egrave;: $newpass\n\n Puoi cambiarla dopo aver effettuato il login su http://www.garak.it/1e\n\n Se non hai richiesto la password, non preoccuparti. Se c' &egrave; stato un errore, devi solo fare login con la tua nuova password";
		$subject="Password per $uname";
		mail($email, $subject, $message, "From: garak@tiscalinet.it\nX-Mailer: PHP/" . phpversion());

	// aggiunta nuova password al database
	
		$cryptpass = crypt($newpass);
		$query="update users set pass='$cryptpass' where uname='$uname'";
		if (!mysqli_query($link, $query)) {
			echo "mail_password: impossibile aggiornare info. Contatta Garak per avere aiuto.";
		}
	
		$titlebar = "Password inviata";
		include ("header.php");
		echo "<center>Password per $uname inviata";
		include ("footer.php");

	// se niente Code, lo invia

		} else {

    		$result = mysqli_query($link, "select email, pass from users where (uname='$uname')");
		if (!$result) {
		    echo "<center>Spiacente, non sono state trovate info corrispondenti all' utente</center>";
		} else {
		    $host_name = getenv("REMOTE_ADDR");
		    list($email, $pass) = mysqli_fetch_row($result);
		    $areyou = substr($pass, 0, 5);

		$message = "L' utente '$uname' ha questa e-mail associata. Qualcuno con indirizzo $host_name ha appena richiesto un Codice di Conferma per cambiare la password.\n\n Il tuo Codice di Conferma &egrave;: $areyou \n\n Con questo codice puoi assegnare una nuova password su http://www.stccg.f2s.com/user.php\n Se non hai richiesto il codice, non preoccuparti. Puoi tranquillamente cancellare questo messaggio.";
		$subject="Codice di conferma per $uname";
		mail($email, $subject, $message, "From: garak@tiscalinet.it\nX-Mailer: PHP/" . phpversion());

		include ("header.php");
		echo "<center>Codice di conferma per $uname inviato";
		include ("footer.php");
    	    }		
	}
    }
}

function docookie($setuid, $setuname, $setpass, $setumode, $setuorder, $setthold)
{
	$info = base64_encode("$setuid:$setuname:$setpass:$setumode:$setuorder:$setthold");
#	setcookie("user","$info",time()+15552000);
	setcookie('user', "$info");		// MODIFICATO cookie scade a fine sessione!
}

function login($uname, $pass)
{
	global $setinfo;
	dbconnect();
	$result = mysqli_query($link, "select pass, uid, umode, uorder from users where uname='$uname'");
	if (mysqli_num_rows($result) == 1) {
		$setinfo = mysqli_fetch_array($result);
		$dbpass = $setinfo[pass];
		$pass = crypt($pass,substr($dbpass,0,12));
	#	$pass = crypt($pass);
		if (strcmp($dbpass, $pass)) {
                        Header("Location: user.php?stop=1");
                        return;
                }
		docookie($setinfo[uid], $uname, $pass, $setinfo[umode], $setinfo[uorder], $setinfo[thold]);
		// NEW: logging degli utenti che effettuano il login
		mysqli_query($link, "INSERT INTO log VALUES(NULL,".$setinfo['uid'].",'".date('Y-m-d H:i:s')."','".$_SERVER['REMOTE_ADDR']."')");
		Header("Location: user.php?op=userinfo&bypass=1&uname=$uname");
	} else {
		Header("Location: user.php?stop=1");
	}
}

function infoCheck($uid, $email)
{
	global $stop;
	if ((!$email) || ($email == "") || (!ereg("[@]", $email)) || (!ereg("[.]", $email)) || (strlen($email) < 7) || (ereg("[^a-zA-Z0-9@.]", $email))) $stop = "e-mail non valida<br />";
	dbconnect();
	list($test) = mysqli_fetch_row(mysqli_query($link, "select email from users where (email='$email' and uid!=$uid)"));
	if ("$test" == "$email") $stop = "<center>ERRORE: Email gi&agrave; registrata</center><br />";
	return $stop;
}

function edituser()
{
	global $user, $userinfo, $cookie;
	include "header.php";
	getusrinfo($user);
	OpenTable();
?>
	<form name="Register" action="user.php" method="post">
	<b>Vero Nome</b> (Opzionale)<br />
	<input type="text" name="name" value="<?php echo $userinfo["name"] ?>" size="30" maxlength="60" /><br />
	<b>Email</b> (Obbligatoria)<br />
	<input type="text" name="email" value="<?php echo $userinfo["email"] ?>" size="30" maxlength="60" /><br />
	<br /><br />E-Mail <input type="radio" name="empp" value="0"<?php if (!$userinfo[uorder]) echo " checked"; ?> />Privata 
	<input type="radio" name="empp" value="1"<?php if ($userinfo[uorder]) echo " checked" ?> />Pubblica
	<br />Nota: Il tuo indirizzo sar&agrave; visibile solamente agli altri utenti e solo nel caso
	vogliano mandarti un messaggio per fare scambi di carte.<br />In NESSUN altro caso.
	<br /><br />
	<b>Nuova Password</b> (inserisci due volte una nuova password per cambiarla)<br />
	<input type="password" name="pass" size="10" maxlength="20" />
	<input type="password" name="vpass" size="10" maxlength="20" />
	<br /><br />
	<input type="hidden" name="uname" value="<?php echo "$userinfo[uname]"; ?>" />
	<input type="hidden" name="uid" value="<?php echo "$userinfo[uid]"; ?>" />
	<input type="hidden" name="op" value="saveuser" />
	<input type="submit" value="Salva" />
	</form>
<?php
	CloseTable();
	echo "<br /><br />";
	include "footer.php";
}


function saveuser($uid, $name, $uname, $email, $pass, $vpass, $empp)
{
	global $user, $cookie, $userinfo, $EditedMessage;
	cookiedecode($user);
	$check = $cookie[1];
	$result = mysqli_query($link, "select uid from users where uname='$check'");
	list($vuid) = mysqli_fetch_row($result);
	if (($check == $uname) AND ($uid == $vuid)) {
	if ((isset($pass)) && ("$pass" != "$vpass")) {
		echo "<center>Le password non coincidono. Devono essere identiche.</center>";
	} elseif (($pass != "") && (strlen($pass) < $minpass)) {
		echo "<center>La password deve essere almeno di 5 caratteri</center>";
	} else {
		if ($pass != "") {
			dbconnect();
			cookiedecode($user);
			mysqli_query($link, "LOCK TABLES users WRITE");
			$pass = crypt($pass);
			mysqli_query($link, "update users set name='$name', email='$email', pass='$pass', uorder='$empp' where uid='$uid'");
			$result = mysqli_query($link, "select uid, uname, pass, umode, uorder, thold from users where uname='$uname' and pass='$pass'");
			if (mysqli_num_rows($result) == 1) {
				$userinfo = mysqli_fetch_array($result);
				docookie($userinfo[uid],$userinfo[uname],$userinfo[pass],$userinfo[umode],$userinfo[uorder],$userinfo[thold]);
			} else {
				echo "<center>Qualcosa non ha funzionato...non &egrave; odioso?</center><br />";
			}
			mysqli_query($link, "UNLOCK TABLES");
		} else {
			dbconnect();
			mysqli_query($link, "update users set name='$name', email='$email', uorder='$empp' where uid='$uid'");
		}
		Header("Location: user.php?"); // question is wierd bugfix
	}
    }
}

?>
