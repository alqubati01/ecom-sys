<?php

session_start();
require_once '../../include/connection.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_FILES['admin_image'], $_POST['id']))
    {
        $file = $_FILES['admin_image'];
        $file_name = $file['name'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];
        $file_error = $file['error'];
        $allowedExts = ['gif', 'png', 'jpg', 'jpeg'];
        $extension = explode('.', $file_name);
        $extension = strtolower(end($extension));

        if (in_array($extension, $allowedExts))
        {
            if ($file_error === 0)
            {
                if ($file_size <= 2*1024*1024)
                {
                    $file_name_new = sha1(uniqid('',true)) . '.' . $extension;
                    $file_destination = "../../images/avatar/" . $file_name_new;
                    
                    if (move_uploaded_file($file_tmp,$file_destination))
                    {
                        $file_destination = "images/avatar/" . $file_name_new;
                        $stmt = $pdo->prepare('UPDATE users SET image=:image WHERE id=:id');
                        $stmt->execute([
                            ':image' => $file_destination,
                            ':id' => $_POST['id']
                        ]);
                        if ($stmt->rowCount())
                        {
                            $_SESSION['success'] = 'تم تحديث صورة ملفك الشخصي بنجاح';
                            header('refresh:0;url=getAdmin.php');
                        }
                        else
                        {
                            $_SESSION['error'] = 'فشل في تحميل الصورة';
                            header('refresh:0;url=../../admin-profile.php');
                        }
                    }
                }
                else
                {
                    $_SESSION['error'] = 'حجم الملف كبير';
                    header('refresh:0;url=../../admin-profile.php');
                }
            }
        }
        else
        {
            $_SESSION['error'] = 'امتداد الملف غير مسموح به';
            header('refresh:0;url=../../admin-profile.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'قم بملىء الحقول';
        header('refresh:0;url=../../admin-profile.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}