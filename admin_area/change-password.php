<?php
session_start();
require_once 'include/connection.php';

if (!isset($_SESSION['admin_login']) && $_SESSION['admin_login'] !== true)
{
    header('refresh:0;url=login.php');
}
else
{ 
    if (array_key_exists('admin', $_SESSION)) 
    {
        if (count($_SESSION['admin']) > 0 && $_SESSION['admin'] !== false) 
        {
            $fullName = $_SESSION['admin']['first_name'] . ' ' . $_SESSION['admin']['last_name'];
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
    <title>الملف الشخصي</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="./assets/css/dashlite.rtl.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="./assets/css/theme.css?ver=2.4.0">
</head>

<body class="nk-body ui-rounder npc-default has-sidebar has-rtl" dir="rtl">
    <div class="nk-app-root">
        <?php 
            require_once 'include/sidebar.php'; 
        ?>
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
                            if (isset($_SESSION['error']) && !empty($_SESSION['error']))
                            {
                                ?>
                                <div class="alert alert-danger alert-icon alert-dismissible alertHide">
                                    <?= $_SESSION['error'] ?>
                                    <button class="close" data-dismiss="alert"></button>
                                </div> 
                                <?php
                                unset($_SESSION['error']);
                            }
                            else if (isset($_SESSION['success']) && !empty($_SESSION['success']))
                            {
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
                                <div class="nk-block">
                                    <div class="card card-bordered">
                                        <div class="card-aside-wrap">
                                            <div class="card-inner card-inner-lg">
                                                <div class="nk-block-head nk-block-head-lg">
                                                    <div class="nk-block-between">
                                                        <div class="nk-block-head-content">
                                                            <h4 class="nk-block-title">معلومات شخصية</h4>
                                                        </div>
                                                        <div class="nk-block-head-content align-self-start d-lg-none">
                                                            <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                        </div>
                                                    </div>
                                                </div><!-- .nk-block-head -->
                                                <div class="nk-block">
                                                    <div class="nk-data data-list">
                                                        <div class="data-head mb-4">
                                                            <h6 class="overline-title">تغيير كلمة السر</h6>
                                                        </div>
                                                        <form  action="controller/auth/change-password.php" method="POST" id="checkChangePassword">
                                                            <div class="form-group mt-2">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="password">كلمة السر الحالية</label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                    </a>
                                                                    <input type="password" name="currentPassword" class="form-control form-control-lg" id="currentPassword" placeholder="ادخل كلمة السر الحالية">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="password">كلمة السر الجديدة</label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                    </a>
                                                                    <input type="password" name="newPassword" class="form-control form-control-lg" id="newPassword" placeholder="ادخل كلمة السر الجديدة">
                                                                </div>
                                                            </div>
                                                            <div class="form-group mt-2">
                                                                <div class="form-label-group">
                                                                    <label class="form-label" for="password">تأكيد كلمة السر</label>
                                                                </div>
                                                                <div class="form-control-wrap">
                                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                                    </a>
                                                                    <input type="password" name="confirmPassword" class="form-control form-control-lg" id="confirmPassword" placeholder="تأكيد كلمة السر">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="submit" name="changePassword" class="btn btn-lg btn-primary btn-block" value="تغيير كلمة السر">
                                                            </div>
                                                        </form>
                                                    </div><!-- data-list -->
                                                </div><!-- .nk-block -->
                                            </div>
                                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                                <div class="card-inner-group" data-simplebar>
                                                    <div class="card-inner">
                                                        <div class="user-card">
                                                            <div class="user-avatar bg-primary">
                                                            <?php
                                                                if($_SESSION['admin']['image'] != '')
                                                                {
                                                                    ?>
                                                                    <img src="<?= $_SESSION['admin']['image'] ?>" alt="">
                                                                    <?php
                                                                }
                                                                else {
                                                                    ?>
                                                                    <em class="icon ni ni-user-alt"></em>
                                                                    <?php
                                                                }
                                                            ?>
                                                            </div>
                                                            <div class="user-info">
                                                                <span class="lead-text"><?= $fullName ?></span>
                                                                <span class="sub-text"><?= $_SESSION['admin']['email'] ?></span>
                                                            </div>
                                                            <div class="user-action">
                                                                <div class="dropdown">
                                                                    <a class="btn btn-icon btn-trigger mr-n2" data-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <ul class="link-list-opt no-bdr">
                                                                            <li><a href="#"  data-toggle="modal" data-target="#image-edit"><em class="icon ni ni-camera-fill"></em><span>تغيير الصورة</span></a></li>
                                                                            <li><a href="#" data-toggle="modal" data-target="#profile-edit"><em class="icon ni ni-edit-fill"></em><span>تحديث الملف الشخصي</span></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- .user-card -->
                                                    </div><!-- .card-inner -->
                                                    <div class="card-inner p-0">
                                                        <ul class="link-list-menu">
                                                            <li><a href="admin-profile.php"><em class="icon ni ni-user-fill-c"></em><span>معلومات اساسية</span></a></li>
                                                            <li><a href="javascript:void(0)"><em class="icon ni ni-bell-fill"></em><span>الاشعارات</span></a></li>
                                                            <li><a href="javascript:void(0)"><em class="icon ni ni-activity-round-fill"></em><span>نشاط الحساب</span></a></li>
                                                            <li><a  class="active" href="change-password.php"><em class="icon ni ni-shield-star-fill"></em><span>تغيير كلمة السر</span></a></li>
                                                        </ul>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .card-inner-group -->
                                            </div><!-- card-aside -->
                                        </div><!-- .card-aside-wrap -->
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
    require_once './modal/edit-adminProfile.php';
    require_once './modal/edit-adminImage.php';
    require_once './include/footer.php';
        }
    }
}
?>

<script>
        $(function() {
            
            $('.alertHide').fadeOut(9000);
        });
    </script>