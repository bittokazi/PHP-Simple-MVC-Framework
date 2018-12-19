<?php
namespace App\Controllers\Backend;

use Core\Controller;

class dashboard extends Controller {
    public function index($data) {
        return $this->view()->load('Backend/index', $data);
    }
}
?>