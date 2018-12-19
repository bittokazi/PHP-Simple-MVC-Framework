<?php
namespace Core;

class ViewScript {
    public static $files=array();
    public static $files_h=array();
    function __construct() {

    }
    public static function addScript($file) {
        ViewScript::$files[]=URL::asset($file.'.js');
    }
    public static function addScriptFoot($file) {
        ViewScript::$files_h[]=URL::asset($file.'.js');
    }
    public static function getScript() {
        foreach(ViewScript::$files as $file) {
            echo '<script language="javascript" type="text/javascript" rel="Scriptsheet" src="'.$file.'"></script>';
        }
    }
    public static function getScriptFoot() {
        foreach(ViewScript::$files_h as $file) {
            echo '<script language="javascript" type="text/javascript" src="'.$file.'"></script>';
        }
    }
}
?>