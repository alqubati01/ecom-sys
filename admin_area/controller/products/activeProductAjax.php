<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();

$actions = ['active', 'stop'];
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['action'],$_POST['id']) && !empty($_POST['action']) && !empty($_POST['id']))
    {
        if (in_array($_POST['action'], $actions))
        {
            if (preg_match('/^[0-9]*$/', $_POST['id']))
            {
                $stmt = $pdo->prepare('SELECT * FROM products WHERE id=:id');
                $stmt->execute([
                    ':id' => $_POST['id']
                ]);
                if ($stmt->rowCount())
                {
                    switch ($_POST['action'])
                    {
                        case 'active':
                            $stmt = $pdo->prepare('UPDATE products SET is_active=:active WHERE id=:id');
                            $stmt->execute([
                                ':id' => $_POST['id'],
                                ':active' => 1
                            ]);
                            if ($stmt->rowCount())
                            {
                                echo json_encode(['status'=> 202, 'message'=> 'تم اظهار المنتج']);
                                exit();
                            }
                            else
                            {
                                echo json_encode(['status'=> 202, 'message'=> 'فشل في اظهار المنتج']);
                                exit();
                            }
                            break;
                        case 'stop':
                            $stmt = $pdo->prepare('UPDATE products SET is_active=:stop WHERE id=:id');
                            $stmt->execute([
                                ':id' => $_POST['id'],
                                ':stop' => 0
                            ]);
                            if ($stmt->rowCount())
                            {
                                echo json_encode(['status'=> 202, 'message'=> 'تم اخفاء المنتج']);
                                exit();
                            }
                            else
                            {
                                echo json_encode(['status'=> 202, 'message'=> 'فشل في اخفاء المنتج']);
                                exit();
                            }
                            break;
                    }
                }
                else
                {
                    echo json_encode(['status'=> 303, 'message'=> 'هذا المنتج غير موجود']);
                    exit();
                }
            }
            else
            {
                echo json_encode(['status'=> 303, 'message'=> 'معرف المنتج غير صحيح']);
                exit();
            }
        }
        else 
        {
            echo json_encode(['status'=> 303, 'message'=> 'الحدث غير موجود']);
            exit();
        }
    }
    else
    {
        echo json_encode(['status'=> 303, 'message'=> 'لم يتم ارسال رقم المنتج']);
        exit();
    }
}
else
{
    echo json_encode(['status'=> 303, 'message'=> 'قم بتسجيل الدخول']);
    exit();
}