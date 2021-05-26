<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id']) && !empty($_POST['id']))
    {
        if (preg_match('/^[0-9]*$/', $_POST['id']))
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
                    echo json_encode(['status'=> 202, 'message'=> 'تم حذف البراند']);
                    exit();
                }
                else
                {
                    echo json_encode(['status'=> 303, 'message'=> 'فشل في حذف البراند']);
                    exit();
                }
            }
            else
            {
                echo json_encode(['status'=> 303, 'message'=> 'هذا البراند غير موجود']);
                exit();
            }
        }
        else
        {
            echo json_encode(['status'=> 303, 'message'=> 'رقم البراند لابد ان يكون رقم']);
            exit();
        }
    }
    else
    {
        echo json_encode(['status'=> 303, 'message'=> 'لم يتم ارسال رقم البراند']);
        exit();
    }
}
else
{
    echo json_encode(['status'=> 303, 'message'=> 'قم بتسجيل الدخول']);
    exit();
}