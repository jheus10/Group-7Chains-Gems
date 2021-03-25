<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_SESSION['UserLogin'])){
        echo "<div class='banner'>";
        echo "<div class='banner_wrapper'>";
        echo "<div class='banner_text'>";
        echo "Welcome <b>".$_SESSION['UserLogin']."</b> ".$_SESSION['U_ID']."<br>";
        date_default_timezone_set('Hongkong');
        echo "Date today: ".date(' Y-m-d H:i:s');
        echo "</div></div></div>";
        
    }else{
        echo header("Location: login.php"); //redirect sa login
    }

    include_once("connections/connection.php");
    $con = connection();

    $var_userID = $_SESSION['U_ID'];

    $sql = "SELECT * FROM tbl_cart  WHERE added_by = '$var_userID' ORDER BY cart_id DESC ";
    $items = $con->query($sql) or die ($con->error);
    $row = $items->fetch_assoc();
    $total = $items->num_rows;   
   
    if(isset($_POST['add'])){
        $id =  $_POST['id'];
        $sql = "UPDATE tbl_cart SET quantity = quantity+1 WHERE prod_id = '$id' AND added_by = '$var_userID'";
        $con->query($sql) or die ($con->error);
        echo header("Location: cart.php");
      }

    if(isset($_POST['remove'])){
        $id =  $_POST['id'];
        $sql = "UPDATE tbl_cart SET quantity = quantity-1 WHERE prod_id = '$id' AND added_by = '$var_userID'";
        $con->query($sql) or die ($con->error);

        // delete if quantity is 0 
        $sql = "DELETE FROM tbl_cart WHERE quantity = 0 AND added_by = '$var_userID'";
        $con->query($sql) or die ($con->error);
        echo header("Location: cart.php"); 
    }

    if(isset($_POST['delete'])){
        $id =  $_POST['id'];
        $sql = "DELETE FROM tbl_cart WHERE prod_id = '$id' AND added_by = '$var_userID'";
        $con->query($sql) or die ($con->error);
        echo header("Location: cart.php"); 
    }

    if(isset($_POST['checkout'])){
        echo header("Location: shipping.php"); 
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Your Cart </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/products.css">
  <link rel="stylesheet" href="css/cart.css">

  <link rel="stylesheet" type="text/css" href="css/animate.css">
  <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <script src='js/jquery.js'></script>
  <link rel="stylesheet" type="text/css" href="js/font-awesome/css/font-awesome.min.css">
</head>

<body> 
<center>


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

  

    <div class="items-category"> <h1>Cart</h1> </div>

    <div class="items-category-desc wow fadeInRight">
        <p>Look into the world of aesthetic that’s fresh and experimental and you'll see that the real magic is in your cart. <p>
    </div>
    
    <section></section><br>

    <!-- Cart -->
    <?php 

    if($total > 0){   // Checks if cart have items or none 
        $image = $row['img']; ?>


        <table style="width:90%;">
            <thead>
                <th> </th>
                <th> </th>
                <th> </th>
                <th> </th>
                <th class="title_th">PRICE</th>
                <th class="title_th">QUANTITY</th>
                <th class="title_th">TOTAL</th>
            </thead>

            <section></section><hr><section></section>

            <?php 
                static $counter = 0; 
                static $subtotal = 0;
                
                do {?>

                    <tbody style="padding:80px;" class="wow fadeIn" data-wow-delay="0.2s">
                        <form action="" method="POST" id="cart_form"> 
                            <tr>
                                <!-- <td><button type="submit" name="delete" class="btn-del" ><i class="far fa-trash-alt"></i> &nbsp; </button></td> delete btn -->
                                <button type="submit" name="delete" id="btn_del" hidden></button>
                                <td><span class="btn-del" 
                                        onclick="function del(){
                                                let confirm_delete = confirm('Are you sure you want to delete?')
                                                if (confirm_delete==true) {
                                                    var delbutton= document.getElementById('btn_del');
                                                        delbutton.click();
                                                } else{}
                                            };
                                            del()">
                    
                                <i class="far fa-trash-alt" ></i> &nbsp; </span></td>

                                <td><input type="number" name="id" id="id" value=<?= $row['prod_id']; ?> style="width:50px;" hidden> </td>
                                <td><img src="<?= $row['img']; ?>" style="width:120px; height: 120px;"> </td>
                                <td><?php echo $row['p_name']; ?></td>
                                <td><?php echo "₱".$row['price']; ?></td>
                                
                                <td>
                                    

            
                                    <button type="submit" name="remove" class="btn"><i class="fas fa-minus-circle"></i></button>    <!--remove btn -->
                                    <input class="number" type="number" name="quantity" id="quantity" value=<?= $row['quantity']; ?> style="width:50px;text-align:center;" readonly>
                                    <?php 
                                        $st = $row['stock'];
                                        $qy = $row['quantity'];

                                    if ($qy < $st) { ?>
                                        <button type="submit" name="add" class="btn"><i class="fas fa-plus-circle"></i> </button>  <!--add btn -->
                                        <?php } ?>
                                   
                                </td>
                        
                                    <?php
                                        $amount = 0;
                                        $price = $row['price'];
                                        $stock = $row['quantity'];
                                        $amount = $price * $stock;
                                       
                                    ?>

                                <td id="amount"><?php echo "₱".$amount;?></td> 
                            </tr>
                            
                            <?php $counter += $stock; $subtotal += $amount; ?> <!--compute subtotal -->
                        </form>
                    </tbody>
                
            <?php }while($row = $items->fetch_assoc()); ?>
        </table>

        <section></section><hr><section></section>

            <p class="titles-cart">Total Items in cart: <?php echo $counter; ?> </p>
            <p class="titles-cart"> SUBTOTAL:  <b class="wow flash" data-wow-delay="0.4s">₱ <?php echo number_format($subtotal,2,".",","); ?></b></p>

            <span style="font-size:12px; color: #575756;"> Shipping, taxes, and discount codes calculated at checkout </span>

            <section></section><br>

            <form action="" method="POST"> 
                <input type="submit" class="submit-butt" name="checkout" value="Checkout">
            </form>


        <section id="big-section"></section><br>

        <?php }else{ echo "<p style='font-style:italic; color: #575756;'>No items added to cart yet</p>"; ?>

        <br>

        <button class="submit-butt" onclick="window.location.href='products.php'">Continue Shopping</button>
        
        <section class="big-section"></section>

        <?php } ?>
        
         <!-- End of Cart -->

        <div id="footer">
        <div class="footer-content">
            <img id="footer-logo" src="img/logo2.png" class="fa fa-facebook wow bounceInDown" data-wow-delay="0.2s">
            <p>We celebrate life’s magic through an aesthetic that’s fresh and experimental – whilst always ensuring our jewels are wearable and timeless. </p>
            <ul class="socials">
                <li><a href="https://www.facebook.com/chainsandgems"><i class="fa fa-facebook  wow bounceInDown" data-wow-delay="0.4s" title="Facebook"></i></a></li>
                <li><a href="https://www.instagram.com/chainsandgems/?hl=en"><i class="fa fa-instagram  wow bounceInDown" data-wow-delay="0.6s" title="Instagram"></i></a></li>
                <li><a href="https://twitter.com/chainsandgems"><i class="fa fa-twitter  wow bounceInDown" data-wow-delay="0.8s" title="Twitter"></i></a></li>
                <li><a href="https://shopee.ph/user/purchase/"><i class="fa fa-store  wow bounceInDown" data-wow-delay="1s" title="Shopee"></i></a></li>
            </ul>
        </div>

            <div class="footer-bottom"> <p>Copyright &copy;2021 Chains and Gems. designed by <span>Charjhe's Angels</span></p> </div>
        </div>

    </center>
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