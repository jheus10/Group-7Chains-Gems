<?php

    include_once("connections/connection.php");
    $con = connection();

    if (isset($_POST['delete'])){

        $id = $_POST['ID'];
        $sql = "DELETE FROM tbl_product WHERE prod_id = '$id'";

        $con->query($sql) or die ($con->error);
        echo header("Location: products.php");
        
    }else{
        echo "Invalid id.";
    }

?>