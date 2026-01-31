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
    <h1>MY CART</h1>
    <section class="container">
        <div class="cart_item">
            <img src="../images/usages/brace1.jpg" class="cart_item_img">
            <div class="details">
                <h2 class="cart_item_name">Elegant Silver Ring</h2>
                <span class="in_stock">In stock</span>
            </div>
            <p class="cart_item_price">$49.99</p>
            <form class="cart_form" action="" method="post">
                <p class="cart_item_quantity">Quantity: <input type="number" name="quantity" value="1" min="1" max="10"></p>
                <button type="submit" name="submit">Proceed to checkout</button>
                <button type="submit" name="remove">Remove from cart</button>
            </form>
        </div>
    </section>
    <h1>SHOP WITH US</h1>
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
    <?php include ('../partials/footer.php'); ?>