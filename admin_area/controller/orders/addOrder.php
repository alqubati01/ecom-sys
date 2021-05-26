<?php

session_start();
require_once '../../include/connection.php';

// print_r($_POST);
// print_r($_SESSION['shopping_cart']);
// foreach($_SESSION['shopping_cart'] as $keys => $values)
// {
//     echo $values['product_id'] . ' ' . $values['product_name'] . ' ' 
//         . $values['product_price'] . ' ' . $values['product_qty'] . '</br>';
    
//     // echo $_SESSION['shopping_cart'][$keys]['product_id'];
//     // echo $values['product_id'];
// }
// die();
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['order_number'], $_POST['order_date'],$_POST['order_status'], $_POST['order_customer'],
              $_POST['order_shipper'], $_POST['order_payment'], $_POST['products_price'], $_POST['delivery_cost'],
              $_POST['total_price'], $_SESSION['shopping_cart'])
            && !empty($_POST['order_number']) && !empty($_POST['order_date']) && !empty($_POST['order_status'])
            && !empty($_POST['order_customer']) && !empty($_POST['order_shipper']) && !empty($_POST['order_payment'])
            && !empty($_POST['products_price']) && !empty($_POST['delivery_cost']) && !empty($_POST['total_price'])
            && !empty($_SESSION['shopping_cart']))
    {
        try 
        {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare('INSERT INTO orders(order_ref_number, customer_id, order_date, products_price, delivery_cost, total_price, status_id,shipper_id, payment_method, created_at)
                    VALUES(:order_ref_number, :customer_id, :order_date, :products_price, :delivery_cost, :total_price, :status_id, :shipper_id, :payment_method, :created_at)');
            $stmt->execute([
                ':order_ref_number' => $_POST['order_number'],
                ':customer_id' => $_POST['order_customer'],
                ':order_date' => date('Y-m-d H:i'),
                ':products_price' => $_POST['products_price'],
                ':delivery_cost' => $_POST['delivery_cost'],
                ':total_price' => $_POST['total_price'],
                ':status_id' => $_POST['order_status'],
                ':shipper_id' => $_POST['order_shipper'],
                ':payment_method' => $_POST['order_payment'],
                ':created_at' => date('Y-m-d H:i')
            ]);
            $order_id = $pdo->lastInsertId();
            if ($stmt->rowCount())
            {
                $stmt = $pdo->prepare('INSERT INTO order_status(order_id, status_id, created_at)
                        VALUES(:order_id, :status_id, :created_at)');
                $stmt->execute([
                    ':order_id' => $order_id,
                    ':status_id' => $_POST['order_status'],
                    ':created_at' => date('Y-m-d H:i')
                ]);
                if ($stmt->rowCount())
                {
                    $stmt = $pdo->prepare('INSERT INTO order_items(order_id, product_id, qty, price_per_unit, total, created_at)
                            VALUES(:order_id, :product_id, :qty, :price_per_unit, :total, :created_at)');
                    foreach($_SESSION['shopping_cart'] as $keys => $values)
                    {
                        $stmt->execute([
                            ':order_id' => $order_id,
                            ':product_id' => $values['product_id'],
                            ':qty' => $values['product_qty'],
                            ':price_per_unit' => $values['product_price'],
                            ':total' => $values['product_price'] * $values['product_qty'],
                            ':created_at' => date('Y-m-d H:i')
                        ]);
                    }
                    if ($stmt->rowCount())
                    {
                        echo json_encode(['status'=> 202, 'message'=> 'تم اضافة طلب بنجاح']);
                        $pdo->commit();
                        unset($_SESSION['shopping_cart']);
                        exit();
                    }
                }
            }
        }
        catch (PDOException $e) 
        {
            $pdo->rollback();
            echo json_encode(['status'=> 303, 'message'=> 'فشل في اضافة طلب']);
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