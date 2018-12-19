<?php
namespace Core;

class View {
    public static $var_name=array();
    public static $data=array();
    public $view;
    function __construct() {

    }
    public static function loadView($view) {
        foreach(View::$var_name as $k=>$v) {
            $$v=View::$data[$k];
        }
        include(dirname(__FILE__).'/../../app/view/'.$view.'.php');
    }
    public function load($view) {
        $this->view=dirname(__FILE__).'/../../app/view/'.$view.'.php';
        return $this;
    }
    public static function style() {
        return new ViewStyle();
    }
    public static function script() {
        return new ViewScript();
    }
    public function with($data, $var_name) {
        View::$var_name[] = $var_name;
        View::$data[] = $data;
        return $this;
    }
    function __destruct() {
        foreach(View::$var_name as $k=>$v) {
            $$v=View::$data[$k];
        }
        include_once($this->view);
    }
}
?>