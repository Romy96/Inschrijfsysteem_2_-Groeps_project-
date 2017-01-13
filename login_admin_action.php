<?php
require_once 'inc/session.php';
require_once 'inc/connection.php';
require_once 'inc/crud.php';

// redirect back to login with error if user didn't enter email
if ( empty($_POST['email']) ) {
	$_SESSION['errors'][] = 'Fout: Geen e-mail ingevuld.';
}

// redirect back to login with error if user didn't enter pass
if ( empty($_POST['wachtwoord']) ) {
	$_SESSION['errors'][] = 'Fout: Geen wachtwoord ingevuld.';
}

// check if user can be found
if (empty($_SESSION['errors'])) $resultarray = CheckUserIsValid($db, $_POST['email'], $_POST['wachtwoord'], true);

if ( $resultarray['result'] == 0 ) {
	$_SESSION['errors'][] = 'Fout: De ingevulde gegevens zijn niet gevonden!';
	header('Location: login_admin.php');
	exit;
}

if ( $resultarray['IsAdmin'] == 0 ) {
	$_SESSION['errors'][] = 'Fout: Uw account is geen beheerder!';
	header('Location: main.php');
	exit;
}

if ( $resultarray['result'] == 1 ) {
	LoginSession($resultarray['userId'], $resultarray['userEmail'], $resultarray['Gebruikersnaam']);

	// als gebruiker heeft aangevinkt "onthou mij", bewaar userId en Gebruikersnaam dan in cookie
	if ( isset($_POST['remember']) && $_POST['remember'] == "checked") {
		RememberCookie($resultarray['userId'], $resultarray['userEmail'], $resultarray['Gebruikersnaam']);
	}

	header('Location: members_list.php');
	exit;	
}
else
{
	$_SESSION['errors'][] = 'Fout: combinatie van e-mail en wachtwoord niet gevonden, of account niet actief.';
	header('Location: login_admin.php');
	exit;
}