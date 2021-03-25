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

    //Category Filter 
    if(isset($_POST['category'])){
        $cat = $_POST['category'];
        $sql = "SELECT * FROM tbl_product WHERE category ='$cat' ORDER BY prod_id DESC";
        $items = $con->query($sql) or die ($con->error);
        $row = $items->fetch_assoc();
        $total = $items->num_rows;    
        
    }else{
        $_POST['category']="";
        $sql = "SELECT * FROM tbl_product ORDER BY prod_id DESC";
        $items = $con->query($sql) or die ($con->error);
        $row = $items->fetch_assoc();
        $total = $items->num_rows;   
    }

    //Material Filter 
    if(isset($_POST['material'])){
        $post_category = $_POST['post_category'];
        $mat = $_POST['material'];

        if($catt!== ""){
            $sql = "SELECT * FROM tbl_product WHERE category ='$post_category' AND material ='$mat' ORDER BY prod_id DESC";
            $items = $con->query($sql) or die ($con->error);
            $row = $items->fetch_assoc();
            $total = $items->num_rows;   

        }else{
            $sql = "SELECT * FROM tbl_product WHERE material ='$mat' ORDER BY prod_id DESC";
            $items = $con->query($sql) or die ($con->error);
            $row = $items->fetch_assoc();
            $total = $items->num_rows;   
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/contactus.css">

    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src='js/jquery.js'></script>
    <link rel="stylesheet" type="text/css" href="js/font-awesome/css/font-awesome.min.css">

   
   <style media="screen">
    u{
      text-decoration: none;
      color: #dfbd69;
    }
    
    </style>
    
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
        <form action="search.php" method="get"> 
            <ul>
                <li><a href="home.php">HOME</a></li>
                <li><a href="products.php">SHOP ALL</a></li>
                <li><a href="aboutus.php">ABOUT US</a></li>
                <li><a href="contactus.php"><font color="#dfbd69"> CONTACT US </font> </a></li>

                <!-- search bar -->
                <li>
                    <input type="text" name="search" id="search" class="search-bar" placeholder="Search our store">
                    <button type="submit" class="button-search" name="query"><i class="fas fa-search"></i></button>
                </li>

            </ul>   
        </form> 
    </div>
</div>



    <div class="items-category"> <h1>Contact Us</h1> </div>

    <div class="items-category-desc">
        <p>Please see our <a href="aboutus.php" class="about-us-link"><b><u>About page</u></b></a> for possible answers to your queries.</p>
        <p>Submit your email and message below if you cannot find your answer. 
          Response times are currently up to <i>48 hours</i>.<p>
    </div>

    <br><br>
    <section></section>

    <!-- CONTACT US -->
    <form action="" method="post" id="msg_form" onsubmit="function sendMessage(){alert('Thank you for sending us a message! Have a good day. :)')};sendMessage()"> 
        <div class="contact-section">
                <div class="name-text-area">
                    <p class="contact-title-name wow animate__lightSpeedInLeft">Name *</p>
                </div>
                <div class="email-text-area">
                    <p class="contact-title wow animate__lightSpeedInLeft" data-wow-delay="0.2s" >Email *</p>
                </div>
        </div>

        <br>

        <div class="contact-section">
                <div class="name-text-area">
                    <input class="text-box" type="text" name="name-contact-us" placeholder="Your full name" required>
                </div>
                <div class="email-text-area">
                    <input class="text-box" type="email" name="email-contact-us" placeholder="Your email address" required>
                </div>
        </div>
        
        <br>

        <div class="contact-section">
                <div class="name-text-area">
                    <p class="contact-title-message wow animate__lightSpeedInLeft" data-wow-delay="0.4s">Message *</p>
                </div>
        </div>

        <br>

        <div class="contact-section">
                <div class="name-text-area">
                    <input class="textarea-box" type="text" name="name-contact-us" placeholder="Write your message here. . ." required>
                </div>
        </div>

        <section></section><br>


        <button class="submit-butt">Send </button>
    </form>

    <section class="big-section"></section>
    <section class="big-section"></section>

    <div class="items-category-desc">
        <p class="p-spacing">You can also check out our social media accounts located at the bottom of the page.</p>

        <p class="p-spacing">Alternatively, you can WhatsApp us at <a href="tel:+63968-369-2541" style="color: #575756;"><b><u>(+63) 968-369-2541</u></b></a> 
        or email us directly at <a href="mailto:info@chainsandgems.com?subject=Get%20in%20touch" style="color: #575756;"><b><u>info@chainsandgems.com</u></b></a></p>

        <p class="p-spacing">For press related enquires, please email 
        <a href="mailto:pr@chainsandgems.com?subject=Get%20in%20touch" style="color: #575756;"><b><u>pr@chainsandgems.com</u></b></a></p>
    </div>

    <section></section>

    <div class="short-message">We look forward to hear from you</div>

    <div class="short-message-desc wow heartBeat" data-wow-delay="0.5s" data-wow-duration="4s" >
        <img src="img/shortmess.png" alt="May you enjoy x" style="max-width: 100%; height: auto;">
    </div>

    <section class="big-section"></section>
    <section class="big-section"></section>

    <!-- FOOTER -->
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