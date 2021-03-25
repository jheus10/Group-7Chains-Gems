<?php
    if(!isset($_SESSION)){ session_start(); }

    include_once("connections/connection.php");
    $con = connection();

    if(isset($_POST['login'])){

        //echo "Logged in <br>";
        $var_uname = $_POST['username'];
        $var_pass = $_POST['password'];

        $sql = "SELECT * FROM tbl_users WHERE BINARY uname = '$var_uname' AND pass = '$var_pass'";

        $user = $con->query($sql) or die ($con->error);
        $row = $user->fetch_assoc();
        $total = $user->num_rows;

        if($total > 0){
            $_SESSION['U_ID'] = $row['user_id'];
            $_SESSION['UserLogin'] = $row['uname'];
            $_SESSION['Access'] = $row['access'];
            $_SESSION['Password'] = $row['pass'];

            //for audit
            $log = "INSERT INTO `tbl_audit_trail` (`uname`, `pass`,`log_status`)
            VALUES ('$var_uname','$var_pass','Success')";

            if($con->query($log)){
                $_SESSION['LastRow']= $con->insert_id;
            }else { die ($con->error); }

            echo header("Location: home.php"); //redirect sa home
        } else {

            echo "<script>alert('Invalid Username or Password')</script>";

            //for audit
            $log = "INSERT INTO `tbl_audit_trail` (`uname`, `pass`,`log_status`)
            VALUES ('$var_uname','$var_pass','Failed')";

            $con->query($log) or die ($con->error);
        }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <link rel="stylesheet" href="css/icon.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="css/login.css">

    <title>Login</title>
  </head>
  <body>


  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-12">
              <div class="form-block">
                    <div class="mb-4">
                      <center>
                      <img src="img/logo.png" alt="">
                    </center>
                    <h3>Sign In to <strong>Chains & Gems</strong></h3>

                    <p class="mb-4">Welcome to Chains & Gems! </p>
                </div>

                <form action="" method="post">
                    <div class="form-group first">
                      <label for="username">Username</label>
                      <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="form-group last mb-4">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="d-flex mb-5 align-items-center">
                      <label class="containerz">Remember me
                        <input type="checkbox">
                        <span class="checkmark"></span>
                      </label>
                    </div>

                    <input type="submit" value="Login" name="login" class="btn btn-pill text-white btn-block btn-primary">

                    <span class="d-block text-center my-4 text-muted"> Don't have an account? <a href= "signup.php">Sign up</font></a></span>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  </body>
</html>
