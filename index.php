<?php
/**
 * Created by PhpStorm.
 * User: SNOVA
 * Date: 2015/7/7
 * Time: 15:41
 */


require '/Lib/DbProxy.php';
$config = require '/Lib/config.php';

$db = new DbProxy($config);

$sql = "select * from `atable` where id > 0";


$result = $db->getAll($sql);



$result = $db->getRow($sql);

var_dump($result);

