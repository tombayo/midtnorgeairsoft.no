<?php declare(strict_types=1);
/**
 * The settings controller, handles user preferences.
 * 
 * 
 * @package mna
 * @subpackage controllers
 * 
 * @author Tom Andre Munkhaug <me@tombayo.com>
 *
 */
class settings extends Controller {
	
  /**
   * Simply redirect the user to base url.
   */
  public static function index() {
    parent::redirect('');
  }
  
  /**
   * Saves the user's language preference
   */
  public static function setlang() {
    if($_GET['lang'] ?? false) {
      $lang = preg_replace('/[^a-z]/','',$_GET['lang']);
      if(strlen($lang) == 2) {
        $_SESSION['language'] = $_GET['lang'];
      }
    }
    parent::redirect('');
  }
}
