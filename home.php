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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chain & Gems </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="aos-by-red.css">

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css">

    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src='js/jquery.js'></script>
    <link rel="stylesheet" type="text/css" href="js/font-awesome/css/font-awesome.min.css">

<style media="screen">
  
  .nav{
    position: relative;
    top: -48px;
  }

  .meaningful .prod3 img{
    width: 500px;
    height: 500px;
    left: -50px;
    position: absolute;
}
</style>
</head>

<body>
<center>
<a id='backToTop'></a> 

<header>
    <a href="home.php"> <img id="logo" src="img/logo.png"> </a>
    <img id="title" src="img/title.png">

    <div class="icons">
        <a href="cart.php"><i class="fas fa-shopping-cart" title="Your Cart"></i></a>
        <a href="profile.php"><i class="fas fa-user-alt" title="Profile"></i></a>
        <?php
            if ($_SESSION['Access']=="administrator") { ?>
            <a href="settings.php"><i class="fas fa-history" title="History"></i></i></a>
        <?php } ?>
        <a href="logout.php"><i class="fas fa-sign-out-alt" title="Logout"></i></a>
    </div>

    <div class="nav">
        <form action="search.php" method="get">
        <ul>
          <li><a href="home.php"><font color="#dfbd69">HOME</font></a></li>
          <li><a href="products.php">SHOP ALL</a></li>
          <li><a href="aboutus.php">ABOUT US</a></li>
          <li><a href="contactus.php">CONTACT US</a></li>
          <li><input type="text" name="search" id="search" class="search-bar" placeholder="Search our store">
          <button class="button-search" name="query"><i class="fas fa-search"></i></button></li>
        </ul>
      </form>
    </div>
</header>



<div id="slider" style="margin-top: -30px" >
  <figure>

    <img src="images/new2.png" alt="">
    <img src="images/new1.png" alt="">
    <img src="images/new4.png" alt="">
    <img src="images/new5.png" alt="">
    <img src="images/new3.png" alt="">

  </figure>

</div>
<div class="wrap">
  <button class="button" data-aos="flip-right" id="explore_btn"><span>Explore more</span></button>
</div>
<div class="golden-title" id="first_set">
  Meaningful Gifts
</div>
<div class="meaningful">
  <div class="text" data-aos="fade-up">MAKE IT PERSONAL</div>
  <div class="meaningful-text" data-aos="fade-down">

    <p>The most thoughtful gifts are those that are personalised. Whether they love astrology or want to manifest their dreams into reality, you’re sure to find them the perfect gift. </p>
  </div>
  <div class="prod1" data-aos="fade-right">
  <img src="img/product1.jpg" alt="">
  </div>
  <div class="prod2" data-aos="fade-left">
  <img src="img/prods/pics/bg10.jpg" alt="">
  </div>
  <div class="prod3" data-aos="fade-zoom-in">
    <img src="img/prods/pics/bg7.jpg" alt="">
      <div class="text2" data-aos="fade-down">EMPOWERING, EVERLASTING JEWELLERY</div>
    <div class="meaningful-text2" data-aos="fade-up">
      <p>The most thoughtful gifts are those that are personalised. Whether they love astrology or want to manifest their dreams into reality, you’re sure to find them the perfect gift. </p>
    </div>
  </div>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<div class="golden-title" data-aos="fade-up">
  Our Best Sellers
</div>
<div class="card-holder" data-aos="fade-in">
<div class="card">


      <div class="front" >
        <a href="http://localhost/ecommerce/details.php?ID=18"><img src="img/prods/bracelets/brace1(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
        <a href="http://localhost/ecommerce/details.php?ID=18"><img src="img/prods/bracelets/brace1.jpg" alt=""></a>

        </div>
      </div>


</div>
<div class="card">
      <div class="front" id="f1">
      <a href="http://localhost/ecommerce/details.php?ID=28">  <img src="img/prods/earrings/ear1(2).jpg" alt=""> </a>
      </div>
      <div class="back" id="f2">
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=28">  <img src="img/prods/earrings/ear1.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=38">  <img src="img/prods/necklaces/neck1(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=38">  <img src="img/prods/necklaces/neck1.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=49">  <img src="img/prods/rings/ring2(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=49">  <img src="img/prods/rings/ring2.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=52">  <img src="img/prods/rings/ring5(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=52">  <img src="img/prods/rings/ring5.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=39">  <img src="img/prods/necklaces/neck2(2).jpg" alt=""></a>

      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=39"> <img src="img/prods/necklaces/neck2.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=32">  <img src="img/prods/earrings/ear5(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=32"><img src="img/prods/earrings/ear5.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=21">  <img src="img/prods/bracelets/brace4(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=21">  <img src="img/prods/bracelets/brace4.jpg" alt=""> </a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=26">  <img src="img/prods/bracelets/brace9(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=26"><img src="img/prods/bracelets/brace9.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=37">  <img src="img/prods/earrings/ear10(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=37">  <img src="img/prods/earrings/ear10.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=47">  <img src="img/prods/necklaces/neck10(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=47">  <img src="img/prods/necklaces/neck10.jpg" alt=""></a>

        </div>
      </div>

</div>
<div class="card">
      <div class="front" >
      <a href="http://localhost/ecommerce/details.php?ID=57"> <img src="img/prods/rings/ring10(2).jpg" alt=""></a>
      </div>
      <div class="back" >
        <div class="back-content middle">
      <a href="http://localhost/ecommerce/details.php?ID=57">  <img src="img/prods/rings/ring10.jpg" alt=""></a>

        </div>
      </div>

</div>
</div>
  
    <!-- Body -->
    <div id="con">

                    </div>
                    </div>
            </div>

    </div>

    <div id="footer" data-aos="fade-up" style="width: 500%">

    <div class="marquee">
            <marquee behavior="" direction="">BUY NOW! ENJOY OUR FAST SHIPPING! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUY NOW! ENJOY OUR FAST SHIPPING! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUY NOW! ENJOY OUR FAST SHIPPING! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUY NOW! ENJOY OUR FAST SHIPPING! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</marquee>
        </div>
        <div class="footer-content" >
            <img id="footer-logo" src="img/logo2.png">
            <p>We celebrate life’s magic through an aesthetic that’s fresh and experimental – whilst always ensuring our jewels are wearable and timeless. </p>
            <ul class="socials">
                <li><a href="https://www.facebook.com/chainsandgems"><i class="fa fa-facebook" title="Facebook"></i></a></li>
                <li><a href="https://www.instagram.com/chainsandgems/?hl=en"><i class="fa fa-instagram" title="Instagram"></i></a></li>
                <li><a href="https://twitter.com/chainsandgems"><i class="fa fa-twitter" title="Twitter"></i></a></li>
                <li><a href="https://shopee.ph/user/purchase/"><i class="fa fa-store" title="Shopee"></i></a></li>
            </ul>
        </div>

        <div class="footer-bottom" style="width: 500%">
            <p>Copyright &copy;2021 Chains and Gems. designed by <span>Charjhe's Angels</span></p>
        </div>

    </div>

     </center>
     <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
          AOS.init({
            duration: 1000,
          });

        </script>
     <script>
        window.addEventListener("scroll",function(){
          var header = document.querySelector("header");
          header.classList.toggle("sticky", window.scrollY > 0);
        })
            $("select").change(function(){
                $("filter").submit();
            });

            $("select").change(function(){
                $("filter").submit();
                $("filter2").submit();
            });

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

              $('#explore_btn').click(function(e){
                  e.preventDefault();
                  $('html, body').animate({scrollTop: ($('#first_set').offset().top)},1500,'easeInOutExpo');
                  return false;
              });
          });
     </script>

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
