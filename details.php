<?php

    if(!isset($_SESSION)){ session_start(); }

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

    $id = $_GET['ID'];

    $sql = "SELECT * FROM tbl_product WHERE prod_id = '$id'";
    $students = $con->query($sql) or die ($con->error);
    $row = $students->fetch_assoc();

    $var_prod = $row['p_name'];
    $var_desc = $row['description'];
    $var_price = $row['price'];
    $var_category =  $row['category'];
    $var_material = $row['material'];
    $var_stock = $row['stock'];
    $var_userID = $_SESSION['U_ID'];
    $image = $row['image'];

    if(isset($_POST['addtocart'])){
        $sql = "SELECT * FROM tbl_cart  WHERE prod_id = '$id' AND added_by = '$var_userID' ORDER BY prod_id DESC ";
        $items = $con->query($sql) or die ($con->error);
        $row = $items->fetch_assoc();
        $total = $items->num_rows;

           if($total>0)
            {
                $sql = "UPDATE tbl_cart SET quantity = quantity+1 WHERE prod_id = '$id' AND added_by = '$var_userID'";
                $con->query($sql) or die ($con->error);
                echo header("Location: cart.php");
            }
            else {
                $sql = "INSERT INTO `tbl_cart` (`prod_id`,`p_name`, `description`, `price`,`category`,`material`,`stock`,`quantity`,`added_by`,`img`)
                VALUES ('$id','$var_prod','$var_desc','$var_price','$var_category','$var_material','$var_stock',1,'$var_userID','".$image."')";

                $con->query($sql) or die ($con->error);
                echo header("Location: cart.php");
            }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/details.css">

    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src='js/jquery.js'></script>
    <link rel="stylesheet" type="text/css" href="js/font-awesome/css/font-awesome.min.css">
</head>

<body>
<center>
<a id='backToTop'></a> 
<div class="header">
    <a href="products.php"> <img id="logo" src="img/logo.png"> </a>
    <img id="title" src="img/title.png">
    <div class="icons">
        <a href="cart.php"><i class="fas fa-shopping-cart" title="Your Cart"></i></a>
        <a href="profile.php"><i class="fas fa-user-alt" title="Profile"></i></a>
        <?php
            if ($_SESSION['Access']=="administrator") { ?>
            <a href="settings.php"><i class="fas fa-history" title="History"></i></i></a>
        <?php } ?>
        <a href="#"><i class="fas fa-sign-out-alt" title="Logout" 
                    onclick="function hi(){
                        let confirm_logout = confirm('Are you sure you want to logout?')

                        if (confirm_logout==true) {
                            window.location.href = 'logout.php';
                        } 
                    };
                    hi()"></i>
        </a>
    </div>
    <div class="nav">
        <ul>
        <li><a href="home.php">HOME</a></li>
        <li><a href="products.php">SHOP ALL</a></li>
        <li><a href="aboutus.php">ABOUT US</a></li>
        <li><a href="contactus.php">CONTACT US</a></li>

        <!-- search bar -->
        <li><input type="text" name="search" id="search" class="search-bar" placeholder="Search our store">
        <button class="button-search" name="query"><i class="fas fa-search"></i></button></li>

        </ul>
    </div>
</div>

<div class="items-category"> <h1><?php echo $row['category']."s";?></h1> </div>

<hr class="about-hr">

<section class="big-section"></section>

    <!-- START OF DETAILS PAGE HERE -->
    <div class="details-section">
        <div class="right-align">
            <h2 class="product-title"> <?php echo $row['p_name'];?></h2>

            <p class="tarnish-det">Non tarnish. Hypoallergenic.</p>

            <div class="container-ann">
                <i class="fas fa-bullhorn"></i>&nbsp;&nbsp;&nbsp;&nbsp;Make up to 3 payments to receive a suprise freebies!
            </div>
            <div class="desc">


            <p class="tarnish-det">Description</p>
            <p class="product-desc"><?php echo $row['description'];?> </p><br>

            <p class="tarnish-det">Category</p>
            <p class="product-desc"><?php echo $row['category'];?> </p><br>

            <p class="tarnish-det">Material</p>
            <p class="product-desc"><?php echo $row['material'];?> </p><br>

            <p class="tarnish-det">Stock</p>
            <p class="product-desc"><?php echo $var_stocks = $row['stock'];?> </p><br>

            <p class="tarnish-det">Date Added</p>
            <p class="product-desc"><?php echo $row['date_added'];?> </p><br>
            </div>
            <p class="product-price">₱<?php echo $row['price'];?></p>


            <section></section>


            <form action="" method="post">
            <?php  if ($var_stocks > 0){?>
                <button type="submit" class="submit-butt" name="addtocart" > Add to Cart </button>
            <?php } ?>
            <br><br>

            </form>
            <?php if ($_SESSION['Access']=="administrator") { ?>
                <a href="edit.php?ID=<?php echo $row['prod_id'];?>"><button class="submit-butt-2">Edit Item</button></a>
            <?php } ?>

            <section></section><br><br><br>

            <form action="delete.php" method="post">
                <?php if ($_SESSION['Access']=="administrator") { ?>
                    <input class="textarea" type="text" name="ID" placeholder="Enter Product's ID to delete" required> <!--MANUALLY TYPE YUNG ID NUM FOR SECURITY -->
                    <button type ="submit" name="delete" class="delete-butt"><i class="far fa-trash-alt"></i></button>

                    <br><br>

                    <!-- DON'T DELETE -->
                    <!-- <input type="text" name="ID" value="<?php //echo $row['prod_id'];?>"> -->
                    <!-- <input type="hidden" name="ID"> AUTOMATIC TYPE & HIDDEN TEXT BOX-->
                <?php } ?>
            </form>

            <section></section>

        </div>

        <div class="left-align">
            <img src="<?= $image ?>" style="width: 450px; height: 450px;">
        </div>
    </div>

    <section class="big-section"></section>

    <a href="products.php"><button class="submit-butt-3"><< Back to All Products</button></a>

    <section class="big-section"></section>

    </center>
    <center>
    <!-- FOOTER -->
    <div id="footer">
        <div class="footer-content">
            <img id="footer-logo" src="img/logo2.png">
            <p>We celebrate life’s magic through an aesthetic that’s fresh and experimental – whilst always ensuring our jewels are wearable and timeless. </p>
            <ul class="socials">
                <li><a href="https://www.facebook.com/chainsandgems"><i class="fa fa-facebook" title="Facebook"></i></a></li>
                <li><a href="https://www.instagram.com/chainsandgems/?hl=en"><i class="fa fa-instagram" title="Instagram"></i></a></li>
                <li><a href="https://twitter.com/chainsandgems"><i class="fa fa-twitter" title="Twitter"></i></a></li>
                <li><a href="https://shopee.ph/user/purchase/"><i class="fa fa-store" title="Shopee"></i></a></li>
            </ul>
        </div>

        <div class="footer-bottom">
            <p>Copyright &copy;2021 Chains and Gems. designed by <span>Charjhe's Angels</span></p>
        </div>
    </div>
</center>
<script>

    $(document).ready(function(){

    //back to top
        $(window).scroll(function(){
        if($(window).scrollTop() > 300){
            $('#backToTop').addClass('show');
        }else{
            $('#backToTop').removeClass('show');
        }
        });
        
        $('#backToTop').click(function(e){
        e.preventDefault();
        $('html,body').animate({scrollTop:10}, 1500, 'easeInOutExpo');
        return false;
        
        });
    });

    </script>

    <!-- animations -->
    <script src="js/wow/wow.min.js"></script>
    <script>new WOW().init();</script>
    <script src="js/easing/easing.min.js"></script>
    <script src="js/main.js"></script>

    <!-- search -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(function() {
            var tags = [
            "Diamond", "Rose Gold","Gold","Ring","Necklace","Yellow Gold","White Gold","Plain",
            "Small","18ct","14ct","Stud","Earrings","Bracelet","Chain","Cut","Wave Ring",
            "Flow Ring","Pinky Ring","Large Struck","Pear Ring","Curved Bar","Double End"];
            
            $( "#search" ).autocomplete({
            source: tags
            });
        });
  </script>
</body>
</html>
