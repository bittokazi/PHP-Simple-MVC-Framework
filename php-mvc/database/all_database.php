<?php
namespace Database;

use Core\Database;
use Core\Auth;

class all_database extends Database {
    public function install() {
        $this->query('CREATE TABLE user (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                firstname VARCHAR(30),
                lastname VARCHAR(30),
                status VARCHAR(30),
                role VARCHAR(30)
                )');
        
        $this->query('CREATE TABLE user_status (
                id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL UNIQUE
                )');
        
        $this->query('CREATE TABLE user_role (
                id INT(3) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL UNIQUE
                )');
        
        $this->query('CREATE TABLE user_notes (
                id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL UNIQUE,
                content TEXT
                )');
        
    }
    public function seed() {
        $this->query("INSERT INTO user_status VALUES('', 'Active')");
        $this->query("INSERT INTO user_role VALUES('', 'Administrator')");
        $this->query("INSERT INTO user_role VALUES('', 'User')");
        $this->query("INSERT INTO user VALUES('', 'admin', '".Auth::CryptBf('password')."', 'bitto.kazi@gmail.com', 'N/A',          'N/A', '1', '1')");
        $this->query("INSERT INTO user VALUES('', 'user', '".Auth::CryptBf('password')."', 'bitto.kazi1@gmail.com', 'N/A',          'N/A', '1', '2')");
    }
    public function uninstall() {
        $this->query('DROP TABLE user_status');
        $this->query('DROP TABLE user_role');
        $this->query('DROP TABLE user');
        $this->query('DROP TABLE user_notes');
    }
}
?>