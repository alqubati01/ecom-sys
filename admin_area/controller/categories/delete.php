<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id'],$_POST['deleteCategory']) 
        && !empty($_POST['id']) && !empty($_POST['deleteCategory']))
    {
        if (preg_match('/^[0-9]*$/', $_POST['id']))
        {
            $stmt = $pdo->prepare('SELECT * FROM categories WHERE id=:id');
            $stmt->execute([
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount())
            {
                $stmt = $pdo->prepare('SELECT * FROM categories WHERE parent_id=:parent_id');
                $stmt->execute([
                    ':parent_id' => $_POST['id']
                ]);
                if ($stmt->rowCount())
                {
                    $stmt = $pdo->prepare('UPDATE categories SET parent_id=NULL WHERE parent_id=:parent_id');
                    $stmt->execute([
                        ':parent_id' => $_POST['id']
                    ]);
                }
                $stmt = $pdo->prepare('DELETE FROM categories WHERE id=:id');
                $stmt->execute([
                    ':id' => $_POST['id']
                ]);
                if ($stmt->rowCount())
                {
                    $_SESSION['success'] = 'تم حذف التصنيف';
                    header('refresh:0;url=../../categories.php');
                }
                else
                {
                    $_SESSION['error'] = 'فشل في حذف التصنيف';
                    header('refresh:0;url=../../categories.php');
                }
            }
        }
        else
        {
            $_SESSION['error'] = 'رقم التصنيف لابد ان يكون رقم';
            header('refresh:0;url=../../categories.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'لم يتم ارسال رقم التصنيف';
        header('refresh:0;url=../../categories.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}