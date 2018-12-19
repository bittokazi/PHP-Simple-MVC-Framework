<?php
namespace App\Models;

use Core\Model;
use Core\Auth;

class User extends Model {
    public function verify_login($un, $pw) {
        
        $data=array($un, Auth::CryptBf($pw));
        
        $result=$this->DB()->prepared_select('SELECT * FROM user WHERE username=? and password=?', 'ss', $data);
        
        return $result;
    
    }
    public function get_user($un) {
        
        $data=array($un);
        
        $result=$this->DB()->prepared_select('SELECT user_role.title as role, user_status.title as status FROM user LEFT JOIN user_role ON user.role=user_role.id LEFT JOIN user_status ON user.status=user_status.id WHERE user.username=?', 's', $data);
        
        return $result;
    
    }
    
    public function get_user_email($email) {
        
        $data=array($email);
        
        $result=$this->DB()->prepared_select('SELECT user_role.title as role, user_status.title as status FROM user LEFT JOIN user_role ON user.role=user_role.id LEFT JOIN user_status ON user.status=user_status.id WHERE user.email=?', 's', $data);
        
        return $result;
    
    }
    
    public function all() {
        
        return $this->DB()->prepared_select('SELECT *, user.id as id FROM user INNER JOIN user_role ON user.role=user_role.id ORDER BY user.id DESC', '', array());
    
    }
    
    public function get_user_by_id($id) {
        
        return $this->DB()->prepared_select('SELECT *, user.id as id FROM user INNER JOIN user_role ON user.role=user_role.id WHERE user.id=?', 'i', array($id));
        
    }
    
    public function get_user_role_all() {
        
        $r=$this->DB()->prepared_select('SELECT * FROM user_role');
        
        return $r;
        
    }
    
    public function save($data) {
        
        $sql = "INSERT INTO user (username, password, email, firstname, lastname, status, role) VALUES(?,?,?,?,?,?,?)";
        
        return $this->DB()->prepared_insert($sql, 'sssssss', $data);
    
    }
    
    public function update($data) {
        
        $sql = "UPDATE user SET email=?, firstname=?, lastname=?, status=?, role=? WHERE id=?";
        
        return $this->DB()->prepared_update($sql, 'sssssi', $data);
    
    }
    
    public function delete($id) {
        
        $sql = "DELETE FROM user WHERE id=?";
        
        return $this->DB()->prepared_delete($sql, 'i', array($id));
    
    }
    
}
?>