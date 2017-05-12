<?php 
   session_start();
  include_once('db/dbconfig.php');
  // include_once('db/dbcontroller.php');
  $admin = $_SESSION['admin'];

  try {
    
    // add to cart db connection
    // include_once("db/dbcontroller.php");
    // $db_handle = new DBController();
    // add to cart section
    if(!empty($_GET["action"])) {

      switch($_GET["action"]) {
        // Add items to cart
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
        // Remove items from cart
        case "remove":
          if(!empty($_SESSION["cart_item"])) {

            foreach($_SESSION["cart_item"] as $k => $v) {

                if($_GET["id"] == $k)
                  unset($_SESSION["cart_item"][$k]);        
                if(empty($_SESSION["cart_item"]))
                  unset($_SESSION["cart_item"]);
            }
          }

        break;
        // Empty cart
        case "empty":
          unset($_SESSION["cart_item"]);
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
  <title>All Products </title>

  <?php  include_once("inc/header.php");  ?>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/product-thumbnail.css">
  <link href="assets/css/main.css" type="text/css" rel="stylesheet" />
</head>

<body>
 
  <?php include_once('inc/nav.php'); ?>
  
  <div class="container-fluid">
    <div class="row">
    <?php
    try {
        // Find out how many items are in the table
        $total = $db_con->query("SELECT COUNT(*) FROM products")->fetchColumn();

        // How many items to list per page
        $limit = 6;

        // How many pages will there be
        $pages = ceil($total / $limit);

        // What page are we currently on?
        $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
            'options' => array(
                'default'   => 1,
                'min_range' => 1,
            ),
        )));

        // Calculate the offset for the query
        $offset = ($page - 1)  * $limit;

        // Some information to display to the user
        $start = $offset + 1;
        $end = min(($offset + $limit), $total);

        // The "back" link
        $prevlink = ($page > 1) ? '<a href="?page=1" title="First page">&laquo;</a> <a href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span class="disabled">&laquo;</span> <span class="disabled">&lsaquo;</span>';
        
        // The "forward" link
        $nextlink = ($page < $pages) ? '<a href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span class="disabled">&rsaquo;</span> <span class="disabled">&raquo;</span>';

        // Prepare the paged query
        $stmt = $db_con->prepare("SELECT * FROM products ORDER BY id ASC LIMIT :limit OFFSET :offset");
        // Bind the query params
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        // Do we have any results?
        if ($stmt->rowCount() > 0) {
            // Define how we want to fetch the results
          $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // $stmt->setFetchMode(PDO::FETCH_ASSOC);
            // $row = new IteratorIterator($stmt);
            // Display the results
            foreach ($row as $key=>$value) {
            ?>
            <!-- var_dump($row); -->

            <div class="col-md-4">
              <div class="product-item">

              <form method="post" action="all-products.php?action=add&id=<?php echo $row[$key]['id']; ?>">

                <div class="pi-img-wrapper">
                  <a href="product-detail.php?id=<?php echo $row[$key]['id']; ?>">
                    <img src="img/<?php echo $row[$key]['image']; ?>" class="img-responsive" alt="loading..." >
                  </a>
                  <!-- hover buttons -->
                  <!-- <div>
                    <a href="#" class="btn">Zoom</a>
                    View
                  </div> -->
                </div>

                <!-- Product-title -->
                <h3> <?php echo $row[$key]['title']; ?> </h3>
                <!-- price -->
                <div class="pi-price">$ <?php echo $row[$key]['price']; ?> </div>
                <!-- add to cart -->
                <input type="submit" class="btn add2cart" value="Add to cart">
                <!-- quantity -->
                <input type="number" class="form-control mg-t10" name="quantity" value="1" size="2" min="1" max="100" />
              </form>

                <!-- <div class="sticker sticker-new"></div> -->
              </div>
            </div>

            <?php
            }
            ?>
    </div> <!-- row -->

  <!-- Display the paging buttons -->
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
    <?php  
          // Display the paging buttons
      echo '<ul class="pager pagination-lg" id="paging"><li>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </li></ul>';
          // End Display the paging buttons
      ?>
    </div>
  </div>
  <!-- End Display the paging buttons -->
        <?php
        } else {
            echo '<p>No results could be displayed.</p>';
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
  ?>
</div><!-- container -->  
  
  <?php include_once('inc/footer.php'); ?>

</body>
</html>
