<?php
    // include configuration files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    if (isset($_POST['submit'])) {
        // declare variables
        $cart_id = filter_var($_POST['cart_id'], FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
        // check if we have an id inputted
        if (!$cart_id && !is_numeric($cart_id)) { 
            header("location: " . SITE_URL . "admin/cart.php");
            die(); 
            if ($quantity < 1 && !$quantity) {
                $_SESSION['cart'] = "Cart must have a quantity of 1++";
                header("location: " . SITE_URL . "admin/cart.php");
                die(); //
            }
        } else {
            header("location: " . SITE_URL . "admin/checkout.php?id=" . $cart_id);
            die();
        }
        // update in to cart table 
        $stmt = mysqli_prepare($conn, "UPDATE cart SET quantity=? WHERE id=?");
        mysqli_stmt_bind_param($stmt, "ii", $quantity, $cart_id);
        mysqli_stmt_execute($stmt);
    } elseif (isset($_POST['remove'])) {
        header("location: " . SITE_URL . "admin/delete_cart.php?id=" . $cart_id);
        die();
    } else {
        header("location: " . SITE_URL . "admin/cart.php");
        die();
    }
    //     if ($stock <= 5) {
//     mail(
//         "admin@yourstore.com",
//         "Low Stock Alert",
//         "$product_name has only $stock left"
//     );
// }

    