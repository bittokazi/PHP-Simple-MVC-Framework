<?php
namespace {
    class Module {
        public static $modules=array();
        public static function add($module) {
            Module::$modules[]=$module;
        }
        private function listFolderFiles($dir) {
            $ffs = scandir($dir);

            unset($ffs[array_search('.', $ffs, true)]);
            unset($ffs[array_search('..', $ffs, true)]);

            if (count($ffs) < 1)
                return;

            foreach($ffs as $ff){
                if(is_dir($dir.'/'.$ff)) {
                    if($ff!='Interceptor') $this->listFolderFiles($dir.'/'.$ff);
                }
                else include_once($dir.'/'.$ff);
            }
        }
        public function addModules() {
            foreach(Module::$modules as $module) {
                $this->listFolderFiles(dirname(__FILE__).'/../Modules/'.$module);
            }
        }
        public function initInterCeptor() {
            foreach(Module::$modules as $module) {
                if(file_exists(dirname(__FILE__).'/../Modules/'.$module.'/Interceptor') && is_dir(dirname(__FILE__).'/../Modules/'.$module.'/Interceptor')) {
                    foreach (glob(dirname(__FILE__).'/../Modules/'.$module.'/Interceptor'."/*.php") as $filename)
                    {
                        include_once($filename);
                        $filename = explode('/', $filename)[sizeof(explode('/', $filename))-1];
                        $filename = explode('.', $filename)[0];
                        $filename = 'Core\\Modules\\'.$module.'\\Interceptor\\'.$filename;
                        $interceptor = new $filename;
                        $interceptor->preHandler();
                    }
                }
            }
        }
    }
}
?>