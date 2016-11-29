<?php
require_once 'inc/crud.php';
require 'inc/connection.php';
require 'inc/session.php';

$activiy_id = $_POST['activity_id'];
$member_id = $_POST['member_id'];

if ( empty($_POST['activity_id']) || empty($_POST['member_id'])) {
	$_SESSION['errors'][] = 'Één van de velden of meer zijn niet ingevuld.';
	header('Location: events.php');
	exit;
}

$sql = $db->prepare("SELECT * FROM members WHERE gebruikersnaam=?");
if ($sql->execute(array($Gebruikersnaam)))
	{
		if ( $sql->rowCount() > 0 ) {
			$_SESSION['errors'][] = 'De gebruikersnaam bestaat al!';
			header('Location: events.php');
			exit;
		}
	}

$sth = $db->prepare("INSERT INTO members_activities (activity_id, member_id) VALUES (?, ?)");
if ($sth->execute(array($activity_id, $member_id)))
{
	$_SESSION['errors'][] = 'De activiteit is toegevoegd.';
	header('Location: events.php');
	exit;
}
else
{
	$_SESSION['errors'][] = 'Er is iets fout gegaan. Probeer het later nog eens.';
	header('Location: events.php');
	exit;
}