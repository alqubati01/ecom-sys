 <?php
session_start();
require_once 'include/connection.php';

if (!isset($_SESSION['admin_login']) && $_SESSION['admin_login'] !== true)
{
    header('refresh:0;url=login.php');
}
else
{ 
    if (array_key_exists('relatedProducts', $_SESSION)) 
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
                                            <h3 class="nk-block-title page-title"> المنتجات المتعلقة بالمنتج <?= $product_name?></h3>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block pt-2">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6 col-lg-4 col-xxl-3">
                                            <form action="./controller/products/addRelatedProduct.php" method="POST">
                                                <div class="row">
                                                    <div class="col-12 gy-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="related-proName">اختر اسم المنتج المتعلق</label>
                                                            <div class="form-control-wrap">
                                                                <select class="form-select form-control form-control-lg" data-search="on" id="related-proName" name="related_product_id">
                                                                    <option value="default_option">اختر منتج</option>
                                                                    <?php
                                                                        $getProducts = $pdo->prepare('SELECT id, slug FROM products');
                                                                        $getProducts->execute();
                                                                        foreach ($getProducts->fetchAll() as $product)
                                                                        {
                                                                            ?>
                                                                                <option value="<?= $product['id']?>"><?= $product['slug']?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>                        
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <input type="hidden" name="product_id" value="<?= $p_id ?>">
                                                            <input type="submit" name="relatedProduct" class="btn btn-md btn-primary mt-2" value="اضافة">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-8 col-xxl-9">
                                            <div class="card">
                                                <div class="card-inner-group">
                                                    <div class="card-inner p-0">
                                                        <div class="nk-tb-list">
                                                            <div class="nk-tb-item nk-tb-head">
                                                                <div class="nk-tb-col nk-tb-col-check">
                                                                    <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                        <input type="checkbox" class="custom-control-input" id="uid">
                                                                        <label class="custom-control-label" for="uid"></label>
                                                                    </div>
                                                                </div>
                                                                <div class="nk-tb-col tb-col-sm"><span>اسم المنتج</span></div>
                                                                <div class="nk-tb-col tb-col-md"><span>التصنيف</span></div>
                                                                <div class="nk-tb-col tb-col-md"><span>الحالة</span></div>
                                                                <div class="nk-tb-col tb-col-md"><span>حذف</span></div>
                                                            </div><!-- .nk-tb-item -->
                                                            <?php
                                                            if (count($_SESSION['relatedProducts']) > 0 && $_SESSION['relatedProducts'] !== false) 
                                                            {
                                                                foreach ($_SESSION['relatedProducts'] as $relatedProduct)
                                                                {
                                                                    ?>
                                                                    <span class="d-none" id="productID"><?= $relatedProduct['product_id'] ?></span>
                                                                    <div class="nk-tb-item">
                                                                        <div class="nk-tb-col nk-tb-col-check">
                                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                                <input type="checkbox" class="custom-control-input" id="uid1">
                                                                                <label class="custom-control-label" for="uid1"></label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="nk-tb-col tb-col-sm">
                                                                            <span class="tb-product">
                                                                                <span class="title" id=""><?= $relatedProduct['product_name']?></span>
                                                                            </span>
                                                                        </div>
                                                                        <div class="nk-tb-col tb-col-md">
                                                                            <span class="tb-sub" id=">"><?= $relatedProduct['category_name']?></span>
                                                                        </div>
                                                                        <div class="nk-tb-col tb-col-md">
                                                                                <span class="tb-sub text-success"><?= $relatedProduct['is_active']?></span>
                                                                        </div>
                                                                        <div class="nk-tb-col tb-col-md">
                                                                            <span class="span-form text-danger">
                                                                                <form action="controller/products/deleteRelatedProduct.php" method="POST">
                                                                                    <input type="hidden" name="product_id" value="<?= $relatedProduct['product_id']?>">
                                                                                    <input type="hidden" name="related_product_id" value="<?= $relatedProduct['related_product_id']?>">
                                                                                    <input type="submit" name="delete" value="حذف المنتج" class="btn btn-link p-0 text-danger text-decoration-none">
                                                                                </form>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            else 
                                                            {
                                                                echo 'there is no related products..';
                                                            }   
                                                            ?>
                                                            <!-- .nk-tb-item -->
                                                        </div><!-- .nk-tb-list -->
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
    <!-- app-root @e -->


    <?php
    require_once 'include/footer.php';
    }
}
?>


<script src="related-products.js"></script>
<script>
    // $(function() {
    //     var productID=$('#productID').text();
    //     $('#product-id').val(productID);
    // });
</script>

