<?php

require_once '../../include/connection.php';
session_start();

if (isset($_GET['id']) && !empty($_GET['id']))
{
    $stmt = $pdo->prepare(
        'SELECT rp.product_id, rp.related_product_id, 
        p.slug AS product_name, p.is_active, pc.category_id , c.slug AS category_name
        FROM related_products rp
        JOIN products p
            ON rp.related_product_id = p.id
        LEFT JOIN product_categories pc
            ON p.id = pc.product_id
        LEFT JOIN categories c
            ON pc.category_id = c.id
        WHERE rp.product_id =:product_id');
    $stmt->execute([
        ':product_id' => $_GET['id']
    ]);
    $_SESSION['relatedProducts'] = $stmt->fetchAll();
    $_SESSION['pname'] = $_GET['pname'];
    $_SESSION['product_id'] = $_GET['id'];
    header('refresh:0; url=../../related-products.php');
}
else
{
    $_SESSION['error'] = 'لم يتم ارسال رقم المنتج';
    header('refresh:0;url=../../products.php');
}



