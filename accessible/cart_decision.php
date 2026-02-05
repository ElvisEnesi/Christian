<?php
    // include configuration files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    if (isset($_POST['add_to_cart'])) {
        // declare variables
        $product_id = filter_var($_POST['product_id'], FILTER_SANITIZE_NUMBER_INT);
        $customer_id = $_SESSION['user_id'];
        // check if we have an id inputted
        if (!$product_id && !is_numeric($product_id)) { 
            header("location: " . SITE_URL . "accessible/shop.php");
            die(); 
        }
        // insert into cart table
        $stmt = mysqli_prepare($conn, "INSERT INTO cart (customer_id, product_id) VALUES(?, ?)");
        mysqli_stmt_bind_param($stmt, "ii", $customer_id, $product_id);
        mysqli_stmt_execute($stmt);
        // check for successful insertions & errors
        if (mysqli_errno($conn)) {
            $_SESSION['add_to_cart'] = "Error: Failed to add to cart!!";
            header("Location: " . SITE_URL . "accessible/shop.php");
            die();  
        } else {
            $_SESSION['add_to_cart_success'] = "Cart successfully added!!";
            if (isset($_SESSION['is_admin'])) {
                header("Location: " . SITE_URL . "admin/manage_cart.php");
                die();
            } else {
                header("Location: " . SITE_URL . "admin/cart.php");
                die();
            }
        }
    } elseif (isset($_POST['sign'])) {
        $_SESSION['login'] = "Please login to add items to your cart!!";
        header("location: " . SITE_URL . "authentication/login.php");
        die();
    } else {
        header("location: " . SITE_URL . "accessible/shop.php");
        die();
    }
    //     if ($stock <= 5) {
//     mail(
//         "admin@yourstore.com",
//         "Low Stock Alert",
//         "$product_name has only $stock left"
//     );
// }

    