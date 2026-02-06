<?php
    // include files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // get id from url
    if (isset($_GET['id'])) {
        $cart_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        // select cart
        $select_cart = mysqli_prepare($conn, "SELECT * FROM cart WHERE id=?");
        mysqli_stmt_bind_param($select_cart, "i", $cart_id);
        mysqli_stmt_execute($select_cart);
        $result = mysqli_stmt_get_result($select_cart);
        $cart = mysqli_fetch_assoc($result);
    } else {
        header("location: " . SITE_URL . "admin/cart.php");
        exit;
    }
    $stmt = mysqli_prepare($conn, "DELETE FROM cart WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $cart['id']);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) >= 0) {
        $_SESSION['delete_cart_success'] = "cart successfully deleted!";
    } else {
        $_SESSION['delete_cart'] = "Delete failed!";
    }
    header("location: " . SITE_URL . "admin/cart.php");
    exit;
    
?>