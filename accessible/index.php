    <?php
        include('./configuration/database.php');
        include('./configuration/constant.php');
        include('../partials/header.php'); 
    ?>
    <section class="banner">
        <div class="banner_text">
            <h1>Discover the Ethereal Beauty</h1>
            <p>Explore our exclusive collection of handcrafted jewelry that captures the essence of elegance and timelessness.</p>
            <button class="btn">Shop Now</button>
        </div>
    </section>
    <h1>SHOP WITH US</h1>
    <section class="category">
        <a href="<?= SITE_URL ?>accessible/category.php">Bracelet</a>
    </section>
    <section class="items">
        <div class="item">
            <img src="../images/usages/brace1.jpg" class="item_img">
            <h2 class="item_name">Elegant Silver Ring</h2>
            <p class="item_price">$49.99</p>
            <form action="" method="post">
                <button class="btn1" type="submit" name="add_to_cart">Add to Cart</button>
            </form>
        </div>
    </section>
    <?php include('../partials/footer.php'); ?>