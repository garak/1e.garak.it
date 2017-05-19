<?php


$mainfile = 1;

function OpenTable()
{
  global $bgcolor1, $bgcolor2;
  if (!$bgcolor1) $bgcolor1 = "#FFFFFF";
  if (!$bgcolor2) $bgcolor2 = "#FFFFFF";
  echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"".$bgcolor2."\">\n<tr>\n<td>\n";
  echo "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"8\" bgcolor=\"".$bgcolor1."\">\n<tr valign=\"top\">\n<td>\n";
}

function OpenTable2()
{
  echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"99%\" align=\"center\" bgcolor=\"#FFFFFF\">\n";
  echo "<tr valign=\"top\">\n";
  echo "<td class=\"ang1\"></td>\n";
  echo "<td>&nbsp;</td>\n";
  echo "<td class=\"ang2\"></td>\n";
  echo "</tr>\n<tr>\n<td colspan=\"3\">\n";
}

function OpenTable3()
{
    $ret = "<table width=\"100%\" cellspacing=\"1\" cellpadding=\"0\" bgcolor=\"#FFFFFF\">\n <tr>\n  <td>\n   ";
    echo $ret;
}

function CloseTable3()
{
    $ret = "  </td>\n </tr>\n</table>\n";
    echo $ret;
}

function CloseTable()
{
    echo "</td></tr></table>\n</td></tr></table>\n";
}


function dbconnect()
{
  global $link;
  $link = mysqli_connect('127.0.0.1', 'legacy', 'legacy') or die("<br />In questo momento ci sono problemi con il server, riprovare pi√π tardi.</table>");
  mysqli_select_db($link, 'garak') or die("Impossibile selezionare database!</table>");
}


function cookiedecode($user)
{
  global $cookie;
  $user = base64_decode($user);
  $cookie = explode(":", $user);
  $result = mysqli_query("SELECT uid FROM users WHERE uname='$cookie[1]'");
  if (!mysqli_num_rows($result)) {
      unset($user);
      unset($cookie);
  }  
  return $cookie;
}

function getusrinfo($user)
{
  global $userinfo;
  $user2 = base64_decode($user);
  $user3 = explode(":", $user2);
  $result = mysqli_query("select * from users where uname='$user3[1]' and pass='$user3[2]'");
  if (mysqli_num_rows($result) == 1) {
    $userinfo = mysqli_fetch_array($result);
  } else {
      echo "<b>C'&egrave; stato un problema!</b><br>";
  }
  return $userinfo;
}

function trad($sigla)
{
  $sigla = strtolower($sigla);
  $trad['1s']  = "Seed";
  $trad['2m']  = "Seed free";
  $trad['3q']  = "Q's Tent";
  $trad['4f']  = "Q-Flash";
  $trad['5b']  = "Battle Bridge";
  $trad['6t']  = "Tribble";
  $trad['7d']  = "Draw";
  $trad['art'] = "Artefatti";
  $trad['dil'] = "Dilemmi";
  $trad['doo'] = "Doorway";
  $trad['eve'] = "Eventi";
  $trad['equ'] = "Equipaggiamento";
  $trad['fac'] = "Installazioni";
  $trad['inc'] = "Incidenti";
  $trad['int'] = "Interruzioni";
  $trad['mis'] = "Missioni";
  $trad['obj'] = "Obiettivi";
  $trad['per'] = "Personale";
  $trad['nav'] = "Navi";
  $trad['sit'] = "Siti";
  $trad['tl']  = "Loc. Temporali";
  $trad['tac'] = "Tattiche";
  $trad['tri'] = "Tribble";
  $trad['tro'] = "Trouble";
  return $trad[$sigla];
}

function mandamail($mittente,$email,$destinatario,$oggetto,$testo)
{
  $smtp_server = "mail.mclink.it";
  $port = 25;
  $mydomain = "mclink.it";
  $handle = @fsockopen($smtp_server,$port) or die("server mail non raggiungibile");
  fputs($handle, "EHLO $mydomain\r\n");
  fputs($handle, "MAIL FROM: $email\r\n");
  fputs($handle, "RCPT TO: $destinatario\r\n");
  fputs($handle, "DATA\r\n");
  fputs($handle, "To: $destinatario\n");
  fputs($handle, "Subject: $oggetto\n\n");
  fputs($handle, "$testo\r\n");
  fputs($handle, ".\r\n");

  fputs($handle, "QUIT\r\n");
} 

function filter_text($Message, $strip = "")
{
  global $EditedMessage;
  $EditedMessage=check_html($Message, $strip);
  return ($EditedMessage);
}

function check_html($str, $strip="")
{
    /* The core of this code has been lifted from phpslash */
    /* which is licenced under the GPL. */
    if ($strip == "nohtml")
            $AllowableHTML=array('');
        $str = stripslashes($str);
        $str = eregi_replace("<[[:space:]]*([^>]*)[[:space:]]*>",
                         '<\\1>', $str);
               // Delete all spaces from html tags .
        $str = eregi_replace("<a[^>]*href[[:space:]]*=[[:space:]]*\"?[[:space:]]*([^\" >]*)[[:space:]]*\"?[^>]*>",
                         '<a href="\\1">', $str); # "
               // Delete all attribs from Anchor, except an href, double quoted.
        $str = eregi_replace("<img?",
                         '', $str); # "
        $tmp = "";
        while (ereg("<(/?[[:alpha:]]*)[[:space:]]*([^>]*)>",$str,$reg)) {
                $i = strpos($str,$reg[0]);
                $l = strlen($reg[0]);
                if ($reg[1][0] == "/") $tag = strtolower(substr($reg[1],1));
                else $tag = strtolower($reg[1]);
                if ($a = $AllowableHTML[$tag])
                        if ($reg[1][0] == "/") $tag = "</$tag>";
                        elseif (($a == 1) || ($reg[2] == "")) $tag = "<$tag>";
                        else {
                          # Place here the double quote fix function.
                          $attrb_list=delQuotes($reg[2]);
                          $tag = "<$tag" . $attrb_list . ">";
                        } # Attribs in tag allowed
                else $tag = "";
                $tmp .= substr($str,0,$i) . $tag;
                $str = substr($str,$i+$l);
        }
        $str = $tmp . $str;
        return $str;
        exit;
        /* Squash PHP tags unconditionally */
        $str = ereg_replace("<\?","",$str);
        return $str;
}


function cbox($idcarta)  // non mette il checkbox sulle carte inedite
{
  if (substr($idcarta, 0, 2) != 'ZZ') echo "input type=\"checkbox\" name=\"per[]\" ";
  else echo "input type=\"hidden\" ";
}

function simboli($testo)  // inserisce il simbolo del download
{
  return str_replace(":d:", "<font class=\"s\">—</font>", $testo);
}

$ABIL[] = "CIVILIAN";
$ABIL[] = "ENGINEER";
$ABIL[] = "MEDICAL";
$ABIL[] = "OFFICER";
$ABIL[] = "SCIENCE";
$ABIL[] = "SECURITY";
$ABIL[] = "VIP";
$ABIL[] = "Acquisition";
$ABIL[] = "Anthropology";
$ABIL[] = "Archaeology";
$ABIL[] = "Astrophysics";
$ABIL[] = "Biology";
$ABIL[] = "ComputerSkill";
$ABIL[] = "Cybernetics";
$ABIL[] = "Diplomacy";
$ABIL[] = "Empathy";
$ABIL[] = "Exobiology";
$ABIL[] = "FCA";
$ABIL[] = "Geology";
$ABIL[] = "Greed";
$ABIL[] = "Honor";
$ABIL[] = "KlingonIntelligence";
$ABIL[] = "Law";
$ABIL[] = "Leadership";
$ABIL[] = "Mindmeld";
$ABIL[] = "Music";
$ABIL[] = "Navigation";
$ABIL[] = "ObsidianOrder";
$ABIL[] = "Physics";
$ABIL[] = "Resistance";
$ABIL[] = "Smuggling";
$ABIL[] = "StellarCartography";
$ABIL[] = "TalShiar";
$ABIL[] = "TransporterSkill";
$ABIL[] = "Treachery";
$ABIL[] = "Youth";

$ICONE["AU"] = "Alternate Universe";
$ICONE["C"] = "Command";
$ICONE["S"] = "Staff";
$ICONE["H"] = "Ologramma";
$ICONE["Com"] = "Borg Comunic.";
$ICONE["Def"] = "Borg Difesa";
$ICONE["Nav"] = "Borg Navig.";
$ICONE["G"] = "Quadrante Gamma";
$ICONE["D"] = "Quadrante Delta";
$ICONE["M"] = "Quadrante Mirror";
$ICONE["TM"] = "Film";
$ICONE["T"] = "Serie Classica";
$ICONE["A"] = "Mirror Alliance";
$ICONE["I"] = "Mirror Empire";
$ICONE["EE"] = "Enterprise E";
$ICONE["Nem"] = "Nemesi";
$ICONE["Maq"] = "Maquis";
$ICONE["B"] = "Barash";
$ICONE["Orb"] = "Orb";
$ICONE["W"] = "Ketracel White";

$AFF[] = "b";
$AFF[] = "bo";
$AFF[] = "c";
$AFF[] = "d";
$AFF[] = "f";
$AFF[] = "fr";
$AFF[] = "h";
$AFF[] = "k";
$AFF[] = "kz";
$AFF[] = "m";
$AFF[] = "n";
$AFF[] = "r";
$AFF[] = "v";

$NAFF[] = "b";
$NAFF[] = "bo";
$NAFF[] = "c";
$NAFF[] = "d";
$NAFF[] = "f";
$NAFF[] = "fr";
$NAFF[] = "h";
$NAFF[] = "k";
$NAFF[] = "kz";
$NAFF[] = "n";
$NAFF[] = "r";
$NAFF[] = "v";

$EQ[] = "CloakingDevice";
$EQ[] = "EnergyDampener";
$EQ[] = "Holodeck";
$EQ[] = "InvasiveTransporters";
$EQ[] = "LongRangeScanShielding";
$EQ[] = "ParticleScatteringDevice";
$EQ[] = "TractorBeam";

$STAFF["AU"] = "Alternate Universe";
$STAFF["C"] = "Command";
$STAFF["S"] = "Staff";
$STAFF["Com"] = "Borg Command";
$STAFF["Def"] = "Borg Defense";
$STAFF["Nav"] = "Borg Navigation";
$STAFF["Maq"] = "Maquis";
$STAFF["T"] = "Serie Classica";
$STAFF["TM"] = "Film";
$STAFF["A"] = "Mirror Alliance";
$STAFF["I"] = "Mirror Empire";
$STAFF["EE"] = "Enterprise E";
$STAFF["W"] = "Ketracel White";

$NICO[] = "AU";
$NICO[] = "G";
$NICO[] = "D";
$NICO[] = "M";
$NICO[] = "Nem";
$NICO[] = "Maq";
$NICO[] = "T";
$NICO[] = "TM";
$NICO[] = "A";
$NICO[] = "I";

$MAFF[] = "b";
$MAFF[] = "c";
$MAFF[] = "d";
$MAFF[] = "f";
$MAFF[] = "fr";
$MAFF[] = "h";
$MAFF[] = "k";
$MAFF[] = "kz";
$MAFF[] = "n";
$MAFF[] = "r";
$MAFF[] = "v";

$MICO[""] = "Quadrante Alfa";
$MICO["G"] = "Quadrante Gamma"; 
$MICO["D"] = "Quadrante Delta"; 
$MICO["M"] = "Quadrante Mirror";
