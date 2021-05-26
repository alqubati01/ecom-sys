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
    <title>التصنيفات</title>
    <!-- StyleSheets  -->
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
    <link rel="stylesheet" href="./assets/css/dashlite.rtl.css?ver=2.4.0">
    <link rel="stylesheet" href="./assets/css/libs/jstree.css?ver=2.4.0">
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
                        } ?>
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">التصنيفات</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>عدد التصنيفات</p>
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
                                                                        <li><a href="#"  data-toggle="modal" data-target="#add-category-modal"><span>اضافة تصنيف</span></a></li>
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
                                    <div class="row g-gs">
                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
                                            <div class="tree">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="form-icon form-icon-left">
                                                            <em class="icon ni ni-search"></em>
                                                        </div>
                                                        <input type="search" id="jstree_menu_search" class="form-control" id="default-03" placeholder="البحث عن تصنيف">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <button id="btn_jstree_open" class="btn btn-dim btn-primary">فتح الشجرة</button>
                                                    <button id="btn_jstree_close" class="btn btn-dim btn-primary">طي الشجرة</button>
                                                    <button id="btn_jstree_toggle" class="btn btn-dim btn-primary" onclick="toggle();">تبديل</button>
                                                </div>
                                                <div id="jstree_menu"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-8 col-xxl-9">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <h5 class="card-title">تعديل تصنيف</h5>
                                                    </div>
                                                    <ul class="nav nav-tabs mt-n3">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" data-toggle="tab" href="#basic">اساسية</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" data-toggle="tab" href="#image">الصورة</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="basic">
                                                            <form action="./controller/categories/edit.php" method="POST" id="editCategory">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="default-06">اسم التصنيف</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="dialog" name="category_name" placeholder="اختر اسم التصنيف من الشجرة">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label" for="default-06">اضافة الى تصنيف رئيسي</label>
                                                                    <div class="form-control-wrap ">
                                                                        <div class="form-control-select">
                                                                            <select class="form-control" id="nan" name="parent_category">
                                                                                <option value="NULL">صنف رئيسي</option>
                                                                                <?php
                                                                                    foreach ($_SESSION['categories'] as $category)
                                                                                    {
                                                                                        ?>
                                                                                        <option value="<?= $category['id']?>"><?= $category['text']?></option>
                                                                                        <?php
                                                                                    }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label" for="default-06">حالة التصنيف</label>
                                                                    <div class="form-control-wrap ">
                                                                        <div class="form-control-select">
                                                                            <select class="form-control" id="nan1" name="isActive">
                                                                                    <option value="1">ظاهر</option>
                                                                                    <option value="0">مخفي</option>  
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <div class="d-flex">
                                                                <div class="form-group mr-3">
                                                                        <input type="hidden" id="edit-category-id" name="id" >
                                                                        <input type="submit" name="editCategory" class="btn btn-primary" value="حفظ التعديلات">
                                                                    </div>
                                                                </form>
                                                                <form action="./controller/categories/delete.php" method="POST">
                                                                    <div class="form-group">
                                                                        <input type="hidden" id="delete-category-id" name="id">
                                                                        <input type="submit" name="deleteCategory" class="btn btn-danger" value="حذف التصنيف">
                                                                    </div>
                                                                </form>
                                                            </div>                       
                                                        </div>
                                                        <div class="tab-pane" id="image">
                                                            <form action="./controller/categories/addCategoryImages.php" method="POST"  enctype="multipart/form-data" id="addImageCategory">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="default-06">اسم التصنيف</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="dialog2" name="category_name" placeholder="اختر اسم التصنيف من الشجرة" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row gy-4">
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">
                                                                                <div class="form-control-wrap">
                                                                                    <div class="custom-file">
                                                                                        <input type="file" name="category_image" class="custom-file-input" id="image">
                                                                                        <label class="custom-file-label" for="customFile">اختر صورة</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <input type="hidden" name="id" id="addImage-category-id">
                                                                                <input type="submit" name="addImage" class="btn btn-primary" value="اضافة">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div id="image-category"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
    <!-- @@ Add Category Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="add-category-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">اضافة تصنيف جديد</h5>
                    <div class="tab-content">
                        <div class="tab">
                            <form  action="./controller/categories/create.php" method="POST" id="addCategory">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="category-name">اسم التصنيف</label>
                                            <input type="text" name="category_name" class="form-control form-block form-control-lg" id="category-name" value="" placeholder="ادخل اسم التصنيف">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="submit" name="createCategory" class="btn btn-lg btn-primary" value="اضافة">
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

<script src="./assets/js/libs/jstree.js?ver=2.4.0"></script>
<script src="./assets/js/categories.js"></script>



