# PHP Simple Model View Control(MVC) Framework

Simple Model View and Control Framework Built on PHP.

  - Define Routes With Specfic Controller Class Method
  - Define All Configuration in a single config File
  - Database Migration Feature
  - Database Seed Option
  - Install, Uninstall, Seed Database with specific link in Development Mode
  - Filter option works as middleware
  - Moduler Option, add New Features to the Framework as Module
  - Module Configuragtion file (Dont want to use a module? just deactivate it)
  - Namespacing for every class file
  - Interceptor Feature added for modules(Intercepts even before filters)
  - Add View file as you want and call it from controller method

# Upcoming Features!

  - ORM module for easier database operation
  - Templating Engine Module.



### Installation

Just Copy and Paste where you want to run the application and start development!

All the request will go to /public folder

Define Database Migration classes in "database" folder and browse these URLs for Install, Uninstall and Seed (Works in Development mode only)
```sh
Install -> http://localhost/php-mvc/public/install.mvc
Uninstall -> http://localhost/php-mvc/public/uninstall.mvc
Seed -> http://localhost/php-mvc/public/seed.mvc
```

### Route Declare

Declare Routes for Request in "config/routes.php" file (GET/POST Supported Currently). Example

Routes::get(contoller, link);
Routes::get(contoller#method, link);
Routes::get(contoller#method, link, filter);

```sh
<?php
Routes::get('FrontController', '/');
Routes::get('FrontController#get_id', '/?id');
Routes::get('FrontController#get', '/home/go');
Routes::post('FrontController#post', '/home/go');
Routes::get('FrontController#get_id', '/idea/?id');*/
Routes::get('FrontController#get_r', '/home/id/?id/r/?r');

Routes::get('Backend/Login', '/dashboard/login');
Routes::post('Backend/Login#check_login', '/dashboard/login');
Routes::get('Backend/Login#logout', '/dashboard/logout');
Routes::get('Backend/Dashboard', '/dashboard', 'Backend/Authentication');
?>
```


### Database Migration file

All database Migration class Files will go in "database/" folder. Example Database Migration Class

```sh
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
```

You can use prepared statements like this example in Model files

```sh
<?php
namespace App\Models;

use Core\Model;
use Core\Auth;

public function all() {
        
        return $this->DB()->prepared_select('SELECT *, user.id as id FROM user INNER JOIN user_role ON user.role=user_role.id', '', array());
    
    }
?>
```