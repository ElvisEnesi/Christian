    <?php
        include('./configuration/database.php');
        include('./configuration/constant.php');
        include('../partials/header.php');
        // get id from url
        if (isset($_GET['id'])) {
            // url id variable
            $gotten_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        } else {
            header("location: " . SITE_URL . "accessible/shop.php");
            die();
        }
    ?>
    <h1>SHOP WITH US</h1>
    <?php
        $table = mysqli_prepare( $conn, "SELECT p.id AS product_id, p.title AS product_title, p.quantity AS product_quantity,
        p.avatar AS product_avatar, p.price AS product_price , p.available AS available, c.id AS category_id, c.title AS category_title FROM 
        category c JOIN product p ON c.id = p.category_id WHERE c.id = ?");
        mysqli_stmt_bind_param($table, "i", $gotten_id);
        mysqli_stmt_execute($table);
        $result = mysqli_stmt_get_result($table);
    ?>
    <?php if (mysqli_num_rows($result) > 0) :?>
       <section class="items">
        <?php while ($item = mysqli_fetch_assoc($result)) : ?>
            <?php if ($item['product_quantity'] !== 0) : ?>
                <div class="item">
                    <img src="<?= SITE_URL ?>images/products/<?= htmlspecialchars($item['product_avatar']) ?>" class="item_img">
                    <h2 class="item_name"><?= $item['product_title'] ?></h2>
                    <p class="item_price">$<?= htmlspecialchars($item['product_price']) ?></p>
                    <form action="<?= SITE_URL ?>accessible/cart_decision.php" method="post">
                        <?php if (isset($_SESSION['user_id'])) : ?>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['product_id']) ?>">
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
        <div class="notice">No category found.</div>
    <?php endif; ?>
    <section class="category">
        <?php $categories = mysqli_query($conn, "SELECT * FROM category"); ?>
            <?php if (mysqli_num_rows($categories) > 0) : ?>
                <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                    <a href="category.php?id=<?= $category['id'] ?>"><?= $category['title'] ?></a>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="notice">No category available</div>
            <?php endif; ?>
    </section>
    <?php include('../partials/footer.php'); ?>