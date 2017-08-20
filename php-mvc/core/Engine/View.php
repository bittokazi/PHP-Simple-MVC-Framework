<?php
namespace Core;

class View {
    function __construct() {

    }
    public static function load($view, $data=array()) {
        include_once(dirname(__FILE__).'/../../app/view/'.$view.'.php');
    }
    public static function style() {
        return new ViewStyle();
    }
    public static function script() {
        return new ViewScript();
    }
}
?>