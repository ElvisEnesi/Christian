<?php
    // include files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // php logic
    if (isset($_POST['place_order'])) {
        // define variables
        $cart_id = (int) $_POST['cart_id'];
        $customer_id = $_SESSION['user_id'];
        $customer_phone = (string) $_POST['customer_phone'];
        $address = (string) $_POST['address'];
        $avatar = $_FILES['avatar'];
        if (!$cart_id || !is_numeric($cart_id)) {
            $_SESSION['error'] = "Invalid cart ID.";
            header("location: " . SITE_URL . "admin/cart.php");
            die();
        }
        if (!$customer_phone || !$address) {
            $_SESSION['error'] = "Fill all required fields!!";
            header("location: " . SITE_URL . "admin/cart.php");
            die();
        }
        if (!empty($avatar['name'])) {
            // work on avatar
            $avatar_name = $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination = "../images/receipts/" . $avatar_name;
            // allowed files
            $allowed_extensions = ['image/jpg', 'image/jpeg', 'image/png'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $avatar_tmp_name);
            if (!in_array($mime_type, $allowed_extensions)) {
                $_SESSION['error'] = "Invalid file type. Only JPG, JPEG, and PNG are allowed as payment receipt!!";
                header("location: " . SITE_URL . "admin/cart.php");
                die();
            } else {
                // check size 
                if ($avatar['size'] < 2000000) {
                    // move file to destination
                    move_uploaded_file($avatar_tmp_name, $avatar_destination);
                } else {
                    $_SESSION['error'] = "File size exceeds 2MB limit.";
                    header("location: " . SITE_URL . "admin/cart.php");
                    die();
                } 
            }
        } else {
            $_SESSION['error'] = "Please upload a payment receipt!!";
            header("location: " . SITE_URL . "admin/cart.php");
            die();
        }
        // join cart, product & customer tables
        $stmt = mysqli_prepare($conn, "SELECT p.id AS product_id, p.title AS product_title, p.quantity AS product_quantity,
        p.price AS product_price, p.available AS product_available, p.avatar AS product_avatar, c.id AS cart_id,
        c.product_id AS cart_pid, c.customer_id AS cart_cid, c.status AS cart_status, c.quantity AS cart_quantity,
        c.date AS cart_date FROM cart c JOIN product p ON c.product_id = p.id WHERE c.id = ? AND c.customer_id = ?");
        // bind params
        mysqli_stmt_bind_param($stmt, "si", $cart_id, $customer_id);
        mysqli_stmt_execute($stmt);
        $table_result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        // check if cart quantity is greater than product quantity
        if ($table_result['cart_quantity'] > $table_result['product_quantity']) {
            $_SESSION['error'] = "Cart quantity exceeds available product quantity!!";
            header("location: " . SITE_URL . "admin/cart.php");
            die();
        }
        // cart details to add to order table
        $product_name = $table_result['product_title'];
        $quantity = $table_result['cart_quantity'];
        $total_price = $table_result['product_price'] * $quantity;
        // insert order details into order table
        $stmt = mysqli_prepare($conn, "INSERT INTO orders (customer_id, product_name, quantity, total_price, phone, address, receipt) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isiisss", $customer_id, $product_name, $quantity, $total_price, $customer_phone, $address, $avatar_name);
        if (mysqli_stmt_execute($stmt)) {
            // update product quantity
            $new_quantity = $table_result['product_quantity'] - $quantity;
            $stmt = mysqli_prepare($conn, "UPDATE product SET quantity = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "ii", $new_quantity, $table_result['product_id']);
            mysqli_stmt_execute($stmt);
            // update cart status to completed
            $status = "checked_out";
            $stmt = mysqli_prepare($conn, "UPDATE cart SET status = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $status, $cart_id);
            mysqli_stmt_execute($stmt);
            // if ($table_result['product_quantity'] === 0) {
            //     // update product availability to 0
            //     $available = 0;
            //     $stmt = mysqli_prepare($conn, "UPDATE product SET available = ? WHERE id = ?");
            //     mysqli_stmt_bind_param($stmt, "ii", $available, $table_result['product_id']);
            //     mysqli_stmt_execute($stmt);
            // }
            $_SESSION['add_to_cart_success'] = "Order placed successfully!!";
            header("location: " . SITE_URL . "admin/cart.php");
            die();
        } else {
            $_SESSION['error'] = "Failed to place order!!";
            header("location: " . SITE_URL . "admin/cart.php");
            die();
        }
    } else {
        $_SESSION['error'] = "Please select a cart item to checkout!!";
        header("location: " . SITE_URL . "admin/cart.php");
        die();
    }
    