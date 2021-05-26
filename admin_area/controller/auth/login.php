<?php

session_start();
require_once '../../include/connection.php';


if (isset($_POST['email'],$_POST['password'], $_POST['login'])
    && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['login']))
{
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=:email');
        $stmt->execute([
            ':email' => $email
        ]);
        if ($stmt->rowCount())
        {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE  email=:email AND is_active = 1');
            $stmt->execute([
                ':email' => $email,
            ]);
            if ($stmt->rowCount()) {
                $value= $stmt->fetch();
                if (password_verify($password, $value['password']))
                {
                    $stmtCheck = $pdo->prepare('SELECT ur.user_id, r.name FROM user_roles ur JOIN 
                                            roles r ON ur.role_id = r.id WHERE user_id =:user_id');
                    $stmtCheck->execute([
                        ':user_id' => $value['id']
                    ]);
                    if ($stmtCheck->rowCount())
                    {
                        $valueCheck = $stmtCheck->fetch();
                        if ($valueCheck['name'] === 'customer')
                        {
                            $_SESSION['error'] = 'غير مسموح لك بدخول';
                            header('refresh:0;url=../../login.php');
                        }
                        else 
                        {
                            // register user for session by id and email
                            $_SESSION['admin_login'] = true;
                            $_SESSION['id'] = $value['id'];
                            $_SESSION['email'] = $value['email'];
                            $stmt = $pdo->prepare('UPDATE users SET last_login=:last_login WHERE id=:id');
                            $stmt->execute([
                                ':last_login' => date('Y-m-d H:i'),
                                ':id' => $_SESSION['id']
                            ]);
                            // get admin session for update admin profile
                            $stmt = $pdo->prepare('SELECT u.*, c.name as city_name, a.name as area_name
                                                FROM users u 
                                                LEFT JOIN cities c
                                                    ON u.city_id = c.id
                                                LEFT JOIN areas a
                                                    ON u.area_id = a.id
                                                WHERE u.id=:id');
                            $stmt->execute([
                                ':id' => $_SESSION['id']
                            ]);
                            $_SESSION['admin'] = $stmt->fetch();
                            header('refresh:0.1;url=../../index.php');
                        }
                    }
                }
                else
                {
                    $_SESSION['error'] = 'تحقق من كلمة السر او اسم المستخدم';
                    header('refresh:0;url=../../login.php');
                }
            }
            else
            {
                $_SESSION['error'] = 'تواصل بالادمن لتفعيل حسابك';
                header('refresh:0;url=../../login.php');
            }
        }
        else 
        {
            $_SESSION['error'] = 'المستخدم غير موجود';
            header('refresh:0;url=../../login.php');
        } 
    }
    else
    {
        $_SESSION['error'] = 'من فضلك تحقق من اسم المستخدم وكلمة السر';
        header('refresh:0;url=../../login.php');
    }
}
else
{
    $_SESSION['error'] = 'من فضلك ادخل اسم المستخدم وكلمة السر';
    header('refresh:0;url=../../login.php');
}

