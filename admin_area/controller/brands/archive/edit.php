<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id'],$_POST['brand_name'], $_POST['editBrand'])
    && !empty($_POST['id']) && !empty($_POST['brand_name']) && !empty($_POST['editBrand']))
    {
        if (preg_match('/^[a-z0-9أ-ي ]*$/i', $_POST['brand_name'])) 
        { 
            $stmt = $pdo->prepare('UPDATE brands SET slug=:slug,updated_at=:updated_at WHERE id=:id');
            $stmt->execute([
                ':slug' => $_POST['brand_name'],
                ':updated_at' => date('Y-m-d H:i'),
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount()) 
            {
                    $_SESSION['success'] = 'تم تعديل البرند بنجاح';
                    header('refresh:0;url=getBrands.php');
            }
            else
            {
                $_SESSION['error'] = 'فشل في تعديل البرند';
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