<?php
/**
 * Created by PhpStorm.
 * User: SNOVA
 * Date: 2015/7/7
 * Time: 15:50
 */
class MysqliDriver{
    private static $conn;
    private $role;
    public function __construct($role){
        $this->role = $role;
    }
    public function connect($config,$role = "slavery"){

        extract($config);
        if(!isset(self::$conn[$role])){
            self::$conn[$role]=new mysqli($db_host,$db_user,$db_pass,$db_name);
        }
        if(self::$conn[$role]){
            self::$conn[$role]->set_charset($charset);
        }
        return self::$conn[$role];
    }
    public function query($sql){
        $result = self::$conn[$this->role]->query($sql);
        return $result;
    }
    public function getAll($sql){
        $result=$this->query($sql);
        if(!$result){
            return false;
        }
        $arr = array();
        while($row = $result ->fetch_assoc()){
            $arr[] = $row;
        }
        $this->free_result($result);
        return $arr;
    }
    public function getRow($sql){
        $result = $this->query($sql);
        if(!$result){
            return false;
        }
        $row = $this->fetch_assoc($result);
        $this->free_result($result);
        return $row;
    }
    public function getCol($sql){
        $result = $this->query($sql);
        if(!$result){
            return false;
        }
        $arr = array();
        while($row = $this->fetch_row($result)){
            $arr[] = $row[0];
        }
        $this->free_result($result);
        return $arr;
    }
    public function getOne($sql){
        $result = $this->query($sql);
        if(!$result){
            return false;
        }
        $row = $this->fetch_row($result);
        $this->free_result($result);
        return $row[0];
    }
    public function fetch_assoc($result){
        if(!$result){
            return false;
        }
        return $result->fetch_assoc();
    }
    public function fetch_array($result){
        if(!$result){
            return false;
        }
        return $result->fetch_array();
    }
    public function fetch_row($result){
        if(!$result){
            return false;
        }
        return $result->fetch_row();
    }
    public function free_result($result){
        if($result){
            $result->free();
        }
        return true;
    }
    public function close(){
        if(self::$conn[$this->role]){
            self::$conn[$this->role] ->close();
        }
        return true;
    }

}