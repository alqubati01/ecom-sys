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
    <title>الطلبات</title>
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
                                            <h3 class="nk-block-title page-title">الطلبات</h3>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <a href="#" class="btn btn-icon btn-primary d-md-none"><em class="icon ni ni-plus"></em></a>
                                            <a href="addOrder.php" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>اضافة طلب عميل</span></a>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-stretch">
                                        <div class="card-inner-group">
                                            <div class="card-inner">
                                                <div class="card-title-group">
                                                    <div class="card-title">
                                                        <h5 class="title">كل الطلبات</h5>
                                                    </div>
                                                    <div class="card-tools mr-n1">
                                                        <ul class="btn-toolbar gx-1">
                                                            <li>
                                                                <a href="#" class="search-toggle toggle-search btn btn-icon" data-target="search"><em class="icon ni ni-search"></em></a>
                                                            </li><!-- li -->
                                                            <li class="btn-toolbar-sep"></li><!-- li -->
                                                            <li>
                                                                <div class="dropdown">
                                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                        <div class="badge badge-circle badge-primary">4</div>
                                                                        <em class="icon ni ni-filter-alt"></em>
                                                                    </a>
                                                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                                        <div class="dropdown-head">
                                                                            <span class="sub-title dropdown-title">Advance Filter</span>
                                                                            <div class="dropdown">
                                                                                <a href="#" class="link link-light">
                                                                                    <em class="icon ni ni-more-h"></em>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown-body dropdown-body-rg">
                                                                            <div class="row gx-6 gy-4">
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="overline-title overline-title-alt">Type</label>
                                                                                        <select class="form-select form-select-sm">
                                                                                            <option value="any">Any Type</option>
                                                                                            <option value="deposit">Deposit</option>
                                                                                            <option value="buy">Buy Coin</option>
                                                                                            <option value="sell">Sell Coin</option>
                                                                                            <option value="transfer">Transfer</option>
                                                                                            <option value="withdraw">Withdraw</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="overline-title overline-title-alt">Status</label>
                                                                                        <select class="form-select form-select-sm">
                                                                                            <option value="any">Any Status</option>
                                                                                            <option value="pending">Pending</option>
                                                                                            <option value="cancel">Cancel</option>
                                                                                            <option value="process">Process</option>
                                                                                            <option value="completed">Completed</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="overline-title overline-title-alt">Pay Currency</label>
                                                                                        <select class="form-select form-select-sm">
                                                                                            <option value="any">Any Coin</option>
                                                                                            <option value="bitcoin">Bitcoin</option>
                                                                                            <option value="ethereum">Ethereum</option>
                                                                                            <option value="litecoin">Litecoin</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <label class="overline-title overline-title-alt">Method</label>
                                                                                        <select class="form-select form-select-sm">
                                                                                            <option value="any">Any Method</option>
                                                                                            <option value="paypal">PayPal</option>
                                                                                            <option value="bank">Bank</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div class="form-group">
                                                                                        <div class="custom-control custom-control-sm custom-checkbox">
                                                                                            <input type="checkbox" class="custom-control-input" id="includeDel">
                                                                                            <label class="custom-control-label" for="includeDel"> Including Deleted</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <button type="button" class="btn btn-secondary">Filter</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="dropdown-foot between">
                                                                            <a class="clickable" href="#">Reset Filter</a>
                                                                            <a href="#savedFilter" data-toggle="modal">Save Filter</a>
                                                                        </div>
                                                                    </div><!-- .filter-wg -->
                                                                </div><!-- .dropdown -->
                                                            </li><!-- li -->
                                                            <li>
                                                                <div class="dropdown">
                                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                        <em class="icon ni ni-setting"></em>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                        <ul class="link-check">
                                                                            <li><span>Show</span></li>
                                                                            <li class="active"><a href="#">10</a></li>
                                                                            <li><a href="#">20</a></li>
                                                                            <li><a href="#">50</a></li>
                                                                        </ul>
                                                                        <ul class="link-check">
                                                                            <li><span>Order</span></li>
                                                                            <li class="active"><a href="#">DESC</a></li>
                                                                            <li><a href="#">ASC</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div><!-- .dropdown -->
                                                            </li><!-- li -->
                                                        </ul><!-- .btn-toolbar -->
                                                    </div><!-- .card-tools -->
                                                    <div class="card-search search-wrap" data-search="search">
                                                        <div class="search-content">
                                                            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                                            <input type="text" class="form-control border-transparent form-focus-none" placeholder="Quick search by transaction">
                                                            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                                        </div>
                                                    </div><!-- .card-search -->
                                                </div><!-- .card-title-group -->
                                            </div><!-- .card-inner -->
                                            <div class="card-inner p-0">
                                                <table class="nk-tb-list nk-tb-tnx" id="order-items">
                                                    
                                                    
                                                </table><!-- .nk-tb-list -->
                                            </div><!-- .card-inner -->
                                            <!-- <div class="card-inner">
                                                <div class="nk-block-between-md g-3 text-center d-block">
                                                    <div class="g">
                                                        <button class="btn btn-primary">عرض المزيد من المنتجات</button>
                                                    </div>
                                                </div>
                                            </div> -->
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

    <!-- @@ Image Edit Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-orderStatus-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">تحديث حاله الطلب</h5>
                    <div class="tab-content">
                        <div class="tab">
                            <form id="editOrderStatus">
                                <div class="row gy-4">
                                    <div class="col-md-8">
                                        <div class="form-control-wrap">
                                            <select class="form-select form-control form-control-lg" data-search="on" name="status_id" id="edit-order-status">
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
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="hidden" name="id" id="edit-orderStatus">
                                                <input type="submit" name="editOrderStatus" class="btn btn-lg btn-primary" value="تحديث">
                                            </li>
                                            <li>
                                                <a href="#" data-dismiss="modal" class="link link-light">الغاء</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div><!-- .tab -->
                    </div><!-- .tab-content -->
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div><!-- .modal -->
    <?php
    require_once 'include/footer.php';
}
?>

<script src="./assets/js/orders.js"></script>