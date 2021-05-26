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
                $stmt = $pdo->prepare('SELECT * FROM users WHERE id=:id');
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
                                $stmt = $pdo->prepare('UPDATE users SET is_active=:active 
                                WHERE id=:id');
                                $stmt->execute([
                                    ':id' => $_GET['id'],
                                    ':active' => 1
                                ]);
                                if ($stmt->rowCount())
                                {
                                    $_SESSION['success'] = 'تم تنشيط العميل';
                                    header('refresh:0;url=getCustomers.php');
                                }
                                else
                                {
                                    $_SESSION['error'] = 'فشل في تنشيط العميل';
                                    header('refresh:0;url=../../customers.php');
                                }
                                break;
                            case 'stop':
                                $stmt = $pdo->prepare('UPDATE users SET is_active=:stop 
                                WHERE id=:id');
                                $stmt->execute([
                                    ':id' => $_GET['id'],
                                    ':stop' => 0
                                ]);
                                if ($stmt->rowCount())
                                {
                                    $_SESSION['success'] = 'تم ايقاف العميل';
                                    header('refresh:0;url=getCustomers.php');
                                }
                                else
                                {
                                    $_SESSION['error'] = 'فشل في ايقاف العميل';
                                    header('refresh:0;url=../../customers.php');
                                }
                                break;
                        }
                    }
                }
                else
                {
                    $_SESSION['error'] = 'هذا العميل غير موجود';
                    header('refresh:0;url=../../customers.php');
                }
            }
            else
            {
                $_SESSION['error'] = 'رقم العميل لابد ان يكون رقم';
                header('refresh:0;url=../../customers.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'الحدث غير موجود';
            header('refresh:0;url=../../customers.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'لم يتم ارسال رقم العميل';
        header('refresh:0;url=../../customers.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}