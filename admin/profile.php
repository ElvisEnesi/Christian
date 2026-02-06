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
        if (isset($_SESSION['update_product_success'])) {
            echo "<div class='success_notice'>";
            echo $_SESSION['update_product_success'];
            echo "</div>";
        }
        unset($_SESSION['update_product_success']);
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
            <?php  
                // select total orders of logged in user
                $order_stmt = mysqli_prepare($conn, "SELECT * FROM orders WHERE customer_id = ?");
                // bind params
                mysqli_stmt_bind_param($order_stmt, "i", $loggedIn);
                mysqli_stmt_execute($order_stmt);
                $table_result = mysqli_stmt_get_result($order_stmt);
                // select total pending orders
                $pending_order_stmt = mysqli_prepare($conn, "SELECT * FROM orders WHERE status = ?");
                $order_status = "pending";
                // bind params
                mysqli_stmt_bind_param($pending_order_stmt, "s", $order_status);
                mysqli_stmt_execute($pending_order_stmt);
                $pending_table_result = mysqli_stmt_get_result($pending_order_stmt);
                // calculate total sales
                // $total_sales_stmt = mysqli_prepare($conn, "SELECT SUM(*) as total_price FROM orders");
                // mysqli_stmt_execute($total_sales_stmt);
                // $sales = mysqli_stmt_get_result($total_sales_stmt);
            ?>
            <div class="main_container">
                <div class="main_details">
                    <div class="greetings">Hello <?= htmlspecialchars($profile_data['full_name']) ?>, welcome back</div>
                </div>
                <!--FOR ADMIN-->
                <?php if(isset($_SESSION['is_admin'])): ?>
                <div class="overview">
                    <div class="column">
                        <h4>Total Pending Orders</h4>
                        <span><?= mysqli_num_rows($pending_table_result) ?> Orders</span>
                    </div>
                    <div class="column">
                        <h4>Total Yearly Sales</h4>
                        <span>$400,000</span>
                    </div>
                    <div class="column">
                        <h4>Monthly Sales</h4>
                        <span>$54,000</span>
                    </div>
                    <?php
                        //select total products available
                        $product_stmt = mysqli_prepare($conn, "SELECT * FROM product WHERE  NOT quantity = ?");
                        // param
                        $quantity_status = 0;
                        // bind params
                        mysqli_stmt_bind_param($product_stmt, "i", $quantity_status);
                        mysqli_stmt_execute($product_stmt);
                        $product_result = mysqli_stmt_get_result($product_stmt);
                    ?>
                    <div class="column">
                        <h4>Total Products</h4>
                        <span><?= htmlspecialchars(mysqli_num_rows($product_result)) ?> Products Available</span>
                    </div>
                </div>
                <div class="sales_message">
                    <?php while ($product_result_loop = mysqli_fetch_assoc($product_result)) : ?>
                        <?php if ($product_result_loop['quantity'] < 10) : ?>
                            <div class="items_message">
                                <?= htmlspecialchars($product_result_loop['title']) ?> are low on stocks, only <?= htmlspecialchars($product_result_loop['quantity']) ?> available. <a href="restock.php?id=<?= htmlspecialchars($product_result_loop['id']) ?>">Restock??</a>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
                <?php
                    //select total products available
                    $product_zero_stmt = mysqli_prepare($conn, "SELECT * FROM product WHERE quantity = ?");
                    // param
                    $quantity_status_zero = 0;
                    // bind params
                    mysqli_stmt_bind_param($product_zero_stmt, "i", $quantity_status_zero);
                    mysqli_stmt_execute($product_zero_stmt);
                    $product_zero_result = mysqli_stmt_get_result($product_zero_stmt);
                ?>
                <div class="sales_message">
                    <?php while ($product_zero_result_loop = mysqli_fetch_assoc($product_zero_result)) : ?>
                        <?php if ($product_zero_result_loop['quantity'] == 0) : ?>
                            <div class="items_message">
                                <?= htmlspecialchars($product_zero_result_loop['title']) ?> is out of stocks, none available. <a href="restock.php?id=<?= htmlspecialchars($product_zero_result_loop['id']) ?>">Restock??</a>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
                <!--FOR USER-->
                <?php else: ?>
                <div class="overview">
                    <div class="column">
                        <h4>Total Orders</h4>
                        <p><?= mysqli_num_rows($table_result) ?> Orders</p>
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
                <h1>Your recent orders</h1>
                <table>
                    <!-- <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Date Created</th>
                    </tr> -->
                    <?php if (mysqli_num_rows($table_result) > 0) : ?>
                        <?php while ($tab = mysqli_fetch_assoc($table_result)) : ?>
                            <tr>
                                <td><?= $tab['product_name'] ?? null ?></td>
                                <td>$<?= htmlspecialchars($tab['total_price']) ?></td>
                                <td><?= htmlspecialchars($tab['quantity']) ?></td>
                                <td><?= date("M, d-y H:i", strtotime(htmlspecialchars($tab['date']))) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <div class="notice">No orders found!!</div>
                    <?php endif; ?>
                </table>
            </div>
        </main>
    </section>
    <div class="side" id="open"><ion-icon name="chevron-forward-outline"></ion-icon></div>
    <div class="side" id="close"><ion-icon name="chevron-back-outline"></ion-icon></div>
    <?php include('../partials/footer.php'); ?>