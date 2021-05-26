<?php

require_once '../../include/connection.php';
session_start();

$stmt = $pdo->prepare('SELECT id, slug, is_active FROM brands ORDER BY created_at DESC');
$stmt->execute();

$_SESSION['brands'] = $stmt->fetchAll();
header('refresh:0; url=../../brands.php');



