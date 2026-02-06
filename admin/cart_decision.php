<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');

    if (isset($_POST['submit'])) {
        $cart_id = (int) $_POST['cart_id'];
        $quantity = trim($_POST['quantity']);
        // VALIDATION
        if ($cart_id <= 0) {
            $_SESSION['cart_error'] = "Invalid cart ID";
            header("location: " . SITE_URL . "admin/cart.php");
            exit;
        }
        if ($quantity === "" || !ctype_digit($quantity) || $quantity < 1) {
            $_SESSION['cart_error'] = "Quantity must be a valid number greater than 0";
            header("location: " . SITE_URL . "admin/cart.php");
            exit;
        }
        // UPDATE QUERY
        $stmt = mysqli_prepare($conn, "UPDATE cart SET quantity = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $quantity, $cart_id);
        mysqli_stmt_execute($stmt);
        // redirect
        header("location: " . SITE_URL . "admin/checkout.php?id=" . $cart_id);
        exit;
    } elseif (isset($_POST['remove'])) {
        $cart_id = (int) $_POST['cart_id'];
        header("location: " . SITE_URL . "admin/delete_cart.php?id=" . $cart_id);
        exit;
    } else {
        header("location: " . SITE_URL . "admin/cart.php");
        exit;
    }
?>
