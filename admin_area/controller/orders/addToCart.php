<?php

session_start();
require_once '../../include/connection.php';

$total_price = 0;
$total_shipper = 20;
$total_price_products = 0;
?>
<tbody id="items-data">
<?php
if(isset($_SESSION["shopping_cart"]))
{
    foreach ($_SESSION["shopping_cart"] as $keys => $values) 
    {
        ?>
        <tr class="tb-tnx-item">
            <td class="tb-tnx-info">
                <div class="tb-tnx-desc">
                    <span class="title"><?= $values['product_name']?></span>
                </div>
                <div class="tb-tnx-date">
                    <span class="date"><?= $values['product_qty']?></span>
                    <span class="date"><?= $values['product_price']?></span>
                </div>
            </td>
            <td class="tb-tnx-amount is-alt">
                <div class="tb-tnx-total">
                    <span class="amount"><?= number_format($values['product_qty'] * $values['product_price'], 2)?></span>
                </div>
            </td>
            <td class="tb-tnx-action">
                <div class="dropdown">
                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                        <ul class="link-list-plain">
                            <li><a href="#">تعديل الكمية</a></li>
                            <li>
                                <span class="span-form">
                                    <button class="deleteOrderItem btn btn-link p-0 text-decoration-none" data-delete_order_item_id="<?= $values['product_id']?>">حذف المنتج</button>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
        <?php
        $total_price_products += $values['product_qty'] * $values['product_price'];
    }
    ?>
    <tr class="tb-tnx-item">
        <td class="tb-tnx-info">
            <div class="tb-tnx-desc">
                <span class="title">مجموع السلة</span>
            </div>
        </td>
        <td class="tb-tnx-amount is-alt">
            <div class="tb-tnx-total">
                <span class="amount" id="product-price"><?= $total_price_products ?></span>
            </div>
        </td>
        <td class="tb-tnx-action">
        </td>
    </tr>
    <tr class="tb-tnx-item">
        <td class="tb-tnx-info">
            <div class="tb-tnx-desc">
                <span class="title">تكلفة الشحن</span>
            </div>
        </td>
        <td class="tb-tnx-amount is-alt">
            <div class="tb-tnx-total">
                <span class="amount" id="delivery-cost"><?= $total_shipper ?></span>
            </div>
        </td>
        <td class="tb-tnx-action">
        </td>
    </tr>
    <!-- <tr class="tb-tnx-item">
        <td class="tb-tnx-info">
            <div class="tb-tnx-desc">
                <span class="title">كوبونات التخفيض</span>
            </div>
        </td>
        <td class="tb-tnx-amount is-alt">
            <div class="tb-tnx-total">
                <span class="amount">$0.00</span>
            </div>
        </td>
        <td class="tb-tnx-action">
        </td>
    </tr> -->
    <tr class="tb-tnx-item">
        <td class="tb-tnx-info">
            <div class="tb-tnx-desc">
                <span class="title">اجمالي الطلب</span>
            </div>
        </td>
        <td class="tb-tnx-amount is-alt">
            <div class="tb-tnx-total">
                <span class="amount" id="total-price"><?= $total_price = $total_price_products + $total_shipper ?></span>
            </div>
        </td>
        <td class="tb-tnx-action">
        </td>
    </tr>
<?php
}
else {
    echo 'there is no order items yet..';
}
?>
</tbody>

    
