<?php
//////////// conteggio skill //////////////

/*
* per contare le abilita` uso l'array $ABIL definita in mainfile.php
* creo per ogni valore di $ABIL una variabile di conteggio costituita
* dalle prime 3 lettere del valore stesso
*/

foreach ($ABIL as $v) {
	$conta = substr($v, 0, 3);
	$$conta = 0; 
}

for ($k = 0; $k < $i; $k++) {
	if ($ar["tipo"][$k] == "per") {
		$abi[$k] = explode(" ", $arp[$k]["testo"]);
		foreach ($abi[$k] as $v) {
			$conta = substr($v, 0, 3);
			$$conta++;
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
	$conta = substr($v, 0, 3);
	echo $$conta ? $$conta : "<em>0</em>";
	echo "</td></tr>\n";
}

echo "</table></td>\n";
echo "<td valign=\"top\">\n";
echo "<img src=\"/img/pixel.gif\" width=\"200\" height=\"1\" hspace=\"0\" alt=\"\" />";

//////////////// conteggio attributi /////////////

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

echo "<table width=\"100%\">\n";
echo "<tr><td class=\"tit3\" colspan=\"4\"><b>Attributi</b></td></tr>\n";
echo "<tr align=\"center\"><td></td><td class=\"t\">I</td><td class=\"t\">C</td><td class=\"t\">S</td></tr>\n";
echo "<tr><td>Massimo</td><td class=\"i\">".$imax."</td><td class=\"u\">".$cmax."</td><td class=\"s\">".$smax."</td></tr>\n";
echo "<tr><td>Medio</td><td class=\"i\">".$imed."</td><td class=\"u\">".$cmed."</td><td class=\"s\">".$smed."</td></tr>\n";
echo "<tr><td>Minimo</td><td class=\"i\">".$imin."</td><td class=\"u\">".$cmin."</td><td class=\"s\">".$smin."</td></tr>\n";
echo "<tr><td>&nbsp;</td></tr>\n";

//// conteggio attributi navi ///

if (isset($arn)) {
	$rmax = max($arn["r"]);
	$rmed = round(array_sum($arn["r"]) / sizeof($arn["r"]), 1);
	$rmin = min($arn["r"]);
	$wmax = max($arn["w"]);
	$wmed = round(array_sum($arn["w"]) / sizeof($arn["w"]), 1);
	$wmin = min($arn["w"]);
	$hmax = max($arn["s"]);
	$hmed = round(array_sum($arn["s"]) / sizeof($arn["s"]), 1);
	$hmin = min($arn["s"]);
}

echo "<tr><td class=\"tit3\" colspan=\"4\"><b>Attributi Navi</b></td></tr>\n";
echo "<tr><td colspan=\"4\"><img src=\"img/pixel.gif\" width=\"200\" height=\"1\" hspace=\"0\" alt=\"\" /></td></tr>\n";
echo "<tr align=\"center\"><td></td><td class=\"t\">R</td><td class=\"t\">W</td><td class=\"t\">S</td></tr>\n";
echo "<tr><td>Massimo</td><td class=\"q\" align=\"center\">".$rmax."</td><td class=\"q\" align=\"center\">".$wmax."</td><td class=\"q\" align=\"center\">$hmax</td></tr>\n";
echo "<tr><td>Medio</td><td class=\"q\" align=\"center\">".$rmed."</td><td class=\"q\" align=\"center\">".$wmed."</td><td class=\"q\" align=\"center\">$hmed</td></tr>\n";
echo "<tr><td>Minimo</td><td class=\"q\" align=\"center\">".$rmin."</td><td class=\"q\" align=\"center\">".$wmin."</td><td class=\"q\" align=\"center\">$hmin</td></tr>\n";

/////////// conteggio tipi e gruppi ///////////

echo "<tr><td>&nbsp;</td></tr>\n<tr><td class=\"tit3\" colspan=\"4\"><b>Conteggio tipi</b></td></tr>\n";
echo "</table>\n";
echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"1\">\n";

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

for ($k = 0; $k < $i; $k++) {
	$grp = $ar["gruppo"][$k];
	$tp = strtolower($ar["tipo"][$k]);
	$carte[$tp][$grp] = $ar["tot"][$k];
}

$totd = 0;
$totm = 0;
$tots = 0;
$totq = 0;

if (is_array($carte)) {    ////////// niente tabella se il mazzo e` vuoto ////////////
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

	echo "<tr class=\"titp\"><td></td><td>Draw</td><td>Seed Free</td><td>Seed</td><td>Q's Tent</td><td>Q Flash</td></tr>\n";

	foreach ($cart as $k1=>$v1) {
		$totriga = 0;
		echo "<tr><td><acronym title=\"".trad($k1)."\">".$k1."</acronym></td>";
		foreach ($v1 as $k2=>$v2) {
			echo "<td>".$v2."</td>";
			$totriga += $v2;
		}
		echo "<td>".$totriga."</td></tr>\n";
	}
	 echo "<tr><td></td><td>";
	if ($totd < 30) $totd = "<em>".$totd."</em>";
	echo $totd."</td><td>";
	if ($totm < 6 || $totm > 12) echo "<em>";
	echo $totm."</td><td>";
	if ($tots > 30) $tots = "<em>".$tots."</em>";
	echo $tots."</td><td>";
	if ($totq > 13) $totq = "<em>".$totq."</em>";
	echo $totq."</td><td>";
	echo $totf."</td><td><b>".$totale."</b></td></tr>\n";
}
echo "</table>\n";
?>
