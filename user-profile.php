<?php	
		session_start();

	if(!isset($_SESSION['uname'])){

		header("location: signup.php");

	}

	include_once('db/dbconfig.php');

		$id 		= $_SESSION['id'];
		$uname 	= $_SESSION['uname'];
		$email 	= $_SESSION['email'];
		$pass 	= $_SESSION['password'];
		$img 		= $_SESSION['image'];
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once('inc/header.php'); ?>
	<title>Profile <?php echo $uname; ?></title>
	<!-- user-profile css -->
	<link rel="stylesheet" href="assets/css/user_profile.css">
	
</head>
<body>
	<?php include('inc/nav.php'); ?>

	<!-- CONTAINER -->
	<div class="container-fluid gry-bg" style='border-top:none;'>
	  <div class="row profile">
	  <!-- col-md-3 -->
			<div class="col-md-3">
				<div class="profile-sidebar">
					<?php 
						try {

							$stmt = $db_con->query("SELECT image FROM users WHERE user_id= '$id'");
							foreach($stmt as $row){

					 ?>
					<!-- SIDEBAR USERPIC -->
						<img src="img/<?php echo $row['image']; ?>" class="img-responsive img-circle center-img" alt="Loading ..." width="150">

					<?php 
							}
						} catch (PDOException $e) {
							$e->getMessage();
						}
					?>

					<!-- SIDEBAR MENU -->
					<div class="profile-usermenu">
						<ul class="nav nav-tabs nav-stacked">
					    <li class="active"><a href="#profile">Profile</a></li> 
					    <li><a href="all-products.php">All Product</a></li>
					    <li><a href="logout.php">Logout</a></li>
					  </ul>
					</div>
					<!-- END MENU -->
				</div>
			</div>
			<!-- /col-md-3 -->

			<!-- col-md-9 -->
			<div class="col-md-9">
        <div class="profile-content">
        <?php 

	        try {

				if(isset($_POST['update'])){

					$uname 	= $_POST['uname'];
					$email 	= $_POST['email'];
					$pass 	= $_POST['pass'];
					$img 		= $_FILES['image']['name'];

					$target = "img/" . basename($_FILES['image']['name']);

					$sql = "UPDATE users SET user_name = :uname, user_email = :email, user_password = :pass, image = :img WHERE user_id = :id";

					$stmt = $db_con->prepare($sql);
					// var_dump($img);
					/*
					/ Uname, email, pass and id placeholder 
					/ must be same as above in query
					*/
					$stmt->execute([
								'uname' => $uname,
								'email' => $email,
								'pass' 	=> $pass,
								'img' 	=> $img,
								':id'		=> $id
								]);
					// echo $result = $stmt->rowCount();

					}

				if(move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

						echo "image uploaded";

					}

						} catch(PDOException $e){

							$e->getMessage();
						}
         ?>
					
	        <form action="user-profile.php" method="post" name="account-info" enctype="multipart/form-data">
	        	<h4> Update Account Information: </h4>
						<div class="form-group">
		          <label for="user-name" class="form-control-label">Username: </label>
		          <input type="text" class="form-control" name="uname" id="user-name" value="<?php echo $uname; ?>" required >
		        </div>

		        <div class="form-group">
		          <label for="user-email" class="form-control-label">Email :</label>
		          <input type="email" class="form-control" name="email" id="user-email" value="<?php echo $email; ?>" required >
		        </div>

		        <div class="form-group">
		          <label for="user-pass" class="form-control-label">Password :</label>
		          <input type="pass" class="form-control" name="pass" id="user-pass" value="<?php echo $pass; ?>" required >
		        </div>
		        <!-- Profile image -->
		        <input type="file" name="image" class="form-control">
						<br>
		        <input type="submit" name="update" value="Update" class="btn btn-primary form-control">
					</form>

        </div>
			</div>
			<!-- /col-md-9 -->
		</div>
	</div>
	<!-- /CONTAINER -->

</body>
</html>