<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');

    if (isset($_POST['submit'])) {
        $id            = (int) $_POST['id'];
        $status      = (string) $_POST['status'];
        // -------- VALIDATION --------
        if (!$id || !$status ) {
            $_SESSION['update_status'] = "All fields are required!";
        }
        // -------- REDIRECT IF ERROR --------
        if (isset($_SESSION['update_status'])) {
            header("location: " . SITE_URL . "admin/edit_order.php?id=" . $id);
            exit;
        }

        // -------- UPDATE DATABASE --------

        $stmt = mysqli_prepare($conn, "UPDATE orders SET status=? WHERE id=?");

        mysqli_stmt_bind_param($stmt, "si", $status, $id);

        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) >= 0) {
            $_SESSION['update_status_success'] = "Status successfully updated!";
        } else {
            $_SESSION['update_status'] = "Update failed!";
        }

        header("location: " . SITE_URL . "admin/manage_orders.php");
        exit;

    } else {
        header("location: " . SITE_URL . "admin/edit_order.php");
        exit;
    }
?>
