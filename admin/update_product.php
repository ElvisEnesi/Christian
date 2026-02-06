<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');

    if (isset($_POST['submit'])) {
        $id            = (int) $_POST['id'];
        $title         = trim($_POST['title']);
        $price         = (int) $_POST['price'];
        $quantity      = (int) $_POST['quantity'];
        $category_id   = (int) $_POST['category'];
        $previous_avatar = trim($_POST['previous_avatar']);
        $avatar        = $_FILES['avatar'];
        // -------- VALIDATION --------
        if ($id <= 0 || $title === "" || $price <= 0 || $quantity <= 0 || $category_id <= 0) {
            $_SESSION['update_product'] = "All fields are required!";
        }
        elseif ($quantity < 1 || $quantity > 100) {
            $_SESSION['update_product'] = "Quantity must be between 1 and 100!";
        }
        // -------- IMAGE PROCESS --------
        $avatar_name = $previous_avatar; // default = keep old image
        if (!empty($avatar['name'])) {

            $avatar_name = time() . "_" . basename($avatar['name']);
            $avatar_tmp  = $avatar['tmp_name'];
            $avatar_path = "../images/products/" . $avatar_name;
            $allowed_types = ['image/jpg', 'image/jpeg', 'image/png'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type  = finfo_file($finfo, $avatar_tmp);
            finfo_close($finfo);
            if (!in_array($type, $allowed_types)) {
                $_SESSION['update_product'] = "Image must be JPG, JPEG or PNG!";
            }
            elseif ($avatar['size'] > 2_000_000) {
                $_SESSION['update_product'] = "Image must be less than 2MB!";
            }
            elseif (!move_uploaded_file($avatar_tmp, $avatar_path)) {
                $_SESSION['update_product'] = "Image upload failed!";
            }
            else {
                // delete old image only after new upload succeeds
                if (!empty($previous_avatar)) {
                    $old_path = "../images/products/" . $previous_avatar;
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
            }
        }

        // -------- REDIRECT IF ERROR --------

        if (isset($_SESSION['update_product'])) {
            header("location: " . SITE_URL . "admin/update_product.php?id=" . $id);
            exit;
        }

        // -------- UPDATE DATABASE --------

        $stmt = mysqli_prepare($conn,
            "UPDATE product 
            SET title=?, price=?, quantity=?, category_id=?, avatar=? 
            WHERE id=?"
        );

        mysqli_stmt_bind_param($stmt, "siiisi",
            $title, $price, $quantity, $category_id, $avatar_name, $id
        );

        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) >= 0) {
            $_SESSION['update_product_success'] = "Product successfully updated!";
        } else {
            $_SESSION['update_product'] = "Update failed!";
        }

        header("location: " . SITE_URL . "admin/manage_product.php");
        exit;

    } else {
        header("location: " . SITE_URL . "admin/manage_product.php");
        exit;
    }
?>
