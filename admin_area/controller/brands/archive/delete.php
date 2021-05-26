<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id'],$_POST['delete']) 
        && !empty($_POST['id']) && !empty($_POST['delete']))
    {
        if (preg_match('/^[0-9]*$/', $_POST['id']))
        {
            $stmt = $pdo->prepare('SELECT * FROM brands WHERE id=:id');
            $stmt->execute([
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount())
            {
                foreach ($stmt->fetchAll() as $value)
                {
                    $stmt = $pdo->prepare('DELETE FROM brands WHERE id=:id');
                    $stmt->execute([
                        ':id' => $_POST['id']
                    ]);
                    if ($stmt->rowCount())
                    {
                        $_SESSION['success'] = 'تم حذف البراند';
                        header('refresh:0;url=getBrands.php');
                    }
                    else
                    {
                        $_SESSION['error'] = 'فشل في حذف البراند';
                        header('refresh:0;url=../../brands.php');
                    }
                }
            }
            else
            {
                $_SESSION['error'] = 'هذا البراند غير موجود';
                header('refresh:0;url=../../brands.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'رقم البراند لابد ان يكون رقم';
            header('refresh:0;url=../../brands.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'لم يتم ارسال رقم البراند';
        header('refresh:0;url=../../brands.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}