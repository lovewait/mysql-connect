<?php
/**
 * Created by PhpStorm.
 * User: SNOVA
 * Date: 2015/7/7
 * Time: 15:50
 */
class PDODriver{
    private static $conn;
    private static $obj;
    private function __construct(){}
    private function __clone(){}
    public static function getInstance($config){
        if(!self::$obj){
            self::$obj = new self();
        }
        if(!self::$conn){
            self::$conn = self::$obj->connect($config);
        }
        return self::$obj;
    }
    public function connect($config){
        extract($config);
        self::$conn = new PDO("mysql:dbname=$db_name;host=$db_host",$db_user,$db_pass);
        if(self::$conn){
            $this->query("SET NAMES ".$charset);
        }
        return self::$conn;
    }
    public function query($sql){
        $result = self::$conn->query($sql);
        return $result;
    }
    public function getAll($sql){
        $result = $this->query($sql);
        if(!$result){
            return false;
        }

        $arr = array();
        while($row = $this->fetch_assoc($result)){
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
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function fetch_array($result){
        if(!$result){
            return false;
        }
        return $result->fetch(PDO::FETCH_BOTH);
    }
    public function fetch_row($result){
        if(!$result){
            return false;
        }
        return $result->fetch(PDO::FETCH_NUM);
    }
    public function free_result($result){
        if($result){
            $result = null;
        }
        return true;
    }
    public function close(){
        if(self::$conn){
            unset(self::$conn);
        }
        return true;
    }
}