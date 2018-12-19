<?php
namespace Core;

use PDO;

class Database {
    public static $db_type;
    public static $mysqli;
    public static $pdo;
    function __construct() {

    }
    public static function mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) {
        Database::$mysqli=@mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
        if (!Database::$mysqli) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
	}
    public static function pdo($host, $user, $pass, $db) {
        $charset = 'utf8';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        Database::$pdo = new PDO($dsn, $user, $pass, $opt);
    }
    public static function Get($db) {
        if($db=='mysqli') {
            return Database::$pdo;
        }
    }
    public static function connect_db($db) {
        $this->db_type=$db;
        if($db=='mysqli') {
            Database::$db();
        }
    }
    public static function select($sql) {
        if(Database::$db_type=='mysqli') {
            $rows=array();
            $result=Database::$mysqli->query($sql);
            if($result) {
                if($result->num_rows==1) {
                    while($row = $result->fetch_assoc()) {
                        $rows=$row;
                    }
                }
                else if($result->num_rows>0) {
                    while($row = $result->fetch_assoc()) {
                        $rows[]=$row;
                    }
                }
            }
            return json_decode(json_encode($rows));
        }
    }
    public static function query($sql) {
        if(Database::$db_type=='mysqli') {
            return Database::$mysqli->query($sql);
        }
    }
    // public static function insert($sql) {
    //     if(Database::$db_type=='mysqli') {
    //         return Database::$mysqli->query($sql);
    //     }
    // }
    // public static function update($sql) {
    //     if(Database::$db_type=='mysqli') {
    //         return Database::$mysqli->query($sql);
    //     }
    // }
    // public static function delete($sql) {
    //     if(Database::$db_type=='mysqli') {
    //         return Database::$mysqli->query($sql);
    //     }
    // }
    public static function prepared_select($sql, $prm='', $data=array()) {
        $rows=array();
        $stmt = Database::$mysqli->prepare($sql);
        //$stmt->bind_param($prm, $un, Auth::CryptBf($pw));
        if($prm!='') {
            $a_params=array();
            $n = count($data);
            $a_params[] = &$prm;
            for($i = 0; $i < $n; $i++) {
                $a_params[] = &$data[$i];
            }
            call_user_func_array(array($stmt, 'bind_param'), $a_params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        if($result) {
            if($result->num_rows==1) {
                while($data = $result->fetch_assoc()){
                    $rows=$data;
                }
            }
            else if($result->num_rows>0) {
                while($data = $result->fetch_assoc()){
                    $rows[]=$data;
                }
            }
        }
        return json_decode(json_encode($rows));
    }
    public static function prepared_insert($sql, $prm='', $data=array()) {
        $stmt = Database::$mysqli->prepare($sql);
        if($prm!='') {
            $a_params=array();
            $n = count($data);
            $a_params[] = &$prm;
            for($i = 0; $i < $n; $i++) {
                $a_params[] = &$data[$i];
            }
            call_user_func_array(array($stmt, 'bind_param'), $a_params);
        }
        return $stmt->execute();
    }
    public static function prepared_delete($sql, $prm='', $data=array()) {
        $stmt = Database::$mysqli->prepare($sql);
        if($prm!='') {
            $a_params=array();
            $n = count($data);
            $a_params[] = &$prm;
            for($i = 0; $i < $n; $i++) {
                $a_params[] = &$data[$i];
            }
            call_user_func_array(array($stmt, 'bind_param'), $a_params);
        }
        return $stmt->execute();
    }
    public static function prepared_update($sql, $prm='', $data=array()) {
        $stmt = Database::$mysqli->prepare($sql);
        if($prm!='') {
            $a_params=array();
            $n = count($data);
            $a_params[] = &$prm;
            for($i = 0; $i < $n; $i++) {
                $a_params[] = &$data[$i];
            }
            call_user_func_array(array($stmt, 'bind_param'), $a_params);
        }
        return $stmt->execute();
    }

    public static function pdo_select($sql, $data=array()) {
        $rows=array();
        $stmt = Database::$pdo->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchAll();
        if(sizeof($result)>0) {
            foreach ($result as $r)
            {
                $rows[]=$r;
            }
        }
        return json_decode(json_encode($rows));
    }
    public static function pdo_selectOne($sql, $data=array()) {
        $rows = array();
        $stmt = Database::$pdo->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchAll();
        if(sizeof($result)>0) {
            foreach ($result as $r)
            {
                $rows=$r;
                break;
            }
        }
        return json_decode(json_encode($rows));
    }
    public static function pdo_insert($sql, $data=array()) {
        $rows=array();
        try {
            $stmt = Database::$pdo->prepare($sql);
            //return $stmt->execute($data);
            $stmt->execute($data);
            return Database::$pdo->lastInsertId();
        }
        catch (PDOException $e) {

        }
        catch (Exception $e) {

        }
    }
    public static function pdo_update($sql, $data=array()) {
        $rows=array();
        try {
            $stmt = Database::$pdo->prepare($sql);
            return $stmt->execute($data);
        }
        catch (PDOException $e) {

        }
        catch (Exception $e) {

        }
    }
    public static function pdo_delete($sql, $data=array()) {
        $rows=array();
        try {
            $stmt = Database::$pdo->prepare($sql);
            return $stmt->execute($data);
        }
        catch (PDOException $e) {

        }
        catch (Exception $e) {

        }
    }
}
?>
