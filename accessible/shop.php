    <?php
        include('./configuration/database.php');
        include('./configuration/constant.php');
        include('../partials/header.php'); 
    ?>
    <section class="search">
        <form action="<?= SITE_URL ?>accessible/search.php" method="get">
            <input type="search" name="search">
            <button type="submit" name="search_btn">Search</button>
        </form>
    </section>
    <?php
        if (isset($_SESSION['add_to_cart'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['add_to_cart'];
            echo "</div>";
        }
        unset($_SESSION['add_to_cart']);
    ?>
    <?php
        if (isset($_SESSION['shop'])) {
            echo "<div class='error_notice'>";
            echo $_SESSION['shop'];
            echo "</div>";
        }
        unset($_SESSION['shop']);
    ?>
    <h1>SHOP WITH US</h1>
    <?php
        // get category from database
        $category = mysqli_prepare($conn, "SELECT * FROM category");
        mysqli_stmt_execute($category);
        $result = mysqli_stmt_get_result($category);
    ?>
    <section class="category">
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <?php while ($cate = mysqli_fetch_assoc($result)) : ?>
                <a href="<?= SITE_URL ?>accessible/category.php?id=<?= htmlspecialchars($cate['id']) ?>"><?= htmlspecialchars($cate['title']) ?></a>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="notice">No category available</div>
        <?php endif; ?>
    </section>
    <?php
        // get product from database
        $product = mysqli_prepare($conn, "SELECT * FROM product");
        mysqli_stmt_execute($product);
        $resultt = mysqli_stmt_get_result($product);
    ?>
    <?php if (mysqli_num_rows($resultt) > 0) : ?>
    <section class="items">
        <?php while ($item = mysqli_fetch_assoc($resultt)) : ?>
            <?php if ($item['quantity'] !== 0) : ?>
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
    <?php include('../partials/footer.php'); ?>