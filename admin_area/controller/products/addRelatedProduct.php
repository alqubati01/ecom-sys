<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();

$p_id = $_SESSION['product_id'];
$product_name = $_SESSION['pname'];

// print_r($p_id);
// print_r($product_name);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['related_product_id'], $_POST['product_id'], $_POST['relatedProduct'])
    && !empty($_POST['related_product_id']) && !empty($_POST['product_id']) && !empty($_POST['relatedProduct']))
    {
        if (preg_match('/^[0-9 ]*$/i', $_POST['product_id'])) 
        {
            if ($_POST['product_id'] === $_POST['related_product_id'])
            {
                $_SESSION['error'] = 'فشل في اضافة العلاقة';
                header('refresh:0;url=../../related-products.php');
            }
            else
            {
                try 
                {
                    $pdo->beginTransaction();
                    $stmt = $pdo->prepare('INSERT INTO related_products (product_id, related_product_id, created_at) 
                    VALUES(:product_id, :related_product_id, :created_at)');
                    $stmt->execute([
                        ':product_id' => $_POST['product_id'],
                        ':related_product_id' => $_POST['related_product_id'],
                        ':created_at' => date('Y-m-d H:i')
                    ]);
                    if ($stmt->rowCount()) 
                    {
                            $_SESSION['success'] = 'تم اضافه العلاقة بنجاح';
                            header('Location:/EcommerceSystem.v.2/admin_area/controller/products/getRelatedProducts.php?id=' . $p_id .'&pname=' . $product_name);
                            // header('refresh:0;url=../../products.php');
                    }
                    else
                    {
                        $_SESSION['error'] = 'فشل في اضافة العلاقة';
                        header('refresh:0;url=../../related-products.php');
                    }
                    $pdo->commit();
                }
                catch (PDOException $e) 
                {
                    $pdo->rollBack();
                    $_SESSION['error'] = 'لا يمكن تكرار العلاقة';
                    header('refresh:0;url=../../related-products.php');
                }
            }
        }
        else
        {
            $_SESSION['error'] = 'رقم المنتج غير صحيح';
            header('refresh:0;url=../../related-products.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'من فضلك املاء بعض الحقول';
        header('refresh:0;url=../../related-products.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}