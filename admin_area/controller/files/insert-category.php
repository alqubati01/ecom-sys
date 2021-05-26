<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['file_id'],$_POST['category_id'],$_POST['insert']) 
        && !empty($_POST['file_id']) && !empty($_POST['category_id']) && !empty($_POST['insert']))
    {
        $stmt = $pdo->prepare('INSERT INTO entity_files (file_id, entity_type, entity_id, zone, created_at)
            VALUES(:file_id, :entity_type, :entity_id, :zone, :created_at)');
        $stmt->execute([
            ':file_id' => $_POST['file_id'],
            ':entity_type' => 'Category',
            ':entity_id' => $_POST['category_id'],
            ':zone' => 'logo',
            ':created_at' => date('Y-m-d H:i')
        ]);
        if ($stmt->rowCount())
        {
            $_SESSION['success'] = 'تم اختيار الصورة بنجاح';
            header('refresh:0;url=../../categories.php');
        }
        else
        {
            $_SESSION['error'] = 'فشل في اختيار الصورة';
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