<?php
/**
 * Created by PhpStorm.
 * User: SNOVA
 * Date: 2015/7/8
 * Time: 14:57
 */
require 'Db.class.php';
class DbProxy{
    private $obj;
    private $config;
    public function __construct($config){
        $this->config = $config;
        $this->obj = new Db();
    }
    //配置主从
    public function __call($name,$params){
        $query_method = array(
            'getAll',
        );
        if(method_exists('Db',$name)){
            if(in_array($name,$query_method)){
                $this->obj->connect($this->config,'slavery', 'PDODriver');
                return call_user_func_array(array($this->obj,$name),$params);
            }else{
                $this->obj->connect($this->config,'master','PDODriver');
                return call_user_func_array(array($this->obj,$name),$params);
            }
        }else{
            trigger_error('方法不存在！！！',E_USER_ERROR);
        }
    }
}