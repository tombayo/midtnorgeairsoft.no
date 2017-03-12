<?php declare(strict_types=1);
/**
 * Configuration file for the application.
 * 
 * 
 * @package pipless
 * @subpackage config
 */

/**
 * Base URL including trailing slash (e.g. http://localhost/)
 * @global string $config['base_url']
 */
$config['base_url'] = 'https://midtnorgeairsoft.no/';
/**
 * Selects whether or not url rewriting should be used for this application
 * @global bool $config['url_rewrite']
 */
$config['url_rewrite'] = true; 
/**
 * Selects if the application should force the use of https
 * @global bool $config['force_https']
 */
$config['force_https'] = true;
/**
 * Sets the lifetime of sessions in seconds.
 * @global integer $config['session_lifetime']
 */
$config['session_lifetime'] = 60*60*24*31;
/**
 * Sets the script default error-reporting setting
 * @global bool $config['report_errors']
 */
$config['report_errors'] = false;
/**
 * The default controller to load
 * @global string $config['default_controller']
 */
$config['default_controller'] = 'main';
/**
 * Controller used for errors (e.g. 404, 500 etc)
 * @global string $config['error_controller']
 */
$config['error_controller'] = 'siteerror';
/**
 * Specifies what to load from the folder 'extras'. Make sure to load the stuff
 * which is needed by any of the controllers. The application will break if an
 * extra is missing when called upon.
 * @global array $config['include_extras'] 
 */
$config['include_extras'] = ['BasicWebpage', 'JsonController', 'Objectify', 'MenuHelper', 'i18nHelper'];
/**
 * ISO 639-1 Language Code for the webcontent
 * @global string $config['language']
 */
$config['language'] = 'no';
date_default_timezone_set('Europe/Paris');

/**
 * Database host (e.g. localhost)
 * @global string $config['db_host']
 */
$config['db_host'] = 'localhost';
/**
 * Database name
 * @global string $config['db_name']
 */
$config['db_name'] = 'dbname';
/**
 * Database username
 * @global string $config['db_username']
 */
$config['db_username'] = 'user';
/**
 * Database password
 * @global string $config['db_password']
 */
$config['db_password'] = 'pass';
/**
 * Prevents changes to the database schema
 * @global string $config['db_freeze']
 */
$config['db_freeze'] = true; 
