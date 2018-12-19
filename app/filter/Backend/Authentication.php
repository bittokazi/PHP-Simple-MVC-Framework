<?php
namespace App\Filters\Backend;

use Core\Filter;
use Core\Response;
use Core\URL;
use App\Controllers\Backend\Menu;
use App\Models\User;

class Authentication extends Filter {
    public $role;
    public $access=false;
    public $title='Not Found';
    public function index($data) {
        if(isset($_SESSION['username'])) {
            $data->username=$_SESSION['username'];
            $m=new Menu();
            $menu=$m->get_menu($_SESSION['userrole'], $_SESSION['userstatus']);
            $data->usermenu=$menu;
            
            $this->check_access($menu);
            $data->page_title=$this->title;
            
            $user=new User();
            $result=$user->get_user($_SESSION['username']);
            $data->userrole=$result->role;
            $data->userstatus=$result->status;
        }
        else {
            return Response::Redirect('dashboard/login');
        }
        return $data;
    }
    function check_access($menu) {
        foreach($menu as $m) {
            if($m['link']==URL::current_url()){
                $this->title=$m['title'];
                break;
            }
            if(isset($m['submenu'])) {
                $this->check_access($m['submenu']);
            }
        }
    }
}
?>