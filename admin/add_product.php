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
    // get user id using session
    $loggedIn = $_SESSION['user_id'];
    // get category from database
    $edit = mysqli_prepare($conn, "SELECT * FROM category");
    mysqli_stmt_execute($edit);
    $result = mysqli_stmt_get_result($edit);
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
        if (isset($_SESSION['add_product'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['add_product'];
            echo "</div>";
        }
        unset($_SESSION['add_product']);
    ?>
    <h1>Add Product</h1>
    <section class="checkout_container">
        <form class="form_container" action="<?= SITE_URL ?>admin/add_product_logic.php" method="post" enctype="multipart/form-data" class="checkout_form">
            <input type="text" name="title" placeholder="Title">
            <input type="number" name="price" placeholder="Price" min="1">
            <input type="number" name="quantity" placeholder="Quantity" min="1" max="100">
            <select name="category">
                <?php while ($gottenDetials = mysqli_fetch_assoc($result)) : ?>
                <option value="<?= htmlspecialchars($gottenDetials['id']) ?>"><?= htmlspecialchars($gottenDetials['title']) ?></option>
                <?php endwhile; ?>
            </select>
            <input type="file" name="avatar">
            <button type="submit" name="submit">Submit</button>
        </form>
</body>
</html>