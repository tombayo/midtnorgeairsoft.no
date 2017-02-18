<?php declare(strict_types=1);
/**
 * PIPless v1.1.0
 * 
 * @link https://github.com/tombayo/PIPless
 * 
 * @author Tom Andre Munkhaug, @tombayo <me@tombayo.com>
 * @license GPLv3
 * 
 * @package pipless
 * 
 */

/**
 * A constant for the project's root directory
 */
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
/**
 * A constant for the application directory
 */
define('APP_DIR', ROOT_DIR .'application/');

/**
 * Load the config file
 */
require(APP_DIR .'config/config.php');
/**
 * Load the system-files
 */
require(ROOT_DIR .'system/Controller.php');
require(ROOT_DIR .'system/Load.php');
require(ROOT_DIR .'system/Model.php');
require(ROOT_DIR .'system/View.php');
/**
 * Loads PIPless' main system file 
 */
require(ROOT_DIR .'system/PIPless.php');

/**
 * @global array $config
 */
global $config;
/**
 * A constant for the project's base url.
 */
define('BASE_URL', $config['base_url']);

/**
 * Sets the ini-file's display_errors variable and sets our error-reporting level.
 * Prevents the webserver's setting to cause unwanted behavior in our application.
 */
if ($config['report_errors']) {
  ini_set("display_errors", "1");
  error_reporting(-1);
} else {
  ini_set("display_errors", "0");
  error_reporting(0);
}

/**#@+
 * Set the session settings
 */
$session_lifetime = 60*60*24*31;
session_start(['gc_maxlifetime'=>$session_lifetime]);
setcookie(session_name(),session_id(),time()+$session_lifetime,"/","",$config['force_https'],true);
/**#@-*/

/**
 * Loads all the defined extras
 */
foreach($config['include_extras'] as $extra) {
  require(APP_DIR .'extras/'.$extra.'.php');
}

// Force redirection to HTTPS
$https = $_SERVER['HTTPS'] ?? 'off';
if($https == 'off' && $config['force_https']) {
  header('Location: '.BASE_URL);
  exit;
}

// Execute the application
PIPless::go();