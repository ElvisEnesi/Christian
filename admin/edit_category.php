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
    // get id from url
    if (isset($_GET['id'])) {
        $cate_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        // select category
        $select_category = mysqli_prepare($conn, "SELECT * FROM category WHERE id=?");
        mysqli_stmt_bind_param($select_category, "i", $cate_id);
        mysqli_stmt_execute($select_category);
        $result = mysqli_stmt_get_result($select_category);
        $category = mysqli_fetch_assoc($result);
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
        if (isset($_SESSION['update_category'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['update_category'];
            echo "</div>";
        }
        unset($_SESSION['update_category']);
    ?>
    <h1>Edit Category</h1>
    <section class="checkout_container">
        <form class="form_container" action="<?= SITE_URL ?>admin/update_category.php" method="post" class="checkout_form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
            <input type="text" name="title" placeholder="Title" value="<?= htmlspecialchars($category['title']) ?>">
            <textarea name="description" placeholder="Description"><?= htmlspecialchars($category['description']) ?></textarea>
            <button type="submit" name="submit">Submit</button>
        </form>
</body>
</html>