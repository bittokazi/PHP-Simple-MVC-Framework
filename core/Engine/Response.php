<?php
namespace Core;

class Response {
    public static function Redirect($url) {
        header('Location: '.(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".(dirname($_SERVER['PHP_SELF'])=='\\' ? '' : dirname($_SERVER['PHP_SELF']))."/$url");
        exit();
    }
    public static function FlushRedirect($url, $name, $data=array()) {
        $_SESSION['flush_data'][$name] = json_encode($data, true);
        header('Location: '.(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".(dirname($_SERVER['PHP_SELF'])=='\\' ? '' : dirname($_SERVER['PHP_SELF']))."/$url");
        exit();
    }
}
?>