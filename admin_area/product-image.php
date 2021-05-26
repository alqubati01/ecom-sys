<?php
session_start();
require_once 'include/connection.php';

if (!isset($_SESSION['admin_login']) && $_SESSION['admin_login'] !== true)
{
    header('refresh:0;url=login.php');
}
else
{ 
    if (array_key_exists('productImage', $_SESSION)) 
    {
        $p_id = $_SESSION['product_id'];
        $product_name = $_SESSION['pname'];
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
    <title>المنتجات المتعلقة</title>
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
                        <div class="nk-content-inner pt-1">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title"><?= $product_name?> الصور الخاصة بالمنتج</h3>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block pt-2">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <h5 class="card-title">اختر صورة اساسية لمنتجك</h5>
                                                    </div>
                                                    <div class="py-2">
                                                        <form action="./controller/products/addProductImages.php" method="POST" enctype="multipart/form-data" id="validateBaseImage">
                                                            <div class="row gy-4">
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <div class="custom-file">
                                                                                <input type="file" name="base_image" class="custom-file-input" id="base-image">
                                                                                <label class="custom-file-label" for="customFile">اختر صورة</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="id" value="<?= $p_id ?>">
                                                                        <input type="submit" name="addBaseImage" class="btn btn-primary" value="اضافة">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <?php
                                                        if (count($_SESSION['productImage']) > 0 && $_SESSION['productImage'] !== false) 
                                                        {
                                                            foreach ($_SESSION['productImage'] as $baseImage)
                                                            {
                                                                if ($baseImage['zone'] == 'baseImage')
                                                                {
                                                                    ?>
                                                                    <div class="row align-items-end">
                                                                        <div class="col-md-9 pt-2">
                                                                            <img src="<?= $baseImage['path']?>" class="w-80"> 
                                                                        </div>
                                                                        <div class="col-md-3 pb-2">
                                                                            <form action="./controller/products/deleteProductImages.php" method="POST">
                                                                                <input type="hidden" name="id" value="<?= $baseImage['file_id']?>"> 
                                                                                <input type="submit" name="deleteBaseImage" class="btn btn-danger" value="حذف"> 
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        else 
                                                        {
                                                            echo 'there is no base image..';
                                                        }  
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="card card-bordered h-100">
                                                <div class="card-inner">
                                                    <div class="card-head">
                                                        <h5 class="card-title">اختر صور فرعية لمنتجك</h5>
                                                    </div>
                                                    <div class="py-2">
                                                        <form action="./controller/products/addProductImages.php" method="POST" enctype="multipart/form-data" id="validateAddtionalImage">
                                                            <div class="row gy-4">
                                                                <div class="col-md-8">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <div class="custom-file">
                                                                                <label class="custom-file-label" for="customFile">اختر صورة</label>
                                                                                <input type="file" name="additional_image" class="custom-file-input" id="additional-image">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" value="<?= $p_id ?>">
                                                                    <input type="submit" name="addAdditionalImage" class="btn btn-primary" value="اضافة">
                                                                </div>
                                                            </div>
                                                            
                                                        </form>
                                                    </div>
                                                    <?php
                                                        if (count($_SESSION['productImage']) > 0 && $_SESSION['productImage'] !== false) 
                                                        {
                                                            foreach ($_SESSION['productImage'] as $additionalImage)
                                                            {
                                                                if ($additionalImage['zone'] == 'additionalImage')
                                                                {
                                                                    ?>
                                                                    <div class="row align-items-end">
                                                                        <div class="col-md-9 pt-2">
                                                                            <img src="<?= $additionalImage['path']?>" class="w-80"> 
                                                                        </div>
                                                                        <div class="col-md-3 pb-2">
                                                                            <form action="./controller/products/deleteProductImages.php" method="POST">
                                                                                <input type="hidden" name="id" value="<?= $additionalImage['file_id']?>"> 
                                                                                <input type="submit" name="deleteAdditionalImage" class="btn btn-danger" value="حذف"> 
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        else 
                                                        {
                                                            echo 'there is no additional image..';
                                                        }  
                                                    ?>
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
    <!-- app-root @e -->
    <?php
        require_once './include/footer.php';
    }
}
?>

<script>
$(document).ready(function(){
    $('#validateBaseImage').validate({
        rules: {
            base_image: "required"
        },
        messages: {
            base_image: "اختر صورة اولا",
        }
    });

    $('#validateAddtionalImage').validate({
        rules: {
            additional_image: "required"
        },
        messages: {
            additional_image: "اختر صورة اولا",
        }
    });
})
</script>

