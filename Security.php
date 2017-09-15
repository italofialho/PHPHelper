<?php 
class Security{

    public function anti_injection($sql){
        $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "" ,$sql);
        $sql = trim($sql);
        $sql = strip_tags($sql);
        $sql = (get_magic_quotes_gpc()) ? $sql : addslashes($sql);
        return $sql;
     }

     public function isVar($var, $op = 0){
        if(!isset($var) || empty($var) || $var === null || is_null($var)){
            return false;
        }else{
            return true;
        }
     }
}


?>