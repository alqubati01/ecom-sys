<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['category_name'], $_POST['createCategory'])
    && !empty($_POST['category_name']) && !empty($_POST['createCategory']))
    {
        if (preg_match('/^[a-z0-9أ-ي ]*$/i', $_POST['category_name'])) 
        {
            $stmt = $pdo->prepare('INSERT INTO categories (slug, is_active, created_at) 
                                        VALUES(:slug,:is_active,:created_at)');
            $stmt->execute([
                ':slug' => $_POST['category_name'],
                ':is_active' => 1,
                ':created_at' => date('Y-m-d H:i')
            ]);
            if ($stmt->rowCount()) 
            {
                    $_SESSION['success'] = 'تم اضافه التصنيف بنجاح';
                    header('refresh:0;url=../../categories.php');
            }
            else
            {
                $_SESSION['error'] = 'فشل في اضافة التصنيف';
                header('refresh:0;url=../../categories.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'اسم التصنيف غير صحيح';
            header('refresh:0;url=../../categories.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'من فضلك املاء بعض الحقول';
        header('refresh:0;url=../../categories.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}