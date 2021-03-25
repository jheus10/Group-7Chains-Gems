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
    <title>About Us</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/aboutus.css">

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

        <form action="search.php" method="get">
            <ul>
                <li><a href="home.php">HOME</a></li>
                <li><a href="products.php">SHOP ALL</a></li>
                <li><a href="aboutus.php"><font color="#dfbd69">ABOUT US</font></a></li>
                <li><a href="contactus.php">CONTACT US</a></li>

                <!-- search bar -->
                <li>
                    <input type="text" name="search" id="search" class="search-bar" placeholder="Search our store">
                    <button type="submit" class="button-search" name="query"><i class="fas fa-search"></i></button>
                </li>

            </ul>
        </form>    
    </div>
</div>

    <!-- START OF BODY -->
    <!-- ABOUT US -->
    <div class="about-img-container">
        <img src="img/about.jpg" alt="Shop Chains & Gems" style="width: 100%; height: 85%; ">
        <div class="centered">
        <i class="i-centered">empowering, everlasting fine jewelery</i>
            </div>
    </div>

    <section></section>

    
    <div class="items-category"> <h1>About Us</h1> </div>

    <div class="items-category-desc">
        <p class="items-category-desc wow " data-wow-delay="0s">Discover the story behind the development of Chains and Gems.<p>
    </div>

    <br>
    
    <hr class="about-hr">

    <section></section>

    <div class="about-us-container">
            <div class="left-align wow fadeInLeft">
                <img src="img/about-1.jpg" style="max-width: 270px; height: auto; object-fit: cover;">
            </div>
            <div class="right-align wow fadeInRight" >
            <p class="about-p">Chains and Gems is a right place for women that loves to express themselves through classy jewelries. 
                We design jewellery with a deeper meaning that every woman should put in mind and feel that they are special. The feeling
                 of being beautiful, confident  that you really are. We make an effort to create aesthetic jewelries that are wearable and
                  timeless. </p>
            
            <a href="products.php"><button class="submit-butt">See All Products</button></a>
            </div>
    </div>

    <section></section>

    <hr class="about-hr">

    <section></section>

    <div class="about-us-container">
            <div class="left-align-2 wow fadeInLeft" data-wow-delay="0.3s">
            <p class="about-p-2">The Chains and Gems supports small, independent businesses. Our exclusive designs are handmade and inspired 
                by international female jewellers. Our designers knows how to make a beutiful woman fall in love to the most beautiful, elegant
                 and luxurious jewellery. A jewellery that you'll cherish for lifetime.</p>    

            <a href="contactus.php"><button class="submit-butt">Get in Touch</button></a>

            </div>
            <div class="right-align-2 wow fadeInRight" data-wow-delay="0.3s">
            <img src="img/about-2.jpg" style="max-width: 270px; height: auto; object-fit: cover;">
            </div>
    </div>

    <section></section>

    <hr class="about-hr">

    <section></section>

    <div class="about-us-container">
            <div class="left-align wow fadeInLeft" data-wow-delay="0.6s">
                <img src="img/about-3.jpg" style="max-width: 270px; height: auto; object-fit: cover;">
            </div>
            <div class="right-align">
            <p class="about-p wow fadeInRight" data-wow-delay="0.6s">Our jewelries are crafted from pure gold, diamonds, pearls, chains and precious gemstones. Chains and Gems gained loyalty, 
                trust, and the esteem of our beloved customers. We want women to wear our products simply because it is Chains and Gems. This is a  place 
                where buying fine jewellery can make a woman feel fun and engaging experience.</p>

            <section></section><br>
            
            <div class="short-message-desc wow heartBeat" data-wow-duration="10s">
            <img src="img/shortmess.png" alt="May you enjoy x" style="max-width: 100%; height: auto;">
            </div>

            </div>
    </div>

    <section></section>
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