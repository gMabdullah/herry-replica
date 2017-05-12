<?php 
   session_start();
  if(!isset($_SESSION['uname'])){

    header("location: signup.php");

  }
  include_once('db/dbconfig.php');

  $u_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Products specific to Owners</title>

  <?php  include_once("inc/header.php");  ?>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/product-thumbnail.css">
  <!-- <link rel="stylesheet" href="css/bootstrap-imageupload.min.css"> -->
</head>

<body>
 

  <div class="container">
    <div class="row">
    <?php
    try {
        // Find out how many items are in the table
        $total = $db_con->query("SELECT COUNT(*) FROM products WHERE owner_id='$u_id'")->fetchColumn();

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

        // Display the paging information
        echo '<ul class="pager pagination-lg" id="paging"><li>', $prevlink, ' Page ', $page, ' of ', $pages, ' pages, displaying ', $start, '-', $end, ' of ', $total, ' results ', $nextlink, ' </li></ul>';

        // Prepare the paged query
        $stmt = $db_con->prepare("SELECT * FROM products WHERE owner_id='$u_id' ORDER BY id LIMIT :limit OFFSET :offset");
        // Bind the query params
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        // Do we have any results?
        if ($stmt->rowCount() > 0) {
            // Define how we want to fetch the results
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $iterator = new IteratorIterator($stmt);

            // Display the results
            foreach ($iterator as $row) {
            ?>

             <div class="col-md-4">
                <div class="product-item">
                  <div class="pi-img-wrapper">
                    <img src="img/<?php echo $row['image']; ?>" class="img-responsive" alt="loading..." height="200" width="200">
                    <div>
                      <a href="#" class="btn">Zoom</a>
                      <a href="product-detail.php?id=<?php echo $row['id']; ?>" class="btn">View</a>
                    </div>
                  </div>
                  <h3><a href="shop-item.html"><?php echo $row['title']; ?></a></h3>
                  <div class="pi-price">$ <?php echo $row['price']; ?></div>
                  <a href="javascript:;" class="btn add2cart">Add to cart</a>
                  <!-- <div class="sticker sticker-new"></div> -->
                </div>
            </div>

            <?php
            }

        } else {
            echo '<p>No results could be displayed.</p>';
        }

    } catch (Exception $e) {
        echo '<p>', $e->getMessage(), '</p>';
    }
?>
    </div> <!-- row -->
  </div>
  <!-- container -->
  <?php include_once('inc/footer.php'); ?>
</body>
</html>
