<?php
namespace App\Controllers\Backend;

use Core\Controller;
use App\Models\User;
use Core\Request;
use Core\Response;

class Login extends Controller {
    public function index() {
        $this->view()->load('Backend/Admin-Login');
    }
    public function check_login() {
        $d=array();
        $user=new User();
        $result=$user->verify_login(Request::post('username'),Request::post('password'));
        if(sizeof($result)>0) {
            if($result->status!=0) {
                $_SESSION['username']=$result->username;
                $_SESSION['userrole']=$result->role;
                $_SESSION['userstatus']=$result->status;
                $d['success']='yes';
            }
            else {
                $d['success']='disabled';
            }
        }
        else {
            $d['success']='no';
        }
        echo json_encode($d);
    }
    public function logout() {
        $_SESSION = array();
        return Response::Redirect('dashboard/login');
    }
}
?>