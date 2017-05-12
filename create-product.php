<?php 
	session_start();

	if(!isset($_SESSION['uname'])){

		header("location: signup.php");

	}

	include_once('db/dbconfig.php');

try {

	$owner_id	= 	$_SESSION['id'];
	$p_title	=	$_POST['title'];
	$p_body		=	$_POST['body'];
	$p_price	=	$_POST['price'];
	$p_color	=	$_POST['color'];
	$p_quantity	=	$_POST['quantity'];
	$p_img 		= 	$_FILES['image']['name'];

	if(isset($_POST['create-product'])){

		$target = "img/" . basename($_FILES['image']['name']);

		$stmt = $db_con->prepare("INSERT INTO products (owner_id, title, body, price, color, quantity, image) VALUES (:owner_id, :title, :body, :price, :color, :quantity, :img)");

		$stmt->bindParam(':owner_id', $owner_id);
		$stmt->bindParam(':title', $p_title);
		$stmt->bindParam(':body', $p_body);
		$stmt->bindParam(':price', $p_price);
		$stmt->bindParam(':color', $p_color);
		$stmt->bindParam(':quantity', $p_quantity);
		$stmt->bindParam(':img', $p_img);

		if($stmt->execute()){

			if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

				header("location: owner-products.php");
			}
			

		} else{
			echo 'not executed';
		}

		
	}

} catch (PDOException $e) {
		echo $e->getMessage();
}
 ?>