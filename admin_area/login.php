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
    <title>تسجيل الدخول</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="assets/css/dashlite.rtl.css?ver=2.4.0">
    <link id="skin-default" rel="stylesheet" href="assets/css/theme.css?ver=2.4.0">
</head>

<body class="nk-body ui-rounder npc-default pg-auth has-rtl" dir="rtl">

    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <?php
                            session_start();
                            if (isset($_SESSION['error']) && !empty($_SESSION['error']))
                            {
                                ?>
                                <div class="alert alert-danger alert-icon alert-dismissible">
                                    <?= $_SESSION['error'] ?>
                                    <button class="close" data-dismiss="alert"></button> 
                                </div>
                                <?php
                                unset($_SESSION['error']);
                            }
                        ?>
                        <div class="brand-logo pb-4 text-center">
                            <a href="html/index.html" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="images/logo.png" srcset="./images/logo2x.png 2x" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="./images/logo-dark.png" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                            </a>
                        </div>
                        <div class="card card-bordered">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">تسجيل الدخول</h4>
                                    </div>
                                </div>
                                <form  action="controller/auth/login.php" method="POST">
                                    <div class="form-group mt-2">
                                        <div class="form-label-group">
                                            <label class="form-label" for="login-email">الايميل</label>
                                        </div>
                                        <input type="email" name="email" class="form-control form-control-lg" id="login-email" placeholder="ادخل ايميلك">
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">كلمة السر</label>
                                            <a class="link link-primary link-sm" href="#">نسيت كلمة السر؟</a>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="login-password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" name="password" class="form-control form-control-lg" id="login-password" placeholder="ادخل كلمة السر">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="login" class="btn btn-lg btn-primary btn-block" value="تسجيل الدخول">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="assets/js/bundle.js?ver=2.4.0"></script>
    <script src="assets/js/scripts.js?ver=2.4.0"></script>

</body>

</html>