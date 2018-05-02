<?php
class MainController extends Controller {
  public function process($params) {
    $this->head = array('title' => APP_NAME , 'description' => 'Your description here');
    $this->assign('header', 'Main Page');
    $this->view ='main/index';
  }
}