<?php 
	// connection 
	require_once('db/dbconfig.php');

	/*  Four steps to closing a session ie logout 
	*/

	// Find teh session
	session_start();

	$_SESSION = array();

	// Unset all the session variables
	if(isset($_COOKIE[session_name()])) {

	// Destroying the session cookie
	setcookie(session_name(), '', time()-42000, '/');
	}

	// Destroying the session
	session_destroy();
	header('location: index.php');
	exit;
 


 ?>
