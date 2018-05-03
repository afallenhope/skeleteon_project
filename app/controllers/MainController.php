<?php
class MainController extends Controller {

  
  protected function Index($params) {    
    $this->view ='main/index';
  }
  public function process($params) {
    $this->head = array('title' => APP_NAME , 'description' => 'Your description here');
    $this->assign('header', 'Main Page');
    $this->view ='main/index';
    $links = array(
      array('text'=>'Home','href'=>'/'),
      array('text'=>'Services','href'=>'/services'),
      array('text'=>'Contact','href'=>'/contact'),
      array('text'=>'Help','href'=>'/help'),
    );

    $this->assign('links', $links);
    $action = (!empty($params))? array_shift($params) : $params;
    if ($index = array_search(ucwords($action),get_class_methods(__CLASS__)) !== FALSE){      
      call_user_func(array($this,$action), $params);
    } else {
      call_user_func(array($this,'Index'), $params);
    }
  }
}
