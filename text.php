<?php

include_once "mainfile.php";
dbconnect();

cookiedecode($user);
$utente = $cookie[1];

$mid = intval($_REQUEST['mid']);

$query = "SELECT idmazzo,user FROM mazzi WHERE user='$utente' AND idmazzo='$mid'";
$result = mysqli_query($query);
if (mysqli_num_rows($result) < 1 && $utente != "garak") die("Accesso non autorizzato");
mysqli_free_result($result);

$query = "SELECT idmazzo,user,nomemazzo FROM mazzi WHERE idmazzo=$mid";
$result = mysqli_query($query);
list($idmazzo, $user, $nomemazzo) = mysqli_fetch_row($result);
mysqli_free_result($result);

$file = "mazzo_$idmazzo.txt";
	
$query = "SELECT * FROM mazzo m LEFT JOIN erti e ON m.id=e.id LEFT JOIN personale p ON m.id=p.id LEFT JOIN navi n ON m.id=n.id LEFT JOIN testo2 t ON p.id=t.id WHERE idmazzo=$mid ORDER BY gruppo,tipo,p.aff,n.aff,nome";
$result = mysqli_query($query);
$i = 0;
while ($r = mysqli_fetch_array($result)) {
	$ar["un"][$i] = $r["un"];
	$ar["nome"][$i] = str_replace("&quot;", "\"", $r["nome"]);
	$ar["rar"][$i] = $r["rar"];
	$ar["id"][$i] = $r["id"];
	$ar["tipo"][$i] = $r["tipo"];
	$ar["gruppo"][$i] = $r["gruppo"];
	$i++;
}
mysqli_free_result($result);
mysqli_close($link);

$fp = @fopen($file, "w") or die("Impossibile creare file $file");

fputs($fp, "GARAK'S STAR TREK CCG DATABASE\n");
fputs($fp, " http://www.garak.it/  -  http://welcome.to/StarTrekCCG\n");
fputs($fp, "\nMAZZO: $nomemazzo, AUTORE: $user\n\n");

for ($k = 0; $k < $i; $k++) {
	if (!$k) {
		fputs($fp, " - ".strtoupper(trad($ar["gruppo"][$k]))." - \n\n");
		fputs($fp, strtoupper(trad($ar["tipo"][$k]))."\n");
	} else if ($ar["gruppo"][$k] != $ar["gruppo"][$k-1]) {	///se cambio gruppo///
		fputs($fp, "\n - ".strtoupper(trad($ar["gruppo"][$k]))." - \n");
		fputs($fp, "\n".strtoupper(trad($ar["tipo"][$k]))."\n");
	} else if ($ar["tipo"][$k] != $ar["tipo"][$k-1]) {	///se cambio tipo///
		fputs($fp, "\n".strtoupper(trad($ar["tipo"][$k]))."\n");
	}
	$spazi = 40 - strlen($ar["nome"][$k]);        ////correzioni per incolonnare bene
	$z = " ";
	$s = 0;
	while ($s < $spazi) {
		$z .= " ";
		$s++;
	}
	$x = "   ";
	if (strlen($ar["rar"][$k]) == 2) $x = "  ";
	fputs($fp, $ar["nome"][$k].$z.$ar["rar"][$k].$x.substr($ar["id"][$k], 0, 3)."\n");
}

@fclose($file);
Header("Location: $file");
?>
