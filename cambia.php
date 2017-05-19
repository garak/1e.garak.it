<?php
#exit();	// da commentare
include_once "mainfile.php";
dbconnect();
$nuovapwd = crypt("wolerght4");
echo $query = "UPDATE users SET pass='".$nuovapwd."' WHERE uid=69";
$result = mysql_query($query);
mysql_close();
echo "<br /> fatto";
?>
