<?php 

 require_once 'inc/session.php';
 require_once 'inc/blade.php';
 require_once 'inc/crud.php';
 $errors = [];

if ( IsLoggedInSession()==false) {
	// stuur direct door naar main pagina
    $_SESSION['errors'][] = "U heeft nog niet ingelogd!";
	header('location: login_admin.php');
	exit;
}

elseif ( IsLoggedInSession()==true && $_SESSION['IsAdmin'] == false)
{
	$_SESSION['errors'][] = "U bent wel ingelogd, maar u bent geen beheerder!";
	header('location: main.php');
	exit;
}

elseif ( IsLoggedInSession()==true && $_SESSION['IsAdmin'] == true)
{
	require 'inc/connection.php';

	//$id = mysqli_real_escape_string($db, $_GET['events_id']);

	$sth = $db->prepare("SELECT * FROM events ORDER BY id ASC");
	$sth->execute();

	/* Fetch all of the remaining rows in the result set */
	$events = $sth->fetchAll(PDO::FETCH_ASSOC);

	// tell blade to create HTML from the template "login.blade.php"
	echo $blade->view()->make('Backend/events/create_event')->with('events', $events)->withErrors($errors)->render();
}