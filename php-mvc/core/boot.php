<?php
namespace Core;

class Main_core {
    function __construct() {
        
    }
    public function include_core() {
        
        //core files inclusion
        include_once(dirname(__FILE__).'/../config/config.php');
        session_start();
        $this->listFolderFiles(dirname(__FILE__).'/Engine');
        //core files inclusion end
        
        include_once(dirname(__FILE__).'/../config/modules.php');
        $module = new \Module;
        $module->addModules();
        $module->initInterCeptor();
        
        $this->listFolderFiles(dirname(__FILE__).'/../app/controller');
        $this->listFolderFiles(dirname(__FILE__).'/../app/filter');
        $this->listFolderFiles(dirname(__FILE__).'/../app/model');
        
    }
    public function init() {
        if(DB_TYPE=='mysqli' && CONNECT_DB) {
            URL::set_url();
            Database::$db_type=DB_TYPE;
            Database::mysqli(MYSQLI_DB_HOST, MYSQLI_DB_USER, MYSQLI_DB_PASS, MYSQLI_DB_NAME); 
        }
        \Routes::excute();
    }
    public function listFolderFiles($dir) {
        $ffs = scandir($dir);

        unset($ffs[array_search('.', $ffs, true)]);
        unset($ffs[array_search('..', $ffs, true)]);

        if (count($ffs) < 1)
            return;
        
        foreach($ffs as $ff){
            if(is_dir($dir.'/'.$ff)) $this->listFolderFiles($dir.'/'.$ff);
            else include_once($dir.'/'.$ff);
        }
    }
}
$main_core=new Main_core;
$main_core->include_core();
$main_core->init();
?>