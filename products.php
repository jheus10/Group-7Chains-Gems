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

        if($post_category!== ""){
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
    <title>Shop All</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/products.css">
    
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src='js/jquery.js'></script>
    <link rel="stylesheet" type="text/css" href="js/font-awesome/css/font-awesome.min.css">
   
	
    <style>
        #add_product {
            margin-left:100px;
            font-size: 16px;
            margin-bottom: 0;
            cursor: pointer;
            background: none;
            padding: 5px 24px;
            border: 1px solid #797777;
            color: #575756;
            width: 300px;
            outline: none;
            font-family: 'Raleway', sans-serif;
        }

        #sold_out {
            width:100px;
            color:white;
            font-size:10px;
            padding:0.5px;
            background-color: #575756;
            z-index: 10;
            position: relative;
            margin-bottom:-80px;
            margin-right:10px;
            float:right;
        }

        #running_out {
            width:100px;
            color:white;
            font-size:10px;
            padding:0.5px;
            background-color: red;
            z-index: 10;
            position: relative;
            margin-bottom:-80px;
            margin-right:10px;
            float:right;
        }

        .content {
            z-index:8;
            position:relative;
        }

    </style>
</head>

<body> 
<center>
<!-- <a class="gotopbtn" href="#" id='backToTop'><i class="fas fa-arrow-up"></i></a> -->
<a id='backToTop'></a> 

<div class="header">
    <a href="products.php" class="wow fadeInRight" data-wow-delay="1s"> <img id="logo" src="img/logo.png"> </a>
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
                <li><a href="products.php"><font color="#dfbd69">SHOP ALL </font></a></li>
                <li><a href="aboutus.php">ABOUT US</a></li>
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

    
    <div class="items-category"> <h1>All Products</h1> </div>

    <div class="items-category-desc wow fadeInRight">
        <p>Through our carefully curated collection we proudly support small, independent businesses, combining our 
            own unique designswith pieces from local jewelers. These precious jewels are made to celebrate 
            you, empower you and to treasure, always. <p>
    </div>
    
    <br><br>
    <section></section>
<div>
    <form action="products.php" method="POST" name="filter" id="filter">
   
    <div class="filter">
        <div class="category-filter">
            <select class="dropdown-menu" name="category" id="category" onchange="this.form.submit()">
                <option value="" disabled selected>Select a Category</option>
                <option value="Necklace">Necklace</option>
                <option value="Earrings">Earrings</option> 
                <!-- <option value="Anklet">Anklet</option> -->
                <option value="Bracelet">Bracelet</option>
                <option value="Ring">Ring</option>
                <option value="Cases">Cases</option>
            </select>
        </form>
        </div>

        <div class="material-filter">
            <form action="products.php" method="POST" name="filter2" id="filter2" >
                <select class="dropdown-menu" name="material" id="material" onchange="this.form.submit()">
                <option value="" disabled selected>Select a Material</option>
                    <option value="White Gold">White Gold</option>  
                    <option value="Yellow Gold">Yellow Gold</option>
                    <option value="Rose Gold">Rose Gold</option>
                </select>

                <!-- Add product button, nasa style tags yung css <3 -->
                <!-- Add product button, nasa style tags yung css <3 -->
                <?php if ($_SESSION['Access']=="administrator") { ?>
                    <span class="add" name="add_product" id="add_product" onclick="window.location.href='add.php'"> Add Product <i class="fas fa-plus-circle"></i></span>
                <?php } ?> 
                
        </div>
       
        <input type="hidden" name="post_category" id="post_category" value="<?php echo $_POST['category']; ?>">
    </form>
   
     </div>
     
    <section></section>
</div>  
    
    <!-- Body -->
    <div id="con">
        <?php

        if($total > 0){
            //images
            $image = $row['image'];
            $image_src = $row['img_name'];
        do {?>
            <div class="content wow fadeInUp" data-wow-delay="0.2s">

                    <?php 
                            $var_stocks =  $row['stock']; 
                            if ($var_stocks <= 0){ ?>
                               
                                    <div id="sold_out"><p> Sold Out </p></div>
                                    <a href="details.php?ID=<?php echo $row['prod_id']; ?>"> <img src="<?= $row['image']; ?>" style="width: 370px; height: auto;"> </a><br>
                            
                                    <div class="items">
                                        <div class="items-title"><?php echo $row['p_name']; ?> <br></div>
                                        <div class="items-price"><?php echo "₱".$row['price']; ?></div>
                                
                           
                          <?php      }

                            
                            elseif ($var_stocks <= 5){ ?>
                               
                                    <div id="running_out"><p> Running Out </p></div>
                                    <a href="details.php?ID=<?php echo $row['prod_id']; ?>"> <img src="<?= $row['image']; ?>" style="width: 370px; height: auto;"> </a><br>
                            
                                    <div class="items">
                                        <div class="items-title"><?php echo $row['p_name']; ?> <br></div>
                                        <div class="items-price"><?php echo "₱".$row['price']; ?></div> 
                            
                          <?php      }
                            
                            else { ?>
                                <a href="details.php?ID=<?php echo $row['prod_id']; ?>"> <img src="<?= $row['image']; ?>" style="width: 370px; height: auto;"> </a><br>
                           
                                <div class="items">
                                <div class="items-title">
                                    <?php echo $row['p_name']; ?> <br>
                                </div>

                                <div class="items-price">
                                    <?php echo "₱".$row['price']; ?>
                                </div>
                         <?php  } ?>

                  
                    
                   
                        
                        
                        
                       
                    </div>
            </div>

        <?php }while($row = $items->fetch_assoc()); 
        }else{

            echo "No items with this category.";
        }
        ?>
    </div>

    <div id="footer">
    <div class="marquee">
            <marquee behavior="" direction="">BUY NOW! ENJOY OUR FAST SHIPPING! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUY NOW! ENJOY OUR FAST SHIPPING! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUY NOW! ENJOY OUR FAST SHIPPING! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUY NOW! ENJOY OUR FAST SHIPPING! &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</marquee>
        </div>
        <div class="footer-content">
            <img id="footer-logo" src="img/logo2.png" class="fa fa-facebook  wow bounceInDown" data-wow-delay="0.2s">
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

            $('.get-btn').click(function(e){
                e.preventDefault();
                $('html, body').animate({scrollTop: ($('#featured-link').offset().top)},1500,'easeInOutExpo');
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