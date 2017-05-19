<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Star Trek CCG DataBase</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<br /><br />
<table cellpadding="0" cellspacing="0" width="99%" align="center" bgcolor="#ffffff">
 <tr>
  <td class="ang1"></td>
  <td></td>
  <td class="ang2"></td>
 </tr>
 <tr>
  <td></td>
  <td colspan="2">
<?php
if (isset($err)) echo $err;
#echo "controllo = $controllo\n";
?>
   <form action="check.php" method="post">
Nome <input name="nick" type="text" />
Password <input name="pass" type="password" />
<input type="hidden" name="login" value="1" />
<input type="submit" value="OK" />
   </form>
   <hr />
Registrazione nuovo utente
   <form action="check.php" method="GET">
Nome <input name="nick" type="text" />
<br>Password <input name="pass" type="password" />
<br>Vero nome <input name="nome" type="text" />
<br>E-mail <input name="email" type="text" />
<input type="hidden" name="reg" value="1" />
<input type="submit" value="OK" />
   </form>
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
