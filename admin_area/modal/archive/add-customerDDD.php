<!-- @@ Add Customer Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="add-customer">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">اضافة عميل جديد</h5>
                <div class="tab-content">
                    <div class="tab">
                        <form action="./controller/customers/create.php" method="POST" id="checkAddCustomer">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="first-name">الاسم الاول</label>
                                        <input type="text" name="first_name" class="form-control form-control-lg" id="customer-first-name" value="" placeholder="ادخل اسمك الاول">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="last-name">الاسم الثاني</label>
                                        <input type="text" name="last_name" class="form-control form-control-lg" id="customer-last-name" value="" placeholder="ادخل اسمك الثاني">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="email">الايميل</label>
                                        <input type="email" name="email" class="form-control form-control-lg" id="customer-email" value="" placeholder="ادخل الايميل">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="">اسم المستخدم</label>
                                        <input type="text" name="username" class="form-control form-control-lg" id="customer-username" value="" placeholder="ادخل اسم المستخدم">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">كلمة السر</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="customer-password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" name="password" class="form-control form-control-lg" id="customer-password" placeholder="ادخل كلمة السر">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="cpassword">تأكيد كلمة السر</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="customer-confirmPassword">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" name="confirmPassword" class="form-control form-control-lg" id="customer-confirmPassword" placeholder="ادخل كلمة السر">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="customer-status">الحاله</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-select">
                                                <select class="form-control" id="customer-status" name="isActive">
                                                    <option value="1">نشط</option>
                                                    <option value="0">موقوف</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="cAddress">العنوان</label>
                                        <input type="text" name="address" class="form-control form-control-lg" id="cAddress" value="" placeholder="ادخل عنوانك">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="city">المدينة</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-select">
                                                <select class="form-control" id="customer-city" name="city">
                                                    <?php
                                                        $stmt = $pdo->prepare('SELECT * FROM cities');
                                                        $stmt->execute();
                                                        foreach ($stmt->fetchAll() as $city)
                                                        {
                                                            ?>
                                                            <option value="<?= $city['id']?>"><?= $city['name']?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="area">المنطقة</label>
                                        <div class="form-control-wrap">
                                            <div class="form-control-select">
                                                <select class="form-control" id="customer-area" name="area">
                                                    <?php
                                                        $stmt = $pdo->prepare('SELECT * FROM areas');
                                                        $stmt->execute();
                                                        foreach ($stmt->fetchAll() as $area)
                                                        {
                                                            ?>
                                                            <option value="<?= $area['id']?>"><?= $area['name']?></option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="customer-phone-no">رقم الهاتف</label>
                                        <input type="text" name="phone" class="form-control form-control-lg" id="customer-phone-no" value="" placeholder="ادخل رقم هاتفك" >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                        <li>
                                            <input type="submit" name="createUser" class="btn btn-lg btn-primary" value="اضافة">
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