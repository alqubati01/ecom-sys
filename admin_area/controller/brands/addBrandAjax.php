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
                echo json_encode(['status'=> 202, 'message'=> 'تم اضافه البرند بنجاح']);
                exit();
            }
            else
            {
                echo json_encode(['status'=> 303, 'message'=> 'فشل في اضافة برند']);
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