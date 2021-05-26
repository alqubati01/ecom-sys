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
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="./images/favicon.png">
    <!-- Page Title  -->
    <title>المنتجات</title>
    <!-- StyleSheets  -->
    <link id="skin-default" rel="stylesheet" href="assets/css/theme.css?ver=2.4.0">
    <link rel="stylesheet" href="assets/css/dashlite.rtl.css?ver=2.4.0">
    <link rel="stylesheet" href="assets/css/editors/quill.rtl.css?ver=2.4.0">
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
                                <div class="alert alert-danger alert-icon alert-dismissible alertHide">
                                    <?= $_SESSION['error'] ?>
                                    <button class="close" data-dismiss="alert"></button>
                                </div> 
                                <?php
                                unset($_SESSION['error']);
                            }
                            elseif (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
                                ?>
                                <div class="alert alert-success alert-icon alert-dismissible mb-2 alertHide">
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
                                            <h3 class="nk-block-title page-title">قائمة المنتجات</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>عدد المنتجات على المنصة</p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                                                <div class="toggle-expand-content" data-content="pageMenu">
                                                    <ul class="nk-block-tools g-3">
                                                        <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>استخراج</span></a></li>
                                                        <li class="nk-block-tools-opt">
                                                            <div class="drodown">
                                                                <a href="#" class="dropdown-toggle btn btn-icon btn-primary" data-toggle="dropdown"><em class="icon ni ni-plus"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="#" data-toggle="modal" data-target="#add-product-modal"><span>اضافة منتج</span></a></li>
                                                                        <li><a href="#"><span>استيراد</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div><!-- .toggle-wrap -->
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-bordered card-stretch">
                                        <div class="card-inner-group">
                                            <div class="card-inner position-relative card-tools-toggle">
                                                <div class="card-title-group">
                                                    <div class="card-tools">
                                                        
                                                    </div><!-- .card-tools -->
                                                    <div class="card-tools mr-n1">
                                                        <ul class="btn-toolbar gx-1">
                                                            <li>
                                                                <a href="#" class="btn btn-icon search-toggle toggle-search" data-target="search"><em class="icon ni ni-search"></em></a>
                                                            </li><!-- li -->
                                                            <li class="btn-toolbar-sep"></li><!-- li -->
                                                            <li>
                                                                <div class="toggle-wrap">
                                                                    <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-menu-right"></em></a>
                                                                    <div class="toggle-content" data-content="cardTools">
                                                                        <ul class="btn-toolbar gx-1">
                                                                            <li class="toggle-close">
                                                                                <a href="#" class="btn btn-icon btn-trigger toggle" data-target="cardTools"><em class="icon ni ni-arrow-left"></em></a>
                                                                            </li><!-- li -->
                                                                            <li>
                                                                                <div class="dropdown">
                                                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                                                        <em class="icon ni ni-filter-alt"></em>
                                                                                    </a>
                                                                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                                                        <div class="dropdown-head">
                                                                                            <span class="sub-title dropdown-title">Filter Users</span>
                                                                                            <div class="dropdown">
                                                                                                <a href="#" class="btn btn-sm btn-icon">
                                                                                                    <em class="icon ni ni-more-h"></em>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="dropdown-body dropdown-body-rg">
                                                                                            <div class="row gx-6 gy-3">
                                                                                                <div class="col-6">
                                                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                                                        <input type="checkbox" class="custom-control-input" id="hasBalance">
                                                                                                        <label class="custom-control-label" for="hasBalance"> Have Balance</label>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-6">
                                                                                                    <div class="custom-control custom-control-sm custom-checkbox">
                                                                                                        <input type="checkbox" class="custom-control-input" id="hasKYC">
                                                                                                        <label class="custom-control-label" for="hasKYC"> KYC Verified</label>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-6">
                                                                                                    <div class="form-group">
                                                                                                        <label class="overline-title overline-title-alt">Role</label>
                                                                                                        <select class="form-select form-select-sm">
                                                                                                            <option value="any">Any Role</option>
                                                                                                            <option value="investor">Investor</option>
                                                                                                            <option value="seller">Seller</option>
                                                                                                            <option value="buyer">Buyer</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="col-6">
                                                                                                    <div class="form-group">
                                                                                                        <label class="overline-title overline-title-alt">Status</label>
                                                                                                        <select class="form-select form-select-sm">
                                                                                                            <option value="any">Any Status</option>
                                                                                                            <option value="active">Active</option>
                                                                                                            <option value="pending">Pending</option>
                                                                                                            <option value="suspend">Suspend</option>
                                                                                                            <option value="deleted">Deleted</option>
                                                                                                        </select>
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
                                                                                            <a href="#">Save Filter</a>
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
                                                                                            <li><span>عرض</span></li>
                                                                                            <li class="active"><a href="#">10</a></li>
                                                                                            <li><a href="#">20</a></li>
                                                                                            <li><a href="#">50</a></li>
                                                                                        </ul>
                                                                                        <ul class="link-check">
                                                                                            <li><span>ترتيب حسب</span></li>
                                                                                            <li class="active"><a href="#">تنازلي</a></li>
                                                                                            <li><a href="#">تصاعدي</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                </div><!-- .dropdown -->
                                                                            </li><!-- li -->
                                                                        </ul><!-- .btn-toolbar -->
                                                                    </div><!-- .toggle-content -->
                                                                </div><!-- .toggle-wrap -->
                                                            </li><!-- li -->
                                                        </ul><!-- .btn-toolbar -->
                                                    </div><!-- .card-tools -->
                                                </div><!-- .card-title-group -->
                                                <div class="card-search search-wrap" data-search="search">
                                                    <div class="card-body">
                                                        <div class="search-content">
                                                            <a href="#" class="search-back btn btn-icon toggle-search" data-target="search"><em class="icon ni ni-arrow-left"></em></a>
                                                            <input type="text" id="search" autocomplete="off" class="form-control border-transparent form-focus-none" placeholder="البحث عن منتج">
                                                            <button class="search-submit btn btn-icon"><em class="icon ni ni-search"></em></button>
                                                        </div>
                                                    </div>
                                                </div><!-- .card-search -->
                                            </div><!-- .card-inner -->
                                            <div class="card-inner p-0">
                                                <!-- <table class="nk-tb-list nk-tb-ulist" data-auto-responsive="false"> -->
                                                <table class="nk-tb-list nk-tb-ulist" id="product-items">
                                                    <!-- <thead>
                                                        <tr class="nk-tb-item nk-tb-head">
                                                            <th class="nk-tb-col nk-tb-col-check">
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input" id="uid">
                                                                    <label class="custom-control-label" for="uid"></label>
                                                                </div>
                                                            </th>
                                                            <th class="nk-tb-col tb-col-sm"><span>اسم المنتج</span></th>
                                                            <th class="nk-tb-col"><span>رمز التخزين</span></th>
                                                            <th class="nk-tb-col"><span>السعر</span></th>
                                                            <th class="nk-tb-col"><span>الكمية</span></th>
                                                            <th class="nk-tb-col tb-col-md"><span>التصنيف</span></th>
                                                            <th class="nk-tb-col tb-col-md"><span>الماركة</span></th>
                                                            <th class="nk-tb-col tb-col-md"><span>الحالة</span></th>
                                                            <th class="nk-tb-col nk-tb-col-tools text-right">
                                                                <div class="dropdown">
                                                                    <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-plus"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                                                                        <ul class="link-tidy sm no-bdr">
                                                                            <li>
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" checked="" id="bl">
                                                                                    <label class="custom-control-label" for="bl">Balance</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" checked="" id="ph">
                                                                                    <label class="custom-control-label" for="ph">Phone</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="vri">
                                                                                    <label class="custom-control-label" for="vri">Verified</label>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input" id="st">
                                                                                    <label class="custom-control-label" for="st">Status</label>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead> -->
                                                    
                                                        
                                                    
                                                    <!-- .nk-tb-list -->
                                                </table>
                                            </div>
                                            <!-- <div class="card-inner">
                                                <div class="nk-block-between-md g-3 text-center d-block">
                                                    <div class="g">
                                                        <button class="btn btn-primary">عرض المزيد من المنتجات</button>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
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
        require_once './include/connection.php';
        $getCategories = $pdo->prepare('SELECT id, slug FROM categories');
        $getCategories->execute();
    ?>
    <!-- @@ Add Product Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="add-product-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">اضافة منتج جديد</h5>
                    <div class="tab-content">
                        <div class="tab">
                            <form id="addProduct">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="product-name">اسم المنتج 
                                                <span class="text-danger">*</span>
                                            </label>
                                            
                                            <input type="text" name="product_name" class="form-control form-control-lg"
                                                id="product-name" value="" placeholder="ادخل اسم المنتج">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="product-status">حالة المنتج
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="product-status" name="isActive">
                                                        <option value="1">نشط</option>
                                                        <option value="0">موقوف</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="price">تكلفة المنتج
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" name="price" class="form-control form-control-lg"
                                                id="price" value="" placeholder="ادخل سعر تكلفة المنتج">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="selling_price">السعر
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" name="selling_price" class="form-control form-control-lg"
                                                id="selling-name" value="" placeholder="ادخل سعر بيع المنتج">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="sku">رمز التخزين</label>
                                            <input type="text" name="sku" class="form-control form-control-lg"
                                                id="sku" value="" placeholder="رمز التخزين">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="category-name">تصنيف المنتج</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="product-category-name" name="category_id">
                                                        <option value="0">من دون تصنيف</option>
                                                    <?php
                                                        foreach ($getCategories->fetchAll() as $category)
                                                        {
                                                            ?>
                                                                <option value="<?= $category['id']?>"><?= $category['slug']?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- d-flex align-items-center -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="special_price">الكمية
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" name="qty" id="qty" class="form-control form-control-lg"
                                                value="" placeholder="ادخل الكمية">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-n1 mt-md-5">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="stock_manage" id="stock-manage">
                                            <label class="custom-control-label" for="stock-manage">غير محدودة</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="submit" name="createProduct" id="add-product" class="btn btn-lg btn-primary" value="اضافة">
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
    <!-- @@ Edit Product Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-product-modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-md">
                    <h4 class="title">تعديل بيانات المنتج</h4>
                    <ul class="nk-nav nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabItem1">البيانات الاساسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabItem2">التصنيف و الماركة</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabItem3">SEO</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem1">
                            <form id="editProductBasic">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-pname">اسم المنتج</label>
                                            <input type="text" name="product_name" class="form-control form-control-lg"
                                                id="edit-pname" placeholder="ادخل اسم المنتج">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-sku">رمز التخزين</label>
                                            <input type="text" name="sku" class="form-control form-control-lg"
                                                id="edit-sku" placeholder="رمز التخزين">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-pdescription">وصف المنتج</label>
                                            <input name="product_desc" id="product-desc" type="hidden">
                                            <div id="quill-editor"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-price">سعر التكلفة</label>
                                            <input type="number" name="price" class="form-control form-control-lg"
                                                id="edit-price" placeholder="ادخل سعر تكلفة المنتج">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-sellingPrice">سعر البيع</label>
                                            <input type="number" name="selling_price" class="form-control form-control-lg"
                                                id="edit-sellingPrice" placeholder="ادخل سعر بيع المنتج">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-specialPrice">سعر مخفض</label>
                                            <input type="number" name="special_price" class="form-control form-control-lg"
                                                id="edit-specialPrice" placeholder="ادخل سعر بيع المنتج المخفض">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">تاريخ انتهاء التخفيض</label>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-left">
                                                    <em class="icon ni ni-calendar"></em>
                                                </div>
                                                <input type="text" class="form-control date-picker" name="special_price_end" id="edit-specialPriceEnd" data-date-format="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-qty">الكمية</label>
                                            <input type="number" name="qty" class="form-control form-control-lg"
                                                id="edit-qty" placeholder="ادخل الكمية">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-n1 mt-md-5">
                                        <div class="custom-control custom-control-sm custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="stock_manage" id="edit-stockManage">
                                            <label class="custom-control-label" for="edit-stockManage">غير محدودة</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="hidden" name="id" id="product-id-basic">
                                                <input type="submit" name="editProductBasic" id="edit-product" class="btn btn-lg btn-primary" value="حفظ التعديلات">
                                            </li>
                                            <li>
                                                <a href="#" data-dismiss="modal" class="link link-light">الغاء</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tabItem2">
                            <form id="editProductMore">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-cateName">تصنيف المنتج</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="edit-cateName" name="category_id">
                                                        <option value="0">من دون تصنيف</option>
                                                        <?php
                                                            $getCategories = $pdo->prepare('SELECT id, slug FROM categories');
                                                            $getCategories->execute();
                                                            foreach ($getCategories->fetchAll() as $category)
                                                            {
                                                                ?>
                                                                    <option value="<?= $category['id']?>"><?= $category['slug']?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-brandName">ماركة المنتج</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="edit-brandName" name="brand_id">
                                                        <option value="NULL">من دون ماركة</option>
                                                        <?php
                                                            $getBrands = $pdo->prepare('SELECT id, slug FROM brands');
                                                            $getBrands->execute();  
                                                            foreach ($getBrands->fetchAll() as $brand)
                                                            {
                                                                ?>
                                                                    <option value="<?= $brand['id']?>"><?= $brand['slug']?></option>
                                                                <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="hidden" name="id" id="product-id-more">
                                                <input type="submit" name="editProductMore" class="btn btn-lg btn-primary" value="حفظ التعديلات">
                                            </li>
                                            <li>
                                                <a href="#" data-dismiss="modal" class="link link-light">الغاء</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tabItem3">
                            <form id="editProductSEO">
                                <div class="row gy-4">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-metaTitle">عنوان Meta</label>
                                            <input type="text" name="meta_title" class="form-control form-control-lg"
                                                id="edit-metaTitle" placeholder="ادخل عنوان ال Meta Tag" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-metaDesc">وصف Meta</label>
                                            <input name="meta_desc" type="hidden" id="meta-desc">
                                            <div id="quill-editor2"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="hidden" name="id" id="product-id-seo">
                                                <input type="hidden" name="editProductSEO" value="seo">
                                                <input type="submit" name="editProductSEO" class="btn btn-lg btn-primary btn-editProductSEO" value="حفظ التعديلات">
                                            </li>
                                            <li>
                                                <a href="#" data-dismiss="modal" class="link link-light">الغاء</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .modal -->

    <?php
    require_once 'include/footer.php';
}
?>

<script src="./assets/js/libs/editors/quill.js?ver=2.4.0"></script>
<script src="./assets/js/editors.js?ver=2.4.0"></script>
<script src="./assets/js/products.js"></script>



