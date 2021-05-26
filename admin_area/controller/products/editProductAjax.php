<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();
//editProductBasic
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['editProductBasic']))
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
            $stmt = $pdo->prepare('UPDATE products SET slug=:product_name, description=:product_desc, price=:price,
                selling_price=:selling_price, special_price=:special_price, special_price_end=:special_price_end,
                updated_at=:updated_at WHERE id=:id');
            $stmt->execute([
                ':product_name' => $_POST['product_name'],
                ':product_desc' => $_POST['product_desc'],
                ':price' => $_POST['price'],
                ':selling_price' => $_POST['selling_price'],
                ':special_price' => $_POST['special_price'],
                ':special_price_end' => $_POST['special_price_end'],
                ':updated_at' => date('Y-m-d H:i'),
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount())
            {
                $stmt = $pdo->prepare('UPDATE stock SET sku=:sku, stock_manage=:stock_manage, qty=:qty,
                                updated_at=:updated_at WHERE product_id=:product_id');
                $stmt->execute([
                    ':sku' => $_POST['sku'],
                    ':stock_manage' => $stock_manage,
                    ':qty' => $qty,
                    ':updated_at' => date('Y-m-d H:i'),
                    ':product_id' => $_POST['id']
                ]);
                if ($stmt->rowCount())
                {
                    echo json_encode(['status'=> 202, 'message'=> 'تم تعديل المنتج بنجاح']);
                    exit();
                }
            }   
        }
        else
        {
            echo json_encode(['status'=> 303, 'message'=> 'اسم المنتج غير صحيح']);
            exit();
        }
    }
    else if (isset($_POST['editProductMore']))
    {
        $stmt = $pdo->prepare('UPDATE product_categories SET category_id=:category_id,
        updated_at=:updated_at WHERE product_id=:id');
        $stmt->execute([
            ':category_id' => $_POST['category_id'],
            ':updated_at' => date('Y-m-d H:i'),
            ':id' => $_POST['id']
        ]);
        if ($stmt->rowCount())
        {
            $stmt = $pdo->prepare('UPDATE products SET brand_id=:brand_id,
            updated_at=:updated_at WHERE id=:id');
            $stmt->execute([
                ':brand_id' => $_POST['brand_id'],
                ':updated_at' => date('Y-m-d H:i'),
                ':id' => $_POST['id']
            ]);
            if ($stmt->rowCount())
            {
                echo json_encode(['status'=> 202, 'message'=> 'تم تعديل المنتج بنجاح']);
                exit();
            }
        }
    }
    else if (isset($_POST['editProductSEO']))
    {
        $stmt = $pdo->prepare('UPDATE products SET meta_title=:meta_title, meta_desc=:meta_desc, 
        updated_at=:updated_at WHERE id=:id');
        $stmt->execute([
            ':meta_title' => $_POST['meta_title'],
            ':meta_desc' => $_POST['meta_desc'],
            ':id' => $_POST['id'],
            ':updated_at' => date('Y-m-d H:i')
        ]);
        if ($stmt->rowCount())
        {
            echo json_encode(['status'=> 202, 'message'=> 'تم تعديل المنتج بنجاح']);
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