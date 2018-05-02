<?php
class ErrorController extends Controller {
  function process( $param) {
    header('HTTP/1.1 404 Not Found', FALSE,404);
    $this->head['title'] = 'Error 404';
    $this->assign('erro_no', 404);
    $this->assign('err_str', 'Page not found');
    $this->assign('err_desc', 'The resource you are looking for is gone or we hid it from you.');    
    $this->view = 'error/404';
  }
}