<?php

class RouteManager {
  protected static $hooks = array();
  public static function hook($route, $callback) {
    static::$hooks[$route] = $callback;
  }

  public static function hasHook($route) {
    return !empty(static::$hooks[$route]);
  }

  public static function proceed($route, $params = array()) {
    call_user_func(static::$hooks[$route], $params);
  }

  public static function halt($route) {
    if (!headers_sent()){
       header('HTTP/1.1 403 Unauthorized', TRUE, 403);
       exit;
    }
  }
}