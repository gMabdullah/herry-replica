<?php	
	session_start();
		// var_dump('expressionsfsegb');

	if(!isset($_SESSION['uname'])){
		// var_dump('expression');
		header("location: signup.php");
		
	}