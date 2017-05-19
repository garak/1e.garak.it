<?php
include_once "mainfile.php";
echo "abil $ABIL";
print_r($ABIL);
//////////// conteggio skill //////////////

$civ = 0;$eng = 0;$med = 0;$off = 0;$sci = 0;$sec = 0;$vip = 0;$acq = 0;$ant = 0;$arc = 0;$ast = 0;$bio = 0;
$com = 0;$cyb = 0;$dip = 0;$emp = 0;$exo = 0;$geo = 0;$gre = 0;$kli = 0;$hon = 0;$lea = 0;$law = 0;$min = 0;
$mus = 0;$nav = 0;$obs = 0;$phy = 0;$res = 0;$sez = 0;$smu = 0;$stel = 0;$tal = 0;$tra = 0;$tre = 0;$you = 0;

for ($k = 0; $k < $i; $k++) {
	if ($ar["tipo"][$k] == "per") {
		$abi[$k] = explode(" ", $arp[$k]["testo"]);
		$size = sizeof($abi[$k]);
		for ($j = 0; $j < $size; $j++) {
			switch ($abi[$k][$j]) {
				case 'CIVILIAN': $sk["civ"]++ ; break;
				case 'ENGINEER': $eng++ ; break;
				case 'MEDICAL': $med++ ; break;
				case 'OFFICER': $off++ ; break;
   case 'SCIENCE': $sci++ ; break;
   case 'SECURITY': $sec++ ; break;
   case 'VIP': $vip++ ; break;
   case 'V.I.P.': $vip++ ; break;
   case 'Acquisition': $acq++ ; break;
   case 'Anthropology': $ant++ ; break;
   case 'Archaeology': $arc++ ; break;
   case 'Astrophysics': $ast++ ; break;
   case 'Biology': $bio++ ; break;
   case 'ComputerSkill': $com++ ; break;
   case 'Cybernetics': $cyb++ ; break;
   case 'Diplomacy': $dip++ ; break;
   case 'Empathy': $emp++ ; break;
   case 'Exobiology': $exo++ ; break;
   case 'FCA': $fca++ ; break;
   case 'Geology': $geo++ ; break;
   case 'Greed': $gre++ ; break;
   case 'Honor': $hon++ ; break;
   case 'KlingonIntelligence': $kli++ ; break;
   case 'Law': $law++ ; break;
   case 'Leadership': $lea++ ; break;
   case 'Mindmeld': $min++ ; break;
   case 'Music': $mus++ ; break;
   case 'Navigation': $nav++ ; break;
   case 'ObsidianOrder': $obs++ ; break;
   case 'Physics': $phy++ ; break;
   case 'Resistance': $res++ ; break;
   case 'Section31': $sez++ ; break;
   case 'Smuggling': $smu++ ; break;
   case 'StellarCartography': $stel++ ; break;
   case 'TalShiar': $tal++ ; break;
   case 'TransporterSkill': $tra++ ; break;
   case 'Treachery': $tre++ ; break;
				case 'Youth': $you++ ; break;
			}
		}
	}
}

for ($k = 0; $k < $i; $k++) {
	if ($ar["tipo"][$k] == "per") {
		switch ($arp["class"][$k]) {
			case 'C': $civ++; break;
			case 'E': $eng++ ; break;
			case 'M': $med++ ; break;
			case 'O': $off++ ; break;
			case 'S': $sci++ ; break;
			case 'Se': $sec++ ; break;
			case 'V': $vip++ ; break;
		}
	}
}

echo "<td valign=\"top\" align=\"center\">";
echo "<img src=\"/img/pixel.gif\" width=\"10\" height=\"1\" hspace=\"0\" alt=\"\" />\n";
echo "<table>\n<tr><td bgcolor=\"#dedebb\" colspan=\"5\"><b>Abilit&agrave; e Classificazioni</b></td></tr>\n";

foreach ($ABIL as $v) {
	echo "<tr><td>".$v."</td><td>&nbsp; ";
	echo $$v ? $$v  : "<em>0</em>";
	echo "</td></tr>\n";
}
/*
echo "<tr><td>Acquisition</td><td>"; if (!$acq) echo "<em>0</em></td>";
echo "<td>&nbsp;</td><td>CIVILIAN</td><td>"; if (!$civ) echo "<em>"; echo "&nbsp; $civ</em></td></tr>\n";
echo "<tr><td>Anthropology</td><td>"; if (!$ant) echo "<em>"; echo "$ant</em></td>";
echo "<td>&nbsp;</td><td>ENGINEER</td><td>"; if (!$eng) echo "<em>"; echo "&nbsp; $eng</em></td></tr>\n";
echo "<tr><td>Archaeology</td><td>"; if (!$arc) echo "<em>"; echo "$arc</td>";
echo "<td>&nbsp;</td><td>MEDICAL</td><td>"; if (!$med) echo "<em>"; echo "&nbsp; $med</td></tr>\n";
echo "<tr><td>Astrophysics</td><td>"; if (!$ast) echo "<em>"; echo "$ast</td>";
echo "<td>&nbsp;</td><td>OFFICER</td><td>"; if (!$off) echo "<em>"; echo "&nbsp; $off</td></tr>\n";
echo "<tr><td>Biology</td><td>"; if (!$bio) echo "<em>"; echo "$bio</td>";
echo "<td>&nbsp;</td><td>SCIENCE</td><td>"; if (!$sci) echo "<em>"; echo "&nbsp; $sci</td></tr>\n";
echo "<tr><td>Computer Skill</td><td>"; if (!$com) echo "<em>"; echo "$com</td>";
echo "<td>&nbsp;</td><td>SECURITY</td><td>"; if (!$sec) echo "<em>"; echo "&nbsp; $sec</td></tr>\n";
echo "<tr><td>Cybernetics</td><td>"; if (!$cyb) echo "<em>"; echo "$cyb</td>";
echo "<td>&nbsp;</td><td>VIP</td><td>"; if (!$vip) echo "<em>"; echo "&nbsp; $vip</td></tr>\n";
echo "<tr><td>Diplomacy</td><td>"; if (!$dip) echo "<em>"; echo "$dip</td></tr>\n";
echo "<tr><td>Exobiology</td><td>"; if (!$exo) echo "<em>"; echo "$exo</td></tr>\n";
echo "<tr><td>Geology</td><td>"; if (!$geo) echo "<em>"; echo "$geo</td></tr>\n";
echo "<tr><td>Greed</td><td>"; if (!$gre) echo "<em>"; echo "$gre</td></tr>\n";
echo "<tr><td>Honor</td><td>"; if (!$hon) echo "<em>"; echo "$hon</td></tr>\n";
echo "<tr><td>Klingon Intelligence</td><td>"; if (!$kli) echo "<em>"; echo "$kli</td></tr>\n";
echo "<tr><td>Law</td><td>"; if (!$law) echo "<em>"; echo "$law</td></tr>\n";
echo "<tr><td>Leadership</td><td>"; if (!$lea) echo "<em>"; echo "$lea</td></tr>\n";
echo "<tr><td>Mindmeld</td><td>"; if (!$min) echo "<em>"; echo "$min</td></tr>\n";
echo "<tr><td>Music</td><td>"; if (!$mus) echo "<em>"; echo "$mus</td></tr>\n";
echo "<tr><td>Navigation</td><td>"; if (!$nav) echo "<em>"; echo "$nav</td></tr>\n";
echo "<tr><td>Obsidian Order</td><td>"; if (!$obs) echo "<em>"; echo "$obs</td></tr>\n";
echo "<tr><td>Physics</td><td>"; if (!$phy) echo "<em>"; echo "$phy</td></tr>\n";
echo "<tr><td>Resistance</td><td>"; if (!$res) echo "<em>"; echo "$res</td></tr>\n";
echo "<tr><td>Section 31</td><td>"; if (!$sez) echo "<em>"; echo "$sez</td></tr>\n";
echo "<tr><td>Smuggling</td><td>"; if (!$smu) echo "<em>"; echo "$smu</td></tr>\n";
echo "<tr><td>Stellar Cartography</td><td>"; if (!$stel) echo "<em>"; echo "$stel</td></tr>\n";
echo "<tr><td>Tal Shiar</td><td>"; if (!$tal) echo "<em>"; echo "$tal</td></tr>\n";
echo "<tr><td>Transporter Skill</td><td>"; if (!$tra) echo "<em>"; echo "$tra</td></tr>\n";
echo "<tr><td>Treachery</td><td>"; if (!$tre) echo "<em>"; echo "$tre</td></tr>\n";
echo "<tr><td>Youth</td><td>"; if (!$you) echo "<em>"; echo "$you</td></tr>\n";
*/

echo "</table></td>\n";

echo "<td valign=\"top\">\n";
echo "<IMG src=\"img/pixel.gif\" width=\"200\" height=\"1\" hspace=\"0\" alt=\"\" />";

////////////////conteggio attributi/////////////

if (isset($arp)) {
	$imax = max($arp["i"]);
	$imed = round(array_sum($arp["i"])/sizeof($arp["i"]),1);
	$imin = min($arp["i"]);
	$cmax = max($arp["c"]);
	$cmed = round(array_sum($arp["c"])/sizeof($arp["c"]),1);
	$cmin = min($arp["c"]);
	$smax = max($arp["s"]);
	$smed = round(array_sum($arp["s"])/sizeof($arp["s"]),1);
	$smin = min($arp["s"]);
}

echo "<table border=\"0\" width=\"100%\">\n";
echo"<tr><td bgcolor=\"#dedebb\" colspan=\"4\"><b>Attributi</b></td></tr>\n";
echo "<tr align=\"center\"><td></td><td CLASS=\"t\">I</td><td CLASS=\"t\">C</td><td CLASS=\"t\">S</td></tr>\n";
echo "<tr><td>Massimo</td><td class=\"i\">$imax</td><td class=\"u\">$cmax</td><td class=\"s\">$smax</td></tr>\n";
echo "<tr><td>Medio</td><td class=\"i\">$imed</td><td class=\"u\">$cmed</td><td class=\"s\">$smed</td></tr>\n";
echo "<tr><td>Minimo</td><td class=\"i\">$imin</td><td class=\"u\">$cmin</td><td class=\"s\">$smin</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";

////navi///

if (isset($arn)) {
	$rmax = max($arn["r"]);
	$rmed = round(array_sum($arn["r"])/sizeof($arn["r"]),1);
	$rmin = min($arn["r"]);
	$wmax = max($arn["w"]);
	$wmed = round(array_sum($arn["w"])/sizeof($arn["w"]),1);
	$wmin = min($arn["w"]);
	$hmax = max($arn["s"]);
	$hmed = round(array_sum($arn["s"])/sizeof($arn["s"]),1);
	$hmin = min($arn["s"]);
}

echo "<tr><td bgcolor=\"#dedebb\" colspan=\"4\"><b>Attributi Navi</b></td></tr>\n";
echo "<IMG src=\"img/pixel.gif\" width=\"200\" height=\"1\" hspace=\"0\" alt=\"\" />";
echo "<tr align=\"center\"><td></td><td CLASS=\"t\">R</td><td CLASS=\"t\">W</td><td CLASS=\"t\">S</td></tr>\n";
echo "<tr><td>Massimo</td><td class=\"q\" align=\"center\">$rmax</td><td class=\"q\" align=\"center\">$wmax</td><td class=\"q\" align=\"center\">$hmax</td></tr>\n";
echo "<tr><td>Medio</td><td class=\"q\" align=\"center\">$rmed</td><td class=\"q\" align=\"center\">$wmed</td><td class=\"q\" align=\"center\">$hmed</td></tr>\n";
echo "<tr><td>Minimo</td><td class=\"q\" align=\"center\">$rmin</td><td class=\"q\" align=\"center\">$wmin</td><td class=\"q\" align=\"center\">$hmin</td></tr>\n";

///////////conteggio tipi e gruppi///////////

echo "<tr><td>&nbsp;</td></tr><tr><td bgcolor=\"#dedebb\" colspan=\"4\"><b>Conteggio tipi</b></td></tr>\n";
echo "</table>\n";
echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"1\">";

$query = "select gruppo,tipo,count(m.id) as tot from mazzo m left join erti e on m.id=e.id where idmazzo=$mid group by gruppo,tipo";

$result = mysql_query($query);
$i = 0;
while ($r = mysql_fetch_array($result)) {
	$ar["gruppo"][$i] = $r["gruppo"];
	$ar["tipo"][$i] = $r["tipo"];
	$ar["tot"][$i] = $r["tot"];
	$i++;
}
mysql_free_result($result);

for ($k = 0; $k<$i; $k++) {
	$grp = $ar["gruppo"][$k];
	$tp = strtolower($ar["tipo"][$k]);
	$carte[$tp][$grp] = $ar["tot"][$k];
}

$totd = 0;
$totm = 0;
$tots = 0;
$totq = 0;

if (is_array($carte)) {    ////////// niente tabella se il mazzo è vuoto ////////////
	foreach ($carte as $k=>$v) {      /// pone a zero se gruppo vuoto ///
		$cart[$k]["7d"] = isset($carte[$k]["7d"]) ? $carte[$k]["7d"] : 0;
		$cart[$k]["2m"] = isset($carte[$k]["2m"]) ? $carte[$k]["2m"] : 0;
		$cart[$k]["1s"] = isset($carte[$k]["1s"]) ? $carte[$k]["1s"] : 0;
		$cart[$k]["3q"] = isset($carte[$k]["3q"]) ? $carte[$k]["3q"] : 0;
		$cart[$k]["4f"] = isset($carte[$k]["4f"]) ? $carte[$k]["4f"] : 0;

		$totd += $cart[$k]["7d"];
		$totm += $cart[$k]["2m"];
		$tots += $cart[$k]["1s"];
		$totq += $cart[$k]["3q"];
		$totf += $cart[$k]["4f"];        /// totali ////
	}

	$totale = $totd + $totm + $tots + $totq + $totf;

	echo "<tr valign=\"top\"><td></td><td><font size=\"1\">Draw</td><td><font size=\"1\">Seed Free</font></td><td><font size=\"1\">Seed</font></td><td><font size=\"1\">Q's Tent</font></td><td><font size=\"1\">Q Flash</font></td></tr>\n";

	foreach ($cart as $k1=>$v1) {
		$totriga = 0;
		echo "<tr><td><acronym title=\"".trad($k1)."\">$k1</acronym></td>";
		foreach ($v1 as $k2=>$v2) {
			echo "<td>$v2</td>";
			$totriga += $v2;
		}
		echo "<td>$totriga</td></tr>\n";
	}
	 echo "<tr><td></td><td>";
	if ($totd<30) echo "<font color=\"red\">";
	echo "$totd</td><td>";
	if ($totm<6 || $totm>12) echo "<font color=\"red\">";
	echo "$totm</td><td>";
	if ($tots>30) echo "<font color=\"red\">";
	echo "$tots</td><td>";
	if ($totq>13) echo "<font color=\"red\">";
	echo "$totq</td><td>";
	echo "$totf</td><td><b>$totale</b></td></tr>\n";
}
echo "</table>\n";
?>
