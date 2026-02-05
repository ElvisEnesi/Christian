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
    <?php
        if (isset($_SESSION['add_to_cart_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['add_to_cart_success'];
            echo "</div>";
        }
        unset($_SESSION['add_to_cart_success']);
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
                <a href="<?= SITE_URL ?>admin/manage_cart.php" class="active">Manage Carts</a>
                <a href="<?= SITE_URL ?>admin/manage_orders.php">Manage Orders</a>
                <?php endif ?>
                <a href="<?= SITE_URL ?>admin/settings.php">Settings</a>
                <a href="<?= SITE_URL ?>authentication/logout.php">Log out</a>
            </div>
        </aside>
        <main>
            <?php  
                // join cart, product & customer tables
                $stmt = mysqli_prepare($conn, "SELECT p.id AS product_id, p.title AS product_title, 
                p.price AS product_price, p.available AS product_available, c.id AS cart_id,
                c.product_id AS cart_pid, c.customer_id AS cart_cid, c.status AS cart_status,
                c.date AS cart_date FROM cart c JOIN product p ON c.product_id = p.id WHERE c.status = ?");
                // bind params
                $status = "checked_out";
                mysqli_stmt_bind_param($stmt, "s", $status);
                mysqli_stmt_execute($stmt);
                $table_result = mysqli_stmt_get_result($stmt);
            ?>
            <div class="main_container">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date Created</th>
                    </tr>
                    <?php if (mysqli_num_rows($table_result) > 0) : ?>
                        <?php while ($tab = mysqli_fetch_assoc($table_result)) : ?>
                            <tr>
                                <td><?= htmlspecialchars($tab['cart_id']) ?></td>
                                <td><?= $tab['product_title']?></td>
                                <td>$<?= htmlspecialchars($tab['product_price']) ?></td>
                                <td><?= htmlspecialchars($tab['cart_status']) ?></td>
                                <td><?= date("M, d-y", strtotime(htmlspecialchars($tab['cart_date']))) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="notice">No cart found!!</div>
                    <?php endif; ?>
                </table>
            </div>
        </main>
    </section>
    <div class="side" id="open"><ion-icon name="chevron-forward-outline"></ion-icon></div>
    <div class="side" id="close"><ion-icon name="chevron-back-outline"></ion-icon></div>
    <?php include('../partials/footer.php'); ?>