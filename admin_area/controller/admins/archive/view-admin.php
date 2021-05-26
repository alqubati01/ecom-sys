<?php

session_start();
require_once '../../include/connection.php';


if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) 
{
    if (isset($_POST['id']) && !empty($_POST['id']))
    {
        print_r($_POST);
        die();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id=:id');
        $stmt->execute([
            ':id' => $_POST['id']
        ]);

        $data = $stmt->fetch();
        echo json_encode($data); 

        // $_SESSION['view-admin'] = $stmt->fetch();
        // header('refresh:0; url=../../admin-profile.php');
    }
}
else
{
    $_SESSION['error'] = 'قم بتسجيل الدخول';
    header('refresh:0;url=../../login.php');
}