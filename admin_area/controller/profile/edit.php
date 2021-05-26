<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (count($_POST) > 1)
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
                $stmt = $pdo->prepare('UPDATE users SET first_name=:first_name, last_name=:last_name,username=:username, 
                        city_id=:city_id, area_id=:area_id, address=:address, phone=:phone, updated_at=:updated_at WHERE id=:id');
                $stmt->execute([
                    ':id' => $_SESSION['id'],
                    ':first_name' => $_POST['first_name'],
                    ':last_name' => $_POST['last_name'],
                    ':username' => $_POST['username'],
                    ':city_id' => $_POST['city'],
                    ':area_id' => $_POST['area'],
                    ':address' => $_POST['address'],
                    ':phone' => $_POST['phone'],
                    ':updated_at' => date('Y-m-d H:i')
                ]);
                if ($stmt->rowCount())
                {
                    $_SESSION['success'] = 'تم تحديث ملفك الشخصي بنجاح';
                    header('refresh:0;url=getAdmin.php');
                }
            }
            $pdo->commit();
        }
        catch (PDOException $e) 
        {
            $pdo->rollBack();
            $_SESSION['error'] = 'اسم المستخدم موجود بالفعل اختر اسماً اخر';
            header('refresh:.5;url=../../admin-profile.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'من فضلك املاء بعض الحقول';
        header('refresh:0;url=../../admin-profile.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}
