<?php

session_start();
require_once '../../include/connection.php';

// print_r($_GET);
// unset($_SESSION['order_details']);
// unset($_SESSION['order_items']);
// unset($_SESSION['order_statues']);

if (isset($_GET['id']) && !empty($_GET['id'])) 
{
    $stmt = $pdo->prepare('SELECT 
                                o.id AS id, 
                                o.order_ref_number AS order_number, 
                                o.customer_id AS customer_id, 
                                o.order_date AS order_date, 
                                o.products_price AS products_price,
                                o.delivery_cost AS delivery_cost,
                                o.total_price AS total_price,
                                u.first_name AS first_name, u.last_name AS last_name,
                                o.status_id AS status_id, s.name AS status_name, 
                                o.shipper_id AS shipper_id, sh.name AS shipper_name,
                                o.payment_method AS payment_method, pm.name AS payment_method_name,
                                SUM(oi.qty) AS qtyProducts
                            FROM orders o
                            JOIN users u
                                ON o.customer_id = u.id
                            JOIN statuses s
                                ON o.status_id = s.id
                            JOIN shippers sh
                                ON o.shipper_id = sh.id
                            JOIN payment_methods pm
                                ON o.payment_method = pm.id
                            JOIN order_items oi
                                ON o.id = oi.order_id
                            WHERE o.id=:id');
$stmt->execute([
    ':id' => $_GET['id']
]);
$_SESSION['order_details'] = $stmt->fetch();

$stmt = $pdo->prepare('SELECT 
                        	oi.id AS order_items_id, 
                            oi.order_id AS order_id, 
                            oi.product_id AS product_id, 
                            oi.qty AS product_qty, 
                            oi.price_per_unit AS product_price_per_unit, 
                            oi.total AS products_total,
                            p.id, p.slug, p.selling_price, p.special_price, f.path
                        FROM order_items oi
                        JOIN products p
                            ON  oi.product_id = p.id
                        LEFT JOIN files f
                            ON p.id = f.entity_id AND f.entity_type = "Product" AND f.zone = "baseImage"
                        WHERE oi.order_id = :id');
$stmt->execute([
    ':id' => $_GET['id']
]);
$_SESSION['order_items'] = $stmt->fetchAll();


$stmt = $pdo->prepare('SELECT os.id, os.order_id, os.status_id, s.name
                        FROM order_status os
                        JOIN statuses s
                            ON os.status_id = s.id
                        WHERE os.order_id = :id');
$stmt->execute([
    ':id' => $_GET['id']
]);
$_SESSION['order_statues'] = $stmt->fetchAll();

// print_r($_SESSION['order_details']);
// print_r($_SESSION['order_items']);
// print_r($_SESSION['order_statues']);
// die();

header('refresh:0; url=../../editOrder.php');

}
else
{
    $_SESSION['error'] = 'لم يتم ارسال رقم المنتج';
    header('refresh:0;url=../../orders.php');
}
