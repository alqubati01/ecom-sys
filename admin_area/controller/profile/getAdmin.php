<?php

session_start();
require_once '../../include/connection.php';

$stmt = $pdo->prepare('SELECT u.*, c.name as city_name, a.name as area_name
                    FROM users u 
                    LEFT JOIN cities c
                        ON u.city_id = c.id
                    LEFT JOIN areas a
                        ON u.area_id = a.id
                    WHERE u.id=:id');
$stmt->execute([
    ':id' => $_SESSION['id']
]);

$_SESSION['admin'] = $stmt->fetch();
header('refresh:0; url=../../admin-profile.php');