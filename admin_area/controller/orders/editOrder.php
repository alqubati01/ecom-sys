<?php

session_start();
require_once '../../include/connection.php';

// print_r($_POST);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id'], $_POST['order_status'], $_POST['order_shipper'], $_POST['order_payment'])
        && !empty($_POST['id']))
    {
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE id=:id');
        $stmt->execute([
            ':id' => $_POST['id']
        ]);
        $order = $stmt->fetch();
        if ($stmt->rowCount())
        {
            try
            {
                $pdo->beginTransaction();
                $stmt = $pdo->prepare('UPDATE orders SET status_id=:status_id, shipper_id=:shipper_id, 
                payment_method=:payment_method, updated_at=:updated_at WHERE id=:id');
                $stmt->execute([
                    ':status_id' => ($_POST['order_status'] == null) ? $order['status_id'] : $_POST['order_status'],
                    ':shipper_id' => ($_POST['order_shipper'] == null) ? $order['shipper_id'] : $_POST['order_shipper'],
                    ':payment_method' => ($_POST['order_payment'] == null) ? $order['payment_method'] : $_POST['order_payment'],
                    ':updated_at' => date('Y-m-d H:i'),
                    ':id' => $_POST['id']
                ]);
                if ($stmt->rowCount())
                {
                    $stmt = $pdo->prepare('INSERT INTO order_status(order_id, status_id, created_at)
                    VALUES(:order_id, :status_id, :created_at)');
                    $stmt->execute([
                        ':order_id' => $_POST['id'],
                        ':status_id' => ($_POST['order_status'] == null) ? $order['status_id'] : $_POST['order_status'],
                        ':created_at' => date('Y-m-d H:i')
                    ]);
                    if ($stmt->rowCount())
                    {
                        echo json_encode(['status'=> 202, 'message'=> 'تم تعديل الطلب بنجاح']);
                        $pdo->commit();
                        exit();
                    }
                }
            }
            catch (PDOException $e) 
            {
                $pdo->rollback();
                echo json_encode(['status'=> 303, 'message'=> 'فشل في تعديل الطلب']);
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