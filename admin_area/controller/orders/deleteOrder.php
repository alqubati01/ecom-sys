<?php

session_start();
require_once '../../include/connection.php';

// print_r($_POST);
// die();
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id']) && !empty($_POST['id']))
    {
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE id=:id');
        $stmt->execute([
            ':id' => $_POST['id']
        ]);
        if ($stmt->rowCount())
        {
            try 
            {
                $pdo->beginTransaction();
                $stmt = $pdo->prepare('DELETE FROM orders WHERE id=:id');
                $stmt->execute([
                    ':id' => $_POST['id']
                ]);
                if ($stmt->rowCount())
                {
                    $stmt = $pdo->prepare('DELETE FROM order_status WHERE order_id=:order_id');
                    $stmt->execute([
                        ':order_id' => $_POST['id']
                    ]);
                    if ($stmt->rowCount())
                    {
                        $stmt = $pdo->prepare('DELETE FROM order_items WHERE order_id=:order_id');
                        $stmt->execute([
                            ':order_id' => $_POST['id']
                        ]);
                        if ($stmt->rowCount())
                        {
                            echo json_encode(['status'=> 202, 'message'=> 'تم حذف الطلب']);
                            $pdo->commit();
                            exit();
                        }
                    }
                }
            }
            catch (PDOException $e) 
            {
                $pdo->rollback();
                echo json_encode(['status'=> 303, 'message'=> 'فشل في حذف الطلب']);
                exit();
            }
        }
        else
        {
            echo json_encode(['status'=> 303, 'message'=> 'هذا الطلب غير موجود']);
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