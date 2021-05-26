<?php
session_start();
require_once 'include/connection.php';

if (!isset($_SESSION['admin_login']) && $_SESSION['admin_login'] !== true)
{
    header('refresh:0;url=login.php');
}
else
{ 

?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>اضافة طلب</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.rtl.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
</head>

<body class="nk-body ui-rounder npc-default has-sidebar has-rtl" dir="rtl">
    <div class="nk-app-root">
        <?php include_once 'include/sidebar.php'; ?>
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php require_once 'include/header.php'; ?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="alert alert-icon alert-dismissible d-none">
                            <span class="message"></span>
                            <button class="close"></button>
                        </div> 
                        <?php
                        if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                            ?>
                            <div class="alert alert-danger alert-icon alert-dismissible">
                                <?= $_SESSION['error'] ?>
                                <button class="close" data-dismiss="alert"></button>
                            </div> 
                            <?php
                            unset($_SESSION['error']);
                        } elseif (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
                            ?>
                            <div class="alert alert-success alert-icon alert-dismissible mb-2">
                                <?= $_SESSION['success'] ?>
                                <button class="close" data-dismiss="alert"></button>
                            </div>
                            <?php
                            unset($_SESSION['success']);
                        } ?>
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">اضافة طلب</h3>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-stretch">
                                        <div class="card-inner-group">
                                            <div class="card-inner">
                                                <form id="addOrder">
                                                    <div class="row g-4">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-number">رقم الطلب</label>
                                                                        <?php
                                                                            $stmt =  $pdo->prepare('SELECT MAX(order_ref_number) AS orderNumber FROM orders');
                                                                            $stmt->execute();
                                                                            $orderNumber = $stmt->fetch();
                                                                        ?>
                                                                        <div class="form-control-wrap">
                                                                            <input type="number" class="form-control" name="order_number" id="order-number" value="<?= $orderNumber['orderNumber'] + 1?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-data">تاريخ الطلب</label>
                                                                        <?php
                                                                            $date = date('Y-m-d H:i');
                                                                        ?>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" name="order_date" id="order-date" value="<?= $date ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-status">حالة الطلب</label>
                                                                        <div class="form-control-wrap">
                                                                            <div class="form-control-select">
                                                                                <select class="form-control" name="order_status" id="order-status">
                                                                                    <option value="1">جديد</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-customer">العميل</label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select form-control form-control-lg" data-search="on" name="order_customer" id="order-customer">
                                                                                <option value="">اختر عمبل</option>
                                                                                <?php
                                                                                    $getCustomers = $pdo->prepare('SELECT 
                                                                                                        u.id, u.first_name, u.last_name, u.username, u.email, u.address, 
                                                                                                        u.phone, u.last_login, u.is_active, u.image,
                                                                                                        c.name AS city_name, a.name AS area_name, 
                                                                                                        r.name 
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
                                                                                    $getCustomers->execute();
                                                                                    foreach($getCustomers->fetchAll() as $customer)
                                                                                    {
                                                                                        ?>
                                                                                            <option value="<?= $customer['id']?>"><?= $customer['first_name'] . ' ' . $customer['last_name']?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-shipper">الشحن</label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select form-control form-control-lg" data-search="on" name="order_shipper" id="order-shipper">
                                                                                <option value="">اختر وسيلة الشحن</option>
                                                                                <?php
                                                                                    $getShippers = $pdo->prepare('SELECT * FROM shippers');
                                                                                    $getShippers->execute();
                                                                                    foreach($getShippers->fetchAll() as $shipper)
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?= $shipper['id']?>"><?= $shipper['name']?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-payment">الدفع</label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select form-control form-control-lg" data-search="on" name="order_payment" id="order-payment">
                                                                                <option value="">اختر وسيلة الدفع</option>
                                                                                <?php
                                                                                    $getPaymentMethods = $pdo->prepare('SELECT * FROM payment_methods');
                                                                                    $getPaymentMethods->execute();
                                                                                    foreach($getPaymentMethods->fetchAll() as $paymentMethod)
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?= $paymentMethod['id']?>"><?= $paymentMethod['name']?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-4">
                                                            <div class="nk-block nk-block-lg">
                                                                <div class="nk-block-head">
                                                                    <div class="nk-block-head-content">
                                                                        <h4 class="nk-block-title">المنتجات</h4>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-items"></label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select form-control form-control-lg" data-search="on" name="order_items" id="order-item">
                                                                                <!-- <option value="default_option">اختر منتج</option> -->
                                                                                <option value="">اختر منتج</option>
                                                                                <?php
                                                                                    $getProducts = $pdo->prepare('SELECT * FROM products');
                                                                                    $getProducts->execute();
                                                                                    foreach($getProducts->fetchAll() as $product)
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?= $product['id']?>"><?= $product['slug']?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="button" name="addOrderItems" class="btn btn-primary add_to_cart" value="اضافة">
                                                                    </div>
                                                                </div>
                                                                <div class="card card-bordered card-preview">
                                                                    <table class="table table-tranx" id="order_items">
                                                                        <thead>
                                                                            <tr class="tb-tnx-head">
                                                                                <th class="tb-tnx-info">
                                                                                    <span class="tb-tnx-desc d-none d-sm-inline-block">
                                                                                        <span>المنتج</span>
                                                                                    </span>
                                                                                    <span class="tb-tnx-date d-md-inline-block d-none">
                                                                                        <span class="d-md-none">الكمية</span>
                                                                                        <span class="d-none d-md-block">
                                                                                            <span>الكمية</span>
                                                                                            <span>السعر</span>
                                                                                        </span>
                                                                                    </span>
                                                                                </th>
                                                                                <th class="tb-tnx-amount is-alt">
                                                                                    <span class="tb-tnx-total">المجموع</span>
                                                                                </th>
                                                                                <th class="tb-tnx-action">
                                                                                    <span>&nbsp;</span>
                                                                                </th>
                                                                            </tr>
                                                                        </thead>
                                                                        
                                                                    </table>
                                                                </div><!-- .card-preview -->
                                                            </div><!-- nk-block -->
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group g-3 text-center d-block">
                                                                <input type="submit" name="addOrder" id="addOrderSubmit" class="btn btn-lg btn-primary" value="حفظ الطلب">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div><!-- .card-inner-group -->
                                    </div><!-- .card -->
                                </div><!-- .nk-block -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <?php
    require_once 'include/footer.php';
}
?>

<script src="./assets/js/addOrder.js"></script>