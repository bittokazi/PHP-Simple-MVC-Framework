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
}
?>