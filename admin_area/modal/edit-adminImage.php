    <!-- @@ Image Edit Modal @e -->
    <div class="modal fade" tabindex="-1" role="dialog" id="image-edit">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                <div class="modal-body modal-body-lg">
                    <h5 class="title">تغيير صورة الملف الشخصي</h5>
                    <div class="tab-content">
                        <div class="tab">
                            <form  action="controller/profile/edit_image.php" method="POST" enctype="multipart/form-data">
                                <div class="row gy-4">
                                    <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <div class="custom-file">
                                                <input type="file" name="admin_image" class="custom-file-input" id="customFile">
                                                <label class="custom-file-label" for="customFile">اختر ملف</label>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-12">
                                        <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                            <li>
                                                <input type="hidden" name="id" value="<?= $_SESSION['id']?>">
                                                <input type="submit" name="editImage" class="btn btn-lg btn-primary" value="تحديث">
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