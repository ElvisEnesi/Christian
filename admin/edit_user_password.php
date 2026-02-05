<?php
    // include database and constant files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // password process code will go here
    if (isset($_POST['password'])) {
        // declare post variables
        $customer_id = $_SESSION['user_id'];
        $current = filter_var($_POST['current'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $create = filter_var($_POST['create'], FILTER_SANITIZE_SPECIAL_CHARS);
        $confirm = filter_var($_POST['confirm'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // validation
        if (!$current || !$create || !$confirm) {
            $_SESSION['password'] = "All password fields are required";
        } elseif (strlen($create) < 8 || strlen($confirm) < 8) {
            $_SESSION['password'] = "All passwords must be 8+";
        } else {
            // select password from users table
            $select_stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE id = ?");
            mysqli_stmt_bind_param($select_stmt, "i", $customer_id);
            mysqli_stmt_execute($select_stmt);
            $result = mysqli_stmt_get_result($select_stmt);
            $passkey = mysqli_fetch_assoc($result);
            if ($current == $passkey['password']) {
                // check if new passwords match
                if ($create == $confirm) {
                    // hash our passwrd
                    $hashed_password = password_hash($create, PASSWORD_DEFAULT);
                } else {            
                    $_SESSION['password'] = "New passwords don't match!!";
                }
            } else {        
                $_SESSION['password'] = "Incorrect current password!";
            }
        }
        // redirect back if there's any error
        if (isset($_SESSION['password'])) {
            header("Location: " . SITE_URL . "admin/settings.php");
            die();
        } else {
            // update user in our database
            $insert_user_query = "UPDATE users SET password=? WHERE id=?";
            $insert_user_stmt = mysqli_prepare($conn, $insert_user_query);
            mysqli_stmt_bind_param($insert_user_stmt, "si", $hashed_password, $customer_id);
            mysqli_stmt_execute($insert_user_stmt);
            // if any connection error
            if (mysqli_errno($conn)) {
                $_SESSION['password'] = "Error: Failed to update password";
                header("Location: " . SITE_URL . "admin/settings.php");
                die();  
            } else {
                $_SESSION['password_success'] = "Password successfully updated!!";
                header("Location: " . SITE_URL . "admin/settings.php");
                die();
            }
        }
    } else {
        // Redirect to settings page if accessed directly
        header("Location: " . SITE_URL . "admin/settings.php");
        die();
    }
    