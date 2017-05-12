<?php
	
	require_once('db/dbconfig.php');

	try{

		if(isset($_POST['login'])){
			
			$user_name = $_POST['uname'];
			$user_email = $_POST['email'];
			// $password 	= md5($_POST['password']);
			$password 	= $_POST['password'];

			$stmt = $db_con->prepare("SELECT * FROM users WHERE user_name = :usrname AND user_email = :email AND user_password = :password");

			$stmt->bindParam(":usrname", $user_name);
			$stmt->bindParam(":email", $user_email);
			$stmt->bindParam(":password", $password);

			$stmt->execute();

			$count = $stmt->rowCount();

			$result = $stmt->fetch(PDO::FETCH_OBJ);

			if($count){

				$selected_user = $result->user_type;
				
				switch ($selected_user){
					
					case "admin":
					session_start();

					$_SESSION['id']    		= $result->user_id;
					$_SESSION['uname'] 		= $result->user_name; 
					$_SESSION['email'] 		= $result->user_email;
					$_SESSION['password'] 	= $result->user_password;
					$_SESSION['admin'] 		= $result->user_type;
					$_SESSION['image'] 		= $result->image;	
									
					// session_unset();
					// session_destroy();
					header("location: owner-profile.php");
					break;

					case "owner":
					session_start();

					$_SESSION['id']    		= $result->user_id;
					$_SESSION['uname'] 		= $result->user_name; 
					$_SESSION['email'] 		= $result->user_email;
					$_SESSION['password'] 	= $result->user_password;
					$_SESSION['owner'] 		= $result->user_type;
					$_SESSION['image'] 		= $result->image;					

					header("location: owner-profile.php");
					break;

					case "user":
					session_start();

					$_SESSION['id']    		= $result->user_id;
					$_SESSION['uname'] 		= $result->user_name; 
					$_SESSION['email'] 		= $result->user_email;
					$_SESSION['password'] 	= $result->user_password;
					$_SESSION['user'] 		= $result->user_type;
					$_SESSION['image'] 		= $result->image;					

					header("location: user-profile.php");
					break;

					default: 
					echo "Your Account type could not be found";
				}

			} else {

				echo "Your email and password could not found ";

			}
		}

	} catch(PDOException $e){

			echo $e->getMessage();

		}


?>