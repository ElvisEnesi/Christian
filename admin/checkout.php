<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>css/style.css">
</head>
<body>
    <div class="notice">Total price, $345 should be paid to & receipt sent below!!</div>
    <h1>Checkout</h1>
    <section class="checkout_container">
        <form class="form_container" action="<?= SITE_URL ?>admin/checkout_logic.php" method="post" enctype="multipart/form-data" class="checkout_form">
            <h2>Payment Information</h2>
            <input type="file" name="avatar">
            <button type="submit" name="place_order">Place Order</button>
        </form>
</body>
</html>