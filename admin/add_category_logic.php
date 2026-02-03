<?php
    // include files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // php logic
    if (isset($_POST['submit'])) {
        // define variables
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // validate inputs
        if (!$title || !$description) {
            $_SESSION['add_category'] = "Fill in all inputs!!";
        }
        // redirect if there's any error
        if (isset($_SESSION['add_category'])) {
            header("location: " . SITE_URL . "admin/add_category.php");
            die();
        } else {
            // insert in to category table if no errors
            $stmt = mysqli_prepare($conn, "INSERT INTO category (title, description) VALUES(?,?)");
            mysqli_stmt_bind_param($stmt, "ss", $title, $description);
            mysqli_stmt_execute($stmt);
            // redirect with success message to manage categories
            if (!mysqli_errno($conn)) {
                $_SESSION['add_category_success'] = "New category successfully added!!";
                header("location: " . SITE_URL . "admin/manage_category.php");
                die();
            } else {
                // redirect with error message to manage categories
                $_SESSION['add_category_error'] = "Couldn't add new category!!";
                header("location: " . SITE_URL . "admin/manage_category.php");
                die();
            }   
        }
    } else {
        // redirect if accessed directly
        header("location: " .SITE_URL . "admin/add_category.php");
        die();
    }
    