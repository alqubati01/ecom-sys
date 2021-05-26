<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id'],$_POST['first_name'],$_POST['last_name'], $_POST['username'], 
    $_POST['city'], $_POST['area'], $_POST['address'], $_POST['phone'], $_POST['editUser'])
    && !empty($_POST['id']) && !empty($_POST['first_name']) && !empty($_POST['last_name']) 
    && !empty($_POST['username']) && !empty($_POST['city']) && !empty($_POST['area']) 
    && !empty($_POST['address']) && !empty($_POST['phone']) && !empty($_POST['editUser']))
    {
        if (preg_match('/^[a-z0-9 ]*$/i', $_POST['username'])) 
        {
            try 
            {
                $pdo->beginTransaction();
                $stmt = $pdo->prepare('SELECT * FROM users WHERE id=:id');
                $stmt->execute([
                    ':id' => $_POST['id']
                ]);
                if ($stmt->rowCount())
                {
                    $stmt = $pdo->prepare('UPDATE users SET first_name=:first_name, last_name=:last_name, 
                                username=:username, city_id=:city_id , area_id=:area_id , address=:address, 
                                phone=:phone, updated_at=:updated_at WHERE id=:id');
                    $stmt->execute([
                        ':first_name' => $_POST['first_name'],
                        ':last_name' => $_POST['last_name'],
                        ':username' => $_POST['username'],
                        ':city_id' => $_POST['city'],
                        ':area_id' => $_POST['area'],
                        ':address' => $_POST['address'],
                        ':phone' => $_POST['phone'],
                        ':updated_at' => date('Y-m-d H:i'),
                        ':id' => $_POST['id']
                    ]);
                    if ($stmt->rowCount()) 
                    {
                        $_SESSION['success'] = 'تم تعديل العميل بنجاح';
                        header('refresh:0;url=getCustomers.php');
                    }
                    else
                    {
                        $_SESSION['error'] = 'فشل في تعديل العميل';
                        header('refresh:0;url=../../customers.php');
                    }
                }
                $pdo->commit();
            }
            catch (PDOException $e) 
            {
                $pdo->rollBack();
                $_SESSION['error'] = 'اسم المستخدم موجود بالفعل اختر اسما اخر';
                header('refresh:0;url=../../customers.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'اسم المستخدم غير صحيح';
            header('refresh:0;url=../../customers.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'من فضلك املاء بعض الحقول';
        header('refresh:0;url=../../customers.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}