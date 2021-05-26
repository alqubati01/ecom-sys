<?php

require_once '../../include/connection.php';
session_start();



$stmt = $pdo->prepare('SELECT b.id AS brand_id, f.id AS file_id,slug, is_active, f.id, f.entity_id, f.entity_type, f.zone, f.path
FROM brands b
LEFT JOIN files f
	ON b.id = f.entity_id AND f.entity_type = "Brand" 
ORDER BY b.created_at DESC');
$stmt->execute();

if ($stmt->rowCount())
{
    $brands = $stmt->fetchAll();
    foreach ($brands as $brand)
    {
        ?>
    <div class="col-sm-6 col-lg-4 col-xxl-3 brand-item">
        <div class="card card-bordered">
            <div class="card-inner">
                <div class="team">
                    <?php 
                        if ($brand['is_active'] === 1)
                        {
                            ?>
                            <div class="team-status bg-success text-white"><em class="icon ni ni-check-thick"></em></div>
                            <?php
                        } 
                        else 
                        {
                            ?>
                            <div class="team-status bg-danger text-white"><em class="icon ni ni-na"></em></div>
                            <?php 
                        }
                    ?>
                    <div class="team-options">
                        <div class="drodown">
                            <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="link-list-opt no-bdr">
                                    <li>
                                        <?php 
                                            if ($brand['is_active'] === 1)
                                            {
                                                ?>
                                                <span class="span-form text-danger">
                                                    <em class="icon ni ni-na"></em>
                                                    <button class="stopBrand btn btn-link p-0 text-danger text-decoration-none" data-stop_brand_id="<?= $brand['brand_id']?>">اخفاء البرند</button>
                                                </span>
                                                <?php
                                            } 
                                            else 
                                            {
                                                ?>
                                                <span class="span-form text-success">
                                                    <em class="icon ni ni-na"></em>
                                                    <button class="activeBrand btn btn-link p-0 text-success text-decoration-none" data-active_brand_id="<?= $brand['brand_id']?>">اظهار البرند</button>
                                                </span>
                                                <?php 
                                            }
                                        ?>
                                    </li>
                                    <li>
                                        <span class="span-form">
                                            <em class="icon ni ni-camera"></em>
                                            <button class="addImageBrand btn btn-link p-0 text-decoration-none" data-addimage_brand_id="<?= $brand['brand_id']?>">اضافة صورة</button>
                                        </span>
                                    </li>
                                    <?php
                                        if ($brand['file_id'] != null)
                                        {
                                            ?>
                                            <li>
                                                <span class="span-form text-danger">
                                                    <em class="icon ni ni-trash"></em>
                                                    <button class="deleteImageBrand btn btn-link p-0 text-danger text-decoration-none" data-deleteimage_brand_id="<?= $brand['file_id']?>">حذف الصورة</button>
                                                </span>
                                            </li>
                                            <?php
                                        }
                                    ?>
                                    <li>
                                        <span class="span-form text-danger">
                                            <em class="icon ni ni-trash-fill"></em>
                                            <button class="deleteBrand btn btn-link p-0 text-danger text-decoration-none" data-delete_brand_id="<?= $brand['brand_id']?>">حذف البرند</button>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="user-card user-card-s2 pt-5">
                        <div class="user-avatar sq xl">
                            <img src="<?= $brand['path'] ?>">
                        </div>
                        <div class="user-info">
                            <h6 id="brandName<?= $brand['brand_id'] ?>"><?=$brand['slug']?></h6>
                        </div>
                    </div>
                    <div class="team-view mt-2">
                        <button type="button" class="btn btn-dim btn-primary edit" value="<?= $brand['brand_id']?>">تحديث المعلومات</button>
                    </div>
                </div><!-- .team -->
            </div><!-- .card-inner -->
        </div><!-- .card -->
    </div><!-- .col -->
    <?php
    }
}
else {
    echo 'there is no brands yet..';
}
?>