<?php

require_once '../../include/connection.php';
session_start();
$p_id = $_SESSION['product_id'];
$product_name = $_SESSION['pname'];

// print_r($_POST);
// print_r($_FILES);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['addBaseImage'], $_POST['id']) && !empty($_POST['addBaseImage']) && !empty($_POST['id']))
    {
        $stmt = $pdo->prepare('SELECT * FROM files where entity_id=:id AND entity_type=:entity_type AND zone=:zone');
        $stmt->execute([
            ':id' => $_POST['id'],
            ':entity_type' => 'Product',
            ':zone' => 'baseImage'
        ]);
        if ($stmt->rowCount())
        {
            $_SESSION['error'] = 'فشل في تحميل الصورة قم بمسح الصورة الاساسية';
            header('refresh:0;url=../../product-image.php');
        }
        else {
            if (!empty($_FILES['base_image']))
            {
                $file = $_FILES['base_image'];
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
                                    ':entity_type' => 'Product',
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
                                    header('Location:/EcommerceSystem.v.2/admin_area/controller/products/getProductImage.php?id=' . $p_id .'&pname=' . $product_name);
                                }
                                else
                                {
                                    $_SESSION['error'] = 'فشل في تحميل الصورة';
                                    header('refresh:0;url=../../product-image.php');
                                }
                            }
                        }
                        else
                        {
                            $_SESSION['error'] = 'حجم الملف كبير';
                            header('refresh:0;url=../../product-image.php');
                        }
                    }
                }
                else
                {
                    $_SESSION['error'] = 'امتداد الملف غير مسموح به';
                    header('refresh:0;url=../../product-image.php');
                }
            }
            else
            {
                $_SESSION['error'] = 'قم برفع الصورة';
                header('refresh:0;url=../../product-image.php');
            }
        } 
    }
    if (isset($_POST['addAdditionalImage'], $_POST['id']) && !empty($_POST['addAdditionalImage']) && !empty($_POST['id']))
    {
        if (!empty($_FILES['additional_image']))
        {
            $file = $_FILES['additional_image'];
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
                                ':entity_type' => 'Product',
                                ':zone' => 'additionalImage',
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
                                header('Location:/EcommerceSystem.v.2/admin_area/controller/products/getProductImage.php?id=' . $p_id .'&pname=' . $product_name);
                            }
                            else
                            {
                                $_SESSION['error'] = 'فشل في تحميل الصورة';
                                header('refresh:0;url=../../product-image.php');
                            }
                        }
                    }
                    else
                    {
                        $_SESSION['error'] = 'حجم الملف كبير';
                        header('refresh:0;url=../../product-image.php');
                    }
                }
            }
            else
            {
                $_SESSION['error'] = 'امتداد الملف غير مسموح به';
                header('refresh:0;url=../../product-image.php');
            }
        }
        else
        {
            $_SESSION['error'] = 'قم برفع الصورة';
            header('refresh:0;url=../../product-image.php');
        }
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}