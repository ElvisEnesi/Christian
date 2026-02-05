<?php
    // get id from url
    if (isset($_GET['id'])) {
        $product_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        echo $product_id;
    }
?>