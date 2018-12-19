<?php
namespace App\Controllers\Frontend;

use Core\Controller;
use Core\Request;
use Core\Response;

class FrontPageController extends Controller {
  public function index() {
      $this->view()->load('Frontend/front-page');
  }
}

?>
