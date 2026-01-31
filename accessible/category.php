    <?php
        include('./configuration/database.php');
        include('./configuration/constant.php');
        include('../partials/header.php'); 
    ?>
    <h1>Bracelets</h1>
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
    <section class="category">
        <a href="category.php">Bracelet</a>
    </section>
    <?php include('../partials/footer.php'); ?>