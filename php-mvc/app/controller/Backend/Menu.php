<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\URL;

class Menu {
    public function get_menu($role, $status) {
        $menu=array();
        if($role==1) {
            $menu[]=array('title'=>'Dashboard', 'link'=>URL::to('dashboard'), 'icon'=>'<i class="fa fa-dashboard"></i>');
            $menu[]=array('title'=>'Users', 'link'=>URL::to('dashboard/users'), 'icon'=>'<i class="fa fa-users">                 </i>','submenu'=>array(
                array('title'=>'All Users', 'link'=>URL::to('dashboard/users'), 'icon'=>'<i class="fa fa-users"></i>'),
                array('title'=>'Add Users', 'link'=>URL::to('dashboard/users/addUser'), 'icon'=>'<i class="fa fa-user"></i>'),
                array('title'=>'My Profile', 'link'=>URL::to('dashboard/users/profile'), 'icon'=>'<i class="fa fa-user"></i>'),
                array('title'=>'User Status', 'link'=>URL::to('dashboard/users/user_status'), 'icon'=>'<i class="fa fa-key"></i>'),
                array('title'=>'User Role', 'link'=>URL::to('dashboard/users/user_role'), 'icon'=>'<i class="fa fa-sort-amount-asc"></i>')
            ));
        }
        else if($role==2) {
            $menu[]=array('title'=>'Dashboard', 'link'=>URL::to('dashboard'), 'icon'=>'<i class="fa fa-dashboard"></i>');
            $menu[]=array('title'=>'My Profile', 'link'=>URL::to('dashboard/users/profile'), 'icon'=>'<i class="fa fa-user"></i>');
        }
        return $menu;
    }
    public function show_menu($menu) {
        
    }
}
?>