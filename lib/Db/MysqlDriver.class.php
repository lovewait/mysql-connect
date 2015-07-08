<?php
/**
 * Created by PhpStorm.
 * User: SNOVA
 * Date: 2015/7/7
 * Time: 15:49
 */
class MysqlDriver{
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
    public function connect($config = array()){
        extract($config);
        self::$conn=mysql_connect($db_host,$db_user,$db_pass);
        mysql_select_db($db_name,self::$conn);
        $this->query('SET NAMES '.$charset);
        return self::$conn;
    }
    public function query($sql){
        $result=mysql_query($sql,self::$conn);
        return $result;
    }
    public function getAll($sql){
        $result = $this->query($sql);
        if($result){
            $rows = array();
            while(($row = $this->fetch_assoc($result))!==false){
                $rows[] = $row;
            }
            $this->free_result($result);
            return $rows;
        }
        return false;
    }
    public function getRow($sql){
        $result = $this->query($sql);
        if($result){
            $row = $this->fetch_assoc($result);
            $this->free_result($result);
            return $row;
        }
        return false;
    }
    public function getCol($sql){
        $result = $this->query($sql);
        if($result){
            $rows = array();
            while(($row = $this->fetch_row($result)) !== false) {
                $rows[] = $row[0];
            }
            $this->free_result($result);
            return $rows;
        }
        return false;
    }
    public function getOne($sql){
        $result = $this->query($sql);
        if($result){
            $row = $this->fetch_row($result);
            $this->free_result($result);
            return $row[0];
        }
        return false;
    }
    public function fetch_assoc($result){
        if(!$result){
            return false;
        }
        return mysql_fetch_assoc($result);
    }
    public function fetch_array($result){
        if(!$result){
            return false;
        }
        return mysql_fetch_array($result);
    }
    public function fetch_row($result){
        if(!$result){
            return false;
        }
        return mysql_fetch_row($result);
    }
    public function free_result($result){
        if($result){
            mysql_free_result($result);
        }
        return true;
    }
    public function close(){
       if(self::$conn)
            mysql_close(self::$conn);
        return true;
    }
}