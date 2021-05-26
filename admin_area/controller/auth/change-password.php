<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true)
{
    if (isset($_POST['currentPassword'], $_POST['newPassword'], 
            $_POST['confirmPassword'], $_POST['changePassword'])
            && !empty($_POST['currentPassword']) && !empty($_POST['newPassword']) 
            && !empty($_POST['confirmPassword']) && !empty($_POST['changePassword']))
    {

        $stmt = $pdo->prepare('SELECT * FROM users WHERE id=:id');
        $stmt->execute([
            ':id' => $_SESSION['id']
        ]);
        if ($stmt->rowCount()) 
        {
            $value = $stmt->fetch();
            if (password_verify($_POST['currentPassword'], $value['password'])) 
            {
                if ($_POST['newPassword'] === $_POST['confirmPassword']) {
                    $stmt = $pdo->prepare('UPDATE users SET password=:password, updated_at=:updated_at WHERE id=:id');
                    $stmt->execute([
                            ':password' => password_hash($_POST['newPassword'], PASSWORD_DEFAULT, ['cost' => 11]),
                            ':id' => $_SESSION['id'],
                            ':updated_at' => date('Y-m-d H:i')
                        ]);
                    if ($stmt->rowCount()) {
                        $_SESSION['success'] = 'تم تغيير كلمة السر بنجاح';
                        header('refresh:0;url=../../change-password.php');
                    } else {
                        $_SESSION['error'] = 'فشل في تغيير كلمة السر';
                        header('refresh:0;url=../../change-password.php');
                    }
                } else {
                    $_SESSION['error'] = 'كلمة السر غير مطابقة';
                    header('refresh:0;url=../../change-password.php');
                }
            }
            else 
            {
                $_SESSION['error'] = 'كلمة السر غير صحيحة';
                header('refresh:0;url=../../change-password.php');
            }
        } 
    } 
    else
    {
        $_SESSION['error'] = 'من فضلك املاء كل الحقول';
        header('refresh:0;url=../../change-password.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}
