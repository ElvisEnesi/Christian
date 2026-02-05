<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // check if user is logged in
    if(!isset($_SESSION['user_id'])) {
        // redirect to login page
        $_SESSION['login'] = "Please login to access Panel.";
        header('location: ' . SITE_URL . 'authentication/login.php');
        exit();//
    }
    // get id from url
    if (isset($_GET['id'])) {
        $product_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        // select product
        $select_product = mysqli_prepare($conn, "SELECT * FROM product WHERE id=?");
        mysqli_stmt_bind_param($select_product, "i", $product_id);
        mysqli_stmt_execute($select_product);
        $result = mysqli_stmt_get_result($select_product);
        $product = mysqli_fetch_assoc($result);
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
    <?php
        if (isset($_SESSION['update_product_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['update_product_success'];
            echo "</div>";
        }
        unset($_SESSION['update_product_success']);
    ?>
    <?php
        if (isset($_SESSION['update_product'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['update_product'];
            echo "</div>";
        }
        unset($_SESSION['update_product']);
    ?>
    <h1>Edit Product</h1>
    <section class="checkout_container">
        <form class="form_container" action="<?php echo SITE_URL ?>admin/update_product.php" method="post" enctype="multipart/form-data" class="checkout_form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
            <input type="hidden" name="previous_avatar" value="<?= htmlspecialchars($product['avatar']) ?>">
            <input type="text" name="title" placeholder="Title" value="<?= $product['title'] ?>">
            <input type="number" name="price" placeholder="Price" value="<?= htmlspecialchars($product['price']) ?>">
            <input type="number" name="quantity" placeholder="Quantity" value="<?= htmlspecialchars($product['quantity']) ?>">
            <?php
                // select category
                $select_category = mysqli_prepare($conn, "SELECT * FROM category");
                mysqli_stmt_execute($select_category);
                $resultt = mysqli_stmt_get_result($select_category);
            ?>
            <select name="category">
                <?php while ($category = mysqli_fetch_assoc($resultt)) : ?>
                    <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['title']) ?></option>
                <?php endwhile; ?>
            </select>
            <input type="file" name="avatar">
            <button type="submit" name="submit">Submit</button>
        </form>
</body>
</html>