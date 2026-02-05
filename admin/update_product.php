<?php
    // include files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // php logic
    if (isset($_POST['submit'])) {
        // define variables
        $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
        $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $previous_avatar = filter_var($_POST['previous_avatar'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $avatar = $_FILES['avatar'];
        // validate inputs
        if (!$title || !$price || !$quantity || !$category_id || !$avatar['name']) {
            $_SESSION['update_product'] = "Fill in all inputs!!";
        } elseif (!is_numeric($price) || !is_numeric($quantity) || !is_numeric($category_id)) {
            $_SESSION['update_product'] = "Price, quantity & category id must be a number!!";
        } elseif ($price < 1 ) {
            $_SESSION['update_product'] = "Quantity must be more than 1!!";
        } elseif ($quantity < 1 && $quantity > 100) {
            $_SESSION['update_product'] = "Quantity must be in a range of 1-100!!";
        } else {
            // work on image
            $avatar_name = $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_path = "../images/products/" . $avatar_name;
            // check if it's an image
            $allowed_files = ['image/jpg', 'image/png', 'image/jpeg'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $avatar_tmp_name);
            if (in_array($type, $allowed_files)) {
                // check file size
                if ($avatar['size'] < 2_000_000) {
                    // upload avatar
                    move_uploaded_file($avatar_tmp_name, $avatar_path);
                } else {
                    $_SESSION['update_product'] = "File size too big. Should be less than 2MB";
                }
            } else {
                $_SESSION['update_product'] = "File should be png, jpg or jpeg";
            }
        }
        // redirect if there's any error
        if (isset($_SESSION['update_product'])) {
            header("location: " . SITE_URL . "admin/update_product.php?id=" . $id);
            die();
        } else {
            // update in to product table if no errors
            $stmt = mysqli_prepare($conn, "UPDATE product SET title=?, price=?, quantity=?, category_id=?, avatar=? WHERE id=?");
            mysqli_stmt_bind_param($stmt, "siiisi", $title, $price, $quantity, $category_id, $avatar_name, $id);
            mysqli_stmt_execute($stmt);
            // unlink previous avatar after updating
            $previous_avatar_path = "../images/products/" . $previous_avatar;
            if ($previous_avatar_path) {
                unlink($previous_avatar_path);
            }
            // redirect with success message to manage categories
            if (!mysqli_errno($conn)) {
                $_SESSION['update_product_success'] = "Product successfully updated!!";
                header("location: " . SITE_URL . "admin/manage_product.php");
                die();
            } else {
                // redirect with error message to manage categories
                $_SESSION['update_product'] = "Couldn't update product!!";
                header("location: " . SITE_URL . "admin/manage_product.php");
                die();
            }   
        }
    } else {
        // redirect if accessed directly
        header("location: " .SITE_URL . "admin/manage_product.php");
        die();
    }
    