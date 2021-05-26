<?php

session_start();
require_once '../../include/connection.php';

if (isset($_POST['deleteImage'], $_POST['id']) && !empty($_POST['deleteImage']) && !empty($_POST['id']))
{
    $stmt = $pdo->prepare('SELECT * FROM files WHERE id=:id');
    $stmt->execute([
        ':id' => $_POST['id']
    ]);
    if ($stmt->rowCount())
    {
        $stmt = $pdo->prepare('DELETE FROM files WHERE id=:id');
        $stmt->execute([
            ':id' => $_POST['id']
        ]);
        if ($stmt->rowCount())
        {
            $_SESSION['success'] = 'تم حذف الصورة بنجاح';
            header('refresh:0;url=../../categories.php');
        }
    }
    else 
    {
        $_SESSION['error'] = 'هذا الصورة غير موجود';
        header('refresh:0;url=../../categories.php');
    }
}