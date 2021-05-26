<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id'],$_POST['brand_name'], $_POST['editBrand'])
    && !empty($_POST['id']) && !empty($_POST['brand_name']) && !empty($_POST['editBrand']))
    {
        if (preg_match('/^[a-z0-9أ-ي ]*$/i', $_POST['brand_name'])) 
        { 
            $stmt = $pdo->prepare('UPDATE brands SET slug=:slug, updated_at=:updated_at WHERE id=:id');
            $stmt->execute([
                ':slug' => $_POST['brand_name'],
                ':updated_at' => date('Y-m-d H:i'),
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount()) 
            {
                echo json_encode(['status'=> 202, 'message'=> 'تم تعديل البرند بنجاح']);
                exit();
            }
            else
            {
                echo json_encode(['status'=> 303, 'message'=> 'فشل في تعديل البرند']);
                exit();
            }
        }
        else
        {
            echo json_encode(['status'=> 303, 'message'=> 'اسم البراند غير صحيح']);
            exit();
        }
    }
    else
    {
        echo json_encode(['status'=> 303, 'message'=> 'من فضلك املاء بعض الحقول']);
        exit();
    }
}
else
{
    echo json_encode(['status'=> 303, 'message'=> 'قم بتسجيل الدخول']);
    exit();
}