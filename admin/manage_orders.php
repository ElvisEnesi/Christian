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
        if (isset($_SESSION['update_status_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['update_status_success'];
            echo "</div>";
        }
        unset($_SESSION['update_status_success']);
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
                <a href="<?= SITE_URL ?>admin/manage_orders.php" class="active">Manage Orders</a>
                <?php endif ?>
                <a href="<?= SITE_URL ?>admin/settings.php">Settings</a>
                <a href="<?= SITE_URL ?>authentication/logout.php">Log out</a>
            </div>
        </aside>
        <main>
            <?php
                // get orders from database
                $edit = mysqli_prepare($conn, "SELECT * FROM orders ORDER BY id DESC");
                mysqli_stmt_execute($edit);
                $result = mysqli_stmt_get_result($edit);
            ?>
            <div class="main_container">
                <?php if (mysqli_num_rows($result) > 0) : ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Receipt</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Date Created</th>
                        <th>Edit</th>
                    </tr>
                    <?php while ($gottenDetials = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($gottenDetials['id']) ?></td>
                            <td><?= htmlspecialchars($gottenDetials['product_name']) ?></td>
                            <td>$<?= htmlspecialchars($gottenDetials['total_price']) ?></td>
                            <td><?= htmlspecialchars($gottenDetials['quantity']) ?></td>
                            <td><?= htmlspecialchars($gottenDetials['status']) ?></td>
                            <td><a href="../images/receipts/<?= htmlspecialchars($gottenDetials['receipt']) ?>" download="">Download</a></td>
                            <td><?= htmlspecialchars($gottenDetials['phone']) ?></td>
                            <td><?= htmlspecialchars($gottenDetials['address']) ?></td>
                            <td><?= htmlspecialchars(date("M d, Y - H:i", strtotime($gottenDetials['date']))) ?></td>
                            <td><a href="<?= SITE_URL ?>admin/edit_order.php?id=<?= htmlspecialchars($gottenDetials['id']) ?>">Edit</a></td>
                        </tr>
                    <?php endwhile ?>
                </table>
                <?php else : ?>
                    <div class="notice">No data to display, try adding!!</div>
                <?php endif; ?>
            </div>
        </main>
    </section>
    <div class="side" id="open"><ion-icon name="chevron-forward-outline"></ion-icon></div>
    <div class="side" id="close"><ion-icon name="chevron-back-outline"></ion-icon></div>
    <?php include('../partials/footer.php'); ?>