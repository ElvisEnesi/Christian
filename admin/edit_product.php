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
    <h1>Edit Product</h1>
    <section class="checkout_container">
        <form class="form_container" action="" method="post" class="checkout_form">
            <input type="text" name="title" placeholder="Title">
            <input type="text" name="description" placeholder="Description"> 
            <input type="number" name="price" placeholder="Price">
            <input type="number" name="quantity" placeholder="Quantity">
            <select name="category">
                <option value="">Rings</option>
            </select>
            <input type="file" name="avatar">
            <button type="submit" name="submit">Submit</button>
        </form>
</body>
</html>