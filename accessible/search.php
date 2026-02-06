    <?php
        include('./configuration/database.php');
        include('./configuration/constant.php');
        include('../partials/header.php'); 
        // get item title from url
        if (isset($_GET['search']) && isset($_GET['search_btn'])) {
            // declare variable
            $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            // check if there is a title
            if (!$search) {
                // redirect back to shop page if there's no title with session message
                $_SESSION['shop'] = "Add a title to search!!";
                header("location: " . SITE_URL . "accessible/shop.php");
                die();
            }
            $searched_details = mysqli_prepare($conn, "SELECT * FROM product WHERE title LIKE ?");
            $like_search = "%" . $search . "%";
            mysqli_stmt_bind_param($searched_details, "s", $like_search);
            mysqli_stmt_execute($searched_details);
            $result_d = mysqli_stmt_get_result($searched_details);
        }
    ?>
    <section class="search">
        <form action="<?= SITE_URL ?>accessible/search.php" method="get">
            <input type="search" name="search">
            <button type="submit" name="search_btn">Search</button>
        </form>
    </section>
    <h1>SHOP WITH US</h1>
    <?php if (mysqli_num_rows($result_d) > 0) : ?>
        <section class="items">
            <?php while ($item = mysqli_fetch_assoc($result_d)) : ?>
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