<?php
/**
 * Created by PhpStorm.
 * User: swaja
 * Date: 12/24/2017
 * Time: 8:23 PM
 */
require_once 'database.php';
$data = db_select('select * from identity');
echo json_encode($data);