    <?php
        include('./configuration/database.php');
        include('./configuration/constant.php');
        include('../partials/header.php');
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
    <?php
        if (isset($_SESSION['cart'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['cart'];
            echo "</div>";
        }
        unset($_SESSION['cart']);
    ?>
    <h1>MY CART</h1>
    <?php  
        // join cart, product & customer tables
        $stmt = mysqli_prepare($conn, "SELECT p.id AS product_id, p.title AS product_title, 
        p.price AS product_price, p.available AS product_available, p.avatar AS product_avatar, c.id AS cart_id,
        c.product_id AS cart_pid, c.customer_id AS cart_cid, c.status AS cart_status, c.quantity AS cart_quantity,
        c.date AS cart_date FROM cart c JOIN product p ON c.product_id = p.id WHERE c.status = ? AND c.customer_id = ?");
        // bind params
        $status = "active";
        mysqli_stmt_bind_param($stmt, "si", $status, $loggedIn);
        mysqli_stmt_execute($stmt);
        $table_result = mysqli_stmt_get_result($stmt);
    ?>
    <section class="container">
        <?php if (mysqli_num_rows($table_result) > 0) : ?>
            <?php while ($tab = mysqli_fetch_assoc($table_result)) : ?>
                <div class="cart_item">
                    <img src="<?= SITE_URL ?>images/products/<?= htmlspecialchars($tab['product_avatar']) ?>" class="cart_item_img">
                    <div class="details">
                        <h2 class="cart_item_name"><?= $tab['product_title'] ?></h2>
                        <?php if ($tab['product_available'] == 1) : ?>
                            <span class="in_stock">In stock</span>
                        <?php else : ?>
                            <del class="in_stock">Out of stock</del>
                        <?php endif; ?>
                    </div>
                    <p class="cart_item_price">$<?= htmlspecialchars($tab['product_price']) ?></p>
                        <?php if ($tab['product_available'] == 1) : ?>
                            <form class="cart_form" action="<?= SITE_URL ?>admin/cart_decision.php" method="post">
                                <input type="hidden" name="cart_id" value="<?= htmlspecialchars($tab['cart_id']) ?>">
                                <p class="cart_item_quantity">Quantity: <input type="number" name="quantity" value="<?= htmlspecialchars($tab['cart_quantity']) ?>" min="1"></p>
                                <button type="submit" name="submit">Proceed to checkout</button>
                                <button type="submit" name="remove">Remove from cart</button>
                            </form>
                        <?php else : ?>
                            <span class="in_stock">Payment unavailable!!</span>
                        <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="notice">No cart found!!</div>
        <?php endif; ?>
    </section>
    <h1>SHOP WITH US</h1>
    <?php
        // get product from database
        $product = mysqli_prepare($conn, "SELECT * FROM product");
        mysqli_stmt_execute($product);
        $resultt = mysqli_stmt_get_result($product);
    ?>
    <?php if (mysqli_num_rows($resultt) > 0) : ?>
    <section class="items">
        <?php while ($item = mysqli_fetch_assoc($resultt)) : ?>
            <?php if ($item['available'] == 1) : ?>
                <div class="item">
                    <img src="<?= SITE_URL ?>images/products/<?= htmlspecialchars($item['avatar']) ?>" class="item_img">
                    <h2 class="item_name"><?= $item['title'] ?></h2>
                    <p class="item_price">$<?= htmlspecialchars($item['price']) ?></p>
                    <form action="<?= SITE_URL ?>accessible/cart_decision.php" method="post">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['id']) ?>">
                            <button class="btn1" type="submit" name="add_to_cart">Add to Cart</button>
                        <?php else : ?>
                            <button class="btn1" type="submit" name="sign">Add to Cart</button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </section>
    <?php else : ?>
        <div class="notice">No products available</div>
    <?php endif; ?>
    <?php include ('../partials/footer.php'); ?>