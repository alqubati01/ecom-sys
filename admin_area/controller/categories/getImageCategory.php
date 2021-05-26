<?php

session_start();
require_once '../../include/connection.php';

if (isset($_POST['id']) && !empty($_POST['id']))
{
    $stmt = $pdo->prepare('SELECT * FROM files
                where entity_id=:id AND entity_type="Category"');
    $stmt->execute([
        ':id' => $_POST['id']
    ]);
    if ($stmt->rowCount())
    {
        $image = $stmt->fetch();
        ?>
        <div class="row align-items-end">
            <div class="col-md-9 pt-2">
                <img src="<?= $image['path']?>" class="w-80"> 
            </div>
            <div class="col-md-3 pb-2">
                <form action="./controller/categories/deleteCategoryImages.php" method="POST">
                    <input type="hidden" name="id" value="<?= $image['id']?>"> 
                    <input type="submit" name="deleteImage" class="btn btn-danger" value="حذف"> 
                </form>
            </div>
        </div>
        <?php
    }
    else {
        echo 'there is no base image yet..';
    }
    
}
