<?php

session_start();
require_once '../../include/connection.php';

// print_r($_POST);
// print_r($_FILES);
// die();

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['addBrandImage'], $_POST['id']) && !empty($_POST['addBrandImage']) && !empty($_POST['id']))
    {
        $stmt = $pdo->prepare('SELECT * FROM files where entity_id=:id AND entity_type=:entity_type');
        $stmt->execute([
            ':id' => $_POST['id'],
            ':entity_type' => 'Brand'
        ]);
        if ($stmt->rowCount())
        {
            echo json_encode(['status'=> 303, 'message'=> 'فشل في تحميل الصورة قم بمسح الصورة الاساسية']);
            exit();
        }
        else {
            if (!empty($_FILES['brand_image']))
            {
                $file = $_FILES['brand_image'];
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
                                    ':entity_type' => 'Brand',
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
                                    echo json_encode(['status'=> 202, 'message'=> 'تم تحميل الصورة بنجاح']);
                                    exit();
                                }
                                else
                                {
                                    echo json_encode(['status'=> 303, 'message'=> 'فشل في تحميل الصورة']);
                                    exit();
                                }
                            }
                        }
                        else
                        {
                            echo json_encode(['status'=> 303, 'message'=> 'حجم الملف كبير']);
                            exit();
                        }
                    }
                }
                else
                {
                    echo json_encode(['status'=> 303, 'message'=> 'امتداد الملف غير مسموح به']);
                    exit();
                }
            }
            else
            {
                echo json_encode(['status'=> 303, 'message'=> 'قم برفع الصورة']);
                exit();
            }
        } 
    }
    else
    {
        echo json_encode(['status'=> 303, 'message'=> 'من فضلك املاء بعض الحقول']);
        exit();
    }
}
else
{
    echo json_encode(['status'=> 303, 'message'=> 'قم بتسجيل الدخول']);
    exit();
}