<?php
namespace Core;

class Model {
    public $dba;
    function __construct() {
        $this->dba=new Database();
    }
    public function DB() {
        return $this->dba;
    }
}
?>