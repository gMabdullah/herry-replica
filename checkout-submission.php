<?php 
	session_start();
	include_once('inc/checksession.php');
	include_once('db/dbconfig.php');	
	$customer_id = $_SESSION['id'];

  require_once('inc/braintree/lib/Braintree.php');

  try {

      Braintree_Configuration::environment('sandbox');
      Braintree_Configuration::merchantId('4vy4mjgkjq5g42w4');
      Braintree_Configuration::publicKey('j6kgrprk7btq8dzn');
      Braintree_Configuration::privateKey('4ce7b4e9235bd1c85a6cb9c3ee6160e7');
    // Braintree integration
    // if(isset($_POST['submit-button'])){
      	$shp_addr 	 = $_POST['shp-addr'];
      	$shp_city 	 = $_POST['shp-city'];
      	$postal_code = $_POST['postal-code'];
      	$grand_total = $_POST['grand-total'];
        // $amount 	 = $_POST["amount"];
        $nonce 		 = $_POST["payment_method_nonce"];


        $result = Braintree_Transaction::sale([
                  // 'amount' => $amount,
        				'amount' => $grand_total,
                'paymentMethodNonce' => $nonce,
                'options' => [ 'submitForSettlement' => true ]
                ]);

        if ($result->success) {
            print_r("success!: " . $result->transaction->id);
        } else if ($result->transaction) {
            print_r("Error processing transaction:");
            print_r("\n  code: " . $result->transaction->processorResponseCode);
            print_r("\n  text: " . $result->transaction->processorResponseText);
        } else {
            print_r("Validation errors: \n");
            print_r($result->errors->deepAll());
        }

    // }
  // END Braintree integration
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

	try {

		// if(!empty($_SESSION['cart_item'])){
			// if(isset($_POST['submitTodb'])){

				$transaction_id = $result->transaction->id;
				$date	= date('l');
				// inserting in order table
				$stmt = $db_con->prepare("INSERT INTO orders (trans_id, customer_id, total, created_at, shp_addr, city, postal_code) VALUES (:trans_id, :cust_id, :total, :created_at,:shp_addr, :city, :postal_code)");

				$stmt->bindParam(':trans_id', $transaction_id);
				$stmt->bindParam(':cust_id', $customer_id);
				$stmt->bindParam(':total', $grand_total);
				$stmt->bindParam(':created_at', $date);
				$stmt->bindParam(':shp_addr', $shp_addr);
				$stmt->bindParam(':city', $shp_city);
				$stmt->bindParam(':postal_code', $postal_code);

				// data need to be set later
				$stmt->execute();

				$lst_id = $db_con->lastInsertId();

				foreach($_SESSION['cart_item'] as $item){

					$each_ord_price = $item['price'] * $item['quantity'];
					
					$stmt = $db_con->prepare('INSERT INTO order_products (order_id, product_id, p_name, quantity, price) VALUES (:lst_ord_id, :product_id, :p_name, :quantity, :price)');

					$stmt->bindParam(':lst_ord_id', $lst_id);
					$stmt->bindParam(':product_id', $item['id']);
					$stmt->bindParam(':p_name', $item['title']);
					$stmt->bindParam(':quantity', $item['quantity']);
					$stmt->bindParam(':price', $each_ord_price);

					if ($stmt->execute()) {
						echo 'Inserted';
					} else {
						echo 'not inserted';
					}
					
					
				}
			
		// }// END isset 
	// }
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once('inc/header.php'); ?>
	<title>Checkout Submission Page</title>
	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<!-- Custom CSS -->
	<!-- <link rel="stylesheet" href="assets/css/main.css"> -->

</head>
<body>
	<?php include_once('inc/nav.php'); ?>
	<div class="container">
		<div class="row">
		<h3>Successfully order Placed</h3>
		
    <hr>
    
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eveniet aspernatur quo ipsa tempora, reiciendis tenetur quas ab perspiciatis ullam sunt soluta nesciunt iure in quae voluptas, neque, temporibus eum dolores!</p>
    </div>
  </div>

</body>
</html>