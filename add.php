<?php
    ini_set('mysql.connect_timeout',300);
    ini_set('default_socket_timeout',300);

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

    if(isset($_POST['submit'])){
        echo "<br>Submit Failed <br>";

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

                $var_prod = $_POST['pname'];
                $var_desc = $_POST['desc'];
                $var_price = $_POST['price'];
                $var_category = $_POST['category'];
                $var_material = $_POST['material'];
                $var_stock = $_POST['stock'];
                $var_userID = $_SESSION['U_ID'];
                $var_user= $_SESSION['UserLogin'];

                $sql = "INSERT INTO `tbl_product` (`p_name`, `description`, `price`,`category`,`material`,`stock`,`added_by`,`image`,`img_name`)
                VALUES ('$var_prod','$var_desc','$var_price','$var_category','$var_material','$var_stock','$var_userID','".$image."','".$var_filename."')";

                $con->query($sql) or die ($con->error);

                echo header("Location: products.php");
            }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/add.css">
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>

</head>
<center>
<body>

  <a class="gotopbtn" href="#"><i class="fas fa-arrow-up"></i></a>
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
          <a href="logout.php"><i class="fas fa-sign-out-alt" title="Logout"></i></a>
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


  <div class="items-category"> <h1>Contact Us</h1> </div>

<div class="items-category-desc">
    <p>Add new products to the business. Don't forget to check all the entered details before saving all the changes.</i>.<p>
</div>

<section></section>

   <form action="" method="post" enctype='multipart/form-data'>
     <div class="format">


        <label class="color" for="">Product Name:</label>
        <input type="text" name="pname" id="pname" required><br/>

        <label class="color" for="">Description:</label>
        <input type="text" name="desc" id="desc" value="" required><br/>

        <label  class="color" for="">Price:</label>
        <input type="number" name="price" id="price" value="" required><br/> <!-- remember to delete the value after! -->

        <label class="color" for="">Category:</label>
        <select name="category" id="category" required>
        <option class="opt-value" value="" disabled selected>Select a Category</option>
            <option class="opt-value" value="Necklace">Necklace</option>
            <option class="opt-value" value="Earrings">Earrings</option>  <!-- remember to delete the value after! -->
            <option class="opt-value" value="Anklet">Anklet</option>
            <option class="opt-value" value="Bracelet">Bracelet</option>
            <option class="opt-value" value="Ring">Ring</option>
            <option class="opt-value" value="Cases">Cases</option>

        </select><br/>

        <label class="color" for="">Material:</label>
        <select name="material" id="material" required>
        <option class="opt-value" value="" disabled selected>Select a Material</option>
            <option class="opt-value" value="White Gold">White Gold</option>  <!-- remember to edit selected after! -->
            <option class="opt-value" value="Yellow Gold">Yellow Gold</option>
            <option class="opt-value" value="Rose Gold">Rose Gold</option>
            <option class="opt-value" value="Diamond">Diamond</option>

        </select><br/>

        <label class="color" for="">Stock:</label>
        <input type="number" name="stock" id="stock" value="" required><br/>  <!-- remember to delete the value after! -->


    <input type="file" id="real-file" name ="file" hidden accept=".jpg"/>
    <label class="color" for="">Upload product image:</label><button type="button" id="custom-button">CHOOSE A FILE</button>
    <span id="custom-text">No file chosen, yet.</span>
      <br><br><br><br><br><br><br>
        <input type="submit" id="submit" name="submit" value="Add Product" style="font-size: 15px;" onclick="confirms()">
         </div>
<br><br><br><br><br>
   </form>
    </center>
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

<script type="text/javascript">

const realFileBtn = document.getElementById("real-file");
const customBtn = document.getElementById("custom-button");
const customTxt = document.getElementById("custom-text");

customBtn.addEventListener("click", function() {
  realFileBtn.click();
});

realFileBtn.addEventListener("change", function() {
  if (realFileBtn.value) {
    customTxt.innerHTML = realFileBtn.value.match(
      /[\/\\]([\w\d\s\.\-\(\)]+)$/
    )[1];
  } else {
    customTxt.innerHTML = "No file chosen, yet.";
  }
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
