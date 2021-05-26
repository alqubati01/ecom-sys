<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['product_name'], $_POST['price'], $_POST['selling_price'], $_POST['sku'])
    && !empty($_POST['product_name'])  && !empty($_POST['price']) && !empty($_POST['selling_price']) && !empty($_POST['sku']))
    {
        if (preg_match('/^[a-z0-9أ-ي ]*$/i', $_POST['product_name'])) 
        {
            if (array_key_exists('stock_manage', $_POST))
            {
                $stock_manage = 0;
                $qty = 0;
            }
            else 
            {
                $stock_manage = 1;
                $qty = $_POST['qty'];
            }
            $stmt = $pdo->prepare('INSERT INTO products (slug, price, selling_price, is_active, created_at) 
                VALUES(:slug, :price, :selling_price, :is_active, :created_at)');
            $stmt->execute([
                ':slug' => $_POST['product_name'],
                ':price' => $_POST['price'],
                ':selling_price' => $_POST['selling_price'],
                ':is_active' => $_POST['isActive'],
                ':created_at' => date('Y-m-d H:i')
            ]);
            $product_id = $pdo->lastInsertId();
            if ($stmt->rowCount())
            {
                $stmt = $pdo->prepare('INSERT INTO product_categories (product_id, category_id, created_at)
                VALUES(:product_id, :category_id, :created_at)');
                $stmt->execute([
                    ':product_id' => $product_id,
                    ':category_id' => $_POST['category_id'],
                    ':created_at' => date('Y-m-d H:i')
                ]);
                if ($stmt->rowCount())
                {
                    $stmt = $pdo->prepare('INSERT INTO stock (product_id, sku, stock_manage, qty, created_at)
                    VALUES(:product_id, :sku, :stock_manage, :qty, :created_at)');
                    $stmt->execute([
                        ':product_id' => $product_id,
                        ':sku' => $_POST['sku'],
                        ':stock_manage' => $stock_manage,
                        ':qty' => $qty,
                        ':created_at' => date('Y-m-d H:i')
                    ]);
                    if ($stmt->rowCount()) 
                    {
                        echo json_encode(['status'=> 202, 'message'=> 'تم اضافه المنتج بنجاح']);
                        exit();
                    }
                    else
                    {
                        echo json_encode(['status'=> 303, 'message'=> 'فشل في اضافة المنتج']);
                        exit();
                    }
                }
                else
                {
                    echo json_encode(['status'=> 303, 'message'=> 'فشل في اضافة المنتج']);
                    exit();
                }
            }
            else
            {
                echo json_encode(['status'=> 303, 'message'=> 'فشل في اضافة المنتج']);
                exit();
            }
        }
        else
        {
            echo json_encode(['status'=> 303, 'message'=> 'اسم المنتج غير صحيح']);
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