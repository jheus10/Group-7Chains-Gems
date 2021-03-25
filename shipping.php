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

    $var_userID = $_SESSION['U_ID'];

    //retrieve items in cart
    $sql = "SELECT * FROM tbl_cart  WHERE added_by = '$var_userID' ORDER BY cart_id DESC ";
    $cart_items = $con->query($sql) or die ($con->error);
    $cart_row = $cart_items->fetch_assoc();
    $total_cart = $cart_items->num_rows;   

    //retrieve user details 
    $sql = "SELECT * FROM tbl_users  WHERE user_id = '$var_userID'";
    $user = $con->query($sql) or die ($con->error);
    $user_row = $user->fetch_assoc();

    $shipping_fee = 0;
    if(isset($_POST['delivery'])){
        $delivery_options = $_POST['delivery'];
    }else{    
        $delivery_options ="";
       
    }

    //save order details
    if(isset($_POST['continue'])){

        $var_userID = $_SESSION['U_ID'];

        $var_arrayIDs = $_POST['p_ids'];
        $var_arrayQYs = $_POST['p_qys'];
        $var_arrayUPs = $_POST['p_ups'];

        $var_total = $_POST['total'];
        $var_MOD = $_POST['delivery'];
        $var_courrier = $_POST['courrier'];
        $var_shipAdd = $_POST['address']." ".$_POST['region']." ".$_POST['postcode'];
        $var_add = $_POST['additional'];
        
        $sql = "INSERT INTO `tbl_orders` (`cust_id`, `prod_id`, `quantity`,`unit_price`,`total`,`mode_of_payment`,`courrier`,`shipping_add`,`additional`,`order_status`) 
        VALUES  ('$var_userID','$var_arrayIDs','$var_arrayQYs','$var_arrayUPs','$var_total','$var_MOD','$var_courrier','$var_shipAdd','$var_add','processing')";
    
        $con->query($sql) or die ($con->error);

        $sql = "DELETE FROM tbl_cart WHERE `added_by` = '$var_userID'";
        $con->query($sql) or die ($con->error);


        $str_id_indiv = explode('-',$var_arrayIDs);
        $str_qy_indiv = explode('-',$var_arrayQYs);
       

        for ($j = 0; $j<sizeof($str_id_indiv); $j++) {
            $sql = "UPDATE tbl_product SET stock = stock - $str_qy_indiv[$j] WHERE prod_id = '$str_id_indiv[$j]'";
            
             $con->query($sql) or die ($con->error);
        }

       echo header("Location: confirmation.php");

        
       
    }else{
        // $_POST['courrier']="";
        // $_POST['address']="";
        // $_POST['region']="";
        // $_POST['additional']="";
    }

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/shipping.css">

    <!-- wag ilagay yung ibang css independent tong file ehehe -->

    <script type="text/javascript" src="js/js.js"></script>
    <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
</head>

<body> 
<center>

    <!-- header logo -->

    <div class="header"><img class="title-logoz" src="img/title.png"></div>
    
    <div id="main">
        <div id="div_delivery">
            <form action="" method="post" name="delivery">

            <!-- left section starts here -->
            
                <b><p class="checkout-titles">Delivery Options:</p></b>
                    <div class="white-bg">
                    <input type="radio" id="ship" name="delivery" id="delivery" value="ship" onclick="this.form.submit();" <?php if($delivery_options=='ship'){ echo 'checked="checked"';} ?>>
                    <label for="ship" class="checkout-opt"><i id="fas-icons" class="fas fa-truck"></i>Shipping</label><br>
                    </div>

                    <div class="white-bg-2">
                    <input type="radio" id="pick_up" name="delivery" id="delivery" value="pick_up" onclick="this.form.submit();" <?php if($delivery_options=='pick_up'){ echo 'checked="checked"';} ?>>
                    <label for="pick_up" class="checkout-opt"><i id="fas-icons" class="fas fa-store"></i>Pick Up</label><br>
                    </div>

                    <section class="space"></section>

                    <?php if( $delivery_options=='ship'){ 
                        
                        if(isset($_POST['courrier'])){
                            $courrier_options = $_POST['courrier'];
                        }else{
                            $courrier_options=""; 
                        }
                        ?>
                        <b><p class="checkout-titles">Choose your courrier:</p></b>

                        <div class="white-bg">
                        <input type="radio" id="j&t" name="courrier" value="j&t" onclick="this.form.submit();" required <?php if($courrier_options=='j&t'){ echo 'checked="checked"'; $shipping_fee = 85;} ?>>
                        <label for="ship" class="checkout-opt"><i id="fas-icons" class="fas fa-truck-loading"></i>J&T Express</label><br>
                        </div>

                        <div class="white-bg-2">
                        <input type="radio" id="ninjavan" name="courrier" value="ninjavan" onclick="this.form.submit();" <?php if($courrier_options=='ninjavan'){ echo 'checked="checked"'; $shipping_fee = 105;} ?>>
                        <label for="pick_up" class="checkout-opt"><i id="fas-icons" class="fas fa-truck-loading"></i>Ninjavan</label><br>
                        </div>

                        <section class="space"></section>
                        <section class="space"></section>

                        <hr class="checkout-hr">

                        
                        <section class="space"></section>

                        <b><p class="checkout-titles">Shipping Address:</p></b>

                        <input type="text" class="checkout-textbox" name="fname" placeholder="First name " value="<?php echo $user_row['fname'];?>"required style="width:215px; margin-right:10px;" />
                        <input type="text" class="checkout-textbox" name="lname" placeholder="Last name" value="<?php echo $user_row['lname'];?>" required style="width:220px;margin-right:0px;"/><br/>
                        <input type="text" class="checkout-textbox" name="address" placeholder="Address" value="<?php echo $user_row['house_number']." ".$user_row['barangay'];?>" required style="width:450px;"/> <br/>
                        <input type="text" class="checkout-textbox" name="additional" placeholder="Apartment, suite, etc. (optional)"style="width:450px;"/>  <br/>
                        <input type="text" class="checkout-textbox" name="city" placeholder="City" value="<?php echo $user_row['city']; ?>" style="width:450px;"/><br/>
                        <input type="text" class="checkout-textbox" name="region" placeholder="Region" value="<?php echo $user_row['region']; ?>" required style="width:215px; margin-right:10px;"/>
                        <input type="number" class="checkout-textbox" name="postcode" placeholder="Postcode" required style="width:220; margin-right:0px;"/><br/><br/>
                        
                        <section class="space"></section>
                        <section class="space"></section>
                        <span style="font-size:12px; color: #575756; float:right;">*Please check all the entered data in the fields before proceeding</span>
                        
                        <button type="submit" class="submit-butt" name="continue" style="width: 250px";> Make Order</button>

                    <?php } if($delivery_options=='pick_up'){ ?>

                        <b><p class="checkout-titles">Pick Up Address:</p></b>

                        <div class="white-bg-3">
                        <input type="radio" id="pick_up_address" name="pick_up_address" value="pick up" checked="checked">
                        <label for="pick_up_address" class="checkout-opt"><i id="fas-icons" class="fas fa-location-arrow"></i>Manila City</label><br>
                        </div>

                        <section class="space"></section>
                        <section class="space"></section>
                        <span style="font-size:12px; color: #575756; float:right;">*Please check all the entered data in the fields before proceeding</span>
                        <button type="submit" class="submit-butt" name="continue" style="width: 250px";> Make Order</button>

                    <?php }?>
                    <!-- </form>  -->
                    
                    <br>
                    <br>
                        
                    <span name="return" class="submit-butt" style="background-color: transparent; color: #575756; border: 1px solid #575756;width:168px;text-align:center;font-size:13px;" onclick="window.location.href='cart.php'">Return to Cart</span>

                    <section class="big-section"></section>
                    <section class="big-section"></section>
            
        </div>

        <!-- right section starts here -->

        <div id="div_subtotal">
        <table>
            <b><p class="checkout-titles">All items:</p></b>
                <?php 
                    static $prod_arr = array(); //to store product ids
                    static $quan_arr = array(); //to store product quantity
                    static $unit_arr = array(); //to store unit price
                    global $string_id;
                    global $string_qy;
                    global $string_up;
                    static $counter = 0; 
                    static $subtotal = 0;
                    static $discount = 0;
                    $_COOKIE['cookie_disc']=0;
                    
                    do {?>
                        
                        <tbody style="padding:80px;">
                            <form action="" method="POST"> 
                                <tr>
                                    <td><input type="number" name="id" id="id" value=<?= $cart_row['prod_id']; ?> style="width:50px;" hidden> </td>
                                    <td><img src="<?= $cart_row['img']; ?>" id="p_img" style="width:50px; height: 50px;"> </td>
                                    <td><div id="quantity"> <?php echo $cart_row['quantity']; ?></div></td>
                                    <td class="checkout-names"><span id="product_name"><?php echo $cart_row['p_name']; ?></span></td>
                                    <td class="checkout-price"><?php echo "₱".$cart_row['price']; ?></td>
                                    
                                        <?php
                                            $amount = 0;
                                            $price = $cart_row['price'];
                                            $stock = $cart_row['quantity'];
                                            $amount = $price * $stock;
                                        ?>

                                    <!-- <td id="amount"><?php// echo "₱".$amount;?></td>  -->
                                </tr>
                                
                                <?php 
                                    // To count items, compute subtotal, % save prod id in the array
                                    $counter++; 
                                    $subtotal += $amount; 
                                    array_push($prod_arr, $cart_row['prod_id']);
                                    array_push($quan_arr, $cart_row['quantity']);
                                    array_push($unit_arr, $amount.".00");


                                    $string_id = implode('-',$prod_arr);
                                    $string_qy = implode('-',$quan_arr);
                                    $string_up = implode(',',$unit_arr);
                                ?>  
                        </tbody>
                    
                <?php }while($cart_row = $cart_items->fetch_assoc()); ?>
            </table>
            
                    <input type="text" name="p_ids" id="p_ids" value=<?php echo $string_id; ?>  HIDDEN>
                    <input type="text" name="p_qys" id="p_qys" value=<?php echo $string_qy; ?>  HIDDEN>
                    <input type="text" name="p_ups" id="p_ups" value=<?php echo $string_up; ?>  HIDDEN>        
                           

            <section class="space"></section>

            <hr class="checkout-hr"><br>


            <input class="checkout-textbox" type="text" name="giftcode" id="giftcode" placeholder="Gift card or discount code" style="width:290px; margin-right:0px;"/>
            <button name="discount" class="apply-butt" onclick="discount()"> Apply</button>
                        <!-- <script>
                                function discount() {
                                    var giftcode= "Chains10";
                                    if (giftcode=='Chains10') {
                                        alert('That discount code is already used. :(');
                                        // var s_pass = 130; 
                                        // document.getElementById('disc').hidden=false;  
                                        // document.getElementById('disc').disabled=false; 
                                        
                                    } else{
                                        alert('Discount code does not exist.')
                                        // var s_pass = -160;
                                        // document.getElementById('disc').hidden=true;  
                                        // document.getElementById('disc').disabled=true;      
                                    }
                            }
                        </script> -->

            <hr class="checkout-hr">

            <p class="checkout-opt">Subtotal:   <span class="checkout-money">₱<?php echo  $subtotal; ?> </span></p>
            <!-- <p class="checkout-opt" id="disc" hidden>Discount:   <span class="checkout-money">₱<?php //echo $corny; ?> </span></p> -->
            <p class="checkout-opt">Shipping Fee: <span class="checkout-money" style="margin-left: 255px;">₱<?php echo  $shipping_fee; ?></span></p>

            <hr class="checkout-hr"> <br>
            
            <p class="checkout-titles">Total: <span class="checkout-money-2">₱<b><?php echo $total= $subtotal+$shipping_fee?></span></p></b>
            <input type="number" name="total" id="total" value=<?= $total ?> style="width:50px;" hidden>   

            </form>
            
        </div>
    </div>
    </center>

    <script>
        $("delivery").change(function(){
            $("delivery").submit();
        });

        $("courrier").change(function(){
            $("courrier").submit();
        })


     </script>
</body>



</html>