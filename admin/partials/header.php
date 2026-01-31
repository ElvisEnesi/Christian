<?php
    // Header partial included in admin pages
    include('./configuration/database.php');
    // logged in user check
    $loggedIn = $_SESSION['user_id'] ?? null;
    // display user image
    $select_profile = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
    $profile_stmt = mysqli_stmt_bind_param($select_profile, "i", $loggedIn);
    mysqli_stmt_execute($select_profile);
    $profile_result = mysqli_stmt_get_result($select_profile);
    $profile_data = mysqli_fetch_assoc($profile_result);
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
    <section class="header">
       <div class="logo">
            Ethereal
        </div>
        <div class="nav">
            <div class="icon">
                <ion-icon name="bag-outline"></ion-icon>
                <a href="<?= SITE_URL ?>accessible/shop.php">Shop</a>
            </div>
            <div class="icon">
                <ion-icon name="cart-outline"></ion-icon>
                <a href="<?= SITE_URL ?>admin/cart.php">Cart</a>
            </div>
            <?php if (!isset($_SESSION['user_id'])) : ?>
            <div class="icon">
                <ion-icon name="log-in-outline"></ion-icon>
                <a href="<?= SITE_URL ?>authentication/login.php">Login</a>
            </div>
            <?php else : ?>
            <div class="icon">
                <a href="<?= SITE_URL ?>admin/profile.php"><img src="../images/users/<?= htmlspecialchars($profile_data['picture']) ?>" class="profile_pic"></a>
            </div>
            <?php endif; ?>
        </div>
    </section>