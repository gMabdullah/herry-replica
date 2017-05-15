<?php

	// $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
	// $server = $url["host"];
	// $username = $url["user"];
	// $password = $url["pass"];
	// $db = substr($url["path"], 1);

	// $config = array(
	//     $server => 'localhost' ,
	//     $username => 'root' ,
	//     $password => 'root',
	//     $db => 'signup' 
	// );
	
	// $server = 'localhost';
	// $username = 'root';
	// $password = 'root';
	// $db = 'signup';

	// infinity.net server config.
	$server = 'sql209.rf.gd';
	$username = 'rfgd_20102755';
	$password = 'subhanALLAH';
	$db = 'rfgd_20102755_signup';

	try{
		
		$db_con = new PDO("mysql:host={$server};dbname={$db}",$username, $password);
		$db_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(PDOException $e){
		echo $e->getMessage();
	}

	// include_once '../includes/class.crud.php';

	// $crud = new crud($db_con);
	

?>