<?php

// bootstrap wrapper.
require_once('private/includes/bootstrap.include.php');

/**
 * TODO:
 * change this to production / dev environments.
 */
if (DEBUG_MODE) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL && ~E_NOTICE && ~E_DEPRECATED);
}

// apply site encoding.
mb_internal_encoding(SITE_ENCODING);

// set the timezone of the server.
TimeManager::setTimezone(TIMEZONE);

// Route Manager for route hooking
require_once(CORE_PATH . 'Routes.php');

// instantiate the router.
$routeController = new RouteController;
$safe_uri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
$routeController->process(array($safe_uri));
$routeController->render();
