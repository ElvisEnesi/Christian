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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal</title>
    <link rel="stylesheet" href="<?= SITE_URL ?>./css/style.css">
</head>
<body>
    <h1>Checkout</h1>
    <section class="checkout_container">
        <form class="form_container" action="" method="post" class="checkout_form">
            <input type="hidden" name="id">
            <input type="hidden" name="user_id">
            <h2>Payment Information</h2>
            <input type="text" name="card_number" placeholder="Card Number">
            <input type="text" name="expiry_date" placeholder="Expiry Date">
            <input type="text" name="cvv" placeholder="CVV">
            <button type="submit" name="place_order">Place Order</button>
        </form>
</body>
</html>