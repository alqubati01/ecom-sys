<?php
    require_once './include/connection.php';
    $getCategories = $pdo->prepare('SELECT id, slug FROM categories');
    $getCategories->execute();
?>
<!-- @@ Add Product Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="add-product">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">اضافة منتج جديد</h5>
                <div class="tab-content">
                    <div class="tab">
                    <form action="./controller/products/create.php" method="POST" id="checkAddProduct">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="product-name">اسم المنتج 
                                            <span class="text-danger">*</span>
                                        </label>
                                        
                                        <input type="text" name="product_name" class="form-control form-control-lg"
                                            id="product-name" value="" placeholder="ادخل اسم المنتج">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="product-status">حالة المنتج
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-select">
                                                <select class="form-control" id="product-status" name="isActive">
                                                    <option value="1">نشط</option>
                                                    <option value="0">موقوف</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="price">تكلفة المنتج
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="price" class="form-control form-control-lg"
                                            id="price" value="" placeholder="ادخل سعر تكلفة المنتج">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="selling_price">السعر
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="selling_price" class="form-control form-control-lg"
                                            id="selling-name" value="" placeholder="ادخل سعر بيع المنتج">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="sku">رمز التخزين</label>
                                        <input type="text" name="sku" class="form-control form-control-lg"
                                            id="sku" value="" placeholder="رمز التخزين">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="category-name">تصنيف المنتج</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-select">
                                                <select class="form-control" id="product-category-name" name="category_id">
                                                    <option value="0">من دون تصنيف</option>
                                                <?php
                                                    foreach ($getCategories->fetchAll() as $category)
                                                    {
                                                        ?>
                                                            <option value="<?= $category['id']?>"><?= $category['slug']?></option>
                                                        <?php
                                                    }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- d-flex align-items-center -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="special_price">الكمية
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="qty" id="qty" class="form-control form-control-lg"
                                            value="" placeholder="ادخل الكمية">
                                    </div>
                                </div>
                                <div class="col-md-6 mt-n1 mt-md-5">
                                    <div class="custom-control custom-control-sm custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="stock_manage" id="stock-manage">
                                        <label class="custom-control-label" for="stock-manage">غير محدودة</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <input type="submit" name="createProduct" class="btn btn-lg btn-primary" value="اضافة">
                                        </li>
                                        <li>
                                            <a href="#" data-dismiss="modal" class="link link-light">الغاء</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div><!-- .tab -->
                </div><!-- .tab-content -->
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

