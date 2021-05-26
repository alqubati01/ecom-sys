    <!-- @@ Profile Edit Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="profile-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">تعديل الملف الشخصي</h5>
                    <div class="tab-content">
                        <div class="tab">
                            <form  action="controller/profile/edit.php" method="POST" id="checkEditProfile">
                                <div class="row gy-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="profile-first-name">الاسم الاول</label>
                                            <input type="text" name="first_name" class="form-control form-control-lg" id="profile-first-name" value="<?= $_SESSION['admin']['first_name']; ?>" placeholder="ادخل اسمك الاول">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="profile-last-name">الاسم الثاني</label>
                                            <input type="text" name="last_name" class="form-control form-control-lg" id="profile-last-name" value="<?= $_SESSION['admin']['last_name']; ?>" placeholder="ادخل اسمك الثاني">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="profile-username">اسم المستخدم</label>
                                            <input type="text" name="username" class="form-control form-control-lg" id="profile-username" value="<?= $_SESSION['admin']['username']; ?>" placeholder="ادخل اسم المستخدم">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for=user-address">العنوان</label>
                                            <input type="text" name="address" class="form-control form-control-lg" id="user-address" value="<?= $_SESSION['admin']['address']; ?>"
                                            placeholder="ادخل عنوانك" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="city">المدينة</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="profile-city" name="city" onChange="getAreas(this.value);">
                                                        <option value="">اختر مدينة</option>
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
                                            <label class="form-label" for="areas">المنطقة</label>
                                            <div class="form-control-wrap">
                                                <div class="form-control-select">
                                                    <select class="form-control" id="profile-areas" name="area">
                                                            
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label" for="profile-phone-no">رقم الهاتف</label>
                                            <input type="text" name="phone" class="form-control form-control-lg" id="profile-phone-no" value="<?= $_SESSION['admin']['phone']; ?>" placeholder="ادخل رقم هاتفك">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="hidden" name="id" value="<?= $_SESSION['admin']['id']?>">
                                                <input type="submit" name="editAdmin" class="btn btn-lg btn-primary" value="تحديث">
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