<?php
/**
 * Created by PhpStorm.
 * User: SNOVA
 * Date: 2015/7/7
 * Time: 15:41
 */
class Db{
    private $obj;
    public static $conn;
    public function __construct(){}
    public function connect($config = array(),$role , $db_type='MysqlDriver'){
        if(empty($config)){
            trigger_error('数据库连接参数为空！！！',E_USER_ERROR);
        }
        require_once dirname(__FILE__).'/Db/'.$db_type.'.class.php';
        $this->obj = new $db_type($role);
        if(!isset(self::$conn[$role])) {
            if($role == 'slavery'){
                $count = count($config['slavery']);
                $config = $config['slavery']['s'.rand(1,$count)];
            }else{
                $config = $config['master'];
            }
            self::$conn[$role] = $this->obj->connect($config, $role);
        }
    }

    public function query($sql){
        return $this->obj->query($sql);
    }
    public function getAll($sql){
        return $this->obj->getAll($sql);
    }
    public function getRow($sql){
        return $this->obj->getRow($sql);
    }
    public function getCol($sql){
        return $this->obj->getCol($sql);
    }
    public function getOne($sql){
        return $this->obj->getOne($sql);
    }
    public function fetch_assoc($result){
        return $this->obj->fetch_assoc($result);
    }
    public function fetch_array($result){
        return $this->obj->fetch_array($result);
    }
    public function fetch_row($result){
        return $this->obj->fetch_row($result);
    }
    public function free_result($result){
        return $this->obj->free_result($result);
    }
    public function close(){
        return $this->obj->close();
    }
}