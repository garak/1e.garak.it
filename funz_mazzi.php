<?php

function attiva ($mid) 		///////// cambia lo status del mazzo //////////
{
	global $user, $cookie;
	cookiedecode($user);
	$utente = $cookie[1];
	controllo($utente,$mid);
	$query = "UPDATE mazzi SET attivo=0 WHERE attivo=1 AND user='$utente'";
	$result = mysqli_query($query);
	$query = "UPDATE mazzi SET attivo=1 WHERE idmazzo=$mid";
	$result = mysqli_query($query);
}

function cancmazzo ($mid) 	///////// elimina un mazzo //////////
{
	global $user, $cookie;
	cookiedecode($user);
	$utente = $cookie[1];
	controllo($utente,$mid);
	$query = "DELETE FROM mazzo WHERE idmazzo=$mid";
	$result = mysqli_query($query);
	$query = "DELETE FROM mazzi WHERE idmazzo=$mid";
	$result = mysqli_query($query);
}

function crea ($nomemazzo) 	//////// crea un mazzo /////////
{
	global $user, $cookie;
	cookiedecode($user);
	$utente = $cookie[1];
	$query = "insert into mazzi (user, nomemazzo, attivo) values ('$utente','$nomemazzo',0)";
	$result = mysqli_query($query);
}

function mazzi ($user) 		/////// elenca i mazzi di un utente ////////
{
	global $user, $cookie;
	cookiedecode($user);
	$utente = $cookie[1];
	$idut = $cookie[0];
	OpenTable2();
	OpenTable();
	echo "<table><tr><td><b>Mazzi</b>\n<p>\n";
	$query = "SELECT * FROM mazzi WHERE user='".addslashes($utente)."'";
	$result = mysqli_query($query);
	if ($result<1) echo "Nessun mazzo creato";
	else {
	#	echo "<script type=\"text/javascript\">function conferma(mex,url) {if(confirm(mex)) {window.document.location=url}}</script>\n";
		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td><strong><big>·</big></strong> <a href=\"user.php?op=vedi&amp;mid=".$r["idmazzo"]."\" title=\"Vedi mazzo\">".$r["nomemazzo"]."</a></td><td>";
			if ($r["attivo"]) echo "(attivo)";
			else echo "(non attivo) <a href=\"user.php?op=attiva&amp;mid=".$r["idmazzo"]."\" title=\"Attiva mazzo\"><i>attiva</i></a>";
		#	echo "&nbsp; <a href=\"user.php\" title=\"Elimina mazzo\" onclick=\"conferma('Sicuro di voler cancellare questo mazzo?','user.php?op=delete&mid=".$r["idmazzo"]."')\">Elimina</a>";
			echo "&nbsp; <a href=\"user.php?op=delete&amp;mid=".$r["idmazzo"]."\" title=\"Elimina mazzo\" onClick=\"return confirm('Sicuro di voler cancellare questo mazzo?')\">Elimina</a>";
			echo "</td></tr>\n";
		}
		mysqli_free_result($result);
	}
	echo "<tr><td colspan=\"2\">";
	?>
	<script type="text/javascript">
	function apri(cosa)
	{
	 window.open (cosa,"Scambi","toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=no,copyhistory=no,width=450,height=400")
	}   
	</script>
	<?php
	echo "<br /><form action=\"user.php\" method=\"get\">";
	echo "Crea un nuovo mazzo:<br />\n";
	echo "<br />Nome mazzo <input name=\"nomemazzo\" type=\"text\" />\n";
	echo "<br /><input type=\"hidden\" name=\"utente\" value=\"".$utente."\" />\n";
	echo "<br /><input type=\"submit\" name=\"op\" value=\"crea\" />\n";
	echo "</form></td></tr>\n</table>\n";
	echo "<td valign=\"top\">\n<table>";                    ///////////// visualizza scambi /////////////
	echo "<tr><td><b>Scambi</b> <a href=\"user.php?op=vedidm\">Controlla le tue doppie e mancanti</a></td></tr>\n";  
	echo "<tr valign=\"top\"><td><table>\n";
	echo "<tr><td valign=\"top\">Puoi avere:<br /></td></tr>";
	$query = "SELECT uname,m.carta,e.nome,SUBSTRING(d.carta,1,3) AS ediz,e.rar,d.note FROM manco m LEFT JOIN doppie d on m.carta=d.carta AND m.note=d.note LEFT JOIN users u on d.user=u.uid LEFT JOIN erti e ON d.carta=e.id WHERE m.user=".$idut." ORDER BY uname,e.nome";
	$result = mysqli_query($query);
	while ($r = mysqli_fetch_array($result)) {
		if ($r[nome]) {
			echo "<tr><td>".$r["nome"]."</td><td>(".$r["rar"].",".$r["note"].",".trim($r["ediz"]).") da ";
			echo "<a href=\"javascript:apri('send_scambi.php?dest=".$r["uname"]."&amp;mitt=".$utente."')\">".ucfirst($r["uname"])."</a></td></tr>\n";
		}
	}
	mysqli_free_result($result);

	echo "</table>\n</td><td valign=\"top\"><table>\n<tr><td>Puoi dare:<br /></td></tr>\n";
	$query = "SELECT uname,d.carta,e.nome,substring(d.carta,1,3) AS ediz,e.rar,d.note FROM doppie d LEFT JOIN manco m on d.carta=m.carta AND m.note=d.note LEFT JOIN users u ON m.user=u.uid LEFT JOIN erti e ON m.carta=e.id WHERE d.user=".$idut." ORDER BY uname,e.nome";
	$result = mysqli_query($query);
	while ($r = mysqli_fetch_array($result)) {
		if ($r[nome]) {
			echo "<tr><td>".$r["nome"]."</td><td>(".$r["rar"].",".$r["note"].",".trim($r["ediz"]).") a ";
			echo "<a href=\"javascript:apri('send_scambi.php?dest=".$r["uname"]."&amp;mitt=".$utente."')\">".ucfirst($r["uname"])."</a></td></tr>\n";
		}
	}
	mysqli_free_result($result);
	echo "<tr><td>";
	CloseTable();
}


/************************************
*   FUNZIONI RELATIVE ALLLE CARTE   *
*************************************/


function vedimazzi ($mid)          /////// visualizza mazzo e caratteristiche ////////
{
	global $user, $cookie, $ABIL;
	cookiedecode($user);
	$utente = $cookie[1];
	controllo($utente, $mid);
	$query = "SELECT * FROM mazzo m LEFT JOIN erti e ON m.id=e.id LEFT JOIN personale p ON m.id=p.id LEFT JOIN navi n ON m.id=n.id LEFT JOIN testo2 t ON p.id=t.id WHERE idmazzo=".$mid." ORDER BY gruppo,tipo,p.aff,n.aff,nome";
	$result = mysqli_query($query);
	$i = 0;
	while ($r = mysqli_fetch_array($result)) {
		$ar["un"][] = $r["un"];
		$ar["nome"][] = $r["nome"];
		$ar["aff"][] = $r["aff"];
		$ar["aff2"][] = $r["aff2"];
		$ar["rar"][] = $r["rar"];
		$ar["icone"][] = $r["icone"];
		$ar["id"][] = $r["id"];
		$ar["pid"][] = $r["pid"];
		$ar["tipo"][] = $r["tipo"];
		$ar["gruppo"][] = $r["gruppo"];

		switch ($ar["tipo"][$i]) {
			case "per":
			$arp["class"][$i] = $r["class"];
			$arp[$i]["testo"] = $r["testo"];
			$arp["testosp"][$i] = $r["testosp"];
			$arp["i"][$i] = $r["i"];
			$arp["c"][$i] = $r["c"];
			$arp["s"][$I] = $r["s"];
			break;
			case "nav":
			$arn["classe"][$i] = $r["classe"];
			$arn[$i]["testo"] = $r["testo"];
			$arn["testosp"][$i] = $r["testosp"];
			$arn["r"][$i] = $r["r"];
			$arn["w"][$i] = $r["w"];
			$arn["s"][$i] = $r["s"];
			break;
		}
		$i++;
	}
	mysqli_free_result($result);

	include "header.php";
	echo "</td></tr>\n<tr><td>";

	////////////////// output lista mazzo ////////////////////

	echo "<tr><td valign=\"top\">";
	echo "<form action=\"user.php\" method=\"post\">";
	echo "<img src=\"/img/pixel.gif\" width=\"275\" height=\"1\" alt=\"\" />";
	echo "<table width=\"95%\">\n<tr><td class=\"tit3\" colspan=\"4\">Carte</td></tr>\n";
	echo "<tr><td></td><td class=\"t\" width=\"100\"><b>Nome</b></td><td class=\"t\"><b>Rar</b></td><td class=\"t\"><b>Ediz</b></td></tr>\n";

	for ($k = 0; $k < $i; $k++) {
		if ($k == 0) {
			echo "<tr><td colspan=\"4\" class=\"a\" align=\"center\"><b>".trad($ar["gruppo"][$k])."</b></td></tr>\n";
			echo "<tr><td></td><td colspan=\"3\" class=\"a\" align=\"center\">".trad($ar["tipo"][$k])."</td></tr>\n";
		} elseif ($ar["gruppo"][$k]<>$ar["gruppo"][$k-1]) { ///se cambio gruppo///
			echo "<tr><td colspan=\"4\" class=\"a\" align=\"center\"><b>".trad($ar["gruppo"][$k])."</b></td></tr>\n";
			echo "<tr><td></td><td colspan=\"3\" class=\"a\" align=\"center\">".trad($ar["tipo"][$k])."</td></tr>\n";
		} elseif ($ar["tipo"][$k]<>$ar["tipo"][$k-1]) {   ///se cambio tipo/// 
			echo "<tr><td></td><td colspan=\"3\" class=\"a\" align=\"center\">".trad($ar["tipo"][$k])."</td></tr>\n";
		}

		echo "<tr><td><input type=\"checkbox\" name=\"per[]\" value=\"".$ar["pid"][$k]."\"></td>";
		if ($ar["tipo"][$k]=='per' || $ar["tipo"][$k]=='nav') echo "<td class=\"".strtolower($ar["aff"][$k])."\">";
		else echo "<td class=\"q\">";
		if ($ar["un"][$k]) echo "<font class=\"w\">".$ar["un"][$k]."</font> ";
		if ($ar["aff2"][$k]) echo "<span class=\"".$ar["aff2"][$k]."\">&nbsp; &nbsp;</span> ";
		echo $ar["nome"][$k]." &nbsp; </td><td class=\"a\">".$ar["rar"][$k]."</td><td class=\"a\">".substr($ar["id"][$k],0,3)."</td></tr>\n";
	}
	echo "</table>\n<br /><input type=\"hidden\" name=\"mid\" value=\"".$mid."\" />\n";
	echo "&nbsp; <input type=\"submit\" name=\"op\" value=\"cancella\" />";
	echo "&nbsp; <input type=\"submit\" name=\"op\" value=\"muovi\" />&nbsp; ";
	echo "<select name=\"gruppo\">";
	echo "<option value=\"2m\">in Seed Free</option>\n";
	echo "<option value=\"1s\">in Seed</option>\n";
	echo "<option value=\"7d\">in Draw</option>\n";
	echo "<option value=\"3q\">in Q's Tent</option>\n";
	echo "<option value=\"4f\">in Q-Flash</option>\n";
	echo "</select>\n</form>\n";
	echo "&nbsp; &nbsp; [ <a href=\"user.php\"><img src=\"/img/left.gif\" alt=\"Torna al gestore di mazzi\" title=\"Torna al gestore di mazzi\" /></a>";
	echo " | <a href=\"print.php?mid=".$mid."\"><img src=\"/img/print.gif\" alt=\"Versione Stampabile\" title=\"Versione Stampabile\" /></a>";
	echo " | <a href=\"text.php?mid=".$mid."\"><img src=\"/img/txt.gif\" align=\"middle\" alt=\"Lista in .txt\" title=\"Lista in .txt\" /></a> ]</td>";

	include "mazzo.php";
	include "footer.php";
	echo "</body>\n</html>";
}

function cancella ($mid,$per)          /////// cancella carte dal mazzo //////
{
	global $user,$cookie;
	cookiedecode($user);
	$utente = $cookie[1];
	controllo($utente,$mid);
	$query = "DELETE FROM mazzo WHERE idmazzo=$mid AND pid=$per";
	$result = mysqli_query($query);
}

function sposta ($mid,$per,$gruppo)     /////// sposta carte tra i gruppi /////
{
	global $user,$cookie;
	cookiedecode($user);
	$utente = $cookie[1];
	controllo($utente,$mid);
	$query = "UPDATE mazzo SET gruppo='$gruppo' WHERE idmazzo=$mid AND pid=$per";
	$result = mysqli_query($query);
}

function inserisci ($per,$gruppo)      ////// inserisce carte nel mazzo /////////
{
	global $user,$cookie,$mid;
	cookiedecode($user);
	$utente = $cookie[1];
	$query = "SELECT idmazzo FROM mazzi WHERE user='$utente' AND attivo=1";
	$result = mysqli_query($query);
	$r = mysqli_fetch_array($result);
	$mid = $r["idmazzo"];
	mysqli_free_result($result);
	$query = "INSERT INTO mazzo (idmazzo,id,gruppo) VALUES ($mid,'$per','$gruppo')";
	$result = mysqli_query($query);
	return($mid);
}


function controllo ($utente,$mid)    ///// per evitare che un utente usi mazzi altrui /////
{
	$query = "SELECT idmazzo,user FROM mazzi WHERE user='".$utente."' AND idmazzo='".$mid."'";
	$result = mysqli_query($query);
	if (mysqli_num_rows($result)<1 && $utente!="garak") die("Accesso non autorizzato");
	mysqli_free_result($result);
}

function inseriscidm ($per,$tipo)
{
	global $user,$cookie;
	cookiedecode($user);
	$uid = $cookie[0];
	$query = "INSERT INTO ".$tipo." (user,carta,note) VALUES (".$uid.",'".$per."','n')";
	$result = mysqli_query($query);
}

function cancdm ($per,$tipo)      ///// cancella doppie o manco (in base a $tipo) /////
{
	global $user,$cookie;
	cookiedecode($user);
	$uid = $cookie[0];
	$query = "DELETE FROM ".$tipo." WHERE user=".$uid." AND carta='".$per."' LIMIT 1";
	$result = mysqli_query($query);
}


function cambia ($per,$tipo,$note)    ////// cambia tipo (b,n,f,*) a doppie o mancanti
{
	global $user,$cookie;
	cookiedecode($user);
	$uid = $cookie[0];
	$query = "UPDATE ".$tipo." SET note='".$note."' WHERE user=".$uid." AND carta='".$per."' LIMIT 1";
	$result = mysqli_query($query);
}


function vedidm ($user)          /////// visualizza mazzo e caratteristiche ////////
{
	global $user, $cookie;
	cookiedecode($user);
	$uid = $cookie[0];
	include "header.php";
	OpenTable();
	echo "</td></tr>\n";
	echo "<tr><td valign=\"top\"><b>DOPPIE</b><br />\n";
	echo "<form action=\"user.php\" name=\"doppie\" method=\"post\">\n";
	echo "<table>\n";
	echo "<tr><td></td><td colspan=\"4\"><img src=\"/img/pixel.gif\" width=\"100\" height=\"1\" alt=\"\" /></td></tr>\n";
	echo "<tr><td></td><td><b>Carta</b></td><td><b>Rar&nbsp;</b></td><td><b>Ediz&nbsp;</b></td><td><b>Note</b></td></tr>\n";
	$query = "SELECT id,substring(id,1,3) AS ediz,nome,rar,note FROM doppie d LEFT JOIN erti e ON d.carta=e.id WHERE user=$uid ORDER BY ediz,id";
	$result = mysqli_query($query);
	while ($r = mysqli_fetch_array($result)) {
		echo "<tr class=\"t\"><td width=\"10\"><input type=\"checkbox\" name=\"per[]\" value=\"".$r["id"]."\" /></td>";
		echo "<td>".$r["nome"]."</td><td>".$r["rar"]."</td>";
		echo "<td>".$r["ediz"]."</td><td>".$r["note"]."</td>\n</tr>\n";
	}
	echo "</table>\n";
	echo "<input type=\"hidden\" name=\"tipo\" value=\"doppie\" />\n";
	echo "<input type=\"submit\" name=\"op\" value=\"elimina\" />\n";
	echo "<input type=\"submit\" name=\"op\" value=\"cambia\" /> in ";
	echo "<select name=\"note\">\n";
	echo "<option value=\"n\">n</option>\n";
	echo "<option value=\"b\">b</option>\n";
	echo "<option value=\"f\">f</option>\n";
	echo "<option value=\"*\">*</option>\n";
	echo "</select>\n</form>\n</td>\n";

	mysqli_free_result($result);

	echo "<td valign=\"top\"><b>MANCANTI</b><br />\n";
	echo "<form action=\"user.php\" name=\"doppie\" method=\"post\">\n";
	echo "<table>\n";
	echo "<tr><td></td><td colspan=\"4\"><img src=\"/img/pixel.gif\" width=\"100\" height=\"1\" alt=\"\" /></td></tr>\n";
	echo "<tr><td></td><td><b>Carta</b></td><td><b>Rar&nbsp;</b></td><td><b>Ediz&nbsp;</b></td><td><b>Note</b></td></tr>\n";
	$query = "SELECT id,substring(id,1,3) AS ediz,nome,rar,note FROM manco d LEFT JOIN erti e ON d.carta=e.id WHERE user=$uid ORDER BY ediz,id";
	$result = mysqli_query($query);
	while ($r = mysqli_fetch_array($result)) {
		echo "<tr class=\"t\"><td width=\"10\"><input type=\"checkbox\" name=\"per[]\" value=\"".$r["id"]."\" /></td>";
		echo "<td>".$r["nome"]."</td><td>".$r["rar"]."</td>";
		echo "<td>".$r["ediz"]."</td><td>".$r["note"]."</td>\n</tr>\n";
	}
	echo "</table>\n";
	echo "<input type=\"hidden\" name=\"tipo\" value=\"manco\" />\n";
	echo "<input type=\"submit\" name=\"op\" value=\"elimina\" />\n";
	echo "<input type=\"submit\" name=\"op\" value=\"cambia\" /> in ";
	echo "<select name=\"note\">\n";
	echo "<option value=\"n\">n</option>\n";
	echo "<option value=\"b\">b</option>\n";
	echo "<option value=\"f\">f</option>\n";
	echo "<option value=\"*\">*</option>\n";
	echo "</select>\n</form></td>\n";

	mysqli_free_result($result);

	echo "<td valign=\"top\" width=\"350\"><b>LEGENDA</b><br />";
	echo "<br />n = Carta a bordo nero";
	echo "<br />b = Carta a bordo bianco";
	echo "<br />f = Carta foil";
	echo "<br />* = Carta con colore alternativo\n";
	echo "<br /><br /><br /><b>ATTENZIONE</b>:";
	echo "<br />&Egrave; importante inserire correttamente il tipo di carta, ";
	echo "secondo la legenda riportata qui sopra. ";
	echo "Infatti la corrispondenza tra la carta mancante di un utente ";
	echo "e quella doppia di un altro &egrave; possibile solo se corrispondono ";
	echo "sia il nome, che l'espansione, che appunto il tipo. ";
	echo "Poich&eacute; il sistema inserisce per default una carta ";
	echo "con il bordo nero, bisogna effettuare a mano ";
	echo "l'eventuale modifica. ";
	# echo "Per inserire in una stessa lista la stessa carta a bordo nero (n) ed in ";
	# echo "versione alternativa (*), occorre inserirla una prima volta, cambiare ";
	# echo "n in * e poi inserirla nuovamente. ";
	# echo "Questo ordine &egrave; importante, perch&eacute; se si inserisce la carta ";
	# echo "due volte non c' &egrave; modo di effettuare la modifica su una sola. ";
	# echo "Per lo stesso motivo non si deve inserire due volte la stessa carta nella ";
	# echo "lista delle doppie, anche disponendone di pi&ugrave; di una copia: ";
	# echo "Se infatti successivamente si volesse cancellare una sola di queste carte, ";
	# echo "verrebbe cancellata anche l' altra. ";
	echo "<br /><br />&Egrave; molto importante eliminare al pi&ugrave; presto ";
	echo "<br />ogni carta che non sia ha pi&ugrave; doppia o mancante, in modo da ";
	echo "<br />mantenere efficiente il sistema.";
	CloseTable();
	include "footer.php";
	echo "</body>\n</html>";
}

?>
