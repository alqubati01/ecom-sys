<?php

require_once '../../include/connection.php';
session_start();

$stmt = $pdo->prepare('SELECT u.id, u.first_name, u.last_name, u.username, u.email, u.address, c.name AS city_name, a.name AS area_name, u.phone, u.last_login, u.is_active, u.image, r.name AS role_name
                        FROM users u
                        JOIN user_roles ur
                            ON u.id = ur.user_id
                        JOIN roles r
                            ON r.id = ur.role_id
                        LEFT JOIN cities c
                            ON u.city_id = c.id
                        LEFT JOIN areas a
                            ON u.area_id = a.id
                        WHERE r.name != "customer"');
$stmt->execute();
?>

<div class="nk-tb-item nk-tb-head">
    <div class="nk-tb-col nk-tb-col-check">
        <div class="custom-control custom-control-sm custom-checkbox notext">
            <input type="checkbox" class="custom-control-input" id="uid">
            <label class="custom-control-label" for="uid"></label>
        </div>
    </div>
    <div class="nk-tb-col"><span class="sub-text">المستخدم</span></div>
    <div class="nk-tb-col tb-col-md"><span class="sub-text">الصلاحية</span></div>
    <div class="nk-tb-col tb-col-sm"><span class="sub-text">الايميل</span></div>
    <div class="nk-tb-col tb-col-md"><span class="sub-text">رقم الهاتف</span></div>
    <div class="nk-tb-col tb-col-lg"><span class="sub-text" id="hideShowAddr">العنوان</span></div>
    <div class="nk-tb-col tb-col-lg"><span class="sub-text" id="hideShowCity">المدينة</span></div>
    <div class="nk-tb-col tb-col-lg"><span class="sub-text" id="hideShowArea">المنطقة</span></div>
    <div class="nk-tb-col tb-col-lg"><span class="sub-text" id="hideShowLLogin">اخر تسجيل دخول</span></div>
    <div class="nk-tb-col"><span class="sub-text" id="hideShowStatus">الحالة</span></div>
    <div class="nk-tb-col nk-tb-col-tools text-right">
        <div class="dropdown">
            <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-plus"></em></a>
            <div class="dropdown-menu dropdown-menu-xs dropdown-menu-right">
                <ul class="link-tidy sm no-bdr">
                    <li>
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="address-col">
                            <label class="custom-control-label" for="address-col">العنوان</label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="city-col">
                            <label class="custom-control-label" for="city-col">المدينة</label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="area-col">
                            <label class="custom-control-label" for="area-col">المنطقة</label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="llogin-col">
                            <label class="custom-control-label" for="llogin-col">اخر تسجيل دخول</label>
                        </div>
                    </li>
                    <li>
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="status-col">
                            <label class="custom-control-label" for="status-col">الحالة</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div><!-- .nk-tb-item -->
<?php
if ($stmt->rowCount()) {
    foreach ($stmt->fetchAll() as $admin) {
        ?>
        <span class="d-none" id="username<?= $admin['id'] ?>"><?= $admin['username'] ?></span>
        <div class="nk-tb-item">
            <div class="nk-tb-col nk-tb-col-check">
                <div class="custom-control custom-control-sm custom-checkbox notext">
                    <input type="checkbox" class="custom-control-input" id="uid1">
                    <label class="custom-control-label" for="uid1"></label>
                </div>
            </div>
            <div class="nk-tb-col">
                <div class="user-card">
                    <div class="user-avatar xs bg-primary">
                        <img src="<?= $admin['image']?>" alt="">
                    </div>
                    <div class="user-name">
                        <span id="fullName<?= $admin['id'] ?>" class="tb-lead"><?= $admin['first_name'] . ' ' . $admin['last_name'] ?></span>
                    </div>
                </div>
            </div>
            <div class="nk-tb-col tb-col-md">
                <span id="role<?= $admin['id'] ?>"><?= $admin['role_name'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-sm">
                <span id="email<?= $admin['id'] ?>"><?= $admin['email'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-md">
                <span id="phone<?= $admin['id'] ?>"><?= $admin['phone'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-lg">
                <span id="address<?= $admin['id'] ?>"  class="hideShowAddr"><?= $admin['address'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-lg">
                <span id="city<?= $admin['id'] ?>" class="hideShowCity"><?= $admin['city_name'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-lg">
                <span id="area<?= $admin['id'] ?>" class="hideShowArea"><?= $admin['area_name'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-lg">
                <span class="hideShowLLogin"><?= $admin['last_login'] ?></span>
            </div>
            <div class="nk-tb-col">
                <?php
                if ($admin['is_active'] === 1) {
                    ?>
                    <span id="active<?= $admin['id'] ?>" class="tb-status text-success hideShowStatus">تنشيط</span>
                    <?php
                } else {
                    ?>
                    <span id="stop<?= $admin['id'] ?>" class="tb-status text-danger hideShowStatus">موقوف</span>
                    <?php
                } ?>
                
            </div>
            <div class="nk-tb-col nk-tb-col-tools">
                <ul class="nk-tb-actions gx-2">
                    <li>
                        <div class="drodown">
                            <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <span class="span-form">
                                            <em class="icon ni ni-eye"></em>
                                            <button type="button" class="btn btn-link p-0 text-decoration-none edit" value="<?= $admin['id']?>">عرض التفاصيل</button>
                                        </span>
                                    </li>
                                    <li>
                                    <?php
                                    if ($admin['is_active'] === 1) {
                                        ?>
                                        <span class="span-form text-danger">
                                            <em class="icon ni ni-na"></em>
                                            <button class="stopAdmin btn btn-link p-0 text-danger text-decoration-none" data-stop_admin_id="<?= $admin['id']?>">ايقاف المستخدم</button>
                                        </span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="span-form text-success">
                                            <em class="icon ni ni-na"></em>
                                            <button class="activeAdmin btn btn-link p-0 text-success text-decoration-none" data-active_admin_id="<?= $admin['id']?>">تنشيط المستخدم</button>
                                        </span>
                                        <?php
                                    } ?>
                                    </li>
                                    <li>
                                        <span class="span-form text-danger">
                                            <em class="icon ni ni-trash-fill"></em>
                                            <button class="deleteAdmin btn btn-link p-0 text-danger text-decoration-none" data-delete_admin_id="<?= $admin['id']?>">حذف الادمن</button>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }
}
else {
    echo 'No Admins Yet.';
}



