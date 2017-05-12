<!doctype html>
<html class="no-js" lang="">
   <head>
   <title> Sign Up Page </title>
    <?php 
      require_once('db/dbconfig.php');
      include_once('inc/header.php'); 
    ?>
     
  </head>
  <body>
    <!-- NAVBAR -->
    <?php include_once('inc/nav.php'); ?>
    <!-- /NAVBAR -->
    
      <?php 
        if(isset($_POST['user_type']))
          {
            $user_name = $_POST['u_name'];
            $user_email     = $_POST['u_email'];
            $user_password  = $_POST['password'];
            $user_type      = $_POST['user_type'];
            
            // $password = md5($user_password);
            $password = $user_password;

            try
            { 
              // checking if email already registered 
              $stmt = $db_con->prepare("SELECT * FROM users WHERE user_email=:email");
              $stmt->execute(array(":email"=>$user_email));
              $count = $stmt->rowCount();
              
              if($count == 0){
                // if email is not found in tmp_user

                //create randum id for every unique user
                $confirm_code = md5(uniqid(rand()));

                $stmt = $db_con->prepare("INSERT INTO tmp_tbl (confirm_code, user_name, email, password, user_type) VALUES(:confrmcode, :uname, :email, :pass, :utype)");

                $stmt->bindParam(":confrmcode", $confirm_code);
                $stmt->bindParam(":uname", $user_name);
                $stmt->bindParam(":email", $user_email);
                $stmt->bindParam(":pass", $password);
                $stmt->bindParam(':utype', $user_type);
                // $stmt->bindParam(":jdate",$joining_date);
                  
                if($stmt->execute()){

                  // echo "Sign up successfully ";

                  ?>
                  <div class="alert alert-info">
                    <strong>Click this link to complete the SignUp </strong>
                    <a href="signup.php?passkey=<?php echo $confirm_code; ?>" class="alert-link">Click Me</a>
                  </div>

                  <?php
                    // $to    = $user_email;
                    // $subject   = "SUBJECT";
                    // $header    = "m.abdullah@devtrongenesis.com";

                    // $message  = "Your Confirmation link \r\n";
                    // $message .= "click on this to activate your account \r\n";
                    // $message .= "gmshopping.com/confirmation.php?passkey=$confirm_code" ;

                    // $sentmail = mail($to, $subject, $message, $header);
                    
                    // $sentmail = "$message" | mail -s "$subject" gmabdullah32@gmail.com;
                    
                    // echo "This is the body of the email" | mail -s "This is the subject line" m.abdullah@devtrongenesis.com

                    // if($sentmail){
                    //  echo "Email sent ";
                    // } else {
                    //  echo " Mail not sent";
                    // }
                }
                else{
                  echo "Insert Query could not execute !";
                }
              
              }
              else {
                
                echo "Try other email to register "; //  not available
              }
                
            }
            catch(PDOException $e){
              echo $e->getMessage();
            }
          }
       ?>
    <!-- BODY CONTAINER -->
    <div class="container mg-b100">

      <div class="row">

        <div class="col-xs-12 col-sm-10 col-md-6 col-md-offset-3 col-lg-6 col-sm-offset-1">

          <form class="lognin" action="signup.php" method="post">

            <h3>Sign up</h3>

            <input type="email" class="form-control " name="u_email" placeholder="Email" required > <br>
            <input type="text" class="form-control " name="u_name" placeholder="Username" required > <br>
            <input type="password" placeholder="Password" name="password" class="form-control" required > <br>

            <select class="form-control" name="user_type" required >
              <option value=""> Please select </option>
              <!-- <option value="admin"> Admin </option> -->
              <option value="owner"> Owner </option>
              <option value="user"> User </option>
            </select> <br>

            <input type="submit" name="login" class="btn btn-primary">

          </form>

        </div>
      </div>
    </div> 
    <!-- /BODY CONTAINER -->
    <!-- CONFIRMATION  -->
    <?php

      
      try{

        if (isset($_GET['passkey'])) {
          
            $passkey = $_GET['passkey'];

            $stmt = $db_con->prepare("SELECT * FROM tmp_tbl WHERE confirm_code = '$passkey'");
            $stmt->execute();
              $count = $stmt->rowCount();

              if ($count == 1) {
                $row = $stmt->fetch();

                $username   = $row['user_name'];
                $email      = $row['email']; 
                $pass       = $row['password'];
                $user_type    = $row['user_type'];
                $joining_date = date('Y-m-d H:i:s');

                $stmt = $db_con->prepare("INSERT INTO users(user_name, user_email, user_password, user_type, joining_date) VALUES(:uname, :email, :pass, :user_type, :jdate)");

                $stmt->bindParam(':uname', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':pass', $pass);
                $stmt->bindParam(':user_type', $user_type);
                $stmt->bindParam(':jdate', $joining_date);

                if($stmt->execute()){

                  // delete confirmation code from tmp_table after inserting to users table
                  $del_code = $db_con->prepare("DELETE FROM tmp_tbl WHERE confirm_code = '$passkey'");
                  $del_code->execute();
                  ?>
                  <div class="alert alert-success" role="alert">
                    <strong>Well done!</strong> You successfully SignUp , Please Login to continue
                  </div>
                  <?php
                  

                }else{

                  echo "Insert to users table query is not working";

                }


              }else{

                echo "Your confirmation code is expired please try again";

              }
            } // if isset end

          }catch(PDOException $e){

            echo $e->getMessage();

          }
        
    ?>
    <!-- /CONFAIRMATION -->

  <?php include_once('inc/footer.php'); ?>

  </body>

</html>

