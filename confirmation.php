<?php
    if(!isset($_SESSION)){ session_start();}

    if(isset($_SESSION['UserLogin'])){
        echo "<div class='banner'>";
        echo "<div class='banner_wrapper'>";
        echo "<div class='banner_text'>";
        echo "Welcome <b>".$_SESSION['UserLogin']."</b> ".$_SESSION['U_ID']."<br>";
        date_default_timezone_set('Hongkong');
        echo "Date today: ".date(' Y-m-d H:i:s');
        echo "</div></div></div>";
        
    }else{ echo header("Location: login.php"); }//redirect sa login page
    

    include_once("connections/connection.php");
    $con = connection();

    $var_userID = $_SESSION['U_ID'];

    //retrieve items in cart
    $sql = "SELECT * FROM tbl_cart  WHERE added_by = '$var_userID' ORDER BY cart_id DESC ";
    $cart_items = $con->query($sql) or die ($con->error);
    $cart_row = $cart_items->fetch_assoc();
    $total_cart = $cart_items->num_rows;   

    //retrieve user details 
    $sql = "SELECT * FROM tbl_users  WHERE user_id = '$var_userID'";
    $user = $con->query($sql) or die ($con->error);
    $user_row = $user->fetch_assoc();

    $shipping_fee = 0;
    if(isset($_POST['delivery'])){
        $delivery_options = $_POST['delivery'];
    }else{    
        $delivery_options ="";
       
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Success</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/confirm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- wag ilagay yung ibang css independent tong file ehehe -->

    <script src="js/wow.min.js"></script>
    <script>new WOW().init();</script>
    <script type="text/javascript" src="js/js.js"></script>
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
</head>

<body> 
<center>

    <!-- header logo -->
    <div class="header"><img class="title-logoz" src="img/title.png"></div>
    
    <!-- confirmation starts here -->
    <div class="confirm-section">
        <div class="animate__animated animate__animated animate__flip confirm-check">
            <i class="far fa-check-circle"></i>
        </div>

        <div class="confirm-title">
            <p class="confirm-one">Yahay! You just made an order!</p>
            <p class="confirm-two">Your order is being processed please wait for the shipping of the item.</p>
        </div>

        <a href="home.php"><button type="submit" class="submit-butt" name="continue">Continue Shopping</button> <!-- redirect home -->
        <br>
        <a href="profile.php"><button type="submit" class="submit-butt-2" name="continue">See Order Details</button></a><!-- lagay link ng profile here -->
    </div>

    <section class="big-section"></section>

</center>
</body>
</html>