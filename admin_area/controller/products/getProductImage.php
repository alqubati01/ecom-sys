<?php

require_once '../../include/connection.php';
session_start();

// print_r($_GET);

if (isset($_GET['id']) && !empty($_GET['id']))
{
    $stmt = $pdo->prepare('SELECT f.id AS file_id, p.id AS product_id, f.entity_type, f.zone, f.path, f.filename, f.size 
                    FROM files f
                    JOIN products p
                    ON f.entity_id = p.id
                    WHERE p.id = :product_id');
    $stmt->execute([
        ':product_id' => $_GET['id']
    ]);
    $_SESSION['productImage'] = $stmt->fetchAll();
    // print_r($_SESSION['productImage']);
    // die();
    $_SESSION['pname'] = $_GET['pname'];
    $_SESSION['product_id'] = $_GET['id'];
    header('refresh:0; url=../../product-image.php');
}
else
{
    $_SESSION['error'] = 'لم يتم ارسال رقم المنتج';
    header('refresh:0;url=../../products.php');
}



