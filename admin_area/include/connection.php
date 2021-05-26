<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=ecommerce_system;connect_timeout=15;charset=utf8', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
    $pdo->query('SET SQL_MODE="NO_BACKSLASH_ESCAPES"');
    $pdo->query('SET NAMES utf8');
} catch(PDOException $e) {
    die($e->getMessage());
}