<?php

class Request
{
    
    public function param($name, $method = "REQUEST")
    {
        switch ($method) {
            case 'REQUEST':
                if (isset($_REQUEST[$name]) && !empty($_REQUEST[$name]) && !is_null($_REQUEST[$name])) {
                    return $_REQUEST[$name];
                }
                break;
            case 'GET':
                if (isset($_GET[$name]) && !empty($_GET[$name]) && !is_null($_GET[$name])) {
                    return $_GET[$name];
                }
                break;
            case 'POST':
                if (isset($_POST[$name]) && !empty($_POST[$name]) && !is_null($_POST[$name])) {
                    return $_POST[$name];
                }
                break;
            case 'FILE':
                if (isset($_FILES[$name]) && !empty($_FILES[$name]) && !is_null($_FILES[$name])) {
                    return $_FILES[$name];
                }
                break;
            default:
                return false;
                break;
        }
        return false;
    }
}


?>
