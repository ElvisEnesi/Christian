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
        // get category from database
        $edit = mysqli_prepare($conn, "SELECT * FROM category");
        mysqli_stmt_execute($edit);
        $result = mysqli_stmt_get_result($edit);
    ?>
    <?php
        if (isset($_SESSION['add_category_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['add_category_success'];
            echo "</div>";
        }
        unset($_SESSION['add_category_success']);
    ?>
    <?php
        if (isset($_SESSION['add_category_error'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['add_category_error'];
            echo "</div>";
        }
        unset($_SESSION['add_category_error']);
    ?>
    <?php
        if (isset($_SESSION['update_category_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['update_category_success'];
            echo "</div>";
        }
        unset($_SESSION['update_category_success']);
    ?>
    <?php
        if (isset($_SESSION['update_category'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['update_category'];
            echo "</div>";
        }
        unset($_SESSION['update_category']);
    ?>
    <?php
        if (isset($_SESSION['delete_category_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['delete_category_success'];
            echo "</div>";
        }
        unset($_SESSION['delete_category_success']);
    ?>
    <?php
        if (isset($_SESSION['delete_category'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['delete_category'];
            echo "</div>";
        }
        unset($_SESSION['delete_category']);
    ?>
    <section class="dashboard_container">
        <aside id="aside">
            <div class="logo">Ethereal</div>
            <div class="profile_info">
                <img src="<?= SITE_URL ?>./images/users/<?= htmlspecialchars($profile_data['picture']) ?>">
            </div>
            <div class="aside_links">
                <a href="<?= SITE_URL ?>admin/profile.php">Dashboard Overview</a>
                <?php if (isset($_SESSION['is_admin'])): ?>
                <a href="<?= SITE_URL ?>admin/manage_category.php" class="active">Manage Categories</a>
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
                <div class="add_page">
                    Want to add a new category? <button onclick="window.location.href='<?= SITE_URL ?>admin/add_category.php'">Add</button>
                </div>
                <?php if (mysqli_num_rows($result) > 0) : ?>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Date Created</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php while ($gottenDetials = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($gottenDetials['id']) ?></td>
                            <td><?= htmlspecialchars($gottenDetials['title']) ?></td>
                            <td><?= htmlspecialchars($gottenDetials['description']) ?></td>
                            <td><?= htmlspecialchars(date("M d, Y - H:i", strtotime($gottenDetials['date']))) ?></td>
                            <td><a href="<?= SITE_URL ?>admin/edit_category.php?id=<?= htmlspecialchars($gottenDetials['id']) ?>">Edit</a></td>
                            <td><a href="<?= SITE_URL ?>admin/delete_category.php?id=<?= htmlspecialchars($gottenDetials['id']) ?>" class="danger">Delete</a></td>
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