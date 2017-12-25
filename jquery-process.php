<?php
/**
 * Created by PhpStorm.
 * User: swaja
 * Date: 12/24/2017
 * Time: 8:23 PM
 */
require_once 'database.php';

$generalUpdate=isset($_POST['generalUpdate'])?$_POST['generalUpdate']:null;
$generalDelete=isset($_POST['generalDelete'])?$_POST['generalDelete']:null;

if($generalUpdate!=null || !empty($generalUpdate)){
    db_update($generalUpdate);
}else if($generalDelete!=null || !empty($generalDelete)){
    db_delete($generalDelete);
} else{
    $data = db_select('select * from identity');
    echo json_encode($data);
}
