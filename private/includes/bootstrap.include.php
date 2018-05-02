<?php
require_once('config.include.php');

/**
 * Autoload classes, with file checking.
 *
 * @param string $class - class being requested
 * @return void
 */
function bootstrap_module ($class) {
  $path = CLASSES_PATH;
  if ( $class === 'Controller' || $class === 'Service' || $class === 'Model' ) {
    $path = CORE_PATH;    
  } elseif ( preg_match('/Controller$/', $class) ) {
    $path = CONTROLLERS_PATH;
  } elseif ( preg_match('/Service$/', $class) ) {
    $path = SERVICES_PATH;
  } elseif ( preg_match('/(Model|Result)$/', $class) ) {
    $path = MODELS_PATH;
  } else { 
    if(file_exists( CLASSES_PATH . $class . '.php'))   $path = CLASSES_PATH;
    elseif(file_exists( MODELS_PATH . $class . '.php')) $path = MODELS_PATH;
    elseif(file_exists( SERVICES_PATH . $class . '.php')) $path = SERVICES_PATH;
    else {
      $x = file_exists(MODELS_PATH . $class . '.php');      
      throw new RuntimeException('Cannot find selected class! ' . $class. ' ' . $x);
    }
  }

   try {
     require_once(sprintf('%s%s.php', $path, $class));     
   } catch(Exception $ex) {
    exit($ex->getMessage());
   }
}

spl_autoload_register('bootstrap_module');
require_once( CORE_PATH . 'Routes.php');
