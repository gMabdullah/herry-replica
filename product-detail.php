<?php 
  session_start();
  include_once('db/dbconfig.php');
  // include_once('../includes/class.crud.php');
  // var_dump($_SESSION['cart_item']);
  
  $admin  = $_SESSION['admin'];
  $u_id   = $_SESSION['id'];
  $body   = $_POST['review'];
  
  
  try {  // getting cart data
  
    // require_once("db/dbcontroller.php");
    // $db_handle = new DBController();

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

                if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {

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
        }
    }
    } catch (PDOException $e) {
        echo $e->getMessage();
 }
  // Inserting reviews
  try {
      
    if(isset($_GET['id'])){

      $p_id = $_GET['id'];
      
      if(isset($_POST['review-btn'])){

        $stmt = $db_con->prepare("INSERT INTO reviews (product_id, user_id, body) VALUES (:pid, :uid, :body)");

        $stmt->bindParam(':pid', $p_id);
        $stmt->bindParam(':uid', $u_id);
        $stmt->bindParam(':body', $body);

        $stmt->execute();
      }

    }  
  } catch (PDOException $e) {

    echo $e->getMessage();
  }
  // End Inserting reviews
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Product Detail Page</title>
  <?php include_once('inc/header.php'); ?>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/main.css">
  <link rel="stylesheet" href="assets/css/product-detail.css">
  
</head>
<body>   
      <?php include_once('inc/nav.php'); ?>
    <div class="container">
    	<div class="row">
      <?php 
      
        // $crud->getAll($p_id, 'products');
          
          $stmt = $db_con->prepare("SELECT p.id, p.owner_id, p.image, p.title, p.body, p.price, p.color,
                                  p.quantity, u.user_name 
                                  FROM products AS p
                                  INNER JOIN users AS u
                                  ON u.user_id = p.owner_id
                                  WHERE p.id = '$p_id'");
          $stmt->execute();
          $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
          // START foreach
          foreach($row as $key=>$value){ 
            // var_dump($row);
            $p_ownerId = $row['owner_id'];
       ?>
       <!-- image -->
       <div class="col-xs-4 col-md-6 item-photo">
            <img style="max-width:100%;" src="img/<?php echo $row[$key]['image']; ?>" />
        </div>
        <!-- Product description -->
        <div class="col-xs-5 col-md-6 pro-detail">

            <!-- Product heading-->
            <h3> <?php echo $row[$key]['title']; ?> </h3>   
              <strong><?php echo $row[$key]['user_name']; ?>&nbsp;| 
              <a href="#">All Products</a>&nbsp;| 
              <small>99.8 % Positive Rating</small>
            </strong>

            <!-- if user is Super Admin then show the Delete button -->
            <?php  

              if($admin){ 
                // var_dump($admin);
            ?>

                <a href="del-product.php?id=<?php echo $p_id; ?>" class="btn btn-danger pull-right" name="dproduct">Delete Product</a> 

            <?php } ?>

            <!-- Price -->
            <h6 class="title-price">Price</h6>
            <h4 > $ <?php  echo $row[$key]['price']; ?></h4>

            <!-- Color -->
            <div class="section">
                <h6 class="title-attr" style="margin-top:15px;" > COLOR </h6>
                <div> <?php echo $row[$key]['color']; ?> </div>
            </div>

          <!-- Add to cart Form -->
          <form method="post" action="product-detail.php?action=add&id=<?php echo $row[$key]['id']; ?>">
            <!-- Quantity -->
            <div class="section" style="padding-bottom:20px;">
                <h6 class="title-attr"> Available in stock: </h6>
                <div> <?php  echo $row[$key]['quantity']; ?> </div>
                <!-- quantity -->
                <input type="number" class="col-xs-2 col-md-3" name="quantity" value="1" size="2" min="1" max="100" />
            </div>                
            <br>
            <!-- Buy Button -->
            <div class="section" style="padding-bottom:20px;">
              <button class="btn btn-success" type="submit">
                <span style="margin-right:20px;" class="fa fa-shopping-cart" aria-hidden="true"></span>
                Add to Cart
              </button>
            </div>
          </form>
          <!-- End add to cart Form -->

        </div>      
        <div class="col-xs-9">
          <h3>Product Description</h3>
          <p> <?php echo $row[$key]['body']; ?> </p>
        </div>

        <?php } // END foreach ?>

        <!-- bottom menu tabs -->
        <div class="col-xs-9 col-md-12 col-offset-xs-2">
          <div class="col-xs-12 col-md-10 ">

          <h3>Reviews</h3>
          <!-- Inserting reviews Form -->
          <?php 

              if($u_id !== $p_ownerId){ 

           ?>
            <form method="post" action="">
              <input type="text" name="review" class="form-control">
              <input type="submit" class="btn btn-default pull-right" value="Review" name="review-btn"><br>
            </form>
          <?php } ?>
          
          <?php 
            // selecting review of that product
          try {

           //$stmt = $db_con->query("SELECT * FROM reviews WHERE product_id = '$p_id'");
            $stmt = $db_con->query("SELECT u.user_name, u.image, r.id, r.user_id, r.body
                                    FROM users AS u
                                    INNER JOIN reviews AS r 
                                    ON u.user_id = r.user_id WHERE r.product_id='$p_id'
                                    ORDER BY r.id DESC");

           // selecting reviews specific to that product
            foreach($stmt as $row){

          ?>
          <!-- review template -->
          <div class="well">
            <!-- <div class="row-fluid"> -->
            <?php
              $user_id = $row['user_id'];

                // Getting image and username form Users Table 
             // $stmt = $db_con->query("SELECT user_name, image FROM users WHERE user_id = '$user_id'");
              // $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                ?>
                  <div class="review-img"> 
                    <img src="img/<?php echo $row['image']; ?>" style="width: 70px;">
                  </div>
                  <strong class="name"> <?php echo $row['user_name']; ?> </strong>
                <?php 

                  if($u_id == $user_id || $p_ownerId == $u_id){

                    if($u_id == $user_id){

                ?>
                      <a href="review-edit.php?id=<?php echo $p_id; ?>&edtreview=<?php echo $row['id']; ?>&rbdy=<?php echo $row['body']; ?>"> 

                      Edit </a> &nbsp; | &nbsp;

              <?php } ?>

                      <a href="review-delete.php?id=<?php echo $p_id; ?>&dreview=<?php echo $row['id']; ?>" name="dreview"> Delete </a>
                
           <?php  } ?>
              
                  <div class="review-body"> <?php echo $row['body']; ?>  </div>
              
            <!-- </div> -->
          </div>
          <!-- /End review template -->
          <?php
            } //outer foreach
          } catch (PDOException $e) {
            echo $e->getMessage();
          }
          // End of selecting review of that product
          ?>
          </div>
            
        </div>	

    	</div> <!-- /row -->
    </div>

 <?php include_once('inc/footer.php'); ?>
  
</body>
</html>
