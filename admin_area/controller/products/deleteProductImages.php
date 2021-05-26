<?php

require_once '../../include/connection.php';
session_start();
$p_id = $_SESSION['product_id'];
$product_name = $_SESSION['pname'];

// print_r($_POST);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['deleteBaseImage'], $_POST['id']) && !empty($_POST['deleteBaseImage']) && !empty($_POST['id']))
    {
        $stmt = $pdo->prepare('SELECT * FROM files WHERE id=:id');
        $stmt->execute([
            ':id' => $_POST['id']
        ]);
        if ($stmt->rowCount())
        {
            $stmt = $pdo->prepare('DELETE FROM files WHERE id=:id');
            $stmt->execute([
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount())
            {
                $_SESSION['success'] = 'تم حذف الصورة بنجاح';
                header('Location:/EcommerceSystem.v.2/admin_area/controller/products/getProductImage.php?id=' . $p_id .'&pname=' . $product_name);
            }
        }
        else 
        {
            $_SESSION['error'] = 'هذا الصورة غير موجود';
            header('refresh:0;url=../../product-image.php');
        }
    }
    if (isset($_POST['deleteAdditionalImage'], $_POST['id']) && !empty($_POST['deleteAdditionalImage']) && !empty($_POST['id']))
    {
        $stmt = $pdo->prepare('SELECT * FROM files WHERE id=:id');
        $stmt->execute([
            ':id' => $_POST['id']
        ]);
        if ($stmt->rowCount())
        {
            $stmt = $pdo->prepare('DELETE FROM files WHERE id=:id');
            $stmt->execute([
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount())
            {
                $_SESSION['success'] = 'تم حذف الصورة بنجاح';
                header('Location:/EcommerceSystem.v.2/admin_area/controller/products/getProductImage.php?id=' . $p_id .'&pname=' . $product_name);
            }
        }
        else 
        {
            $_SESSION['error'] = 'هذا الصورة غير موجود';
            header('refresh:0;url=../../product-image.php');
        }
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}