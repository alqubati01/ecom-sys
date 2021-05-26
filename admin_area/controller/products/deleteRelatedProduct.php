<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();

$p_id = $_SESSION['product_id'];
$product_name = $_SESSION['pname'];

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['product_id'],$_POST['related_product_id'], $_POST['delete']) 
        && !empty($_POST['product_id']) && !empty($_POST['related_product_id']) && !empty($_POST['delete']))
    {
        if (preg_match('/^[0-9]*$/', $_POST['product_id']))
        {
            $stmt = $pdo->prepare('SELECT * FROM related_products WHERE product_id=:product_id AND related_product_id=:related_product_id');
            $stmt->execute([
                ':product_id' => $_POST['product_id'],
                ':related_product_id' => $_POST['related_product_id']
            ]);
            if ($stmt->rowCount())
            {
                $stmt = $pdo->prepare('DELETE FROM related_products WHERE product_id=:product_id AND related_product_id=:related_product_id');
                $stmt->execute([
                    ':product_id' => $_POST['product_id'],
                    ':related_product_id' => $_POST['related_product_id']
                ]);
                if ($stmt->rowCount())
                {
                    $_SESSION['success'] = 'تم حذف العلاقة بهذا المنتج';
                    header('Location:/EcommerceSystem.v.2/admin_area/controller/products/getRelatedProducts.php?id=' . $p_id .'&pname=' . $product_name);
                }
                else
                {
                    $_SESSION['error'] = 'فشل في حذف المنتج';
                    header('refresh:0;url=../../related-products.php');
                }
            }
            else
            {
                $_SESSION['error'] = 'هذا المنتج غير موجود';
                header('refresh:0;url=../../related-products.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'رقم المنتج لابد ان يكون رقم';
            header('refresh:0;url=../../related-products.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'لم يتم ارسال رقم المنتج';
        header('refresh:0;url=../../related-products.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}