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


    ini_set('mysql.connect_timeout',300);
    ini_set('default_socket_timeout',300);

    if(!isset($_SESSION)){ session_start(); }

    include_once("connections/connection.php");
    $con = connection();
    $id = $_GET['ID'];


    $sql = "SELECT * FROM tbl_product WHERE prod_id = '$id'";
    $prod = $con->query($sql) or die ($con->error);
    $row = $prod->fetch_assoc();

    if(isset($_POST['submit'])){
        echo "Submitted <br>";

        $var_filename = $_FILES['file']['name'];

        $target_dir = "img/";

            if($var_filename !=''){
                $target_file = $target_dir.basename($_FILES["file"]["name"]);
                
                // Select file type
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    
                // Valid file extensions
                $extensions_arr = array("jpg","jpeg","png","gif");

                // Check extension
                if(in_array($imageFileType,$extensions_arr) ){

                    //Convert to base 64
                    $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
                    $image = "data::image/".$imageFileType.";base64,".$image_base64;

                    // Upload file
                  // move_uploaded_file($_FILES['file']['tmp_name'],$target_file);  
                }
            }
                $var_prod = $_POST['pname'];
                $var_desc = $_POST['desc'];
                $var_price = $_POST['price'];
                $var_category = $_POST['category'];
                $var_material = $_POST['material'];
                $var_stock = $_POST['stock'];
                $var_userID = $_SESSION['U_ID'];
                $var_user = $_SESSION['UserLogin'];

                
                $sql = "UPDATE tbl_product SET p_name = '$var_prod', description = '$var_desc', price = '$var_price', 
                category = '$var_category', material = '$var_material', stock = '$var_stock', image = '".$image."', img_name = '".$var_filename."'
                WHERE prod_id = '$id'";

                $con->query($sql) or die ($con->error);
                echo header("Location: products.php");
    }
    $image = $row['image'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/edit.css">

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
        <a href="#"><i class="fas fa-user-alt" title="Profile"></i></a>
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

    <!-- START OF EDIT PRODUCTS-->
    <center>
    <div class="items-category"> <h1>Edit Product</h1> </div>

    <div class="items-category-desc wow fadeInRight">
        <p>Edit the name of the product, its description, price, category, material, and number of stock. Upon proceeding, all entereddata 
            will be saved and updated automatically.<p>
    </div>

    <section class="big-section"></section>

    <div class="edit-container">
        <div class="left-align">
        <img src="<?= $image ?>" style="width: 450px; height: 450px;">
        </div>

        <div class="right-align">
        <form action="" method="post" enctype='multipart/form-data'>

        <label for="" class="contact-title">Product Name:</label><br/>
        <input type="text" class="textarea" name="pname" id="pname" value="<?php echo $row['p_name'];?>" ><br/><br/><br/>

        <label for="" class="contact-title">Description:</label><br/>
        <input type="text" class="textarea" name="desc" id="desc" value="<?php echo $row['description'];?>"><br/><br/><br/>

        <label for="" class="contact-title">Price:</label><br/>
        <input type="number"  class="textarea" name="price" id="price" value="<?php echo $row['price'];?>"><br/> <br/><br/>

        <label for="" class="contact-title">Category:</label><br/>
        <select class="dropdown" name="category" id="category">
            <option option value="" disabled selected>Select a Category</option>
            <option value="Necklace" <?php echo ($row['category']== "Necklace")? 'selected' : ''; ?>>Necklace</option>
            <option value="Earrings" <?php echo ($row['category']== "Earrings")? 'selected' : ''; ?>>Earrings</option>  
            <option value="Anklet" <?php echo ($row['category']== "Anklet")? 'selected' : ''; ?>>Anklet</option>
            <option value="Bracelet" <?php echo ($row['category']== "Bracelet")? 'selected' : ''; ?>>Bracelet</option>
            <option value="Ring" <?php echo ($row['category']== "Ring")? 'selected' : ''; ?>>Ring</option>
            <option value="Cases"<?php echo ($row['category']== "Cases")? 'selected' : ''; ?>>Cases</option>
        
        </select><br/><br/><br/>

        <label for="" class="contact-title">Material:</label><br/>
        <select class="dropdown" name="material" id="material">
            <option option value="" disabled selected>Select a Material</option>
            <option value="White Gold" <?php echo ($row['material']== "White Gold")? 'selected' : ''; ?>>White Gold</option> 
            <option value="Yellow Gold" <?php echo ($row['material']== "Yellow Gold")? 'selected' : ''; ?>>Yellow Gold</option>
            <option value="Rose Gold" <?php echo ($row['material']== "Rose Gold")? 'selected' : ''; ?>>Rose Gold</option>
            <option value="Diamond" <?php echo ($row['material']== "Diamond")? 'selected' : ''; ?>>Diamond</option>
        
        </select><br/><br/><br/>

        <label for="" class="contact-title">Stock:</label><br/>
        <input type="number" class="textarea" name="stock" id="stock" value="<?php echo $row['stock'];?>" ><br/><br/><br/>

        <input class="submit-butt-2" type='file' name='file' required/><br/><br/><br/>

        <section></section><br>

        <span style="font-size:12px; color: #575756;"><i>*Please double check all entered data before proceeding</i></span>
        
        <br><br>

        <input type="submit" class="submit-butt" name="submit" value="Save Changes"></form>
        <a href="details.php?ID=<?php echo $row['prod_id'];?>"><button class="submit-butt-2">Cancel</button></a>

        </div>
        </div>


</center>

<section class="big section"></section>
<section class="big section"></section>

<center>
    <!-- FOOTER -->
    <div id="footer">
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