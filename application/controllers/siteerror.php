<?php declare(strict_types=1);
/**
 * The main error-controller. Gets called whenever the application generates errors.
 *
 *
 * @package mna
 * @subpackage controllers
 *
 * @author Tom Andre Munkhaug <me@tombayo.com>
 */
class siteerror extends Controller {
	
  /**
   * Gets called whenever an error occurs on the webpage.
   * 
   * Handles the errors by calling the appropriate function. The default is 500.
   * Also logs the error using logerror()
   * 
   * @param Throwable $error
   */
	public static function index(Throwable $error = null) {
	  if (!is_null($error)) {
	    self::logerror($error);
	    
  	  switch($error->getCode()) {
  	    case 404:
  	      self::error404($error);
  	      break;
  	    default:
  	      self::error500($error);
  	  }
	  } else {
	    parent::redirect('');
	  }
	}
	
	/**
	 * Deals with a 404 error.
	 * 
	 * @param Throwable $error
	 */
	private static function error404(Throwable $error) {
	  http_response_code(404);
    echo '<h1>404 Error</h1>';
		echo '<p>Looks like this page doesn\'t exist.</p>';
	}
	
	/**
	 * Deals with a 500 error.
	 * 
	 * @param Throwable $error
	 */
	private static function error500(Throwable $error) {
	  global $config;
	  http_response_code(500);
	  echo '<h1>500 Error</h1>';
	  echo '<p>Looks like the server has encountered a problem. Please try again later.</p>';
	  if ($config['report_errors']) echo '<p>' . $error . '</p>';
	}
	
	/**
	 * Logs an error in a datestamped file within the "logs" folder.
	 * Each error is logged with a full timestamp.
	 * 
	 * @param Throwable $error
	 */
	private static function logerror(Throwable $error) {
	  $logfile = ROOT_DIR . 'logs/error-' . date('Ymd') . '.txt';
	  $msg = date('c') . ': ' . $error . "\n";
	  file_put_contents($logfile, $msg, FILE_APPEND);
	}
}
?>
