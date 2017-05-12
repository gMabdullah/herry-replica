<?php
	
	require_once 'db/dbconfig.php';

	if(isset($_POST))
	{
		// $user_name = $_POST['user_name'];
		$user_email = $_POST['u_email'];
		$user_password = $_POST['password'];
		$user_type = $_POST['user_type'];
		
		$password = md5($user_password);
		// $password = $user_password;

		try
		{	
			// checking if email already registered 
			$stmt = $db_con->prepare("SELECT * FROM users WHERE user_email=:email");
			$stmt->execute(array(":email"=>$user_email));
			$count = $stmt->rowCount();
			
			if($count == 0){
				// if email is not found in tmp_user

				//create randum id for every unique user
				$confirm_code = md5(uniqid(rand()));

			$stmt = $db_con->prepare("INSERT INTO tmp_tbl (confirm_code, email, password, user_type) VALUES(:confrmcode, :email, :pass, :utype)");

			$stmt->bindParam(":confrmcode", $confirm_code);
			$stmt->bindParam(":email", $user_email);
			$stmt->bindParam(":pass", $password);
			$stmt->bindParam(':utype', $user_type);
			// $stmt->bindParam(":jdate",$joining_date);
					
				if($stmt->execute()){
					echo "Sign up successfully ";
					$redirect_path = 'gmshopping.com/user/confirmation.php?passkey=$confirm_code';
					// echo "<script> alert('To Complete the sign up Click the below link.$redirect_path'); </script>";

					// $to 		= $user_email;
					// $subject 	= "SUBJECT";
					// $header		= "m.abdullah@devtrongenesis.com";

					// $message  = "Your Confirmation link \r\n";
					// $message .= "click on this to activate your account \r\n";
					// $message .= "gmshopping.com/confirmation.php?passkey=$confirm_code" ;

					// $sentmail = mail($to, $subject, $message, $header);
					
					// $sentmail = "$message" | mail -s "$subject" gmabdullah32@gmail.com;
					
					// echo "This is the body of the email" | mail -s "This is the subject line" m.abdullah@devtrongenesis.com

					// if($sentmail){
					// 	echo "Email sent ";
					// } else {
					// 	echo " Mail not sent";
					// }
				}
				else{
					echo "Insert Query could not execute !";
				}
			
			}
			else {
				
				echo "Try other email to register "; //  not available
			}
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>