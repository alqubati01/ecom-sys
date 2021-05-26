<?php

session_start();
require_once '../../include/connection.php';

// print_r($_POST);
// print_r($_FILES);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['addImage'], $_POST['id']) && !empty($_POST['addImage']) && !empty($_POST['id']))
    {
        $stmt = $pdo->prepare('SELECT * FROM files where entity_id=:id AND entity_type=:entity_type');
        $stmt->execute([
            ':id' => $_POST['id'],
            ':entity_type' => 'Category'
        ]);
        if ($stmt->rowCount())
        {
            $_SESSION['error'] = 'فشل في تحميل الصورة قم بمسح الصورة الاساسية';
            header('refresh:0;url=../../categories.php');
        }
        else {
            if (!empty($_FILES['category_image']))
            {
                $file = $_FILES['category_image'];
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
                                $stmt = $pdo->prepare('INSERT INTO files (entity_id, entity_type, zone, filename, path, extension, mime, size, created_at)
                                VALUES (:entity_id, :entity_type, :zone, :filename, :path, :extension, :mime, :size, :created_at);');
                                $stmt->execute([
                                    ':entity_id' => $_POST['id'],
                                    ':entity_type' => 'Category',
                                    ':zone' => 'baseImage',
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
                                    header('refresh:0;url=../../categories.php');
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
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}