<?php 
	session_start();
	include_once('inc/checksession.php');
	include_once('db/dbconfig.php');	
	$customer_id = $_SESSION['id'];

  require_once('inc/braintree/lib/Braintree.php');
  
  try {
    $total_price  = $_POST['disc_price'];
    $shipping = '5';
    
    Braintree_Configuration::environment('sandbox');
    Braintree_Configuration::merchantId('4vy4mjgkjq5g42w4');
    Braintree_Configuration::publicKey('j6kgrprk7btq8dzn');
    Braintree_Configuration::privateKey('4ce7b4e9235bd1c85a6cb9c3ee6160e7');

    $clientToken = Braintree_ClientToken::generate();

  // END Braintree integration
  } catch (PDOException $e) {
    echo $e->getMessage();
  }

	
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once('inc/header.php'); ?>
	<title>Checkout Page</title>
	<!-- CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

</head>
<body>

  <div class="container">
    <div class="row">
    <h3>Checkout Page</h3>
    <hr>

        <form method="post" action="checkout-submission.php" id="payment-form">
          <div class="col-md-4">

            <h4>Shipping Details</h4>
            <hr>
            <input type="text" class="form-control" name="shp-addr" placeholder="Shipping Address"> <br>

            <input type="text" class="form-control" name="shp-city" placeholder="City">
            <br>
            <input type="text" class="form-control" name="postal-code" placeholder="Postal code">
          </div>

          <!-- Order Summary -->
          <div class="col-md-4">

          <h4>Order Summary</h4>
          <table class="table table-hover table-responsive">
            <tbody>
            <?php 
              foreach ($_SESSION["cart_item"] as $item){
             ?>
             <!-- All products -->
              <tr>
                <td><?php echo $item["title"]; ?></td>
                <td > <?php echo $item["quantity"]; ?> </td>
              </tr>

             <?php } ?>
              <!-- Subtotal -->
              <tr>
                <td> Subtotal: </td>
                <td > <strong> $ <?php echo $total_price; ?> </strong> </td>
              </tr>
              <!-- shipping amount -->
              <tr>
                <td> Shipping: </td>
                <td > <strong> $ <?php echo $shipping; ?> </strong> </td>
              </tr>
              <tr>
                <td>Total: </td>
                <td> 
                  <strong> $ <?php echo $grand_total = $total_price + $shipping; ?> </strong> </td>
              </tr>
            </tbody>
          </table>
          </div>
          <!-- END Order Summary -->

          <!-- Payment Details -->
          <div class="col-md-4">

            <h4>Payment Details</h4>
              <!-- Dropin form fields -->
              <div id="dropin-container"></div>
              <!-- Amount field -->
              <!-- <input id="amount" name="amount" class="form-control" type="tel" min="1" placeholder="Amount" value="10"> -->
              <br>
              <input type="hidden"  name="grand-total" value="<?php echo $grand_total; ?>">
              <!-- purchase button -->
              <button id="submitbutton" type="submit" name="submitTodb" class="btn btn-primary btn-block"> Purchase </button>
            <!-- END Payment Details -->
          </div>

        </form>

        <script src="https://js.braintreegateway.com/js/braintree-2.27.0.min.js"></script>
        
        <script>
          var client_token = "<?php echo $clientToken; ?>";
          braintree.setup(client_token, "dropin", {
              container: "dropin-container"
          });
        </script>

      </div>
    </div>

</body>
</html>