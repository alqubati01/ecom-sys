<?php

session_start();
require_once '../../include/connection.php';

$limit = 1;
if(isset($_POST['last_id']))
{
  $last_id = $_POST['last_id'];
}
else{
  $last_id = 0;
}

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
                        WHERE p.id > :last_id
                        LIMIT :limit');
$stmt->execute([
    ':last_id' => $last_id,
    ':limit' => $limit
]);
?>
<tbody>
<?php
if ($stmt->rowCount()) {
    foreach ($stmt->fetchAll() as $product)
    {
        $last_id = $product['id'];
        ?>
        <tr class="nk-tb-item">
            <td class="nk-tb-col nk-tb-col-check">
                <div class="custom-control custom-control-sm custom-checkbox notext">
                    <input type="checkbox" class="custom-control-input" id="uid1">
                    <label class="custom-control-label" for="uid1"></label>
                </div>
            </td>
    
            <span class="d-none" id="price<?= $product['id'] ?>"><?= $product['price'] ?></span>
            <span class="d-none" id="specialPrice<?= $product['id'] ?>"><?= $product['special_price'] ?></span>
            <span class="d-none" id="specialPriceEnd<?= $product['id'] ?>"><?= $product['special_price_end'] ?></span>
            <span class="d-none" id="metaTitle<?= $product['id'] ?>"><?= $product['meta_title'] ?></span>
            <input type="text" class="d-none" id="metaDesc<?= $product['id'] ?>" value="<?= $product['meta_desc'] ?>">
            <input type="text" class="d-none" id="pdescription<?= $product['id'] ?>" value="<?= $product['description'] ?>">
        
            <td class="nk-tb-col tb-col-sm">
                <span class="tb-product">
                    <img src="./images/product/a.png" alt="" class="thumb">
                    <span class="title" id="pname<?= $product['id'] ?>"><?= $product['slug']?></span>
                </span>
            </td>
            <td class="nk-tb-col">
                <span class="tb-sub" id="sku<?= $product['id'] ?>"><?= $product['sku']?></span>
            </td>
            <td class="nk-tb-col">
                <span class="tb-lead" id="sellingPrice<?= $product['id'] ?>"><?= $product['selling_price']?></span>
            </td>
            <td class="nk-tb-col">
                <span class="tb-sub" id="qty<?= $product['id'] ?>"><?= $product['qty']?></span>
            </td>
            <td class="nk-tb-col tb-col-md">
                <span class="tb-sub" id="cateName<?= $product['id'] ?>"><?= $product['category_name']?></span>
            </td>
            <td class="nk-tb-col tb-col-md">
                <span class="tb-sub" id="brandName<?= $product['id'] ?>"><?= $product['brand_name']?></span>
            </td>
            <td class="nk-tb-col tb-col-md">
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
                
            </td>
            <td class="nk-tb-col nk-tb-col-tools">
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
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
    <tfoot id='pagination'>
        <tr class="nk-tb-item">
            <td class="nk-tb-col tb-col-sm" colspan="4">
                <button class="btn btn-primary" id="btn-pagination" data-last_id="<?= $last_id ?>">عرض المزيد من المنتجات</button>
            </td>
        </tr>
    </tfoot>

    <?php
}
else {
    echo '';
}



