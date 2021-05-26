<?php

session_start();
require_once '../../include/connection.php';

$actions = ['active', 'stop'];
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_GET['action'],$_GET['id'])
        && !empty($_GET['action']) && !empty($_GET['id']))
    {
        if (in_array($_GET['action'], $actions))
        {
            if (preg_match('/^[0-9]*$/', $_GET['id']))
            {
                $stmt = $pdo->prepare('SELECT * FROM brands WHERE id=:id');
                $stmt->execute([
                    ':id' => $_GET['id']
                ]);
                if ($stmt->rowCount())
                {
                    foreach ($stmt->fetchAll() as $value)
                    {
                        switch ($_GET['action'])
                        {
                            case 'active':
                                $stmt = $pdo->prepare('UPDATE brands SET is_active=:active WHERE id=:id');
                                $stmt->execute([
                                    ':id' => $_GET['id'],
                                    ':active' => 1
                                ]);
                                if ($stmt->rowCount())
                                {
                                    $_SESSION['success'] = 'تم اظهار البراند';
                                    header('refresh:0;url=getBrands.php');
                                }
                                else
                                {
                                    $_SESSION['error'] = 'فشل في اظهار البراند';
                                    header('refresh:0;url=../../brands.php');
                                }
                                break;
                            case 'stop':
                                $stmt = $pdo->prepare('UPDATE brands SET is_active=:stop WHERE id=:id');
                                $stmt->execute([
                                    ':id' => $_GET['id'],
                                    ':stop' => 0
                                ]);
                                if ($stmt->rowCount())
                                {
                                    $_SESSION['success'] = 'تم اخفاء البراند';
                                    header('refresh:0;url=getBrands.php');
                                }
                                else
                                {
                                    $_SESSION['error'] = 'فشل في اخفاء البراند';
                                    header('refresh:0;url=../../brands.php');
                                }
                                break;
                        }
                    }
                }
                else
                {
                    $_SESSION['error'] = 'هذا البراند غير موجود';
                    header('refresh:0;url=../../brands.php');
                }
            }
            else
            {
                $_SESSION['error'] = 'رقم البراند لابد ان يكون رقم';
                header('refresh:0;url=../../brands.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'الحدث غير موجود';
            header('refresh:0;url=../../brands.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'لم يتم ارسال رقم البراند';
        header('refresh:0;url=../../brands.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}