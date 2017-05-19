<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Garak STCCG</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15">
<style type="text/css">
body { background: #505050; color: #000000; font-family: Verdana, Helvetica, sans-serif; font-size: 11px; text-align: center}
table { font-family: Verdana, Helvetica, sans-serif; font-size: 11px; margin-left: auto; margin-right: auto }
a:link { color: #363636; text-decoration: none }
a:visited { color: #505050; text-decoration: none }
a:hover { background: #C0C0C0; color: #000000; text-decoration: underline }
</style>
</head>
<body>
<br />
<?php
echo "<h2>".strtoupper(htmlentities($_SERVER['QUERY_STRING']))."</h2><br /><br />\n";
include_once "mainfile.php";
$bgcolor1 = "#F1F1F1";
$bgcolor2 = "#C0C0C0";
OpenTable();
if ($_SERVER['QUERY_STRING'] == "garak") {
?>
Il mio vero nome &egrave; <b>Massimiliano</b>, sono di Roma ed ho 28 anni (nel 2002).<br />
Lavoro come sviluppatore PHP in un noto portale studentesco. Sono iscritto allo Star Trek Italian Club dal 1995.<br />
Seguo Star Trek regolarmente da un anno prima, ma naturalmente da piccolo guardavo anch' io gli episodi della Serie Classica.<br />
Mi sono avvicinato al gioco di carte nel 1995, quando ancora era difficile trovare qualcuno con cui giocare e scambiare.
Ora contribuisco attivamente alla diffusione del gioco, con questo sito e con altri mezzi, insieme ad altri arbitri in Italia, i pochi rimasti 
di un gruppo un tempo pi&ugrave; numeroso.<br />
Nel 1998 ho contribuito a creare <a href="http://gilda.it/dsx" target="_top">Deep Space X</a>, gruppo ufficiale di giocatori di Roma.<br />
Non sono ancora riuscito a terminare la collezione <TT>:-)</TT>
<?php 

} else {

?>
<br /><br />
<B>Customizable Card Game ? Che cos'&egrave; ?</B>
<br /><br />
Un gioco di carte personalizzabile &egrave; qualcosa di completamente diverso dai giochi che conosci ! In un normale gioco di carte, entrambi i giocatori giocano con le stesse carte. In Star Trek Customizable Card Game (Star Trek CCG) puoi costruire il tuo mazzo di gioco scegliendo tra un universo di più di 1000 carte diverse che ogni espansione fa aumentare. Puoi personalizzare il tuo mazzo come vuoi, aggiungendo o togliendo carte fino a creare la tua &quot;arma definitiva&quot; !
<br /><br />
Immagina di giocare una partita a scacchi dove ogni giocatore può scegliere i propri pezzi tra 1000 disponibili, ognuno dei quali si muove diversamente. Seleziona i tuoi 16 pezzi in segreto così come il tuo avversario. Seduto di fronte a lui, guardando la scacchiera, attacca in base ai pezzi che hai scelto, e difenditi dalle sue mosse. Ovviamente puoi cambiare strategia e pezzi di volta in volta, altrimenti il tuo avversario saprà cosa lo aspetta e si preparerà con nuovi pezzi per contrastarti ! Una cosa è sicura : non sarà mai noioso!
<br /><br />
Le carte sono spettacolari. Le immagini sono state prese direttamente dai film e telefilm, ritoccate e rifinite dal dipartimento artistico e stampate con la più alta qualità possibile. Inoltre le carte hanno un testo che descrive il personaggio o la situazione, persino i personaggi comparsi solo per qualche secondo nel telefilm hanno la loro &quot;storia&quot; approvata ufficialmente dalla Paramout Pictures.
<br /><br />
<B>Come si gioca ?</B>
<br /><br />
Con Star Trek CCG, puoi comandare la U.S.S. Enterprise in missioni esplorative, evitare guerrieri nausicaani, ingannare i Ferengi e viaggiare in altre dimensioni (ma attento a Q!). Puoi anche scegliere di rappresentare i Klingon, Romulani, Bajoriani, Ferengi, Cardassiani, i Borg o il Dominio, che vuole esplorare la galassia per i suoi malvagi scopi, e a cui non piace avere a che fare con gli umani !
<br /><br />
Non finirai mai di trovare nuove idee e nuovi modi di giocare. Le possibilità e le strategie di Star Trek CCG sono infinite !!!
<br /><br />
<B>sembra complicato...</B>
<br /><br />
Non molto, richiede un po' di tempo per imparare le regole ma una volta fatto la ricompensa &egrave; grande ! Potrai giocare con tutti i personaggi e nei luoghi della tua serie di fantascienza preferita, metterli in stuazioni impossibili (e tirarli fuori) di volta in volta. Il gioco è uguale a quello che accade nei telefilm, con la differenza che sei tu a &quot;scrivere la sceneggiatura&quot; !!
<br /><br />
Puoi rendere il gioco difficile quanto vuoi. Non riesci a comprendere una regola ? Usa una strategia diversa ! Le carte Interrupt ti confondono? Gioca senza per qualche partita ! &Egrave; il tuo gioco e lo puoi fare nella maniera che più desideri.
<br /><br />
<b>Bello, dove lo posso trovare ?</b>
<br /><br />
Puoi comprare Star Trek CCG nei negozi di giochi, giochi di ruolo e fumetti. Le carte sono vendute in mazzi &quot;Starter&quot; da 60 carte e bustine di espansione da 15 o da 9. 
<br /><br />
La Decipher produce nuove &quot;espansioni&quot; per il gioco. Star Trek: TNG CCG è stato lanciato nel Novembre 1994 e la prima espansione, intitolata &quot;Alternate Universe&quot;, è uscita in autunno 1995. 
&quot;Q-Continuum&quot; è uscita ad Ottobre 1996, quindi &quot;First Contact&quot; a Dicembre 1997 e &quot;Deep Space Nine&quot; a Luglio 1998. L'ultima, emozionante espansione si chiama &quot;The Dominion&quot;, ed è uscita a Gennaio 1999.
<br /><br />

<hr width="90" align="left" />
Nota: questa descrizione &egrave; opera del mitico <b>Robbo</b> ed &egrave; un po' datata: non ho voluto comunque modificarla come tributo ad una persona 
che a questo gioco in Italia ha dato molto.
<?php } CloseTable() ?>

<br />
<a href="/" target="_top">Home Page</a>
</body>
</html>
