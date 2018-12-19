<?php
namespace Core;

class ViewStyle {
    public static $files=array();
    function __construct() {
        $this->files=array();
    }
    public static function addStyle($file) {
        ViewStyle::$files[]=URL::asset($file.'.css');
    }
    public static function getStyle() {
        foreach(ViewStyle::$files as $file) {
            echo '<link rel="stylesheet" href="'.$file.'">';
        }
    }
}
?>