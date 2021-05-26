<?php
session_start();
require_once 'include/connection.php';

if (!isset($_SESSION['admin_login']) && $_SESSION['admin_login'] !== true)
{
    header('refresh:0;url=login.php');
}
else
{    
    // if (array_key_exists('brands', $_SESSION)) 
    // {
    //     if (count($_SESSION['brands']) > 0 && $_SESSION['brands'] !== false) 
    //     {   
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
    <title>البراندات</title>
    <!-- StyleSheets  -->
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
    <link rel="stylesheet" href="./assets/css/dashlite.rtl.css?ver=2.4.0">
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
                            } elseif (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
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
                                            <h3 class="nk-block-title page-title">البراندات</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>عدد البراندات</p>
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
                                                                        <li><a href="#"  data-toggle="modal" data-target="#add-brand-modal"><span>اضافة براند</span></a></li>
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
                                    <div class="row g-gs" id="brand-items">
                                    
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
    <!-- @@ Add Brand Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="add-brand-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">اضافة علامة تجارية جديدة</h5>
                    <div class="tab-content">
                        <div class="tab">
                            <form id="addBrand">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="brand-name">اسم العلامة</label>
                                            <input type="text" name="brand_name" class="form-control form-control-lg" id="brand-name" value="" placeholder="ادخل اسم العلامة التجارية" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="submit" name="createBrand" class="btn btn-lg btn-primary" value="اضافة">
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
    <!-- @@ Edit Brand Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="edit-brand-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">تعديل العلامة التجارية </h5>
                    <div class="tab-content">
                        <div class="tab">
                            <form id="editBrand">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="edit-brand-name">اسم العلامة</label>
                                            <input type="text" name="brand_name" class="form-control form-control-lg" id="edit-brand-name" value="" placeholder="ادخل اسم العلامة التجارية" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="hidden" name="id" id="brand-id">
                                                <input type="submit" name="editBrand" class="btn btn-lg btn-primary" value="تحديث">
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
    <!-- app-root @e -->
    <!-- @@ Add IMAGE Brand Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="image-brand-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">اضافة صورة للعلامة التجارية</h5>
                    <div class="tab-content">
                        <div class="tab">
                            <form id="addImageBrand">
                                <div class="row gy-4">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" name="brand_image" class="custom-file-input" id="brand-image">
                                                    <label class="custom-file-label" for="customFile">اختر صورة</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="hidden" name="id" id="imageBrand-id">
                                            <input type="submit" name="addBrandImage" class="btn btn-primary" value="اضافة">
                                        </div>
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
    //     }
    // }
}
?>


<script src="./assets/js/brands.js"></script>