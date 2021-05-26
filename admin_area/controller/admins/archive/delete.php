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
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id=:id');
            $stmt->execute([
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount())
            {
                foreach ($stmt->fetchAll() as $value)
                {
                    $stmt = $pdo->prepare('DELETE FROM users WHERE id=:id');
                    $stmt->execute([
                        ':id' => $_POST['id']
                    ]);
                    if ($stmt->rowCount())
                    {
                        $_SESSION['success'] = 'تم حذف الادمن';
                        header('refresh:0;url=getAdmins.php');
                    }
                    else
                    {
                        $_SESSION['error'] = 'فشل في حذف الادمن';
                        header('refresh:0;url=../../employees.php');
                    }
                }
            }
            else
            {
                $_SESSION['error'] = 'هذا الادمن غير موجود';
                header('refresh:0;url=../../employees.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'رقم الادمن لابد ان يكون رقم';
            header('refresh:0;url=../../employees.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'لم يتم ارسال رقم الادمن';
        header('refresh:0;url=../../employees.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}