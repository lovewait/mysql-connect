<?php
/**
 * Created by PhpStorm.
 * User: SNOVA
 * Date: 2015/7/7
 * Time: 15:41
 */

//$config = array(
//    'db_host'=>'localhost',
//    'db_name'=>'test',
//    'db_user'=>'root',
//    'db_pass'=>'123',
//    'charset'=>'UTF8',
//);
require '/Lib/DbProxy.php';
$config = require '/Lib/config.php';

$db = new Db($config['master']);
$db1 = new Db($config['master']);
var_dump($db,$db1);
$sql = "select * from `atable` where id > 0";
//$sql1 = 'update atable set name ="aaa1" where id=1';

$result = $db->getAll($sql);
$result = $db->getRow($sql);
//$result = $db->getCol($sql);
//$result=$db->getOne($sql);
var_dump($result);

