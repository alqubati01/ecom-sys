<?php
session_start();
require_once 'include/connection.php';

if (!isset($_SESSION['admin_login']) && $_SESSION['admin_login'] !== true)
{
    header('refresh:0;url=login.php');
}
else
{ 
    if (array_key_exists('order_details', $_SESSION) && 
        array_key_exists('order_items', $_SESSION) && 
        array_key_exists('order_statues', $_SESSION)) 
    {
        if (count($_SESSION['order_details']) > 0 && $_SESSION['order_details'] !== false &&
            count($_SESSION['order_items']) > 0 && $_SESSION['order_items'] !== false &&
            count($_SESSION['order_statues']) > 0 && $_SESSION['order_statues'] !== false) 
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
    <title>تعديل الطلب</title>
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
                            }
                        ?>
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">تعديل الطلب</h3>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-stretch">
                                        <div class="card-inner-group">
                                            <div class="card-inner">
                                                <form id="editOrder">
                                                    <div class="row g-4">
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-number">رقم الطلب</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="number" class="form-control" name="order_number" id="order-number" value="<?= $_SESSION['order_details']['order_number'] ?>" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-data">تاريخ الطلب</label>
                                                                        <?php
                                                                            $date = date('Y-m-d H:i'); ?>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" name="order_date" id="order-date" value="<?= $_SESSION['order_details']['order_date'] ?>" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-status">حالة الطلب (الحالية = <?= $_SESSION['order_details']['status_name'] ?>)</label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select form-control form-control-lg" data-search="on" name="order_status" id="order-status">
                                                                                <option value=""></option>
                                                                                <?php
                                                                                    $getStatuses = $pdo->prepare('SELECT * FROM statuses');
                                                                                    $getStatuses->execute();
                                                                                    foreach($getStatuses->fetchAll() as $status)
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?= $status['id']?>"><?= $status['name']?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-number">العميل</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" name="customer_number" id="customer-number" value="<?= $_SESSION['order_details']['first_name'] . ' ' . $_SESSION['order_details']['last_name'] ?>" disabled>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-shipper">الشحن (الحالية = <?= $_SESSION['order_details']['shipper_name'] ?>)</label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select form-control form-control-lg" data-search="on" name="order_shipper" id="order-shipper">
                                                                                <option value="">اختر وسيلة الشحن</option>
                                                                                <?php
                                                                                    $getShippers = $pdo->prepare('SELECT * FROM shippers');
                                                                                    $getShippers->execute();
                                                                                    foreach ($getShippers->fetchAll() as $shipper) {
                                                                                        ?>
                                                                                        <option value="<?= $shipper['id']?>"><?= $shipper['name']?></option>
                                                                                        <?php
                                                                                     } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="order-payment">الدفع (الحالية = <?= $_SESSION['order_details']['payment_method_name'] ?>)</label>
                                                                        <div class="form-control-wrap">
                                                                            <select class="form-select form-control form-control-lg" data-search="on" name="order_payment" id="order-payment">
                                                                                <option value="">اختر وسيلة الدفع</option>
                                                                                <?php
                                                                                    $getPaymentMethods = $pdo->prepare('SELECT * FROM payment_methods');
                                                                                    $getPaymentMethods->execute();
                                                                                    foreach ($getPaymentMethods->fetchAll() as $paymentMethod) {
                                                                                        ?>
                                                                                        <option value="<?= $paymentMethod['id']?>"><?= $paymentMethod['name']?></option>
                                                                                        <?php
                                                                                    } ?>
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
                                                                                    foreach ($getProducts->fetchAll() as $product) {
                                                                                        ?>
                                                                                        <option value="<?= $product['id']?>"><?= $product['slug']?></option>
                                                                                        <?php
                                                                                     } ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="order_id" id="order_id" value="<?= $_SESSION['order_details']['id']?>">
                                                                        <input type="button" name="editOrderItems" class="btn btn-primary edit_cart" value="اضافة">
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
                                                                        <tbody>
                                                                            <?php
                                                                            foreach ($_SESSION['order_items'] as $items) 
                                                                            {
                                                                                ?>
                                                                                <tr class="tb-tnx-item">
                                                                                    <td class="tb-tnx-info">
                                                                                        <div class="tb-tnx-desc">
                                                                                            <span class="title"><?= $items['slug']?></span>
                                                                                        </div>
                                                                                        <div class="tb-tnx-date">
                                                                                            <span class="date"><?= $items['product_qty']?></span>
                                                                                            <span class="date"><?= $items['product_price_per_unit']?></span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="tb-tnx-amount is-alt">
                                                                                        <div class="tb-tnx-total">
                                                                                            <span class="amount"><?= number_format($items['product_qty'] * $items['product_price_per_unit'], 2)?></span>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="tb-tnx-action">
                                                                                        <div class="dropdown">
                                                                                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                                                                <ul class="link-list-plain">
                                                                                                    <li><a href="#">تعديل الكمية</a></li>
                                                                                                    <li>
                                                                                                        <span class="span-form">
                                                                                                            <button class="deleteOrderItems btn btn-link p-0 text-decoration-none" data-delete_order_items="<?= $items['order_items_id']?>">حذف المنتج<?= $items['order_items_id']?></button>
                                                                                                        </span>
                                                                                                    </li>
                                                                                                </ul>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                            }?>
                                                                            <tr class="tb-tnx-item">
                                                                                <td class="tb-tnx-info">
                                                                                    <div class="tb-tnx-desc">
                                                                                        <span class="title">مجموع السلة</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="tb-tnx-amount is-alt">
                                                                                    <div class="tb-tnx-total">
                                                                                        <span class="amount" id="product-price"><?= $_SESSION['order_details']['products_price'] ?></span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="tb-tnx-action">
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="tb-tnx-item">
                                                                                <td class="tb-tnx-info">
                                                                                    <div class="tb-tnx-desc">
                                                                                        <span class="title">تكلفة الشحن</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="tb-tnx-amount is-alt">
                                                                                    <div class="tb-tnx-total">
                                                                                        <span class="amount" id="delivery-cost"><?= $_SESSION['order_details']['delivery_cost'] ?></span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="tb-tnx-action">
                                                                                </td>
                                                                            </tr>
                                                                            <!-- <tr class="tb-tnx-item">
                                                                                <td class="tb-tnx-info">
                                                                                    <div class="tb-tnx-desc">
                                                                                        <span class="title">كوبونات التخفيض</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="tb-tnx-amount is-alt">
                                                                                    <div class="tb-tnx-total">
                                                                                        <span class="amount">$0.00</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="tb-tnx-action">
                                                                                </td>
                                                                            </tr> -->
                                                                            <tr class="tb-tnx-item">
                                                                                <td class="tb-tnx-info">
                                                                                    <div class="tb-tnx-desc">
                                                                                        <span class="title">اجمالي الطلب</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="tb-tnx-amount is-alt">
                                                                                    <div class="tb-tnx-total">
                                                                                        <span class="amount" id="total-price"><?= $_SESSION['order_details']['total_price'] ?></span>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="tb-tnx-action">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div><!-- .card-preview -->
                                                            </div><!-- nk-block -->
                                                        </div>
                                                        <div class="col-12 mt-4">
                                                            <div class="nk-block nk-block-lg">
                                                                <div class="nk-block-head">
                                                                    <div class="nk-block-head-content">
                                                                        <h4 class="nk-block-title">سجل الطلب</h4>
                                                                    </div>
                                                                </div>
                                                                <div class="card card-bordered card-preview">
                                                                <?php
                                                                    foreach ($_SESSION['order_statues'] as $statuses)
                                                                    {
                                                                        echo $statuses['name'] . '<br>';
                                                                    }
                                                                ?>
                                                                </div><!-- .card-preview -->
                                                            </div><!-- nk-block -->
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group g-3 text-center d-block">
                                                                <input type="submit" name="addOrder" id="editOrderSubmit" class="btn btn-lg btn-primary" value="تعديل الطلب">
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
    }
}
?>

<script src="./assets/js/editOrder.js"></script>