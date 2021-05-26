<?php

session_start();
require_once '../../include/connection.php';

// print_r($_FILES);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (!empty($_FILES))
    {
        $file = $_FILES['file'];
        $file_name = $file['name'];
        $file_type = $file['type'];
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
                if ($file_size <= 5*1024*1024)
                {
                    $file_name_new = sha1(uniqid('',true)) . '.' . $extension;
                    $file_destination = "../../images/media/" . $file_name_new;
                    
                    if (move_uploaded_file($file_tmp,$file_destination))
                    {
                        $file_destination = "images/media/" . $file_name_new;
                        $stmt = $pdo->prepare('INSERT INTO files (user_id, filename, path, extension, mime, size, created_at)
                        VALUES (:user_id, :filename, :path, :extension, :mime, :size, :created_at);');
                        $stmt->execute([
                            ':user_id' => $_SESSION['id'],
                            ':filename' => $file_name,
                            ':path' => $file_destination,
                            ':extension' => $extension,
                            ':mime' => $file_type,
                            ':size' => $file_size,
                            ':created_at' => date('Y-m-d H:i')
                        ]);
                        if ($stmt->rowCount())
                        {
                            $_SESSION['success'] = 'تم تحميل الصورة بنجاح';
                            header('refresh:0;url=categories.php');
                        }
                        else
                        {
                            $_SESSION['error'] = 'فشل في تحميل الصورة';
                            header('refresh:0;url=../../categories.php');
                        }
                    }
                }
                else
                {
                    $_SESSION['error'] = 'حجم الملف كبير';
                    header('refresh:0;url=../../categories.php');
                }
            }
        }
        else
        {
            $_SESSION['error'] = 'امتداد الملف غير مسموح به';
            header('refresh:0;url=../../categories.php');
        }
    }
    else
    {
        $_SESSION['error'] = 'قم برفع الصورة';
        header('refresh:0;url=../../categories.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}