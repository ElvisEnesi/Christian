<?php
    // include files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // get id from url
    if (isset($_GET['id'])) {
        $product_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        // select product
        $select_product = mysqli_prepare($conn, "SELECT * FROM product WHERE id=?");
        mysqli_stmt_bind_param($select_product, "i", $product_id);
        mysqli_stmt_execute($select_product);
        $result = mysqli_stmt_get_result($select_product);
        $product = mysqli_fetch_assoc($result);
    } else {
        header("location: " . SITE_URL . "admin/manage_product.php");
        exit;
    }
    $previous_image = $product['avatar'];
    $previous_image_path = "../images/products/" . $previous_image;
    if ($previous_image_path) {
        // unlink image from folder
        unlink($previous_image_path);
    }
    $stmt = mysqli_prepare($conn, "DELETE FROM product WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $product['id']);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) >= 0) {
        $_SESSION['delete_product_success'] = "product successfully deleted!";
    } else {
        $_SESSION['delete_product'] = "Delete failed!";
    }
    header("location: " . SITE_URL . "admin/manage_product.php");
    exit;
    
?>