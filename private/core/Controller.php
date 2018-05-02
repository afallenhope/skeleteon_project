<?php
/**
 * Undocumented class
 * 
 * @abstract process(&$params);
 * @method void render([$view ='']);
 * @method void redirect($url);
 */
abstract class Controller {

  protected $data = array();
  protected $head = array('title' => APP_NAME, 'description' => 'Project Description');
  protected $view = '';
  /**
   * process(& $_REQUEST)
   * 
   * @abstract
   * @param array $params;
   */
  abstract function process( $params);

  /**
   * render($view='')
   *
   * @param string $view
   * @return void
   * @example render('index'); renders index view
   */
  public function render($view = NULL) {
    if (!empty($this->view) && !is_null($this->view)) 
      $view = $this->view;
     
    $safe_view = filter_var($view, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH );
    $req_path = sprintf('%s%s',VIEWS_PATH,$safe_view);
    
    preg_match('/\.([0-9a-zA-Z]{3})$/',$req_path,$matches);
    $ext = (count($matches)>=1) ? $matches[1] : '.phtml';
    
    $safe_path = sprintf("%s%s",$req_path, $ext);
    
    if (empty($view) || is_null($view)) return;

    if(! file_exists($safe_path))
     throw new Exception('Invalid View Selected');
    extract($this->data);    
    require_once($safe_path);
  }


  /**
   * redirect($url)
   *
   * @param string $url
   * @return void
   * @example $this->redirect('/error'); redirects the user.
   */
  public function redirect($url) {    
    // Close session information
    if (session_id() != "")
      session_write_close();
    
    header('Location: '. $url);
    header('Connection: Close');
    exit;
  }
  
  protected function assign($name,$value) {
    $this->data[$name] = $value;
  }  
}
