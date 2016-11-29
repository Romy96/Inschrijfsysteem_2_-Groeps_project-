<?php
require_once 'inc/session.php';
require_once 'inc/blade.php';
require_once 'inc/connection.php';
$errors = [];

   if ( isset($_SESSION['errors'])) {
      $errors = $_SESSION['errors'];
      $_SESSION['errors'] = array();  // remove all errors
   } 
   else
   {
      $_SESSION['errors'] = array();
   }

   //$sth = $db->prepare("SELECT * FROM members WHERE id=? AND validation_token=?");
	//$sth->execute();
	//$id = $db->lastInsertId();

	/* Fetch all of the remaining rows in the result set */
	//$user = $sth->fetchAll(PDO::FETCH_ASSOC);


echo $blade->view()->make('validate_account')->withErrors($errors)->render();
