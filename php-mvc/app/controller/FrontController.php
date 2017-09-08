<?php
namespace App\Controllers;

use Core\Controller;

class FrontController extends Controller {
    public function index() {
        echo URL::HOME_URL().'<br>';
        //var_dump($this->dba);
        $re=$this->DB()->select('SELECT * FROM category');
        foreach($re as $r) {
            echo $r['id'];
        }
        //var_dump($this->db());
    }
    public function get() {
        echo '<form action="" method="post"><input name="title" /><input type="submit"/></form>';
    }
    public function post() {
        echo Request::post('title');
    }
    public function get_id($id) {
        $this->view()->Style()->addStyle('style');
        $this->view()->Script()->addScript('cush');
        $this->view()->Script()->addScriptFoot('cusf');
        $data=array();
        $data['i']=$id['id'];
        //$data['i']=Request::get('id');
        
        $this->model('get_cat');
        $gc=new get_cat();
        $data['ids']=$gc->get_id();
        $this->view()->load('home',$data);
    }
    public function get_r($data) {
        echo Request::get('id');
        print_r($data);
    }
}
?>