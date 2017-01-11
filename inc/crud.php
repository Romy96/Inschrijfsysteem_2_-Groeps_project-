<?php
function CheckUserIsValid ($db, $email, $wachtwoord, $needs_admin = false) {
	// return 0 if email is empty
	if (empty($email)) {
		return ['result' => 0, 'userId' => null, 'userEmail' => null, 'Gebruikersnaam' => null];
	}

	// return 0 if password is empty
	if (empty($wachtwoord)) {
		return ['result' => 0, 'userId' => null, 'userEmail' => null, 'Gebruikersnaam' => null];
	}

	$hash = md5($wachtwoord);

	$statement = $db->prepare('SELECT id, gebruikersnaam, IsAdmin FROM members where email=? AND wachtwoord=? AND active=1 ;');
	$statement->execute(array($email, $hash));
	$count = $statement->rowCount();
	$row = $statement->fetch(PDO::FETCH_ASSOC);
	$userId = $row['id'];
	$Gebruikersnaam = $row['gebruikersnaam'];
	$IsAdmin = $row['IsAdmin'];

	// user/pass combination found; return 1.
	if ($count == 1) {
		if ($needs_admin == true) {
				if ($IsAdmin == 1) {
					return ['result' => 1, 'userId' => $userId, 'userEmail' => $email, 'Gebruikersnaam' => $Gebruikersnaam, 'IsAdmin' => $needs_admin];
				} 
				else {
					return ['result' => 0, 'userId' => null, 'userEmail' => null, 'Gebruikersnaam' => null, 'IsAdmin' => null];
				}
			}
			else{
				return ['result' => 1, 'userId' => $userId, 'userEmail' => $email, 'Gebruikersnaam' => $Gebruikersnaam];			
			}	
		}
		else
		{
			return ['result' => 0, 'userId' => null, 'userEmail' => null, 'Gebruikersnaam' => null];
		}

	}

function IsLoggedIn() {

	// check if cookie contains gebruikersnaam (then, if session has no gebruikersnaam, fill session as well)
	if ( isset($_COOKIE['userId']) && !isset($_SESSION['userId']) ) {
		LoginSession($_COOKIE['userId'], $_COOKIE['userEmail'], $_COOKIE['Gebruikersnaam']);
		return true;
	}

		// check if session contains gebruikersnaam
	if ( isset($_SESSION['userId']) ) {
		return true;
	}

	return false;
}

function LoginSession($userId, $userEmail, $Gebruikersnaam) {
	$_SESSION['userId'] = $userId;
	$_SESSION['userEmail'] = $userEmail;
	$_SESSION['displayName'] = $displayName;
}

function RememberCookie($userId, $userEmail, $Gebruikersnaam) {
			// bewaar userId in cookie dat 30 dagen geldig blijft
			setcookie("userId", $userId, time() + (86400 * 30), "/"); // 86400 = 1 day

			// bewaar userEmail in cookie dat 30 dagen geldig blijft
			setcookie("userEmail", $userEmail, time() + (86400 * 30), "/"); // 86400 = 1 day

			// bewaar displayName in cookie dat 30 dagen geldig blijft
			setcookie("displayName", $displayName, time() + (86400 * 30), "/"); // 86400 = 1 day
}

function IsLoggedInSession() {
	if (isset($_SESSION['userId'])==false || empty($_SESSION['userId']) ) {
		return 0;
	}
	else
	{
		return 1;
	}
}

function LogOut() {
	$_SESSION['errors'][] = "Logged out.";

	unset($_SESSION['userId'], $_SESSION['userEmail'], $_SESSION['Gebruikersnaam']);

	// verwijder het cookie door expiration 
	setcookie("userId", null, time() -3600, "/"); // 86400 = 1 day
	setcookie("userEmail", null, time() -3600, "/"); // 86400 = 1 day
	setcookie("displayName", null, time() -3600, "/"); // 86400 = 1 day
}

