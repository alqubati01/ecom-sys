<?php

session_start();
require_once '../../include/connection.php';

$stmt = $pdo->prepare('SELECT 
                            o.id AS id, 
                            o.order_ref_number AS order_number, 
                            o.customer_id AS customer_id, 
                            o.order_date AS order_date, 
                            o.total_price AS total_price,
                            u.first_name AS first_name, u.last_name AS last_name,
                            o.status_id AS status_id, s.name AS status_name, 
                            o.shipper_id AS shipper_id, sh.name AS shipper_name,
                            o.payment_method AS payment_method, pm.name AS payment_method_name,
                            SUM(oi.qty) AS qtyProducts
                        FROM orders o
                        JOIN users u
                            ON o.customer_id = u.id
                        JOIN statuses s
                            ON o.status_id = s.id
                        JOIN shippers sh
                            ON o.shipper_id = sh.id
                        JOIN payment_methods pm
                            ON o.payment_method = pm.id
                        JOIN order_items oi
                            ON o.id = oi.order_id
                        GROUP BY o.id
                        ORDER BY o.id');
$stmt->execute();

?>
<div class="nk-tb-item nk-tb-head">
    <div class="nk-tb-col nk-tb-col-check">
        <div class="custom-control custom-control-sm custom-checkbox notext">
            <input type="checkbox" class="custom-control-input" id="uid">
            <label class="custom-control-label" for="uid"></label>
        </div>
    </div>
    <div class="nk-tb-col"><span>رقم الطلب</span></div>
    <div class="nk-tb-col tb-col-md"><span>التاريخ</span></div>
    <div class="nk-tb-col tb-col-sm"><span>العميل</span></div>
    <div class="nk-tb-col tb-col-md"><span>المشتريات</span></div>
    <div class="nk-tb-col"><span>الحالة</span></div>
    <div class="nk-tb-col"><span>الاجمالي</span></div>
    <div class="nk-tb-col nk-tb-col-tools">
        <ul class="nk-tb-actions gx-1 my-n1">
            <li>
                <div class="drodown">
                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger mr-n1" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <ul class="link-list-opt no-bdr">
                            <li><a href="#"><em class="icon ni ni-edit"></em><span>Update Status</span></a></li>
                            <li><a href="#"><em class="icon ni ni-truck"></em><span>Mark as Delivered</span></a></li>
                            <li><a href="#"><em class="icon ni ni-money"></em><span>Mark as Paid</span></a></li>
                            <li><a href="#"><em class="icon ni ni-report-profit"></em><span>Send Invoice</span></a></li>
                            <li><a href="#"><em class="icon ni ni-trash"></em><span>Remove Orders</span></a></li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div><!-- .nk-tb-item -->
<?php
if ($stmt->rowCount()) {
    foreach ($stmt->fetchAll() as $order)
    {
        ?>
        <div class="nk-tb-item">
            <div class="nk-tb-col nk-tb-col-check">
                <div class="custom-control custom-control-sm custom-checkbox notext">
                    <input type="checkbox" class="custom-control-input" id="uid1">
                    <label class="custom-control-label" for="uid1"></label>
                </div>
            </div>
            <div class="nk-tb-col">
                <span class="tb-lead"><a href="#"><?= $order['order_number']?></a></span>
            </div>
            <div class="nk-tb-col tb-col-md">
                <span class="tb-sub"><?= $order['order_date']?></span>
            </div>
            <div class="nk-tb-col tb-col-sm">
                <span class="tb-sub"><?= $order['first_name'] . ' ' . $order['last_name']?></span>
            </div>
            <div class="nk-tb-col tb-col-md">
                <span class="tb-sub text-primary"><?= $order['qtyProducts']?> منتجات</span>
            </div>
            <div class="nk-tb-col">
                <span class="tb-sub"><?= $order['status_name']?></span>
            </div>
            <div class="nk-tb-col">
                <span class="tb-lead"><?= $order['total_price']?> ريال</span>
            </div>
            <div class="nk-tb-col nk-tb-col-tools">
                <ul class="nk-tb-actions gx-1">
                    <li>
                        <div class="dropdown mr-n1">
                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <a href="controller/orders/getOrder.php?id=<?= $order['id']?>"><em class="icon ni ni-camera"></em><span>عرض الطلب</span></a>
                                    </li>
                                    <li>
                                        <span class="span-form">
                                            <em class="icon ni ni-eye"></em>
                                            <button type="button" class="btn btn-link p-0 text-decoration-none editStatus" value="<?= $order['id']?>">حاله الطلب</button>
                                        </span> 
                                    </li>
                                    <!-- <li><a href="#"><em class="icon ni ni-report-profit"></em><span>Send Invoice</span></a></li> -->
                                    <li>
                                        <span class="span-form text-danger">
                                            <em class="icon ni ni-trash-fill"></em>
                                            <button class="deleteOrder btn btn-link p-0 text-danger text-decoration-none" data-delete_order_id="<?= $order['id']?>">حذف الطلب</button>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .nk-tb-item -->
        <?php
    }
}
else {
    echo 'No Orders Yet.';
}