<?php

require_once '../../include/connection.php';
session_start();

$stmt = $pdo->prepare('SELECT id, parent_id, slug AS text, is_active FROM categories');
$stmt->execute();
$_SESSION['categories'] = $stmt->fetchAll();
header('refresh:0; url=../../categories.php');

