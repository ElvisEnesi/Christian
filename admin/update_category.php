<?php
    // include files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // php logic
    if (isset($_POST['submit'])) {
        // define variables
        $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        // validate inputs
        if (!$title || !$description) {
            $_SESSION['update_category'] = "Fill in all inputs!!";
        }
        // redirect if there's any error
        if (isset($_SESSION['update_category'])) {
            header("location: " . SITE_URL . "admin/update_category.php?id=" . $id);
            die();
        } else {
            // update in to category table if no errors
            $stmt = mysqli_prepare($conn, "UPDATE category SET title=?, description=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $id);
            mysqli_stmt_execute($stmt);
            // redirect with success message to manage categories
            if (!mysqli_errno($conn)) {
                $_SESSION['update_category_success'] = "Category successfully updated!!";
                header("location: " . SITE_URL . "admin/manage_category.php");
                die();
            } else {
                // redirect with error message to manage categories
                $_SESSION['update_category'] = "Couldn't update category!!";
                header("location: " . SITE_URL . "admin/manage_category.php");
                die();
            }   
        }
    } else {
        // redirect if accessed directly
        header("location: " .SITE_URL . "admin/manage_category.php");
        die();
    }
    