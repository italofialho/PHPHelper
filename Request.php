<?php 

class Request  {
    
    public function param($name, $method = "REQUEST")
    {
        switch($method){
            case 'REQUEST':
                if (isset($_REQUEST[$name]) && !empty($_REQUEST[$name]) && !is_null($_REQUEST[$name])){
                    return $_REQUEST[$name];
                }else{
                    return false;
                }
                break;
            case 'GET':
                if (isset($_GET[$name]) && !empty($_GET[$name]) && !is_null($_GET[$name])){
                    return $_GET[$name];
                }else{
                   return false;
                }
                break;
            case 'POST':
                if (isset($_POST[$name]) && !empty($_POST[$name]) && !is_null($_POST[$name])){
                    return $_POST[$name];
                }else{
                    return false;
                }
                break;
            default:
                return false;
                break;
        }
    }
}


?>