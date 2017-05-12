<?php 
session_start();

	try {

		include_once('db/dbconfig.php');

		$p_id = $_GET['id'];
	    $rbody = $_GET['rbdy'];

	    // if(isset($_GET['edtreview'])){

	    		$rid = $_GET['edtreview'];

				if(isset($_POST['uptbtn']) && $_SESSION['uname']){
					// echo $rid;
	    		$ureview = $_POST['upt-review'];
	    		// var_dump($rid);
					// echo "hello there";
		      // var_dump($rid);
		      // $stmt = $db_con->prepare("DELETE FROM reviews WHERE id = '$rid'");
		      $stmt = $db_con->prepare("UPDATE reviews SET body = :body WHERE id = '$rid'");

		      $stmt->bindparam(':body', $ureview);
		      
		      $stmt->execute();
		      
		      header("location: product-detail.php?id=$p_id");

		    } //else {

		    // // 	echo "Not entered in isset";
		    // // }
		//}
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit Page </title>
	<?php 
		include_once('inc/header.php');
	 ?>
	 <!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	
</head>
<body>

	<?php include_once('inc/nav.php'); ?>

	<div class="container">
		<div class="col-md-6">
			<form action="" method="post">
				<input type="text" name="upt-review" value="<?php echo $rbody; ?>">
				<input type="submit" name="uptbtn" class="btn btn-default" value="Update">
			</form>
		</div>
	</div>

	<!-- Jquery -->
  <script src="assets/js/jquery-1.12.4.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>