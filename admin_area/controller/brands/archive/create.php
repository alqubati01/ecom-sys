<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['brand_name'], $_POST['createBrand'])
    && !empty($_POST['brand_name']) && !empty($_POST['createBrand']))
    {
        if (preg_match('/^[a-z0-9أ-ي ]*$/i', $_POST['brand_name'])) 
        {
            $stmt = $pdo->prepare('INSERT INTO brands (slug, is_active, created_at) 
                                        VALUES(:slug,:is_active,:created_at)');
            $stmt->execute([
                ':slug' => $_POST['brand_name'],
                ':is_active' => 1,
                ':created_at' => date('Y-m-d H:i')
            ]);
            if ($stmt->rowCount()) 
            {
                    $_SESSION['success'] = 'تم اضافه برند بنجاح';
                    header('refresh:0;url=getBrands.php');
            }
            else
            {
                $_SESSION['error'] = 'فشل في اضافة برند';
                header('refresh:0;url=../../brands.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'اسم البراند غير صحيح';
            header('refresh:0;url=../../brands.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'من فضلك املاء بعض الحقول';
        header('refresh:0;url=../../brands.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}