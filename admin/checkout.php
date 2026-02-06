<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // loggedin user
    $loggedIn = $_SESSION['user_id'];
    // check if user is logged in
    if(!isset($_SESSION['user_id'])) {
        // redirect to login page
        $_SESSION['login'] = "Please login to access Panel.";
        header('location: ' . SITE_URL . 'authentication/login.php');
        exit();
    }
    if (isset($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    } else {
        header('location: ' . SITE_URL . 'admin/cart.php');
    }
?>
    <?php  
        // join cart, product & customer tables
        $stmt = mysqli_prepare($conn, "SELECT p.id AS product_id, p.title AS product_title, p.quantity AS product_quantity,
        p.price AS product_price, p.available AS product_available, p.avatar AS product_avatar, c.id AS cart_id,
        c.product_id AS cart_pid, c.customer_id AS cart_cid, c.status AS cart_status, c.quantity AS cart_quantity,
        c.date AS cart_date FROM cart c JOIN product p ON c.product_id = p.id WHERE c.id = ? AND c.customer_id = ?");
        // bind params
        mysqli_stmt_bind_param($stmt, "si", $id, $loggedIn);
        mysqli_stmt_execute($stmt);
        $table_result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>css/style.css">
</head>
<body>
    <?php $total_price = $table_result['product_price'] * $table_result['cart_quantity']; ?>
    <div class="notice">Total price, $<?= htmlspecialchars($total_price) ?> should be paid to & receipt sent below!!</div>
    <h1>Checkout</h1>
    <section class="checkout_container">
        <form class="form_container" action="<?= SITE_URL ?>admin/checkout_logic.php" method="post" enctype="multipart/form-data" class="checkout_form">
            <h2>Payment Information</h2>
            <input type="hidden" name="cart_id" value="<?= htmlspecialchars($table_result['cart_id']) ?>">
            <input type="text" name="customer_phone" placeholder="Enter your phone number">
            <input type="text" name="address" placeholder="Enter your address">
            <input type="file" name="avatar">
            <button type="submit" name="place_order">Place Order</button>
        </form>
    </section>
</body>
</html>