<?php
namespace Core;

class Request {
    public static function post($id) {
        $val="";
        if (isset($_POST[$id])) {
            $val=$_POST[$id];
        }
        return $val;
    }
    public static function set_post($k, $v) {
        $_POST[$k]=$v;
    }
    public static function post_all() {
        return $_POST;
    }
    public static function get($id) {
        $val="";
        if (isset($_GET[$id])) {
            $val=$_GET[$id];
        }
        return $val;
    }
    public static function set_get($k, $v) {
        $_GET[$k]=$v;
    }
    public static function get_all() {
        return $_POST;
    }
    public static function method() {
        return $_SERVER['REQUEST_METHOD'];
    }
    public static function contentType() {
        if(Request::method() === 'POST' && isset($_SERVER['CONTENT_TYPE'])) {
            return $_SERVER['CONTENT_TYPE'];
        } else {
            return "";
        }
    }
    public static function dataBinding() {
        if(strpos(Request::contentType(), 'application/json') !== false) {
            return json_decode(json_encode(json_decode(file_get_contents('php://input'), true)));
        } else {
            return json_decode(json_encode($_POST));
        }
    }
}
?>
