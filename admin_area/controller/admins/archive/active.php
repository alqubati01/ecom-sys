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
                                    $_SESSION['success'] = 'تم تنشيط الادمن';
                                    header('refresh:0;url=getAdmins.php');
                                }
                                else
                                {
                                    $_SESSION['error'] = 'فشل في تنشيط الادمن';
                                    header('refresh:0;url=../../employees.php');
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
                                    $_SESSION['success'] = 'تم ايقاف الادمن';
                                    header('refresh:0;url=getAdmins.php');
                                }
                                else
                                {
                                    $_SESSION['error'] = 'فشل في ايقاف الادمن';
                                    header('refresh:0;url=../../employees.php');
                                }
                                break;
                        }
                    }
                }
                else
                {
                    $_SESSION['error'] = 'هذا الادمن غير موجود';
                    header('refresh:0;url=../../employees.php');
                }
            }
            else
            {
                $_SESSION['error'] = 'رقم الادمن لابد ان يكون رقم';
                header('refresh:0;url=../../employees.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'الحدث غير موجود';
            header('refresh:0;url=../../employees.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'لم يتم ارسال رقم الادمن';
        header('refresh:0;url=../../employees.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}