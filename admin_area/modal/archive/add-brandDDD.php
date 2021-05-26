<!-- @@ Add Brand Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="add-brand">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">اضافة علامة تجارية جديدة</h5>
                <div class="tab-content">
                    <div class="tab">
                        <form  action="./controller/brands/create.php" method="POST" id="checkAddBrand">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="brand-name">اسم العلامة</label>
                                        <input type="text" name="brand_name" class="form-control form-control-lg" id="brand-name" value="" placeholder="ادخل اسم العلامة التجارية" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <input type="submit" name="createBrand" class="btn btn-lg btn-primary" value="اضافة">
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