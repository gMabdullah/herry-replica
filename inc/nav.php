
    <!-- NAVBAR -->
    <nav class="navbar navbar-default" role="navigation">
      <div class="container-fluid">
        <!-- Navbar-header -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand logo-img" href="index.php"></a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
          <!-- left links -->
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#">Save Plans <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="all-products.php">Products</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
          </ul>
          <!-- Search Area -->
          <form class="navbar-form navbar-left" name="search" method="get" action="/searchresults.php">
            <div class="form-group">
              <input type="text" name="q" id="q" class="form-control" placeholder="Search..." >
            </div>
            <button type="submit" class="btn btn-default">Search</button>
          </form>
          <!-- Rights links -->
          <ul class="nav navbar-nav navbar-right">
              <li ><a href="signup.php">Sign Up</a></li>
              <li><a href="" data-toggle="modal" data-target="#signIn-model" data-whatever="@fat">Sign in</a></li>
              <li><a href="addtocart.php">Cart 
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
              </a></li>
          </ul>
          
          <!-- SIGN IN MODEL -->
          <div class="modal fade" id="signIn-model" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <!-- model-header -->
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SignIn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <!-- model-body -->
              <form method="post" name="signin-form" action="login.php">
                <div class="modal-body">

                    <div class="form-group">
                      <label for="user-name" class="form-control-label">Username: </label>
                      <input type="text" class="form-control" name="uname" id="user-name" required >
                    </div>

                    <div class="form-group">
                      <label for="user-email" class="form-control-label">Email :</label>
                      <input type="email" class="form-control" name="email" id="user-email" required >
                    </div>

                    <div class="form-group">
                      <label for="password" class="form-control-label">Password :</label>
                      <input type="password" class="form-control" name="password" id="password" required >
                    </div>

                </div>

                  <!-- model-footer -->
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="login" class="btn btn-primary" value="Sign In">
                  </div>

                </form>
              </div> <!-- model-content -->
            </div> <!-- model-dialogbox -->
          </div> <!-- model-fade -->
          <!-- /SIGN IN MODEL -->
        </div><!--/.navbar-collapse -->
      </div>
    </nav>