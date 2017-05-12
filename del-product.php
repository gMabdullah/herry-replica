<?php 
	session_start();
	try {

		include_once('db/dbconfig.php');

		if(isset($_GET['id'])){

			$p_id = $_GET['id'];
		    // $rid = $_GET['dreview'];
		    var_dump($p_id);

		    $stmt = $db_con->prepare("DELETE FROM products WHERE id = '$p_id'");

		    $stmt->execute();
		    
		    // header("location: product-detail.php?id=$p_id");
		    header("location: all-products.php?id='$p_id'");

		    }else {

		    	echo "not deleted";
		    }
		
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
     
