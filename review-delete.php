<?php 
	session_start();
	// echo $_SESSION['uname'];
	try {

		include_once('db/dbconfig.php');

		if(isset($_GET['dreview']) && $_SESSION['uname']){

			$p_id = $_GET['id'];
		    $rid = $_GET['dreview'];
		    // var_dump($rid);
		    $stmt = $db_con->prepare("DELETE FROM reviews WHERE id = '$rid'");

		    $stmt->execute();
		    
		    header("location: product-detail.php?id=$p_id");

	    }else {

	    	echo "Can't deleted.";
	    }
			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
     
