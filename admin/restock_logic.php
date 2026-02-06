<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');

    if (isset($_POST['submit'])) {
        $id            = (int) $_POST['id'];
        $quantity      = (int) $_POST['quantity'];
        // -------- VALIDATION --------
        if (!$id || !$quantity ) {
            $_SESSION['update_product'] = "All fields are required!";
        }
        elseif ($quantity < 1 || $quantity > 100) {
            $_SESSION['update_product'] = "Quantity must be between 1 and 100!";
        }
        // -------- REDIRECT IF ERROR --------
        if (isset($_SESSION['update_product'])) {
            header("location: " . SITE_URL . "admin/restock.php?id=" . $id);
            exit;
        }

        // -------- UPDATE DATABASE --------

        $stmt = mysqli_prepare($conn, "UPDATE product SET quantity=? WHERE id=?");

        mysqli_stmt_bind_param($stmt, "ii", $quantity, $id);

        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) >= 0) {
            $_SESSION['update_product_success'] = "Product successfully updated!";
        } else {
            $_SESSION['update_product'] = "Update failed!";
        }

        header("location: " . SITE_URL . "admin/profile.php");
        exit;

    } else {
        header("location: " . SITE_URL . "admin/restock.php");
        exit;
    }
?>
