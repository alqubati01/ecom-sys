<?php

session_start();
require_once '../../include/connection.php';

// print_r($_POST);
// die();

$stmt = $pdo->prepare('SELECT p.id, p.slug, p.selling_price, p.special_price, f.path
        FROM products p
        LEFT JOIN files f
            ON p.id = f.entity_id AND f.entity_type = "Product" AND f.zone = "baseImage"
        WHERE p.id =:id');
$stmt->execute([
    ':id' => $_POST['id']
]);
$product = $stmt->fetch();
// print_r($product);

if (isset($_POST["action"]))
{
    if($_POST["action"] == "add")
	{
        if (isset($_SESSION['shopping_cart']))
        {
            $is_available = 0;
            foreach($_SESSION['shopping_cart'] as $keys => $values)
            {
                if ($_SESSION['shopping_cart'][$keys]['product_id'] == $_POST['id'])
                {
                    $is_available++;
                    $_SESSION['shopping_cart'][$keys]['product_qty'] =
                        $_SESSION['shopping_cart'][$keys]['product_qty'] + $_POST['productQty'];
                }
            }
            if ($is_available == 0)
            {
                $item_array = array(
                    'product_id' => $_POST['id'],
                    'product_name' => $product['slug'],
                    'product_price' => $product['selling_price'],
                    'product_qty' => $_POST['productQty'],
                ); 
                $_SESSION['shopping_cart'][] = $item_array; 
            }
        }
        else 
        {
            $item_array = array(
                'product_id' => $_POST['id'],
                'product_name' => $product['slug'],
                'product_price' => $product['selling_price'],
                'product_qty' => $_POST['productQty'],
            ); 
            $_SESSION['shopping_cart'][] = $item_array; 
        }
        // print_r($_SESSION['shopping_cart']);
    }

    if($_POST['action'] == 'remove')
	{
        foreach($_SESSION['shopping_cart'] as $keys => $values)
        {
            if ($values['product_id'] == $_POST['id'])
            {
				unset($_SESSION['shopping_cart'][$keys]);
            }
        }
    }

    if($_POST["action"] == "edit")
    {
        if (isset($_POST['id'], $_POST['order_id'],$_POST['productQty'])
            && !empty($_POST['id']) && !empty($_POST['order_id']) && !empty($_POST['productQty']))
        {
            $stmt = $pdo->prepare('SELECT * FROM order_items WHERE order_id=:order_id AND product_id=:product_id');
            $stmt->execute([
                ':order_id' => $_POST['order_id'],
                ':product_id' => $_POST['id']
            ]);
            $orderItem = $stmt->fetch();
            if ($stmt->rowCount())
            {
                try 
                {
                    $pdo->beginTransaction();
                    $stmt = $pdo->prepare('UPDATE order_items SET qty=:qty, 
                                    total=:total, 
                                    updated_at=:updated_at
                                    WHERE order_id=:order_id AND product_id=:product_id');
                    $stmt->execute([
                        ':order_id' => $_POST['order_id'],
                        ':product_id' => $_POST['id'],
                        ':qty' => $orderItem['qty'] + $_POST['productQty'],
                        ':total' => $orderItem['total'] + $orderItem['price_per_unit'],
                        ':updated_at' => date('Y-m-d H:i')
                    ]);
                    if ($stmt->rowCount())
                    {
                        $stmt = $pdo->prepare('UPDATE orders SET 
                                    products_price=products_price + :price,
                                    total_price=total_price+:total,
                                    updated_at=:updated_at 
                                    WHERE id=:id');
                        $stmt->execute([
                            ':id' => $_POST['order_id'],
                            ':price' => $orderItem['price_per_unit'],
                            ':total' => $orderItem['price_per_unit'],
                            ':updated_at' => date('Y-m-d H:i')
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
                try {
                    $pdo->beginTransaction();
                    $stmt = $pdo->prepare('INSERT INTO order_items(order_id, product_id, qty, price_per_unit, total,created_at)
                                VALUES(:order_id, :product_id, :qty, :price_per_unit, :total, :created_at)');
                    $stmt->execute([
                    ':order_id' => $_POST['order_id'],
                    ':product_id' => $_POST['id'],
                    ':qty' => $_POST['productQty'],
                    ':price_per_unit' => $product['selling_price'],
                    ':total' => $product['selling_price'] * $_POST['productQty'],
                    ':created_at' => date('Y-m-d H:i')
                    ]);
                    if ($stmt->rowCount())
                    {
                        $stmt = $pdo->prepare('UPDATE orders SET 
                                    products_price=products_price + :price,
                                    total_price=total_price+:total,
                                    updated_at=:updated_at 
                                    WHERE id=:id');
                        $stmt->execute([
                            ':id' => $_POST['order_id'],
                            ':price' => $product['selling_price'],
                            ':total' => $product['selling_price'],
                            ':updated_at' => date('Y-m-d H:i')
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
        }
        else
        {
            echo json_encode(['status'=> 303, 'message'=> 'من فضلك املاء بعض الحقول']);
            exit();
        }
    }

    if($_POST["action"] == "deleteItem")
    {
        if (isset($_POST['id']) && !empty($_POST['id']))
        {
            $stmt = $pdo->prepare('SELECT * FROM order_items WHERE id=:id');
            $stmt->execute([
                ':id' => $_POST['id']
            ]);
            $orderItem1 = $stmt->fetch();
            // print_r($orderItem1);
            // die();
            if ($stmt->rowCount()) 
            {
                try {
                    $pdo->beginTransaction();
                    $stmt = $pdo->prepare('DELETE FROM order_items WHERE id=:id');
                    $stmt->execute([
                        ':id' => $_POST['id']
                    ]);
                    if ($stmt->rowCount())
                    {
                        $stmt = $pdo->prepare('UPDATE orders SET 
                                    products_price=products_price - :totalProduct,
                                    total_price=total_price - :totalProduct1,
                                    updated_at=:updated_at 
                                    WHERE id=:id');
                        $stmt->execute([
                            ':id' => $_POST['order_id'],
                            ':totalProduct' => $orderItem1['total'],
                            ':totalProduct1' => $orderItem1['total'],
                            ':updated_at' => date('Y-m-d H:i')
                        ]);
                        if ($stmt->rowCount())
                        {
                            echo json_encode(['status'=> 202, 'message'=> 'تم حذف العنصر بنجاح']);
                            $pdo->commit();
                            exit();
                        }
                    }
                }
                catch (PDOException $e) 
                {
                    $pdo->rollback();
                    echo json_encode(['status'=> 303, 'message'=> 'فشل في حذف العنصر']);
                    exit();
                }
            }
            else
            {
                echo json_encode(['status'=> 303, 'message'=> 'هذا العنصر غير موجود']);
                exit();
            }
        }
        else
        {
            echo json_encode(['status'=> 303, 'message'=> 'من فضلك املاء بعض الحقول']);
            exit();
        }

    }

}