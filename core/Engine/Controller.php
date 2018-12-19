<?php
namespace Core;

class Controller {
    public $dba;
    public $view;
    function __construct() {
//        $this->dba=new Database();
//        $this->view=new View();
    }
    public function view() {
        $this->view=new View();
        return $this->view;
    }
    public function DB() {
        $this->dba=new Database();
        return $this->dba;
    }
    public function model($model) {
        include_once(dirname(__FILE__).'/../app/model/'.$model.'.php');
    }
    public function addClass($file) {
        include_once(dirname(__FILE__).'/../'.$file.'.php');
    }
}
?>