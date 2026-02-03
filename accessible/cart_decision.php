<?php
    // include configuration files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    if (isset($_POST['submit'])) {
        # code...
    } elseif (isset($_POST['sign'])) {
        $_SESSION['login'] = "Please login to add items to your cart!!";
        header("location: " . SITE_URL . "authentication/login.php");
        die();
    } else {
        header("location: " . SITE_URL . "accessible/shop.php");
        die();
    }
    