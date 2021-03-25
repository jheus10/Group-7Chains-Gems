<?php
     ini_set('mysql.connect_timeout',300);
     ini_set('default_socket_timeout',300);

    if(!isset($_SESSION)){ session_start(); }

    if(isset($_SESSION['UserLogin'])){
        echo "<div class='banner'>";
        echo "<div class='banner_wrapper'>";
        echo "<div class='banner_text'>";
        echo "Welcome <b>".$_SESSION['UserLogin']."</b> ".$_SESSION['U_ID']."<br>";
        date_default_timezone_set('Hongkong');
        echo "Date today: ".date(' Y-m-d H:i:s');
        echo "</div></div></div>";
        
        $var_datetime = date(' Y-m-d H:i:s');
    }else{ echo header("Location: login.php"); }//redirect sa login page
    
    include_once("connections/connection.php");
    $con = connection();

    $var_userID = $_SESSION['U_ID'];

    //RETRIEVE USER INFO
    $sql = "SELECT * FROM tbl_users  WHERE user_id = '$var_userID'";
    $user = $con->query($sql) or die ($con->error);
    $user_row = $user->fetch_assoc();

    //RETRIEVE ORDERS
    $sql = "SELECT * FROM tbl_orders  WHERE cust_id = '$var_userID' ORDER BY order_id DESC ";
    $items = $con->query($sql) or die ($con->error);
    $row = $items->fetch_assoc();
    $total = $items->num_rows;   

    //RETRIVE PRODUCTS
    $sql = "SELECT * FROM tbl_product ORDER BY prod_id DESC ";
    $prod_items = $con->query($sql) or die ($con->error);
    $prod_row = $prod_items->fetch_assoc();
    $prod_total = $prod_items->num_rows;  

    //ORDER RECEIVED
    if(isset($_POST['received'])){
        $id =  $_POST['id'];
        $sql = "UPDATE tbl_orders SET order_status = 'received', date_received = '$var_datetime' WHERE order_id = '$id'";
                $con->query($sql) or die ($con->error);
                echo header("Location: profile.php");         
    }

    //UPDATE AVATAR
    if(isset($_POST['btn_update'])){

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
                $sql = "UPDATE tbl_users SET img = '".$image."', img_name = '".$var_filename."' WHERE user_id = '$var_userID'";
                $con->query($sql) or die ($con->error);
                echo header("Location: profile.php");      
    }

    //UPDATE DETAILS
    if(isset($_POST['btn_update_info'])){
       
        $var_fname = $_POST['fname']; 
        $var_mname = $_POST['mname']; 
        $var_lname = $_POST['lname']; 
        $var_email = $_POST['email_add']; 
        $var_contact = $_POST['contact_number']; 
        $var_uname = $_POST['uname']; 

        if(isset($_POST['confirm_pass'])){
            $var_NewPassword = $_POST['confirm_pass']; 
            $_SESSION['Password'] = $var_NewPassword;
        }else{
            $var_NewPassword = $_POST['pass']; 
        }

        $sql = "UPDATE tbl_users SET fname ='$var_fname', mname ='$var_mname', lname ='$var_lname', email_add ='$var_email', 
                                     contact_number ='$var_contact',  uname = '$var_uname', pass = '$var_NewPassword' 
                                    WHERE user_id = '$var_userID'";

        $con->query($sql) or die ($con->error);
        echo header("Location: profile.php");
    }

    $image = $user_row['img'];
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/profile.css">

    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src='js/jquery.js'></script>
    <link rel="stylesheet" type="text/css" href="js/font-awesome/css/font-awesome.min.css">

    <style>
        .submit-butt-4 {
            background-color: transparent;
            color: #dfbd69;
            border: 1px solid #dfbd69;
            font-style: italic;
            letter-spacing: 0.1em;
            cursor: pointer;
            margin-top: 10px;
            width:100%;
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
<center>   
    <div class="items-category"> <h1>Profile</h1> </div>
    
    <section></section>
        <div class="prof_con">
            <div class ="profile_info">
                <div class="avatar">

                    <?php if ($image==""){ ?>
                        <!-- default avatar -->
                        <i class="far fa-user-circle"></i>

                    <?php }else { ?>
                        <!-- updated avatar -->
                        <img src="<?= $image ?>" id="icon" style="width: 250px;height: 250px;">

                   <?php }?>

                    <div id="div_edit">
                        <button class="btn btn-design" name="btn_edit" onclick="myFunctionEdit()">Edit Profile</button> <br/>
                    </div>
                   
                    <div id="div_cancel">
                        <div id="cancel_contents">
                            <form action="" method="post" enctype='multipart/form-data' name="form_avatar">
                                <input type='file' name='file'class="btn-design" style="width: 250px"/>   
                                <button type="submit" style="width:100%;" class="submit-butt-3" name="btn_update">Update Profile</button>
                            </form>

                            <button class="submit-butt-3" style="width:100%; margin-top: -5px;" name="btn_cancel" onclick="myFunctionCancel()">Cancel</button>
                        </div>
                    </div>    
                </div>

                <form action="" method="post" name="form_user">

                    <label for="" class="profile-label">FIRST NAME: </label>
                    <input type="text" class="text-box" name="fname" id="fname" value="<?php echo $user_row['fname'];?>" readonly="readonly" style="width: 200px;"REQUIRED> 

                    <label for="" class="profile-label">MIDDLE NAME: </label>
                    <input type="text" class="text-box"name="mname" id="mname" value="<?php echo $user_row['mname'];?>" readonly="readonly" style="width: 195px;"> </br>

                    <label for="" class="profile-label">LAST NAME: </label>
                    <input type="text" class="text-box"name="lname" id="lname" value="<?php echo $user_row['lname'];?>" readonly="readonly" style="width: 575px;" REQUIRED> </br>

                    <label for="" class="profile-label">EMAIL ADD: </label>
                    <input type="email" class="text-box"name="email_add" id="email_add" value="<?php echo $user_row['email_add'];?>" readonly="readonly" style="width: 200px;" REQUIRED> 

                    <label for="" class="profile-label">CONTACT NUM: </label>
                    <input type="text" class="text-box"name="contact_number" id="contact_number" value="<?php echo $user_row['contact_number'];?>" readonly="readonly" style="width: 200px;" REQUIRED> </br>

                    <label for="" class="profile-label">USERNAME: </label>
                    <input type="text" class="text-box"name="uname" id="uname" value="<?php echo $user_row['uname'];?>" readonly="readonly" style="width: 200px;" REQUIRED> 

                    <label for="" class="profile-label">PASSWORD: </label>
                    <input type="password" class="text-box"name="pass" id="pass" value="" readonly="readonly" style="width: 235px;"REQUIRED> </br>

                    <div id="edit_pass">

                        <div class="pass-container">
                        <section></section>
                        <button id="btn_inputPass" class="submit-butt-3" onclick="inputPass()" style="float: right; width:35%;">Change Password</button>
                        </div>

                    <div id="inputpass">
                        <section></section>
                        <p style='font-style:italic; color: #575756; text-align: center;'>Please enter a new password</p>
                            <input type="password" name="new_pass" id="new_pass" class="pass-word" placeholder="Enter New Password" DISABLED HIDDEN> </br>
                            <input type="password" name="confirm_pass" id="confirm_pass"  class="pass-word" placeholder="Confirm Password" DISABLED HIDDEN> </br>
                    </div>
                    </div>                 
                    </div>

                    <button class ="submit-butt" id="btn_edit_info" onclick="makeEditable()"> Edit Details</button> 
                    <section class="big-section"></section>

                    <div id="cancel">
                        <button type="submit" class="submit-butt" name ="btn_update_info" id="btn_update_info" onclick="updateChanges()"> Update Changes</button><br>
                        <button class="submit-butt-2" id="btn_cancel_info" onclick="makeEditableCancel()">Cancel</button> 
                        <section class="big-section"></section>
                    </div>
                </form>
            </div>
<!-- Start of Orders -->
<div class="order-details">
        <p class="orderd-title">ORDER DETAILS</p>
        <hr class="one-hr">
</div>

<section></section>

<?php 

if($total > 0){    // Checks if tbl_orders have items or none ?>

<table style="width:80%;">
    <thead>
        <th class="title_th">PRODUCTS</th>
        <th class="title_th">TOTAL</th>
        <th class="title_th">MOD</th>
        <th class="title_th">COURRIER</th>
        <th class="title_th">DATE ORDERED</th>
        <th class="title_th">STATUS</th>
    </thead>

    <?php 
        static $counter = 0; 
        static $subtotal = 0;    
        
        do {?>
                    
            <tbody style="padding:80px;">
                <form action="" method="POST"> 
               
                    <tr>
                        <!-- row para sa order number -->
                            <tr>
                                <td colspan="7" class="order_id">
                                        
                                    <?php
                                        $str_id_indiv = explode('-', $row['prod_id']);
                                        $str_qy_indiv = explode('-', $row['quantity']);
                                        $id_count = count($str_id_indiv);

                                        echo "Order Number: ".$row['order_id'];
                                    
                                    ?>
                                </td>
                            </tr>
                        <!-- end row para sa order number -->

                            <input type="number" name="id" id="id" value=<?= $row['order_id']; ?> style="width:50px;" hidden>
                            
                            <td> <!--slider -->
                                <div class="slideshow-container">

                                <?php
                                        for($i=0; $i<$id_count; $i++){
                                           
                                            $sql = "SELECT * FROM tbl_product WHERE prod_id = '$str_id_indiv[$i]'";
                                            $prod_items = $con->query($sql) or die ($con->error);
                                            $prod_row = $prod_items->fetch_assoc();
                                            $prod_total = $prod_items->num_rows;  
                                ?> 
                                           <img src=<?= $prod_row['image']; ?> style="width:70px;">

                                <?php } ?>

    
                            </div>

                            </td> <!--end slider -->

                            <!-- <td><?php echo $row['prod_id']; ?></td> -->     
                            <td><?php echo "<b>₱".$row['total']."</b>"; ?></td>
                            <td><?php echo $row['mode_of_payment']; ?></td>
                            <td><?php echo $row['courrier']; ?></td>  
                            <td><?php echo $row['date_ordered']; ?></td>
                            <td><?php echo $row['order_status']; echo"</br>";

                                if($row['order_status']=='processing'){ ?>

                                    <form action="" method="POST" id="received_form">
                                        <button type="submit" class="submit-butt-3" style="margin-top:10px; width:100%; padding: 5px; font-size:10px;" name="received" id="btn_receive" hidden> Order Received </button>
                                        <div class="submit-butt-3" style="margin-top:10px; width:94%; padding: 5px; font-size:10px;"
                                            onclick="function received_order(){
                                                let confirm_order = confirm('Do you confirm your order? This action cannot be undone.')
                                                    if (confirm_order==true) {
                                                        var receivebutton= document.getElementById('btn_receive');
                                                        receivebutton.click();
                                                        
                                                    } else{alert('Action cancelled.')}
                                            };
                                            received_order()"> Order Received </div>
                                    </form>


                                    
                                <?php } ?>
                                
                            </td>
                    </tr>
                
                </form>
            </tbody>
        
    <?php }while($row = $items->fetch_assoc()); ?>
</table>

<section id="big-section"></section>

<?php }else{ echo "<p style='font-style:italic; color: #575756;'>No orders made yet</p><section class='big-section'></section>"; } ?>

 <!-- End of Orders -->


<section class="big-section"></section>

    
    </center>
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
var edit = document.getElementById("div_edit");
var cancel = document.getElementById("div_cancel");
function myFunctionEdit() {

  if (edit.style.display === "none") {
        edit.style.display = "block";
        cancel.style.display = "none";   
  }else {
        edit.style.display = "none";
        cancel.style.display = "block";
  }
}

function myFunctionCancel() {
  if (cancel.style.display === "none") {
        edit.style.display = "none";
        cancel.style.display = "block";       
  }else {
        edit.style.display = "block";
        cancel.style.display = "none";
  }
}

    var edit_info = document.getElementById("btn_edit_info");  
    var cancel_edit  = document.getElementById("cancel");
    var edit_pass  = document.getElementById("edit_pass");
    var confirm_pass  = document.getElementById("confirm_pass");
    var btn_input_pass  = document.getElementById("btn_inputPass");
    var div_input_pass  = document.getElementById("inputpass");
    var current =  document.getElementById("pass"), password = document.getElementById("new_pass"), confirm_password = document.getElementById("confirm_pass");
    
    
function makeEditable(){

        document.getElementById('fname').removeAttribute('readonly');
        document.getElementById('mname').removeAttribute('readonly');
        document.getElementById('lname').removeAttribute('readonly');
        document.getElementById('email_add').removeAttribute('readonly');
        document.getElementById('contact_number').removeAttribute('readonly');
        document.getElementById('uname').removeAttribute('readonly');
        document.getElementById('pass').removeAttribute('readonly');
        document.getElementById('confirm_pass').removeAttribute('readonly');


    if (edit_info.style.display === "none") {
        edit_info.style.display = "block";
        cancel_edit.style.display = "none";
        password.disabled = true; 
        confirm_pass.disabled = true; 

        edit_pass.style.display = "none";
        btn_input_pass.style.display = "none";
        div_input_pass.style.display = "none";
        
    }else {
        edit_info.style.display = "none";
        cancel_edit.style.display = "block";
        password.disabled = false;
        confirm_pass.disabled = false; 
        edit_pass.style.display = "block";
        btn_input_pass.style.display = "block";
        div_input_pass.style.display = "none";
    }  
}

function makeEditableCancel(){

    if (cancel_edit.style.display === "none") {
        edit_info.style.display = "none";
        cancel_edit.style.display = "block";
        password.disabled = false;
        confirm_pass.disabled = false;
        password.hidden = false; 
        confirm_pass.hidden = false;
        edit_pass.style.display = "block"; 
        btn_input_pass.style.display = "block"; 
        div_input_pass.style.display = "none";
        
    }else {
        
        edit_info.style.display = "block";
        cancel_edit.style.display = "none";
        password.disabled = true; 
        confirm_pass.disabled = true; 
        password.hidden = true; 
        confirm_pass.hidden = true; 
        edit_pass.style.display = "none";
        btn_input_pass.style.display = "none"; 
        div_input_pass.style.display = "none";

        document.getElementById('fname').setAttribute('readonly','readonly');
        document.getElementById('mname').setAttribute('readonly','readonly');
        document.getElementById('lname').setAttribute('readonly','readonly');
        document.getElementById('email_add').setAttribute('readonly','readonly');
        document.getElementById('contact_number').setAttribute('readonly','readonly');
        document.getElementById('uname').setAttribute('readonly','readonly');
        document.getElementById('pass').setAttribute('readonly','readonly');
        document.getElementById('confirm_pass').setAttribute('readonly','readonly');

    }  
}

function inputPass(){

    if (btn_input_pass.style.display === "none") {
        btn_input_pass.style.display = "block"; 
        div_input_pass.style.display = "none";
        password.removeAttribute('hidden');
        confirm_password.removeAttribute('hidden');
        password.disabled = true; 
        confirm_pass.disabled = true; 
        password.hidden = true; 
        confirm_pass.hidden = true; 


    }else {
        btn_input_pass.style.display = "none";
        div_input_pass.style.display = "block";
        password.setAttribute('hidden','hidden');
        confirm_password.setAttribute('hidden','hidden');
        password.disabled = false; 
        confirm_pass.disabled = false; 
        password.hidden = false; 
        confirm_pass.hidden = false;

    }  
}


function updateChanges(){
    document.getElementById('form_user').submit();
}


var txtPass = document.getElementById("new_pass");
var txtConPass = document.getElementById("confirm_pass");
var s_pass = <?php echo json_encode($_SESSION['Password']); ?>; //password na ginamit sa log-in page :))

function checkCurrentPass(){
    if(current.value != s_pass) {
        document.getElementById("new_pass").disabled = true; 
        document.getElementById("confirm_pass").disabled = true; 
        document.getElementById("new_pass").hidden = true; 
        document.getElementById("confirm_pass").hidden = true; 
        current.setCustomValidity('Your password is incorrect.');

    }else if ((current.value == s_pass) &&(btn_input_pass.style.display = "block")){
        document.getElementById("new_pass").disabled = true; 
        document.getElementById("confirm_pass").disabled = true; 
        document.getElementById("new_pass").hidden = true; 
        document.getElementById("confirm_pass").hidden = true; 
        current.setCustomValidity('');

        
    }else if ((current.value == s_pass) &&(btn_input_pass.style.display = "none")){
        document.getElementById("new_pass").disabled = false; 
        document.getElementById("confirm_pass").disabled = false; 
        document.getElementById("new_pass").hidden = false; 
        document.getElementById("confirm_pass").hidden = false; 
        current.setCustomValidity('');
    }
}

function validatePassword(){
    if(password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords don't match");
    }else {
        confirm_password.setCustomValidity('');
    }
}

function checkNewPass(){  
        if(password.value=="") {
            password.setCustomValidity("Enter a valid password");
        }else {
            password.setCustomValidity('');
        }   
}

current.onkeyup = checkCurrentPass;
current.onchange = checkNewPass;
password.onkeyup = checkNewPass;
password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;


//pag nakarating ka dito, gusto ko lang sabihing, IT student niyo pagod na zzZ

</script>

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