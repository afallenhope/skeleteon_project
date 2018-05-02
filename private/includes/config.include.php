<?php

// App Settings
$app_name         = 'YOUR APP NAME';
$app_icon         = 'FONTAWESOME ICON';
$timezone         = 'America/Toronto';
$charset          = 'utf-8';
$debug_mode       = TRUE;
$use_composer     = FALSE;
/////////////////////////////////////////

// App Paths
$root_path        = ''; // change this if you're using a subdomain/folder.
$app_path         = 'app';
$views_path       = 'views';
$controllers_path = 'controllers';
$services_path    = 'services';
$classes_path     = 'classes';
$models_path      = 'models';

$private_path     = 'private';
$public_path      = 'public';
$assets_path      = 'public/assets';
$bootstrap_path   = 'public/assets/bootstrap';    // default css framework.
$fontawesome_path = 'public/assets/fontawesome';  // default for icons.
$core_path        = 'core';
$includes_path    = 'includes';
/////////////////////////////////////////////

// Database Information.
$db_driver        = 'sqlsrv';
$db_host          = '';
$db_name          = '';
$db_user          = '';
$db_password      = '';
$db_dsn           = 'sqlsrv:Server=' . $db_host .';Database=' . $db_name . ';';

/**
 * CORE Paths.
 */
define('SERVER_ROOT',      $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR);
define('ROOT_PATH',        SERVER_ROOT . $root_path . DIRECTORY_SEPARATOR);
define('PRIVATE_PATH',     ROOT_PATH . $private_path . DIRECTORY_SEPARATOR);
define('PUBLIC_PATH',      ROOT_PATH . $public_path . DIRECTORY_SEPARATOR);
define('ASSETS_PATH',      PUBLIC_PATH . $assets_path . DIRECTORY_SEPARATOR);
define('BOOTSTRAP_PATH',   ASSETS_PATH . $bootstrap_path . DIRECTORY_SEPARATOR);
define('FONTAWESOME_PATH', ASSETS_PATH . $fontawesome_path . DIRECTORY_SEPARATOR);
define('INCLUDES_PATH',    PRIVATE_PATH . $includes_path . DIRECTORY_SEPARATOR);
define('CORE_PATH',        PRIVATE_PATH  . $core_path . DIRECTORY_SEPARATOR);

/**
 * App Paths
 */
define('APP_PATH', ROOT_PATH . $app_path . DIRECTORY_SEPARATOR);
define('CONTROLLERS_PATH', APP_PATH .  $controllers_path . DIRECTORY_SEPARATOR);
define('SERVICES_PATH', APP_PATH .  $services_path . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', APP_PATH .  $views_path . DIRECTORY_SEPARATOR);
define('MODELS_PATH', APP_PATH .  $models_path . DIRECTORY_SEPARATOR);
define('CLASSES_PATH', APP_PATH .  $classes_path . DIRECTORY_SEPARATOR);

/**
 * DB Stuff
 */
define('DB_DRIVER', $db_driver);
define('DB_HOST', $db_host);
define('DB_SCHEMA', $db_name );
define('DB_USER', $db_user);
define('DB_PASSWORD', $db_password);
define('DB_DSN', $db_dsn);



/**
 * App Settings
 */
define('TIMEZONE', $timezone);
define('SITE_ENCODING', $charset);
define('DEBUG_MODE', $debug_mode);
define('APP_NAME', $app_name);
define('APP_ICON', $app_icon);
