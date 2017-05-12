<?php
session_start();
	$_SESSION["cart_item"];
 try {
 	// echo "<pre>";
		// 					var_dump($_SESSION["cart_item"]);
		// 					echo "</pre>";
	// require_once("db/dbcontroller.php");
	// $db_handle = new DBController();
	// var_dump($_SESSION['cart_item']);
	// var_dump($_POST['quantity']);
		if(!empty($_GET["action"])) {

			switch($_GET["action"]) {

				case "add":
					if(!empty($_POST["quantity"])) {
						$stmt = $db_con->query("SELECT * FROM products WHERE id='" . $_GET["id"] . "'");
						
						foreach ($stmt as $row) {
              $resultset[] = $row;
            }
            if (!empty($resultset)) {
              $productByCode = $resultset;
              $itemArray = array($productByCode[0]["id"]=>array(
                              // 'id'      =>  $productByCode[0]["id"],
                              'id'    =>  $productByCode[0]["id"],
                              'title'   =>  $productByCode[0]["title"],
                              'quantity'=>  $_POST["quantity"],
                              'price'   =>  $productByCode[0]["price"],
                              'image'   =>  $productByCode[0]["image"])
                          );
            }
							// if cart not empty then run it
						if(!empty($_SESSION["cart_item"])) {

							if(in_array($productByCode[0]["id"],array_keys($_SESSION["cart_item"]))) {

								foreach($_SESSION["cart_item"] as $k => $v) {
										
										if($productByCode[0]["id"] == $k) {

											if(empty($_SESSION["cart_item"][$k]["quantity"])) {

												$_SESSION["cart_item"][$k]["quantity"] = 0;
											}
											$_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
										}
								} // END foreach

							} else {
								$_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
							}

						} else {
							$_SESSION["cart_item"] = $itemArray;
						}
					}
				break;

				case "remove":
					if(!empty($_SESSION["cart_item"])) {
						// echo "<pre>";
						// 	var_dump($_SESSION["cart_item"]);
						// 	echo "</pre>";
						foreach($_SESSION["cart_item"] as $k => $v) {

							if($_GET["id"] == $_SESSION["cart_item"][$k]['id'])
								unset($_SESSION["cart_item"][$k]);				
							if(empty($_SESSION["cart_item"]))
								unset($_SESSION["cart_item"]);
						}
					}
				break;

				case "empty":
					unset($_SESSION["cart_item"]);
				break;	

				case "update":
					if(!empty($_SESSION['cart_item'])){

						// not getting quantity from FORM yet
						$up_quantity = $_GET['quantity'];

						foreach($_SESSION["cart_item"] as $k => $v) {

							if($_GET["id"] == $_SESSION["cart_item"][$k]['id'])
								// echo '<pre>';
								// var_dump($_SESSION["cart_item"][$k]);				
								// echo '</pre>';
								$_SESSION["cart_item"][$k]['quantity'];
								
						}
					}
				break;
			}
		}
		} catch (PDOException $e) {
 				echo $e->getMessage();
 }
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include_once('inc/header.php'); ?>
		<title>Cart Page</title>
		<!-- CSS -->
  	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/main.css">
	</head>
<body>
	<!-- navbar -->
	<?php include_once('inc/nav.php');  ?>

	<div class="container mg-b100">
		<div id="row">
		<div class="col-md-12">
		<h3> Cart Page</h3>
			<!-- <div class="txt-heading">Shopping Cart  -->
				<a class="btn btn-primary pull-right" href="addtocart.php?action=empty">Empty Cart</a>
			<!-- </div> -->
		<?php
		try {
			
			if(isset($_SESSION["cart_item"])){
			    $item_total = 0;

		?>	
			<table class="table table-hover table-responsive">
				<thead>
				<tr>
					<th> Products </th>
					<th> Price </th>
					<th> Quantity </th>
					<th> Action </th>
				</tr>
				</thead>
				<tbody>
					<form action="checkout.php" method="post" >
					<?php		
						// foreach START
				    foreach ($_SESSION["cart_item"] as $item){
					?>
							<tr>
								<!-- product image, title and remove link -->
								<td class="col-xs-4"> 
									<img src="img/<?php echo $item['image']; ?>" height="70" width="70" alt="loading...">
									<span><?php echo $item["title"]; ?></span>
									<p><a href="addtocart.php?action=remove&id=<?php echo $item["id"]; ?>">Remove</a></p> 
								</td>

								<!-- price -->
								<td class="col-xs-2"> 
									$ <?php echo $item["price"]; ?> 
								</td>
								<!-- <form action="addtocart.php?action=update&id=<?php //echo $item['id']; ?>&quantity=quantity" method="get"> -->
									<!-- quantity -->
									<td class="col-xs-1">  
										<input type="number" name="quantity" class="form-control" value="<?php echo $item["quantity"]; ?>" size="2" min="1" max="10" />
									</td>

									<!-- Update Record -->
									<td class="col-xs-2"> 
										<!-- <?php //print_r($item["price"] * $item["quantity"]); ?> -->
										<a href="addtocart.php?action=update&id=<?php echo $item['id']; ?>&quantity=quantity" class="btn btn-default" >Update</a>
										<!-- <input type="submit" class="btn btn-default" value="Update"> -->
									</td>
								<!-- </form> -->
							</tr>
					<?php
								// Grand total
				        $item_total += ($item["price"] * $item["quantity"]);

					}
								// Discount 10%
								$discounted_price = $item_total - ($item_total * 0.10);
					?>

							<tr>
								<td  colspan="5" style="text-align:right;"> <strong>Total : </strong> 
									<span > <?php echo "$".$discounted_price; ?> </span> 

									<!-- hidden fields -->
									<input type="hidden" name="disc_price" value="<?php echo $discounted_price; ?>">
								</td>
							</tr>
				</tbody>
			</table>

			<div class="row">
				<button class="btn btn-default pull-right" name="checkout" type="submit" > Checkout </button>	
			</div>

			</form>	
		<?php
			}
			//End Foreach 
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		?>
		</div>
		</div> <!-- End row -->
	</div> <!-- END main container -->

</body>
</html>
