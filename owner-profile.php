<?php	
	
	include_once('inc/checksession.php');


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
	<title>Profile <?php echo $uname; ?></title>
	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="assets/css/user_profile.css">
	<!-- <link rel="stylesheet" href="css/bootstrap-imageupload.min.css"> -->
	
</head>
<body>
	<!-- CONTAINER -->
	<div class="container-fluid gry-bg">
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
						<ul class="nav nav-pills">
							<li>
								<a href="products.php">
								<i class="glyphicon glyphicon-home"></i>
								Products </a>
							</li>
							<li class="active">
								<a href="#">
								<i class="glyphicon glyphicon-user"></i>
								Account Settings </a>
							</li>
							<li>
								<a href="#" target="_blank">
								<i class="glyphicon glyphicon-ok"></i>
								Tasks </a>
							</li>
							<li>
								<a href="logout.php">
								<i class="glyphicon glyphicon-flag"></i>
								Logout </a>
							</li>
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
					
	        <form action="owner-profile.php" method="post" name="account-info" enctype="multipart/form-data">
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
		        <input type="file" name="image">
		        <input type="submit" name="update" value="Update" class="btn btn-primary">
					</form>

					<!-- create product  -->
					<form action="create-product.php" method="post" name="create-product" enctype="multipart/form-data">
	        	<h4> Create Products </h4>
	        	<!-- Title -->
						<div class="form-group">
		          <label for="title" class="form-control-label">Title: </label>
		          <input type="text" class="form-control" name="title" id="title" value="" required >
		        </div>
						<!-- Description -->
		        <div class="form-group">
		          <label for="body" >Description :</label>
		          <textarea name="body" class="form-control" id="" rows="4">
		          	
		          </textarea>
		        </div>
						<!-- Price -->
		        <div class="form-group col-xs-3">
		          <label for="price" >Price :</label>
		          <input type="pass" class="form-control" name="price" value="" required  >
		        </div>
		        <!-- Quantity -->
						<div class="col-xs-2">
							<label for="quantity">Quantity: </label>
							<input type="number" class="form-control" name="quantity" min="1" maxlength="2" >
						</div>
		        <!-- Color -->
		        <label for="color">Color :</label>
		        <label class="radio-inline"><input type="radio" name="color" value="orange" >Orange</label>
						<label class="radio-inline"><input type="radio" name="color" value="blue" >Blue</label>
						<label class="radio-inline"><input type="radio" name="color" value="green" >Green</label>
						
						<!-- image upload -->
						<input type="file" name="image">

		        <input type="submit" name="create-product" value="Create Product" class="btn btn-primary">
					</form>
					<!-- /create product  -->
        </div>
			</div>
			<!-- /col-md-9 -->
		</div>
	
	</div>
	<!-- /CONTAINER -->

	<!-- Jquery -->
  <script src="assets/js/jquery-3.1.1.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- <script src="assets/js/bootstrap-imageupload.js"></script> -->

</body>
</html>