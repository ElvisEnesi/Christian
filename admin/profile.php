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
                <a href="<?= SITE_URL ?>admin/profile.php" class="active">Dashboard Overview</a>
                <?php if(isset($_SESSION['is_admin'])): ?>
                <a href="<?= SITE_URL ?>admin/manage_category.php">Manage Categories</a>
                <a href="<?= SITE_URL ?>admin/manage_product.php">Manage Products</a>
                <a href="<?= SITE_URL ?>admin/manage_cart.php">Manage Carts</a>
                <a href="<?= SITE_URL ?>admin/manage_orders.php">Manage Orders</a>
                <?php endif ?>
                <a href="<?= SITE_URL ?>admin/settings.php">Settings</a>
                <a href="<?= SITE_URL ?>authentication/logout.php">Log out</a>
            </div>
        </aside>
        <main>
            <div class="main_container">
                <div class="main_details">
                    <div class="greetings">Hello <?= htmlspecialchars($profile_data['full_name']) ?>, welcome back</div>
                    <!-- <div class="year_joined">You joined us 2022</div> -->
                </div>
                <!--FOR ADMIN-->
                <?php if(isset($_SESSION['is_admin'])): ?>
                <div class="overview">
                    <div class="column">
                        <h4>Total Pending Orders</h4>
                        <span>24 Orders</span>
                    </div>
                    <div class="column">
                        <h4>Total Yearly Sales</h4>
                        <span>$345,900</span>
                    </div>
                    <div class="column">
                        <h4>Monthly Sales</h4>
                        <span>$54,000</span>
                    </div>
                    <div class="column">
                        <h4>Monthly Products</h4>
                        <span>326 Products Available</span>
                    </div>
                </div>
                <div class="sales_message">
                    <div class="items_message">
                        Men's Bracelet are low on stocks, 7 available. <a href="restock.php">Restock??</a>
                    </div>
                    <div class="items_message">
                        Diamond Ring are low on stocks, 7 available. <a href="restock.php">Restock??</a>
                    </div>
                    <div class="items_message">
                        Women's Bracelet are low on stocks, 7 available. <a href="restock.php">Restock??</a>
                    </div>
                </div>
                <!--FOR USER-->
                <?php else: ?>
                <div class="overview">
                    <div class="column">
                        <h4>Total Orders</h4>
                        <p>24 Orders</p>
                    </div>
                    <?php 
                        // select active carts
                        $cart_status = "active";
                        $cart_stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS active_carts FROM cart WHERE status = ? AND customer_id = ?");
                        mysqli_stmt_bind_param($cart_stmt, "si", $cart_status, $loggedIn);
                        mysqli_stmt_execute($cart_stmt);
                        $cart_result = mysqli_fetch_assoc(mysqli_stmt_get_result($cart_stmt));
                    ?>
                    <div class="column">
                        <h4>Total Active Carts</h4>
                        <p><?= htmlspecialchars($cart_result['active_carts']) ?> Carts</p>
                    </div>
                    <div class="column">
                        <h4>Last Order</h4>
                        <p>Men's silver bracelet</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </section>
    <div class="side" id="open"><ion-icon name="chevron-forward-outline"></ion-icon></div>
    <div class="side" id="close"><ion-icon name="chevron-back-outline"></ion-icon></div>
    <?php include('../partials/footer.php'); ?>