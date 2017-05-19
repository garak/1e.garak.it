<?php

include_once "mainfile.php";

function tabella($tipo)
{
	global $db,$clausola, $cediz, $crar, $ctrl, $notipo, $txtjoin, $txt2join, $ctext, $ctextn, $ctexta, $q;

	/**** scelta della query da eseguire, in base al tipo *****/

	$order = "order by e.nome";
	if (in_array($tipo, ['dilemmi', 'siti'])) $query = "SELECT * FROM ".$tipo." a LEFT JOIN erti e ON a.id=e.id ".$txtjoin." ".$clausola." ORDER BY nome";
	elseif (in_array($tipo, ['installazioni', 'navi', 'personale'])) $query = "SELECT * FROM ".$tipo." a LEFT JOIN erti e ON a.id=e.id ".$txt2join." ".$clausola." ORDER BY aff,nome";
	elseif (in_array($tipo, ['missioni', 'tattiche'])) $query = "SELECT * FROM ".$tipo." a LEFT JOIN erti e ON a.id=e.id ".$txt2join." ".$clausola." ORDER BY nome";
	else $query = "SELECT * FROM erti a ".$txtjoin." ".$clausola." AND tipo='".$tipo."' ORDER BY nome";

	if ($q) echo $query;
	$result = @mysqli_query($query);

	if (strlen($tipo)>3) $tipo = substr($tipo,0,3);
	if ($tipo=='ins') $tipo = 'fac';
	if ($tipo=='tat') $tipo = 'tac';

	if (@mysqli_num_rows($result)) {         //// procede solo se tabella non vuota ////
	if ($notipo) {                      //// stampa titolo solo se tipo non scelto ////
		echo "<br />&nbsp; &nbsp;<b>".strtoupper(trad($tipo))."</b><br /><br />\n";
	}

	/************ output tabella/e **************/

	$fname = $tipo == "int"	? "inr" : $tipo;	// modifica per la funzione js (int e` un nome riservato!)
	echo "<form method=\"post\" action=\"user.php\" name=\"".$fname."\" target=\"MAZZO\">\n";
	echo "<table width=\"100%\">\n";
	echo "<tr class=\"tit2\"><td width=\"10\"><input type=\"checkbox\" name=\"CheckAll\" onClick=\"ToggleCheck".$fname."()\" /></td>";

	switch ($tipo) {      ////// scelta delle colonne della tabella, in base al tipo /////

	case 'dil':

		echo "<td>Nome</td>".$crar."<td>Tipo</td><td>Icone</td>".$ctexta." ".$cediz."</tr>";

		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td class=\"t\" width=\"10\"><";
			cbox($r["id"]);
			echo "value=\"".$r["id"]."\" />";
			echo "</td><td class=\"a\">".$r["nome"]."</td>";
			if (substr($ctrl, 2, 2) == "r0") echo "<td class=\"a\">".$r["rar"]."</td>";
			echo "<td class=\"a\">".$r["tipod"]."</td><td class=\"a\">".$r["icone"]."</td>";
			if ($txtjoin) echo "<td class=\"a\" width=\"60%\">".$r["testo"]."</td>";
			if (substr($ctrl, 0, 2) == "e0") echo "<td class=\"a\">".substr($r["id"], 0, 3)."</td>";
			echo "</tr>\n";
		}
		echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"1s\" /></td></tr>\n";
		break;

	case 'fac':

		echo "<td>Nome</td>".$crar."<td>icone</td>".$ctexta."<td>Armi</td>";
		echo "<td>Scudi</td>".$cediz."</tr>\n";

		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td class=\"t\" width=\"10\"><";
			cbox($r["id"]);
			echo "value=\"".$r["id"]."\" />";
			echo "</td><td class=\"".strtolower($r["aff"])."\">";
			if ($r["un"]) echo "<font class=\"w\">".$r["un"]."</font> ";
			echo $r["nome"]."</td>";
			if (substr($ctrl, 2, 2) == "r0") echo "<td class=\"a\">".$r["rar"]."</td>";
			echo "<td class=\"a\">".$r["icone"]."</td>";
			if ($txtjoin) echo "<td class=\"a\" width=50%>".$r["testo"]." ".simboli($r["testosp"])."</td>";
			echo "<td class=\"a\">".$r["armi"]."</td><td class=\"a\">".$r["scudi"]."</td>";
			if (substr($ctrl, 0, 2) == "e0") echo "<td class=\"a\">".substr($r["id"], 0, 3)."</td>";
			echo "</tr>\n";
		}
		echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"1s\" /></td></tr>\n";
		break;

	case 'sit':

		echo "<td>Nome</td>".$crar."<td>Nor</td><td>Livello</td>".$ctexta." ".$cediz."</tr>\n";

		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td class=\"t\" width=\"10\"><";
			cbox($r["id"]);
			echo "value=\"".$r["id"]."\" />";
			echo "</td><td class=\"a\">"; 
			if ($r["un"]) echo "<font class=\"w\">".$r["un"]."</font> ";
			echo $r["nome"]."</td>";
			if (substr($ctrl, 2, 2) == "r0") echo "<td class=\"a\">".$r["rar"]."</td>";
			echo "<td class=\"a\">".$r["nor"]."</td><td class=\"a\">".$r["loc"]."</td>";
			if ($txtjoin) echo "<td class=\"a\" width=\"55%\">".$r["testo"]."</td>";
			if (substr($ctrl, 0, 2) == "e0") echo "<td class=\"a\">".substr($r["id"], 0, 3)."</td>";
			echo "</tr>\n";
		}
		echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"2m\" /></td></tr>\n";
		break;

	case 'tac':

		echo "<td>Nome</td>".$crar."<td width=\"10\">Ico</td><td width=\"15\">a</td>";
		echo "<td width=\"15\">D</td><td>Bonus</td><td width=\"15\">R</td>";
		echo "<td width=\"15\">W</td><td width=\"15\">S</td><td>Hull</td>".$ctexta." ".$cediz."</tr>\n";

		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td class=\"t\" width=\"10\"><";
			cbox($r["id"]);
			echo "VALUE=\"".$r["id"]."\" />";
			echo "</TD><TD CLASS=\"a\">".$r["nome"]."</td>";
			if (substr($ctrl, 2, 2) == "r0") echo "<td class=\"a\">".$r["rar"]."</td>";
			echo "<td class=\"a\" width=\"10\">".$r["icone"]."</td><td class=\"a\">".$r["a"]."</td><td class=\"a\">".$r["d"]."</td>";
			echo "<td class=\"a\" width=\"30%\">".$r["bonus"]."</td><td class=\"a\">".$r["r"]."</td><td class=\"a\">".$r["w"]."</td>";
			echo "<td class=\"a\">".$r["s"]."</td><td class=\"a\">".$r["hull"]."</td>";
			if ($txtjoin) echo "<td class=\"a\" width=\"22%\">".$r["testo"].$r["testosp"]."</td>";
			if (substr($ctrl, 0, 2) == "e0") echo "<td class=\"a\">".substr($r["id"], 0, 3)."</td>";
			echo "</tr>\n";
		}
		echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"5b\" /></td></tr>\n";
		break;

	case 'per':

		echo "<td>Nome</td>".$crar."<td>Cl</td><td align=\"center\" width=\"15\">I</td>";
		echo "<td align=\"center\" width=\"15\">C</td><td align=\"center\" width=\"15\">S</td>".$ctext;
		echo "<td>Icone</td>".$cediz."</tr>\n";

		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td class=\"t\" width=\"10\"><";
			cbox($r['id']);
			echo "value=\"".$r['id']."\" /></td>";
			echo "<td class=\"".strtolower($r['aff'])."\">";
			if ($r['un']) echo "<font class=\"w\">".$r['un']."</font> ";
			if ($r['aff2']) echo "<span class=\"".strtolower($r['aff2'])."\">&nbsp; &nbsp;</span> ";
			if ($r['id'] == "TwT048") echo "<span class=\"f\">&nbsp; &nbsp;</span> ";
			if ($r['id'] == "FJ 016") echo "<span class=\"n\">&nbsp; &nbsp;</span> ";
			echo $r['nome']."</td>";
			if (substr($ctrl, 2, 2) == "r0") echo "<td class=\"a\">".$r['rar']."</td>";
			echo "<td class=\"a\">".$r["class"]."</td><td class=\"i\">".$r['i']."</td><td class=\"u\" width=\"15\">".$r['c']."</td>";
			echo "<td class=\"s\" width=\"15\">".$r['s']."</td>";
			if ($txtjoin) echo "<td class=\"a\" width=\"55%\">".$r['testo']." ".simboli($r['testosp'])."</td>";
			echo "<td class=\"a\">".$r['icone']."</td>";
			if (substr($ctrl, 0, 2) == "e0") echo "<td class=\"a\">".substr($r['id'], 0, 3)."</td>";
			echo "</tr>\n";
		}
		echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"7d\" /></td></tr>\n";
		break;

	case 'nav':

		echo "<td>Nome</td>".$crar."<td>Classe</td>".$ctextn."<td align=\"center\" width=\"15\">R</td>";
		echo "<td align=\"center\" width=\"15\">W</td><td align=\"center\" width=\"15\">S</td><td>Staff</td>";
		echo "<td>Icone</td>".$cediz."</tr>\n";

		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td class=\"t\" width=\"10\"><";
			cbox($r['id']);
			echo "value=\"".$r['id']."\" /></td>";
			echo "<td class=\"".strtolower($r['aff'])."\">";
			if ($r['un']) echo "<font class=\"w\">".$r['un']."</font> ";
			if ($r['aff2']) echo "<span class=\"".strtolower($r['aff2'])."\">&nbsp; &nbsp;</span> ";
			echo $r['nome']."</td>";
			if (substr($ctrl, 2, 2) == "r0") echo "<td class=\"a\">".$r['rar']."</td>";
			echo "<td class=\"a\">".$r['classe']."</td>";
			if ($txtjoin) echo "<td class=\"a\" width=\"40%\">".$r['testo']." ".simboli($r['testosp'])."</td>";
			echo "<td class=\"".strtolower($r['aff'])."\" align=\"center\">".$r['r']."</td>";
			echo "<td class=\"".strtolower($r['aff'])."\" align=\"center\">".$r['w']."</td>";
			echo "<td class=\"".strtolower($r['aff'])."\" align=\"center\">".$r['s']."</td>";
			echo "<td class=\"a\">".$r['staff']."</td><td class=\"a\">".$r['icone']."</td>";
			if (substr($ctrl, 0, 2) == "e0") echo "<td class=\"a\">".substr($r['id'], 0, 3)."</td>";
			echo "</tr>\n";
		}
		echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"7d\" /></td></tr>\n";
		break;

	case 'mis':

		echo "<td>Nome</td>".$crar."<td>Tipo</td><td>Aff</td>".$ctexta;
		echo "<td>Pt</td><td>Dist</td><td>Icone</td>".$cediz."</tr>\n";

		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td class=\"t\" width=\"10\"><";
			cbox($r['id']);
			echo "value=\"".$r['id']."\" /></td>";
			echo "<td class=\"a\">";
			if ($r['un']) echo "<font class=\"w\">".$r['un']."</font> ";
			echo $r['nome']."</td>";
			if (substr($ctrl, 2, 2) == "r0") echo "<td class=\"a\">".$r['rar']."</td>";
			echo "<td class=\"a\">".$r['tipom']."</td><td class=\"a\">".$r['aff']."</td>";
			if ($txtjoin) echo "<td class=\"a\" width=\"55%\">".$r['testo']." ".$r['testosp']."</td>";
			echo "<td class=\"a\">".$r['punti']."</td><td class=\"a\" align=\"center\">".$r['span']."</td><td class=\"a\">".$r['icone']."</td>";
			if (substr($ctrl, 0, 2) == "e0") echo "<td class=\"a\">".substr($r['id'], 0, 3)."</td>";
			echo "</tr>\n";
		}
		echo "<tr><td><input type=\"hidden\" name=\"gruppo\" value=\"2m\" /></td></tr>\n";
		break;

	default:

		echo "<td>Nome</td>".$crar."<td>Icone</td>".$ctexta." ".$cediz."</tr>\n";

		while ($r = mysqli_fetch_array($result)) {
			echo "<tr><td class=\"t\" width=\"10\"><";
			cbox($r["id"]);
			echo "value=\"".$r["id"]."\" /></td>";
			echo "<td class=\"a\">".$r["nome"]."</td>";
			if (substr($ctrl, 2, 2) == "r0") echo "<td class=\"a\">".$r["rar"]."</td>";
			echo "<td class=\"a\">".$r["icone"]."</td>";
			if ($txtjoin) echo "<td class=\"a\" width=\"60%\">".$r["testo"]."</td>";
			if (substr($ctrl, 0, 2) == "e0") echo "<td class=\"a\">".substr($r["id"], 0, 3)."</td>";
			echo "</tr>\n";
		}
		echo "<tr><td><input type=\"hidden\" name=\"gruppo\" ";
		if ($tipo == 'tri' || $tipo == 'tro')  echo "value=\"6t\" /></td></tr>\n";
		else echo "value=\"7d\" /></td></tr>\n";
		break;

	}   ///// fine switch /////

	echo "<tr><td></td><td colspan=\"2\" nowrap>";
	echo "<input type=\"submit\" value=\"Aggiungi a\" /> ";
	echo "<select name=\"op\">";
	echo "<option selected value=\"insert\">Mazzo</option>\n";
	echo "<option value=\"insd\">Doppie</option>\n";
	echo "<option value=\"insm\">Mancanti</option>\n";
	echo "</select></td></tr>\n</table>\n</form>\n";

	mysqli_free_result($result);
	}
}
