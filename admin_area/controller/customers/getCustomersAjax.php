<?php

require_once '../../include/connection.php';
session_start();

$stmt = $pdo->prepare('SELECT u.id, u.first_name, u.last_name, u.username, u.email, u.address, c.name AS city_name, a.name AS area_name, u.phone, u.last_login, u.is_active, u.image, r.name 
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
$stmt->execute();
?>
<div class="nk-tb-item nk-tb-head">
    <div class="nk-tb-col nk-tb-col-check">
        <div class="custom-control custom-control-sm custom-checkbox notext">
            <input type="checkbox" class="custom-control-input" id="uid">
            <label class="custom-control-label" for="uid"></label>
        </div>
    </div>
    <div class="nk-tb-col"><span class="sub-text">العميل</span></div>
    <div class="nk-tb-col tb-col-sm"><span class="sub-text">اسم المستخدم</span></div>
    <div class="nk-tb-col tb-col-sm"><span class="sub-text">ايميل العميل</span></div>
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
    foreach ($stmt->fetchAll() as $customer) {
        ?>
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
                        <img src="<?= $customer['image']?>" alt="">
                    </div>
                    <div class="user-name">
                        <span id="fullName<?= $customer['id'] ?>" class="tb-lead"><?= $customer['first_name'] . ' ' . $customer['last_name'] ?></span>
                    </div>
                </div>
            </div>
            <div class="nk-tb-col tb-col-sm">
                <span id="username<?= $customer['id'] ?>"><?= $customer['username'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-sm">
                <span id="email<?= $customer['id'] ?>"><?= $customer['email'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-md">
                <span id="phone<?= $customer['id'] ?>"><?= $customer['phone'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-lg">
                <span id="address<?= $customer['id'] ?>"  class="hideShowAddr"><?= $customer['address'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-lg">
                <span id="address<?= $customer['id'] ?>" class="hideShowCity"><?= $customer['city_name'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-lg">
                <span id="address<?= $customer['id'] ?>" class="hideShowArea"><?= $customer['area_name'] ?></span>
            </div>
            <div class="nk-tb-col tb-col-lg">
                <span class="hideShowLLogin"><?= $customer['last_login'] ?></span>
            </div>
            <div class="nk-tb-col">
                <?php
                if ($customer['is_active'] === 1) {
                    ?>
                    <span id="active<?= $customer['id'] ?>" class="tb-status text-success hideShowStatus">تنشيط</span>
                    <?php
                } else {
                    ?>
                    <span id="stop<?= $customer['id'] ?>" class="tb-status text-danger hideShowStatus">موقوف</span>
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
                                            <button type="button" class="btn btn-link p-0 text-decoration-none edit" value="<?= $customer['id']?>">عرض التفاصيل</button>
                                        </span>
                                    </li>
                                    <li>
                                    <?php
                                    if ($customer['is_active'] === 1) {
                                        ?>
                                        <span class="span-form text-danger">
                                            <em class="icon ni ni-na"></em>
                                            <button class="stopCustomer btn btn-link p-0 text-danger text-decoration-none" data-stop_customer_id="<?= $customer['id']?>">ايقاف العميل</button>
                                        </span>
                                        <?php
                                    } else {
                                        ?>
                                        <span class="span-form text-success">
                                            <em class="icon ni ni-na"></em>
                                            <button class="activeCustomer btn btn-link p-0 text-success text-decoration-none" data-active_customer_id="<?= $customer['id']?>">تنشيط العميل</button>
                                        </span>
                                        <?php
                                    } ?>
                                    </li>
                                    <li>
                                        <span class="span-form text-danger">
                                            <em class="icon ni ni-trash-fill"></em>
                                            <button class="deleteCustomer btn btn-link p-0 text-danger text-decoration-none" data-delete_customer_id="<?= $customer['id']?>">حذف العميل</button>
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
    echo 'No Customers Yet.';
}



