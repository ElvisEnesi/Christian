<?php
    // include database and constant files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // details process code will go here
    if (isset($_POST['details'])) {
        // declare post variables
        $fullname = filter_var($_POST['fullname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $user_name = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // validation
        if (!$fullname || !$email || !$user_name || !$phone || !$address) {
            $_SESSION['details'] = "All fields are required";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['details'] = "Invalid email address";
        }
        // redirect back if there's any error
        if (isset($_SESSION['details'])) {
            header("Location: " . SITE_URL . "admin/settings.php");
            die();
        } else {
            // update user in our database
            $insert_user_query = "UPDATE users SET full_name=?, email=?, user_name=?, phone=?, address=? WHERE id=?";
            $insert_user_stmt = mysqli_prepare($conn, $insert_user_query);
            $customer_id = $_SESSION['user_id'];
            mysqli_stmt_bind_param($insert_user_stmt, "sssssi", $fullname, $email, $user_name, $phone, $address, $customer_id);
            mysqli_stmt_execute($insert_user_stmt);
            // if any connection error
            if (mysqli_errno($conn)) {
                $_SESSION['details'] = "Error: Failed to update details";
                header("Location: " . SITE_URL . "admin/settings.php");
                die();  
            } else {
                $_SESSION['details_success'] = "Details successfully updated!!";
                header("Location: " . SITE_URL . "admin/settings.php");
                die();
            }
        }
    } else {
        // Redirect to settings page if accessed directly
        header("Location: " . SITE_URL . "admin/settings.php");
        die();
    }
    