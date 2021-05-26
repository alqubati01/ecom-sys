<?php

session_start();
require_once '../include/connection.php';


if (isset($_POST['id']) && !empty($_POST['id']))
{
    $stmt = $pdo->prepare('SELECT * FROM areas WHERE city_id=:city_id');
    $stmt->execute([
        ':city_id' => $_POST['id']
    ]);
    
    ?>
    <option value="">اختر منطقة</option>
    <?php
    foreach ($stmt->fetchAll() as $area) 
    {
    ?>
        <option value="<?php echo $area["id"]; ?>"><?php echo $area["name"]; ?></option>
    <?php
    }
}
