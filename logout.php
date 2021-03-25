<?php

    session_start();

    include_once("connections/connection.php");
    $con = connection();

    date_default_timezone_set('Hongkong');

    $var_datetime = date(' Y-m-d H:i:s');
    $var_user= $_SESSION['UserLogin'];
    $lastrow = $_SESSION['LastRow'];

    $sql = "UPDATE `tbl_audit_trail` SET logout = '$var_datetime' WHERE log_count = '$lastrow'";
    
    if( $con->query($sql)){
        $lastrow = $con->insert_id;

     }else {
        die ($con->error);
     }

        unset($_SESSION['UserLogin']);
        unset($_SESSION['Access']);
        unset($_SESSION['U_ID']);
        unset($_SESSION['LastRow']);

    echo header("Location: products.php");
?>