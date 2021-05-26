<?php

require_once '../../include/connection.php';
session_start();

$stmt = $pdo->prepare('SELECT u.id, u.first_name, u.last_name, u.username, u.email, u.address, c.name AS city_name, a.name AS area_name, u.phone, u.last_login, u.is_active, u.image, r.name 
                        FROM users u
                        JOIN user_roles ur
                            ON u.id = ur.user_id
                        JOIN roles r
                            ON r.id = ur.role_id
                        LEFT JOIN cities c
                            ON u.city_id = c.id
                        LEFT JOIN areas a
                            ON u.area_id = a.id
                        WHERE r.name = "customer"');
$stmt->execute();

$_SESSION['customers'] = $stmt->fetchAll();
header('refresh:0; url=../../customers.php');



