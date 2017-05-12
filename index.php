<?php 
	session_start();
	include_once('db/dbconfig.php');

 ?>
<!doctype html>
<html class="no-js" lang="">
	<head>
	 <title> Main Page </title>
		<?php include_once('inc/header.php'); ?>


	</head>
  <body>
  <!-- Navbar -->
  <?php include_once('inc/nav.php'); ?>

		<div class="container-fluid mainpg-bg">
			
				<div class="col-md-4 col-md-offset-6">
					<h3>Try the shaving company <br>
							that's fixing shaving.
					</h3>
					<p>start a free trial, just cover shipping. </p>

					<button type="button" class="btn btn-default"> START TRIAL </button>
				</div>
		</div>

		<!-- Feactured Products -->
		<div class="container-fluid">
			<div class="row">
				<div class="text-center pd-t80 pd-b60">
					<h3>Featured Products</h3>
					<p>Products designed and formulated for a quality shave.</p>
				</div>
				<!-- products thumbnails -->
				<?php 
				try {
					$stmt = $db_con->query("SELECT * FROM products LIMIT 3");
					foreach($stmt as $row){

				 ?>
				<!-- First product -->
				<div class="col-xs-6 col-md-4 main-prdt">
					<a href="product-detail.php?id=<?php echo $row['id'] ?>">
				    <div class="thumbnail">
				      <img src="img/<?php echo $row['image']; ?>" alt="loading...">
				    </div>
				    <div class="product-text text-center">
				    	<span class="price"> $ <?php echo $row['price']; ?> </span> | <span class="color"> <?php echo $row['title']; ?> </span>
				    	<div class="most-popular mg-t10">
				    		<a href="product-detail.php?id=<?php echo $row['id'] ?>" class="btn btn-default ">View Details</a>
				    	</div>
				    </div>
			    </a>
			  </div>
			  <?php 

			  	}
				} catch (PDOException $e) {
					echo $e->getMessage();
				}
			   ?>

			</div><!-- /row -->
		</div>

			<!-- Image -->
		<div class="container pd-t80 pd-b80">
			<section class="row">
				<div class="col-md-6 fproduct-4">
					<h4> Looking to save <br>
									even more ? <br>
									Check out our <br>
					</h4>
					<p>Try for Free</p>
				</div>
				<div class="col-md-6 fproduct-5">
					<h4>Make it Personal</h4>
					<p>Engrave your Winston Handle <br> with up to 3 letters for a <br> more 
					personal touch.  </p>
					<p class="shopnow">Shop now</p>
				</div>
			</section>
		</div>
		<!-- Feactured End -->

		<!-- More on herry -->
		<div class="container">
			<div class="row">
				<div class="text-center pd-b50">
					<h2>More From Harry's </h2>
					<p>We do more than make razors, you know.</p>
				</div>
				<!-- more herry-1 -->
				<div class="col-sm-6 col-md-3 col-md-offset-1">
			    <div class="thumbnail">
			      <img src="img/more-herry-1.jpg" alt="loading...">
			      <div class="text-center">
			        <h3>Five O Clock Magazine</h3>
			        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
			      </div>
			    </div>
			  </div>
			  <!-- more herry-2 -->
			  <div class="col-sm-6 col-md-3 col-md-offset-1">
			    <div class="thumbnail">
			      <img src="img/more-herry-2.jpg" alt="loading...">
			      <div class="text-center">
			        <h3>Five O Clock Magazine</h3>
			        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
			      </div>
			    </div>
			  </div>
			  <!-- more herry-3 -->
			  <div class="col-sm-6 col-md-3 col-md-offset-1">
			    <div class="thumbnail">
			      <img src="img/more-herry-3.jpg" alt="loading...">
			      <div class="text-center">
			        <h3>Five O Clock Magazine</h3>
			        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
			      </div>
			    </div>
			  </div>

			</div><!-- /row -->
		</div>
		<!-- /More on herry -->

	<?php include_once('inc/footer.php'); ?>
		
  </body>

</html>