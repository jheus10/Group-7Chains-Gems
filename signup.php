<?php

    include_once("connections/connection.php");
    $con = connection();

    if(isset($_POST['submit'])){
        echo "Submitted <br>";

                $var_fname = $_POST['fname'];
                $var_mname = $_POST['mname'];
                $var_lname = $_POST['lname'];
                $var_email = $_POST['email'];
                $var_uname = $_POST['uname'];
                $var_pass = $_POST['confirm_password'];
                $var_contact = $_POST['contact'];
                $var_street = $_POST['street'];
                $var_region = $_POST['region'];
                $var_province = $_POST['province'];
                $var_city = $_POST['city'];
                $var_barangay = $_POST['barangay'];

                $sql = "INSERT INTO `tbl_users` (`fname`,`mname`, `lname`, `email_add`,`house_number`,`region`,`province`,`city`,`barangay`,`contact_number`,`uname`,`pass`,`access`) 
                VALUES ('$var_fname','$var_mname','$var_lname','$var_email','$var_street','$var_region','$var_province','$var_city','$var_barangay','$var_contact','$var_uname','$var_pass','user')";
            
                $con->query($sql) or die ($con->error);

                echo header("Location: products.php");
    } 
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
      <link rel="stylesheet" href="css/signup.css">
      <meta charset="utf-8">
      <title>Signup</title>
      <script src="https://kit.fontawesome.com/c84b46effb.js" crossorigin="anonymous"></script>
      <script src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations-v1.0.0.js"></script>
  </head>

<body >
<div class="login"> Already have an account? <a href="login.php">Login</a> </div>

<div class="container" id="container">
      <div class="form-container sign-up-container">
          <form action="" method="post">

              <h1><font color="#dfbd69">Contact</font></h1>
              <span> Please provide your contact details.</span>

              <div class="address">
                      <input type="number" name="contact" placeholder="Contact number" required/>
                      <input type="text" name="street" placeholder="House # Street" required/>
                      Region <select id="region" name="region" required> </select>
                      Province <select id="province" name="province" required></select>
                      City <select id="city" name="city" required></select>
                      Barangay<select id="barangay" name="barangay" required></select>
              </div>
              <button type="submit" name="submit">Signup</button>
              

      </div>
      <div class="form-container sign-in-container">

              <h1><font color="#dfbd69">Account</font></h1>
              <span> Please provide details for your account.</span>

              <input type="text" name="fname" placeholder="Last name" required/>
              <input type="text" name="mname" placeholder="First name" required/>
              <input type="text" name="lname" placeholder="Middle name" />
              <input type="email" name="email" placeholder="Email" required/>
              <input type="text" name="uname" placeholder="Username" required/>
              <input type="password" name="password" id="password" placeholder="Password" required/>
              <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required/>
              <button type="submit" name="submit">Signup</button>
        </form>
      </div>

    <div class="overlay-container">
      <div class="overlay">
          <div class="overlay-panel overlay-left">
              <img src="images/model1.jpg" alt="">
              <h1>Go Back</h1>
              <p>Check your personal information before signing up.</p>
              <button class="ghost" id="signIn">Back</button>
          </div>
          <div class="overlay-panel overlay-right">
              <img src="images/model2.jpg" alt="">
              <h1>Next part is here!</h1>
              <p>Enter your personal details and start journey with us</p>
              <button class="ghost" id="signUp">Next</button>
          </div>

      </div>
    </div>

</div>

<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
      container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
      container.classList.remove("right-panel-active");
    });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.js"></script>
        <!-- script type="text/javascript" src="../jquery.ph-locations.js"></script -->
        <script type="text/javascript" src="https://f001.backblazeb2.com/file/buonzz-assets/jquery.ph-locations.js"></script>
        <script type="text/javascript">

        var my_handlers = {

               fill_provinces:  function(){
                   var region_code = $(this).val();
                   $('#province').ph_locations('fetch_list', [{"region_code": region_code}]);

               },

               fill_cities: function(){
                   var province_code = $(this).val();
                   $('#city').ph_locations('fetch_list', [{"province_code": province_code}]);
               },


               fill_barangays: function(){
                   var city_code = $(this).val();
                   $('#barangay').ph_locations('fetch_list', [{"city_code": city_code}]);
               }
        };

           $(function(){
               $('#region').on('change', my_handlers.fill_provinces);
               $('#province').on('change', my_handlers.fill_cities);
               $('#city').on('change', my_handlers.fill_barangays);

               $('#region').ph_locations({'location_type': 'regions'});
               $('#province').ph_locations({'location_type': 'provinces'});
               $('#city').ph_locations({'location_type': 'cities'});
               $('#barangay').ph_locations({'location_type': 'barangays'});

               $('#region').ph_locations('fetch_list');
           });

           var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");

          function validatePassword(){

              if(password.value != confirm_password.value) {
                  confirm_password.setCustomValidity("Passwords Don't Match");
              }else {
                  confirm_password.setCustomValidity('');
              }
          }

          password.onchange = validatePassword;
          confirm_password.onkeyup = validatePassword;
       </script>
</body>
</html>
