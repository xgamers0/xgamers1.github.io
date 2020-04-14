<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: others\login.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
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
  
 Change password - X Gamer's

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



 

<div class="container">
      <link rel="stylesheet" type="text/css" href="ssform.css">
    <section id="content">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
             <h1>Reset Password</h1>
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
               
                <input type="password" name="new_password" placeholder = "New Password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
               
                <input type="password" name="confirm_password" placeholder = "Confirm Password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
        
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

