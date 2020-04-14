<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
 
<title>
  
 Sign up to X Gamer's

</title>
<link rel = "icon" href = "logo.jpg" type = "image/x-icon"> 



<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="newss.css">
  <script src="newjs.js"></script>
  <script src="newjs2.js"></script>
  <script src="newjs3.js"></script>
  <style>
    
  .fakeimg {
    height: 200px;
    background: #aaa;
  }
  .video-fluid {
  width: 100%;
  height: auto;
}
  </style>
</head>
<body>


<div class="container text-center" style="margin-bottom:0">
 <header align="center">
 <a href= "index.php" target="_blank"> <img src="headerlogo100.png"  height="auto" width="400" align="middle"> 
  </a>

</header>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
   <a class="navbar-brand" href="index.php">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse"  align = "center" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="login.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>    
    </ul>
  </div>  
</nav>






  <br><br><br><br>

      
       <div class="container-fluid">
      <link rel="stylesheet" type="text/css" href="ssform.css">
    <section id="content">
       

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"/>
            <h1>Sign Up</h1>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                
                <input type="text" name="username"  placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
               
                <input type="password" name="password"  placeholder="Password" class="form-control">

                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
              <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                
                <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Sign Up" />
                <a href="resetpass.php">Lost your password?</a>
                <a href="register.php">Register</a>
            </div>
        </form><!-- form -->
        
    </section>
  </link>
</div><!-- container -->


</div>
<br><br><br><br>
<br><br><br><br>
<br><br><br><br>

<footer class="jumbotron page-footer font-small teal pt-4 text-info" style="margin-bottom:0">

  <!-- Footer Text -->
  <div class="container-fluid text-center text-md-left">

    <!-- Grid row -->
    <div class="row">

      <!-- Grid column -->
      <div class="col-md-6 mt-md-0 mt-3">

        <!-- Content -->
        <h5 class="text-uppercase font-weight-bold">Follow Us on : </h5>
        <a href="https://www.facebook.com/xgamers0" target="_blank"> <img src="facebook1.png"  height="70" width="70"></a>


      </div>
      <!-- Grid column -->

      <hr class="clearfix w-100 d-md-none pb-3">

      <!-- Grid column -->
      <div class="col-md-6 mb-md-0 mb-3">

        <!-- Content -->
        <h5 class="text-uppercase font-weight-bold">Subscribe Us on : </h5>
        <a href="https://www.youtube.com/channel/UCaP_M5gxHEpjJVPTuKvYk3A?view_as=subscriber" target="_blank"> <img src="youtube1.png" height="70" width="70"></a>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div><br><br>
  <!-- Footer Text -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="index.php"> X Gamers</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->


 


</div>


</body>
</html>

