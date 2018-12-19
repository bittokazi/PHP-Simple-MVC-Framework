<?php
namespace {

    class Routes {
        public static $controller=array();
        public static $links=array();
        public static $req_type=array();
        public static $filter=array();
        public static function get($controller, $links, $filter='') {
            Routes::$controller[]=$controller;
            Routes::$links[]=$links;
            Routes::$req_type[]='GET';
            Routes::$filter[]=$filter;
        }
        public static function post($controller, $links, $filter='') {
            Routes::$controller[]=$controller;
            Routes::$links[]=$links;
            Routes::$req_type[]='POST';
            Routes::$filter[]=$filter;
        }
        public static function excute() {

            require_once(dirname(__FILE__).'/../../config/routes.php');

            $data=new \StdClass;
            $data=json_decode(json_encode($data));
            if(Core\Request::method() === 'POST') {
                $data->requestBody = Core\Request::dataBinding();
            }
            $found=0;
            if(!isset($_REQUEST['q'])) $_REQUEST['q']='/';
            $req=ltrim(rtrim($_REQUEST['q'], '/'),'/');
            $req=explode('/',$req);

            //flush message
            if(isset($_SESSION['flush_data'])) {
                foreach($_SESSION['flush_data'] as $k=>$v) {
                    $data->$k=json_decode($v, true);
                }
                unset($_SESSION['flush_data']);
            }
            //install database

            if(sizeof($req)==1 && DEBUG==true) {
                if($req[0]=='install.mvc') {
                    foreach (glob(ROOT_URL."/../database/*.php") as $filename)
                    {
                        include_once $filename;
                        $fn=explode('/',$filename);
                        $fn=$fn[sizeof($fn)-1];
                        $fn=explode('.',$fn)[0];
                        $fn = 'Database\\'.$fn;
                        $con=new $fn;
                        $con->install();
                    }
                    exit();
                }
                else if($req[0]=='seed.mvc') {
                    foreach (glob(ROOT_URL."/../database/*.php") as $filename)
                    {
                        include_once $filename;
                        $fn=explode('/',$filename);
                        $fn=$fn[sizeof($fn)-1];
                        $fn=explode('.',$fn)[0];
                        $fn = 'Database\\'.$fn;
                        $con=new $fn;
                        $con->seed();
                    }
                    exit();
                }
                else if($req[0]=='uninstall.mvc') {
                    foreach (glob(ROOT_URL."/../database/*.php") as $filename)
                    {
                        include_once $filename;
                        $fn=explode('/',$filename);
                        $fn=$fn[sizeof($fn)-1];
                        $fn=explode('.',$fn)[0];
                        $fn = 'Database\\'.$fn;
                        $con=new $fn;
                        $con->uninstall();
                    }
                    exit();
                }
            }

            //uninstall database

            foreach(Routes::$controller as $k=>$v) {
                if(Routes::$req_type[$k]!=$_SERVER['REQUEST_METHOD']) { continue; }
                $skip=0;
                $link=Routes::$links[$k];
                $link=ltrim(rtrim($link, '/'),'/');
                foreach(explode('/',$link) as $lk=>$lv) {
                    if(sizeof(explode('?',$lv))>1) {
                        if(!isset($req[$lk])) {
                            $found=0;
                        }
                        else {
                            $found++;
                            $var=explode('?',$lv)[1];
                            $data->$var=$req[$lk];
                        }
                    }
                    else {
                        if(!isset($req[$lk])) {
                            $found=0;
                        }
                        else if($lv==$req[$lk]) {
                            $found++;
                        }
                        else {
                            $found=0;
                        }
                    }
                    if($found==0) break;
                }
                if($found!=0 && sizeof($req)==$found)  break;
                else $found=0;
            }
            if($found>0 && sizeof($req)==$found) {
                if(sizeof(explode('#',$v))>1) {
                    $class_name=explode('#',$v)[0];
                    $func_name=explode('#',$v)[1];
                    //include_once(dirname(__FILE__).'/../app/controller/'.$class_name.'.php');

                    if(Routes::$filter[$k]!='') {
                        if(sizeof(explode('/', Routes::$filter[$k]))>0) {
                            if(sizeof(explode('#',Routes::$filter[$k]))>1) {
                                $filter=explode('#',Routes::$filter[$k])[0];
                                $filter_func=explode('#',Routes::$filter[$k])[1];

                                //include_once(dirname(__FILE__).'/../app/filter/'.$filter.'.php');

    //                            if(sizeof(explode('/', $filter))>0) {
    //                                $filter=explode('/', $filter)[sizeof(explode('/', $filter))-1];
    //                            }

                                $filter = str_replace('/', '\\',$filter);
                                $filter = 'App\\Filters\\'.$filter;

                                $data=call_user_func(array($filter, $filter_func), $data);
                            }
                            else {
                                $filter=Routes::$filter[$k];
                                //include_once(dirname(__FILE__).'/../app/filter/'.$filter.'.php');
    //                            if(sizeof(explode('/', $filter))>0) {
    //                                $filter=explode('/', $filter)[sizeof(explode('/', $filter))-1];
    //                            }

                                $filter = str_replace('/', '\\',$filter);
                                $filter = 'App\\Filters\\'.$filter;

                                $con=new $filter;
                                $data=call_user_func(array($con, 'index'), $data);
                            }
                        }
                    }

    //                if(sizeof(explode('/', $class_name))>0) {
    //                    $class_name=explode('/', $class_name)[sizeof(explode('/', $class_name))-1];
    //                }
                    $class_name = str_replace('/', '\\',$class_name);
                    $class_name = 'App\\Controllers\\'.$class_name;


                    $con=new $class_name;
                    if(sizeof($data)>0) {
                        call_user_func(array($con, $func_name), $data);
                    }
                    else {
                        $con->$func_name();
                    }
                }
                else {
                    //include_once(dirname(__FILE__).'/../app/controller/'.$v.'.php');

                    if(Routes::$filter[$k]!='') {
                        if(sizeof(explode('/', Routes::$filter[$k]))>0) {
                            if(sizeof(explode('#',Routes::$filter[$k]))>1) {
                                $filter=explode('#',Routes::$filter[$k])[0];
                                $filter_func=explode('#',Routes::$filter[$k])[1];

                                //include_once(dirname(__FILE__).'/../app/filter/'.$filter.'.php');

    //                            if(sizeof(explode('/', $filter))>0) {
    //                                $filter=explode('/', $filter)[sizeof(explode('/', $filter))-1];
    //                            }

                                $filter = str_replace('/', '\\',$filter);
                                $filter = 'App\\Filters\\'.$filter;

                                $data=call_user_func(array($filter, $filter_func), $data);
                            }
                            else {
                                $filter=Routes::$filter[$k];
                                //include_once(dirname(__FILE__).'/../app/filter/'.$filter.'.php');
    //                            if(sizeof(explode('/', $filter))>0) {
    //                                $filter=explode('/', $filter)[sizeof(explode('/', $filter))-1];
    //                            }


                                $filter = str_replace('/', '\\',$filter);
                                $filter = 'App\\Filters\\'.$filter;

                                $con=new $filter;
                                $data=call_user_func(array($con, 'index'), $data);
                            }
                        }
                    }

    //                if(sizeof(explode('/', $v))>0) {
    //                    $v=explode('/', $v)[sizeof(explode('/', $v))-1];
    //                }

                    $v = str_replace('/', '\\',$v);
                    $v = 'App\\Controllers\\'.$v;
                    $con=new $v;
                  //   //$class = new ReflectionClass($con);
                  //   $class = new ReflectionMethod($v, 'addUserAction');
                  //   //print_r($class->getMethods('addUser')->getParameters());
                  // //print_r($class->getParameters());
                  //   $params = $class->getParameters();
                  //   foreach ($params as $param) {
                  //       //$param is an instance of ReflectionParameter
                  //       echo $param->getName();
                  //       //echo $param->isOptional();
                  //   }
                  //   exit;
                    if(sizeof($data)>0) {
                        call_user_func(array($con, 'index'), $data);
                    }
                    else {
                        $con->index();
                    }
                }
            }
            else {
                http_response_code(404);
                Core\View::loadView('route-404');
            }
        }
    }
}
?>
