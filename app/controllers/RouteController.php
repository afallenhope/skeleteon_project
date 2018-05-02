<?php
class RouteController extends Controller {

  protected $controller;

  /**
   * processes the request.
   *
   * @param mixed $params params being passed 
   * @param boolean $isSubDir is this app in a subdirectory
   * @param string $subDir the subdirectory name
   * @return void
   */
  public function process($params, $isSubDir = FALSE, $subDir = '/' ) {
    $path = ($isSubDir) ? substr($params[0], stripos($params[0],$subDir)+ strlen($subDir)) : $params[0];
    $paths = $this->parseUrl($path);

    if (empty($paths[0])) $this->redirect(($isSubDir)? $subDir . '/main' : '/main');

    $route = array_shift($paths);
    $controller = $this->symbolToCamel($route) . 'Controller';
    try {
      if(file_exists(CONTROLLERS_PATH . $controller . '.php')) {
        $this->controller = new $controller;
        $this->controller->process($paths);
        $this->data['title'] = $this->controller->head['title'];
        $this->data['description'] = $this->controller->head['description'];
        $this->view = 'layout';
        $this->route = $route;
        $this->paths = $paths;
      } elseif (RouteManager::hasHook($route)) {
        RouteManager::proceed($route);
      }
      
      // $this->pdo = DatabaseManager::connect();
    } catch(Exception $ex) {
      $this->redirect(($isSubDir)? $subDir . '/error' : '/error');
    }
  }

  /**
   * converts a request into an array.
   *
   * @param string $url
   * @return array
   */
  private function parseUrl($url) {
    $parsed_url = parse_url($url);
    $parsed_url['path'] = ltrim($parsed_url['path'],'/');
    $parsed_url['path'] = rtrim($parsed_url['path']);
    $exploded_url = explode('/', $parsed_url['path']);
    return $exploded_url;
  }

  /**
   * converts to camelcase.
   *
   * @param string $url
   * @return string
   */
  private function symbolToCamel($url) {
    $url = preg_replace('/[^0-9a-zA-Z ]/', ' ',$url);
    if (is_array($url)) implode(' ', $url );
    $url = ucwords($url);
    $url = str_replace(' ', '', $url);
    return $url;
  }
}