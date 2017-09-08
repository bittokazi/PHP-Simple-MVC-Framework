<?php
namespace App\Controllers\Backend;

use Core\Controller;
use Core\Response;
use Core\Request;
use Core\Validation;
use Core\Auth;
use App\Models\User;

class Users extends Controller {
    
    private $user;
    
    function __construct() {
        
        $this->user = new User();
        
    }
    
    public function index($data) {
        
        if($data->userrole=='Administrator') ;
        
        else return Response::Redirect('dashboard');
        
        return $this->view()->load('Backend/user_list')
                            ->with($data, 'data')
                            ->with($this->user->all(), 'users');
        
    }
    public function my_profile($data) {
        
    }
    public function addUser($data) {
        
        if($data->userrole == 'Administrator') ;
        
        else return Response::Redirect('dashboard');
        
        return $this->view()->load('Backend/addUser')
                            ->with($data, 'data')
                            ->with($this->user->get_user_role_all(), 'roles');
        
    }
    
    public function addUserAction($data) {
        
        if($data->userrole == 'Administrator') ;
        
        else return Response::Redirect('dashboard');
        
        $user_data1 = array(Request::post('username'), Auth::CryptBf(Request::post('password')), Request::post('email'),                          Request::post('fname'), Request::post('lname'), Request::post('role'));
        
        $user_data = array(Request::post('username'), Auth::CryptBf(Request::post('password')), Request::post('email'),                          Request::post('fname'), Request::post('lname'), Request::post('status'), Request::post('role'));
        
        if(Validation::notEmptyArray($user_data1) || Request::post('password')=='') {
        
            $message['error'] = array('Empty Fields');

            $message['data'] = $user_data;

            return Response::FlushRedirect('dashboard/users/addUser', 'data', $message);
        
        }
        
        else {
            
            if($this->user->save($user_data)) {

                $data->success='User Created Successfully';  

                return $this->view()->load('Backend/user_list')
                                    ->with($data, 'data')
                                    ->with($this->user->all(), 'users');

            }

            else {
                
                if($this->user->get_user(Request::post('username'))) $message['error'][] = 'Username Already Exist';
                
                if($this->user->get_user_email(Request::post('email'))) $message['error'][] = 'Email Already Exist';

                $message['data'] = $user_data;

                return Response::FlushRedirect('dashboard/users/addUser', 'data', $message);

            }
            
        }
        
    }
    
    public function editUser($data) {
        
        if($data->userrole == 'Administrator') ;
        
        else return Response::Redirect('dashboard');
        
        $r = $this->user->get_user_by_id($data->id);
        
        if(sizeof($r)>0) {
            
            $data->data['data']=array();
            
            foreach($r as $k => $v)
            
                $data->data['data'][] = $v;
            
        }
        
        $data->page_title = "Edit User";
        
        return $this->view()->load('Backend/editUser')
                            ->with($data, 'data')
                            ->with($this->user->get_user_role_all(), 'roles');
        
    }
    
    public function editUserAction($data) {
        
        if($data->userrole == 'Administrator') ;
        
        else return Response::Redirect('dashboard');
        
        $user_data = array(Request::post('email'), Request::post('fname'), Request::post('lname'),                                              Request::post('status'), Request::post('role'), Request::post('id'));
        
        if($this->user->update($user_data)) {
        
            $data->success='User Updated Successfully';  
        
            return $this->view()->load('Backend/user_list')
                                ->with($data, 'data')
                                ->with($this->user->all(), 'users');
        
        }
        
        else {
            
            $message->error = array('Username or Email Exist');
            
            return Response::FlushRedirect('dashboard/users/edit/'.$data->id, 'data', $message);
        
        }
        
    }
    
    public function delete($data) {
        
        if($data->userrole == 'Administrator') ;
        
        else return Response::Redirect('dashboard');
        
        if($data->username==$this->user->get_user_by_id($data->id)->username) {
            
            $data->error='You Can Not Delete Yourself!!! Forget It Mr/Mrs or Whoever you are :p';
            
        }
        
        else if(isset($data->id)) {
            
            if($this->user->delete($data->id)) {
                
                $data->success='User Delete Successfully';
                
            }
            
            else {
                
                $data->error='Error Occured';
                
            }
            
        }
        
        else {
            
            $data->error='Not Found!!!';
            
        }
        
        return $this->view()->load('Backend/user_list')->with($data, 'data')->with($this->user->all(), 'users');
        
    }
    
}
?>