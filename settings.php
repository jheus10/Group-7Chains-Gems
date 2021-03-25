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
        
    }else{ echo header("Location: login.php"); } //redirect sa login
    

    include_once("connections/connection.php");
    $con = connection();

    //for logins 
    $sql = "SELECT * FROM tbl_audit_trail ORDER BY log_count DESC";
    $log_trail = $con->query($sql) or die ($con->error);
    $log_row = $log_trail->fetch_assoc();

    //for users 
    $sql = "SELECT * FROM tbl_users ORDER BY user_id DESC";
    $user_trail = $con->query($sql) or die ($con->error);
    $user_row = $user_trail->fetch_assoc();

    //for orders 
    $sql = "SELECT * FROM tbl_orders ORDER BY order_id DESC";
    $order_trail = $con->query($sql) or die ($con->error);
    $order_row = $order_trail->fetch_assoc();
  
?>

<html lang="en">
<head>
<title>History of Logs</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
    
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src='js/jquery.js'></script>
    <link rel="stylesheet" type="text/css" href="js/font-awesome/css/font-awesome.min.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Raleway&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Arizonia&family=Dawning+of+a+New+Day&family=Petit+Formal+Script&display=swap');

    html {
        scroll-behavior: smooth;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
    }

    body { 
        background-image: url('css/background.png');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        font-family: 'Raleway', sans-serif;
    }

    /* scroll to top button */

    .gotopbtn{
        position: fixed;
        width: 50px;
        height: 50px;
        background: #575756e3;
        border-radius: 50%;
        bottom: 30px;
        right: 30px;

        text-decoration: none;
        text-align: center;
        line-height: 50px;
        color: white;
        font-size: 22px;
    }

    .gotopbtn:active {
        background: #575756e5;
    }

    /* gray box sa top */

    .banner { 
        max-width: 100%;
        position: relative;
        margin-top: 0px;
    }
        
    .banner_wrapper { 
        background-color: #e2e2e2;
        color: #575756;
    }
        
    .banner_text { 
        font-size: 12px;
        letter-spacing: 0.2em;
        display: block;
        padding: 7px 20px 6px;
        transition: opacity 0.75s ease;
        text-align: center;
    }
    
    /* header and navigations */

    .header { 
        height: 300px;
    }

    a {
        text-decoration: none;
    }

    #logo { 
        width: 130px;
        height: 130px;
        position: relative;
        margin-left: 50px;
        margin-top: auto;
    }

    #title { 
    width: 270px;
    height: 170px;
    position: relative;
    margin-left: 350px;
    margin-top: auto;
    }

    .nav { 
        color: #575756;
        text-align: center;
    }

    .nav ul {
        width: auto;
        margin-top: -5px;
    }

    .nav li {  
        display: inline;
        padding: 40px;
    }

    .nav a {  
        color: #575756;
        text-align: center;
        font-size: 14px;
        font-weight:bold;
    }

    .nav a:hover{
        color: #dfbd69;
        transition: color .4s ease;
    }


    /* icons */

    .icons {  
        position: relative;
        float: right;
        margin-top: 70px;
        margin-right: 80px;
    }

    .icons i { 
        font-size: 20px;
        color: #575756;
        padding-left: 30px;
    }

    /* for the items displayed */

    .items { 
        position: relative;
        text-transform: capitalize;
        margin-top: 15px;
        color: #575756;
    }

    .items-title {
        font-size: 18px;
    }

    .items-desc {
        font-style: italic;
        font-size: 15px;
    }

    .items-price {
        font-weight: bold;
        font-size: 16px;
    }

    .items-category {
        position: relative;
        margin-top: -50px;
        animation: slide_up .8s ease;
    }

    @keyframes slide_up {
        0% {
            transform: translateY(45px);
        }
        100% {
            transform: translateY(0);
        }
    }

    .items-category h1 { 
        color:#dfbd69;
        font-size: 45px;
        font-family: 'Petit Formal Script', cursive;
    }

    .items-category-desc p{ 
        color:#575756;
        font-size: 15px;
    }

    .items-category-desc { 
        width: 800px;
        text-align: center;
    }

    /* for footer */

    #footer{
        z-index: -1;
        position: relative;
        margin-top: 20px;
        margin-bottom: -10px;
        margin-left: -10px;
        margin-right: -30px;
        background-color: #e2e2e2;
        height: auto;
        width: auto;
        padding-top: 20px;
        color: #575756;
    }

    .footer-content{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        text-align: center;
        width: 500px;
    }

    #footer-logo {
        width: 200px;
        height: 200px;
    }

    .footer-content p{
        max-width: 100%;
        margin: 5px auto;
        line-height: 28px;
        font-size: 14px;
    }

    .socials{
        list-style: none;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 1rem 0 3rem 0;
    }

    .socials li{
        margin: 0 20px;
    }

    .socials a{
        color: #575756;
    }

    .socials a i{
        font-size: 21px;
        transition: color .4s ease;

    }

    .socials a:hover i{
        color: #dfbd69;
    }

    .footer-bottom{
        background: #b6b4b4;
        max-width:100%;
        padding: 1px 0;
        text-align: center;
    }

    .footer-bottom p{
        font-size: 11px;
        word-spacing: 2px;
        text-transform: capitalize;
    }

    .footer-bottom span{
        text-transform: uppercase;
        opacity: .7;
        font-weight: 200;
    }

    /*for filter */

    .dropdown-menu {
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

    .filter {
        display: inline-block;
    }

    .category-filter {
        float: left;
        margin-right: 80px;
    }

    .material-filter {
        float: right;
    }

    /* for section space */

    section {
        height: 30px;
    }

    .big-section {
        height:150px;
    }

    /*for search bar in navigation */

    .search-bar {
        background-color: transparent;
        color: #575756;
        border: 0;
        border-bottom: 2px solid #575756;
        width: 180px;
        padding: 8px 0;
        border-radius: 0;
        outline: none;
        font-size: 13px;
    }

    .button-search {
        color: #575756;
        background-color: Transparent;
        border: none;
        cursor:pointer;
        overflow: hidden;
        margin-left: -30px;
        outline: none;
    }

    #con {
        text-align: center;
        width: 100%;
        height:auto;
        display: inline-block;
        
    }

    .content {
        width: 390px;
        height:450px;
        display:inline-block;
        padding: 10px;
        margin-top:10px;   
    }

    .table-th {
        color: #575756;
        font-size: 14px;
        font-weight:bold;
        letter-spacing: 0.2em;
        text-align: left;
    }

    .table-td {
        color: #575756;
        font-size: 14px;
        text-align: left;
    }

    .submit-butt-3 {
        padding: 12px 40px;
        background-color: #575756;
        color: white;
        border: none;
        font-style: italic;
        letter-spacing: 0.1em;
        outline: none;
        cursor: pointer;
        width: 300px;
        margin-top: 10px;
        float: center;
        font-size: 13px;
    }

    /*back to top button */
    #backToTop {
        background-color: #dfbd69;
        width:50px;
        height:50px;
        display: inline-block;
        border-radius: 50%;
        bottom: 30px;
        right: 30px;
        position:fixed;
        text-align: center;
        font-size: 22px;
        z-index: 10000;
        opacity: 0;
        visibility: hidden;
    }

    #backToTop:hover{
        cursor: pointer;
        background-color: #555;
    }

    #backToTop::after{
        content: "\f062";
        font-family: 'FontAwesome';
        font-weight:normal;
        font-style: normal;
        line-height: 50px;
        color: #fff;
    }

    #backToTop.show{
        opacity: 1;
        visibility: visible;
}


</style>
</head>
<body>
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
    <div class="nav" style="justify-content: center;">
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
<section></section>

    <div class="items-category"> <h1>Trail</h1></div>

    <br>

    <div class="items-category-desc">
        <p>Get a detailed view of those who accessed the website including the name of user, date accessed, and its status. <p>
    </div>

<section></section>

        <!-- TABS -->
        <ul class="nav nav-tabs" id="myTab" role="tablist" style="justify-content: center;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true" style="color:#575756;">Logins</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" style="color:#575756;">Users</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false" style="color:#575756;">Orders</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">

        <!--table for list of logins -->
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <table style="width:70%;">
                <thead>
                    <th class="table-th">LOG COUNT</th>
                    <th class="table-th">USERNAME</th>
                    <th class="table-th">PASSWORD</th>
                    <th class="table-th">LOGIN</th>
                    <th class="table-th">LOGOUT</th>
                    <th class="table-th">STATUS</th>
                </thead>

            <?php do {?> 

                <tbody style="padding:80px;">
                    <tr>
                        <td class="table-td"><?php echo $log_row['log_count']; ?></td>
                        <td class="table-td"><?php echo $log_row['uname']; ?></td>
                        <td class="table-td"><?php echo $log_row['pass']; ?></td>
                        <td class="table-td"><?php echo $log_row['login']; ?></td>
                        <td class="table-td"><?php echo $log_row['logout']; ?></td>
                        <td class="table-td"><?php echo $log_row['log_status']; ?></td>    
                    </tr>
                </tbody>
                
                <?php }while($log_row = $log_trail->fetch_assoc()); ?>
            </table>
        </div>

        <!--table for users -->
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <table style="width:80%;">
                <thead>
                    <th class="table-th">USER ID</th>
                    <th class="table-th">NAME</th>
                    <th class="table-th">EMAIL </th>
                    <th class="table-th">ADDRESS</th>
                    <th class="table-th">CONTACT</th>
                    <th class="table-th">USERNAME</th>
                    <th class="table-th">PASSWORD</th>
                    <th class="table-th">ACCESS</th>
                    <th class="table-th">DATE ADDED</th>
                </thead>

           

                <?php  do {?> 

                    <tbody style="padding:80px;">
                        <tr>
                            <td class="table-td"><?php echo $user_row['user_id']; ?></td>
                            <td class="table-td"><?php echo $user_row['fname']." ".$user_row['lname']; ?></td>
                            <td class="table-td"><?php echo $user_row['email_add']; ?></td>
                            <td class="table-td"><?php echo $user_row['city']; ?></td>
                            <td class="table-td"><?php echo $user_row['contact_number']; ?></td>    
                            <td class="table-td"><?php echo $user_row['uname']; ?></td>    
                            <td class="table-td"><?php echo $user_row['pass']; ?></td>    
                            <td class="table-td"><?php echo $user_row['access']; ?></td>  
                            <td class="table-td"><?php echo $user_row['date_added']; ?></td>      
                        </tr>
                        
                    </tbody>
                <?php }while($user_row = $user_trail->fetch_assoc()); ?>
            </table>

        </div>

        <!--table for users -->
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <table style="width:80%;">
                <thead>
                    <th class="table-th">ORDER ID</th>
                    <th class="table-th">CUST ID</th>
                    <th class="table-th">TOTAL </th>
                    <th class="table-th">MOD</th>
                    <th class="table-th">COURRIER</th>
                    <th class="table-th">DATE ORDERED</th>
                    <th class="table-th">DATE</th>
                    <th class="table-th">STATUS</th>
                </thead>

           

                <?php  do {?> 
                    <tbody style="padding:80px;">
                        <tr>
                            <td class="table-td"><?php echo $order_row['order_id']; ?></td>
                            <td class="table-td"><?php echo $order_row['cust_id']; ?></td>
                            <td class="table-td"><?php echo $order_row['total']; ?></td>
                            <td class="table-td"><?php echo $order_row['mode_of_payment']; ?></td>
                            <td class="table-td"><?php echo $order_row['courrier']; ?></td>    
                            <td class="table-td"><?php echo $order_row['date_ordered']; ?></td>    
                            <td class="table-td"><?php echo $order_row['date_received']; ?></td>    
                            <td class="table-td"><?php echo $order_row['order_status']; ?></td>  
                        </tr>
                        
                    </tbody>
                <?php }while($order_row = $order_trail->fetch_assoc()); ?>
            </table>
        </div>
</div>

    <section class="big-section"></section>

    <a href="products.php"><button class="submit-butt-3"><< Go Back to Home</button></a>

    <section class="big-section"></section>

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
            <p><br>Copyright &copy;2021 Chains and Gems. designed by <span>Charjhe's Angels</span></p>
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
        $('html,body').animate({scrollTop:10}, 100, 'easeInOutExpo');
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