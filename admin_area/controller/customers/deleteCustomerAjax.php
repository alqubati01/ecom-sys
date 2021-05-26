<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id']) && !empty($_POST['id']))
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
                        echo json_encode(['status'=> 202, 'message'=> 'تم حذف العميل']);
                        exit();
                    }
                    else
                    {
                        echo json_encode(['status'=> 303, 'message'=> 'فشل في حذف العميل']);
                        exit();
                    }
                }
            }
            else
            {
                echo json_encode(['status'=> 303, 'message'=> 'هذا العميل غير موجود']);
                exit();
            }
        }
        else
        {
            echo json_encode(['status'=> 303, 'message'=> 'معرف العميل غير صحيح']);
            exit();
        }
    }
    else
    {
        echo json_encode(['status'=> 303, 'message'=> 'لم يتم ارسال رقم العميل']);
        exit();
    }
}
else
{
    echo json_encode(['status'=> 303, 'message'=> 'قم بتسجيل الدخول']);
    exit();
}