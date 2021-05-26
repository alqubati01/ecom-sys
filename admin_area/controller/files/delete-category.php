<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id'],$_POST['delete']) 
        && !empty($_POST['id']) && !empty($_POST['delete']))
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
                $_SESSION['success'] = 'تم حذف الصورة';
                header('refresh:0;url=../../categories.php');
            }
            else
            {
                $_SESSION['error'] = 'فشل في حذف الصورة';
                header('refresh:0;url=../../categories.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'هذا الصورة غير موجود';
            header('refresh:0;url=../../categories.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'لم يتم ارسال رقم الصورة';
        header('refresh:0;url=../../categories.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}