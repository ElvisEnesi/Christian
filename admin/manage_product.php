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
    // get product from database
    $edit = mysqli_prepare($conn, "SELECT * FROM product");
    mysqli_stmt_execute($edit);
    $result = mysqli_stmt_get_result($edit);
?>
    <?php
        if (isset($_SESSION['add_product_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['add_product_success'];
            echo "</div>";
        }
        unset($_SESSION['add_product_success']);
    ?>
    <?php
        if (isset($_SESSION['add_product_error'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['add_product_error'];
            echo "</div>";
        }
        unset($_SESSION['add_product_error']);
    ?>
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
                <a href="<?= SITE_URL ?>admin/manage_product.php" class="active">Manage Products</a>
                <a href="<?= SITE_URL ?>admin/manage_cart.php">Manage Carts</a>
                <a href="<?= SITE_URL ?>admin/manage_orders.php">Manage Orders</a>
                <?php endif ?>
                <a href="<?= SITE_URL ?>admin/settings.php">Settings</a>
                <a href="<?= SITE_URL ?>authentication/logout.php">Log out</a>
            </div>
        </aside>
        <main>
            <div class="main_container">
                <div class="add_page">
                    Want to add a new product? <button onclick="window.location.href='<?= SITE_URL ?>admin/add_product.php'">Add</button>
                </div>
                <?php if (mysqli_num_rows($result) > 0) : ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Availability</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php while ($gottenDetials = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($gottenDetials['id']) ?></td>
                        <td><?= $gottenDetials['title'] ?></td>
                        <td>$<?= htmlspecialchars($gottenDetials['price']) ?></td>
                        <td><?= htmlspecialchars($gottenDetials['quantity']) ?></td>
                        <td><?= htmlspecialchars($gottenDetials['available'] ? 'yes' : 'no') ?></td>
                        <td><a href="<?= SITE_URL ?>admin/edit_product.php?id=<?= htmlspecialchars($gottenDetials['id']) ?>">Edit</a></td>
                        <td><a href="<?= SITE_URL ?>admin/delete_product.php?id=<?= htmlspecialchars($gottenDetials['id']) ?>" class="danger">Delete</a></td>
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