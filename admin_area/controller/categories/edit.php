<?php

session_start();
require_once '../../include/connection.php';
// print_r($_POST);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id'],$_POST['category_name'], $_POST['parent_category'], $_POST['editCategory'])
        && !empty($_POST['id']) && !empty($_POST['category_name']) && !empty($_POST['parent_category']) && !empty($_POST['editCategory']))
    {
        if (preg_match('/^[a-z0-9أ-ي ]*$/i', $_POST['category_name'])) 
        {
            if ($_POST['id'] === $_POST['parent_category']) 
            {
                $_SESSION['error'] = 'لا يمكن جعل هذا اختيار هذا التصنيف الرئيسي';
                header('refresh:0;url=../../categories.php');
            }
            else if ($_POST['parent_category'] === 'NULL') 
            {
                $stmt = $pdo->prepare('UPDATE categories SET parent_id=:parent_id,slug=:slug,is_active=:is_active,
                updated_at=:updated_at WHERE id=:id');
                $stmt->execute([
                    ':parent_id' => NULL,
                    ':slug' => $_POST['category_name'],
                    ':is_active' => $_POST['isActive'],
                    ':updated_at' => date('Y-m-d H:i'),
                    ':id' => $_POST['id']
                ]);
                if ($stmt->rowCount()) 
                {
                        $_SESSION['success'] = 'تم تعديل التصنيف بنجاح';
                        header('refresh:0;url=../../categories.php');
                }
                else
                {
                    $_SESSION['error'] = 'فشل في تعديل التصنيف';
                    header('refresh:0;url=../../categories.php');
                }
            }
            else
            {
                $stmt = $pdo->prepare('UPDATE categories SET parent_id=:parent_id,slug=:slug,is_active=:is_active,
                                updated_at=:updated_at WHERE id=:id');
                $stmt->execute([
                    ':parent_id' => $_POST['parent_category'],
                    ':slug' => $_POST['category_name'],
                    ':is_active' => $_POST['isActive'],
                    ':updated_at' => date('Y-m-d H:i'),
                    ':id' => $_POST['id']
                ]);
                if ($stmt->rowCount()) 
                {
                        $_SESSION['success'] = 'تم تعديل التصنيف بنجاح';
                        header('refresh:0;url=getCategories.php');
                }
                else
                {
                    $_SESSION['error'] = 'فشل في تعديل التصنيف';
                    header('refresh:0;url=../../categories.php');
                }
            }
        }
        else
        {
            $_SESSION['error'] = 'اسم التصنيف غير صحيح';
            header('refresh:0;url=../../categories.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'من فضلك املاء بعض الحقول';
        header('refresh:0;url=../../categories.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}