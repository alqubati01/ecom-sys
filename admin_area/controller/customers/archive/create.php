<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['first_name'],$_POST['last_name'], $_POST['username'], 
    $_POST['email'], $_POST['password'], $_POST['confirmPassword'], $_POST['address'],
    $_POST['city'], $_POST['area'], $_POST['phone'], $_POST['createUser'])
    && !empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['username'])
    && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmPassword']) 
    && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['area']) 
    && !empty($_POST['phone']) && !empty($_POST['createUser']))
    {

        if (preg_match('/^[a-z0-9 ]*$/i', $_POST['username'])) 
        {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) 
            {
                if ($_POST['confirmPassword'] === $_POST['password']) 
                { 
                    $stmt = $pdo->prepare('SELECT * FROM users WHERE username=:username');
                    $stmt->execute([
                        ':username' => $_POST['username']
                    ]);
                    if ($stmt->rowCount()) 
                    {
                        $_SESSION['error'] = 'اسم المستخدم موجود بالفعل اختر اسما اخر';
                        header('refresh:0;url=../../customers.php');
                    } 
                    else {
                        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
                        $stmt->execute([
                            ':email' => $_POST['email']
                        ]);
                        if ($stmt->rowCount()) 
                        {
                            $_SESSION['error'] = 'هذا الايميل موجود بالفعل اختر اسما اخر';
                            header('refresh:0;url=../../customers.php');
                        } 
                        else 
                        {
                            $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, username, email, password, is_active, phone, city_id, area_id, address, created_at) 
                                                    VALUES(:first_name,:last_name,:username,:email,:password,:is_active,:phone,:city_id, :area_id, :address,:created_at)');
                            $stmt->execute([
                                ':first_name' => $_POST['first_name'],
                                ':last_name' => $_POST['last_name'],
                                ':username' => $_POST['username'],
                                ':email' => $_POST['email'],
                                ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 11]),
                                ':is_active' => $_POST['isActive'],
                                ':phone' => $_POST['phone'],
                                ':city_id' => $_POST['city'],
                                ':area_id' => $_POST['area'],
                                ':address' => $_POST['address'],
                                ':created_at' => date('Y-m-d H:i')
                            ]);
                            if ($stmt->rowCount()) 
                            {
                                $stmt = $pdo->prepare('INSERT INTO user_roles (user_id, role_id, created_at) 
                                            VALUES(:user_id, :role_id, :created_at)');
                                $stmt->execute([
                                    ':user_id' => $pdo->lastInsertId(),
                                    ':role_id' => 2,
                                    ':created_at' => date('Y-m-d H:i')
                                ]);
                                if ($stmt->rowCount()) 
                                {
                                    $_SESSION['success'] = 'تم اضافه عميل بنجاح';
                                    header('refresh:0;url=getCustomers.php');
                                }
                            }
                            else
                            {
                                $_SESSION['error'] = 'فشل في اضافة عميل';
                                header('refresh:0;url=../../customers.php');
                            }
                        }
                    }
                }
                else
                {
                    $_SESSION['error'] = 'كلمة السر غير مطابقة';
                    header('refresh:0;url=../../customers.php');
                }
            }
            else
            {
                $_SESSION['error'] = 'ايميل غير صالح';
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