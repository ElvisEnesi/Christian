<?php
    // include files
    include('./configuration/database.php');
    include('./configuration/constant.php');
    // get id from url
    if (isset($_GET['id'])) {
        $cate_id = (int) $_GET['id'];
        // select category
        $select_category = mysqli_prepare($conn, "SELECT * FROM category WHERE id=?");
        mysqli_stmt_bind_param($select_category, "i", $cate_id);
        mysqli_stmt_execute($select_category);
        $result = mysqli_stmt_get_result($select_category);
        $category = mysqli_fetch_assoc($result);
    } else {
        header("location: " . SITE_URL . "admin/manage_category.php");
        exit;
    }
    // update product category_id
    $update_stmt = mysqli_prepare($conn, "UPDATE product SET category_id=? WHERE category_id=?");
    $new_category_id = (int) 5;
    mysqli_stmt_bind_param($update_stmt, "ii", $new_category_id, $cate_id);
    mysqli_stmt_execute($update_stmt);
    // delete category
    $stmt = mysqli_prepare($conn, "DELETE FROM category WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $category['id']);
    mysqli_stmt_execute($stmt);
    if (mysqli_stmt_affected_rows($stmt) >= 0) {
        $_SESSION['delete_category_success'] = "Category successfully deleted!";
    } else {
        $_SESSION['delete_category'] = "Delete failed!";
    }
    header("location: " . SITE_URL . "admin/manage_category.php");
    exit;
    
?>