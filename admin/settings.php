<?php
    include('./configuration/database.php');
    include('./configuration/constant.php');
    include('./partials/header.php');
    // check if user is logged in
    if(!isset($_SESSION['user_id'])) {
        // redirect to login page
        $_SESSION['login'] = "Please login to access Panel.";
        header('location: ' . SITE_URL . 'authentication/login.php');
        exit();
    }
?>
    <section class="dashboard_container">
        <aside id="aside">
            <div class="logo">Ethereal</div>
            <div class="profile_info">
                <img src="<?= SITE_URL ?>./images/users/<?= htmlspecialchars($profile_data['picture']) ?>">
            </div>
            <div class="aside_links">
                <a href="<?= SITE_URL ?>admin/profile.php">Dashboard Overview</a>
                <?php if(isset($_SESSION['is_admin'])): ?>
                <a href="<?= SITE_URL ?>admin/manage_category.php">Manage Categories</a>
                <a href="<?= SITE_URL ?>admin/manage_product.php">Manage Products</a>
                <a href="<?= SITE_URL ?>admin/manage_cart.php">Manage Carts</a>
                <a href="<?= SITE_URL ?>admin/manage_orders.php">Manage Orders</a>
                <?php endif ?>
                <a href="<?= SITE_URL ?>admin/settings.php" class="active">Settings</a>
                <a href="<?= SITE_URL ?>authentication/logout.php">Log out</a>
            </div>
        </aside>
        <main>
            <div class="main_container">
                <!-- Settings Header Here -->
                <div class="setting_icon">
                    <span>Settings</span>
                    <span><ion-icon name="settings-outline"></ion-icon></span>
                </div>
                <h1>Your details</h1>
                <?php
                    if (isset($_SESSION['details_success'])) {
                        echo "<div class='success_notice'>";
                        echo $_SESSION['details_success'];
                        echo "</div>";
                    }
                    unset($_SESSION['details_success']);
                ?>
                <?php
                    if (isset($_SESSION['details'])) {
                        echo "<div class='error_notice'>";
                        echo $_SESSION['details'];
                        echo "</div>";
                    }
                    unset($_SESSION['details']);
                ?>
                <?php
                    if (isset($_SESSION['password_success'])) {
                        echo "<div class='success_notice'>";
                        echo $_SESSION['password_success'];
                        echo "</div>";
                    }
                    unset($_SESSION['password_success']);
                ?>
                <?php
                    if (isset($_SESSION['password'])) {
                        echo "<div class='error_notice'>";
                        echo $_SESSION['password'];
                        echo "</div>";
                    }
                    unset($_SESSION['password']);
                ?>
                <div class="details_container">
                    <form action="<?= SITE_URL ?>admin/edit_user_details.php" method="post">
                        <input type="text" name="fullname" value="<?= htmlspecialchars($profile_data['full_name']) ?>" placeholder="Full Name">
                        <input type="email" name="email" value="<?= htmlspecialchars($profile_data['email']) ?>" placeholder="Email">
                        <input type="text" name="username" value="<?= htmlspecialchars($profile_data['user_name']) ?>" placeholder="User Name">
                        <input type="text" name="phone" value="<?= htmlspecialchars($profile_data['phone']) ?>" placeholder="Phone">
                        <input type="text" name="address" value="<?= htmlspecialchars($profile_data['address']) ?>" placeholder="Address">
                        <button type="submit" name="details">Edit Details</button>
                    </form>
                    <form action="<?= SITE_URL ?>admin/edit_user_password.php" method="post">
                        <input type="password" name="current" placeholder="Current password">
                        <input type="password" name="create" placeholder="Create password">
                        <input type="password" name="confirm" placeholder="Confirm password">
                        <button type="submit" name="password">Edit Password</button>
                    </form>
                </div>
            </div>
        </main>
    </section>
    <div class="side" id="open"><ion-icon name="chevron-forward-outline"></ion-icon></div>
    <div class="side" id="close"><ion-icon name="chevron-back-outline"></ion-icon></div>
    <?php include('../partials/footer.php'); ?>