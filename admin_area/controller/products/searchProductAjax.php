<?php

session_start();
require_once '../../include/connection.php';

// print_r($_POST);
// die();

$search_value = $_POST['search'];
$stmt = $pdo->prepare('SELECT p.*, b.slug as brand_name, s.sku, s.qty, pc.category_id, c.slug as category_name
                        FROM products p
                        JOIN stock s
                            ON p.id = s.product_id
                        LEFT JOIN brands b
                            ON p.brand_id = b.id
                        LEFT JOIN product_categories pc
                            ON pc.product_id = p.id
                        LEFT JOIN categories c
                            ON pc.category_id = c.id
                        WHERE p.slug LIKE :search_value');
$stmt->execute([
    ':search_value' => '%'.$search_value.'%',
]);

?>
<div class="nk-tb-item nk-tb-head">
    <div class="nk-tb-col nk-tb-col-check">
        <div class="custom-control custom-control-sm custom-checkbox notext">
            <input type="checkbox" class="custom-control-input" id="uid">
            <label class="custom-control-label" for="uid"></label>
        </div>
    </div>
    <div class="nk-tb-col tb-col-sm"><span>اسم المنتج</span></div>
    <div class="nk-tb-col"><span>رمز التخزين</span></div>
    <div class="nk-tb-col"><span>السعر</span></div>
    <div class="nk-tb-col"><span>الكمية</span></div>
    <div class="nk-tb-col tb-col-md"><span>التصنيف</span></div>
    <div class="nk-tb-col tb-col-md"><span>الماركة</span></div>
    <div class="nk-tb-col tb-col-md"><span>الحالة</span></div>
    <div class="nk-tb-col nk-tb-col-tools text-right">
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
    </div>
</div><!-- .nk-tb-item -->
<?php
if ($stmt->rowCount()) {
    foreach ($stmt->fetchAll() as $product)
    {
        ?>
        <div class="nk-tb-item">
            <div class="nk-tb-col nk-tb-col-check">
                <div class="custom-control custom-control-sm custom-checkbox notext">
                    <input type="checkbox" class="custom-control-input" id="uid1">
                    <label class="custom-control-label" for="uid1"></label>
                </div>
            </div>
    
            <span class="d-none" id="price<?= $product['id'] ?>"><?= $product['price'] ?></span>
            <span class="d-none" id="specialPrice<?= $product['id'] ?>"><?= $product['special_price'] ?></span>
            <span class="d-none" id="specialPriceEnd<?= $product['id'] ?>"><?= $product['special_price_end'] ?></span>
            <span class="d-none" id="metaTitle<?= $product['id'] ?>"><?= $product['meta_title'] ?></span>
            <input type="text" class="d-none" id="metaDesc<?= $product['id'] ?>" value="<?= $product['meta_desc'] ?>">
            <input type="text" class="d-none" id="pdescription<?= $product['id'] ?>" value="<?= $product['description'] ?>">
        
            <div class="nk-tb-col tb-col-sm">
                <span class="tb-product">
                    <img src="./images/product/a.png" alt="" class="thumb">
                    <span class="title" id="pname<?= $product['id'] ?>"><?= $product['slug']?></span>
                </span>
            </div>
            <div class="nk-tb-col">
                <span class="tb-sub" id="sku<?= $product['id'] ?>"><?= $product['sku']?></span>
            </div>
            <div class="nk-tb-col">
                <span class="tb-lead" id="sellingPrice<?= $product['id'] ?>"><?= $product['selling_price']?></span>
            </div>
            <div class="nk-tb-col">
                <span class="tb-sub" id="qty<?= $product['id'] ?>"><?= $product['qty']?></span>
            </div>
            <div class="nk-tb-col tb-col-md">
                <span class="tb-sub" id="cateName<?= $product['id'] ?>"><?= $product['category_name']?></span>
            </div>
            <div class="nk-tb-col tb-col-md">
                <span class="tb-sub" id="brandName<?= $product['id'] ?>"><?= $product['brand_name']?></span>
            </div>
            <div class="nk-tb-col tb-col-md">
                <?php
                    if ($product['is_active'] === 1)
                    {
                        ?>
                        <span class="tb-sub text-success">ظاهر</span>
                        <?php
                    }
                    else
                    {
                        ?>
                        <span class="tb-sub text-danger">مخفي</span>
                        <?php
                    }
                ?>
                
            </div>
            <div class="nk-tb-col nk-tb-col-tools">
                <ul class="nk-tb-actions gx-1 my-n1">
                    <li class="mr-n1">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <span class="span-form">
                                            <em class="icon ni ni-eye"></em>
                                            <button type="button" class="btn btn-link p-0 text-decoration-none edit" value="<?= $product['id']?>">عرض المنتج</button>
                                        </span>
                                    </li>
                                    <li>
                                        <a href="controller/products/getRelatedProducts.php?id=<?= $product['id']?>&pname=<?= $product['slug']?>"><em class="icon ni ni-link"></em><span>منتجات متعلقة</span></a>
                                    </li>
                                    <li>
                                    <?php 
                                        if ($product['is_active'] === 1)
                                        {
                                            ?>
                                            <span class="span-form text-danger">
                                                <em class="icon ni ni-na"></em>
                                                <button class="stopProduct btn btn-link p-0 text-danger text-decoration-none" data-stop_product_id="<?= $product['id']?>">اخفاء المنتج</button>
                                            </span>
                                            <?php
                                        } 
                                        else 
                                        {
                                            ?>
                                            <span class="span-form text-success">
                                                <em class="icon ni ni-na"></em>
                                                <button class="activeProduct btn btn-link p-0 text-success text-decoration-none" data-active_product_id="<?= $product['id']?>">اظهار المنتج</button>
                                            </span>
                                            <?php 
                                        }
                                    ?>
                                    </li>
                                    <li>
                                        <span class="span-form text-danger">
                                            <em class="icon ni ni-trash-fill"></em>
                                            <button class="deleteProduct btn btn-link p-0 text-danger text-decoration-none" data-delete_product_id="<?= $product['id']?>">حذف المنتج</button>
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
    echo 'No Products Found.';
}



