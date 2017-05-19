<?php

include_once "mainfile.php";
include_once "funz_user.php";
include_once "funz_mazzi.php";

dbconnect();

$op = $_REQUEST['op'] ?? null;
$user = $_REQUEST['user'] ?? null;
$email = $_REQUEST['email'] ?? null;
$empp = $_REQUEST['empp'] ?? null;
$uname = $_REQUEST['uname'] ?? null;
$code = $_REQUEST['code'] ?? null;
$bypass = $_REQUEST['bypass'] ?? null;
$vpass = $_REQUEST['vpass'] ?? null;
$mid = $_REQUEST['mid'] ?? null;
$nomemazzo = $_REQUEST['nomemazzo'] ?? null;

switch ($op) {			////// Scelta Opzione ///////
	case "logout":
		logout();
		break;

	case "lost_pass":
		lost_pass();
		break;

	case "new user":
		confirmNewUser($uname, $email, $empp);
		break;

	case "finish":
		finishNewUser($uname, $email, $empp);
		break;

	case "mailpasswd":
		mail_password($uname, $code);
		break;

	case "userinfo":
		userinfo($uname, $bypass);
		break;

	case "login":
		login($uname, $pass);
		break;

	case "edituser":
		edituser();
		break;

	case "saveuser":
		saveuser($uid, $name, $uname, $email, $pass, $vpass, $empp);
		break;

	case "vedi":
		vedimazzi($mid);
		break;	

	case "attiva":
		attiva($mid);
		main($user);
		break;

	case "crea":
		crea($nomemazzo);
		main($user);
		break;	

	case "delete":
		cancmazzo($mid);
		main($user);
		break;	

	case "cancella":
		foreach ($per as $v) cancella($mid,$v);
		vedimazzi($mid);
		break;

	case "muovi":
		foreach ($per as $v) sposta($mid,$v,$gruppo);
		vedimazzi($mid);
		break;

	case "insert":
		if (isset($user)) {
			foreach ($per as $v) inserisci($v,$gruppo);
			vedimazzi($mid);
		} else main($user);
		break;

	case "insd":
		if (isset($user)) {
			foreach ($per as $v) inseriscidm($v,doppie);
			vedidm($user);
		} else main($user);
		break;

	case "insm":
		if (isset($user)) {
			foreach ($per as $v) inseriscidm($v,manco);
		 	vedidm($user);
		} else main($user);
		break;

	case "elimina":
		foreach ($per as $v) cancdm($v,$tipo);
		vedidm($user);
		break;

	case "cambia":
		foreach ($per as $v) cambia($v,$tipo,$note);
		vedidm($user);
		break;

	case "vedidm":
		vedidm($user);
		break;

	default:
		main($user);
		break;
}

mysqli_close();

