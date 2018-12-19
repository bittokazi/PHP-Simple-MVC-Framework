<?php
namespace Core;

class Filter {
    public $dba;
    function __construct() {
        $this->dba=new Database();
    }
    public function DB() {
        return $this->dba;
    }
    public function model($model) {
        include_once(dirname(__FILE__).'/../../app/model/'.$model.'.php');
    }
    public function addClass($file) {
        include_once(dirname(__FILE__).'/../'.$file.'.php');
    }
}
?>