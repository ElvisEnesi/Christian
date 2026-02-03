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
    <?php
        if (isset($_SESSION['add_category'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['add_category'];
            echo "</div>";
        }
        unset($_SESSION['add_category']);
    ?>
    <h1>Add Category</h1>
    <section class="checkout_container">
        <form class="form_container" action="<?= SITE_URL ?>admin/add_category_logic.php" method="post" class="checkout_form">
            <input type="text" name="title" placeholder="Title">
            <textarea name="description" placeholder="Description"></textarea>
            <button type="submit" name="submit">Submit</button>
        </form>
</body>
</html>