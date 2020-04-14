<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location:welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
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
  
Sign in to X Gamer's

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
       
    
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"/>
            <h1>Sign In</h1>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                
                <input type="text" name="username"  placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
               
                <input type="password" name="password"  placeholder="Password" class="form-control">

                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" value="Log in" />
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

