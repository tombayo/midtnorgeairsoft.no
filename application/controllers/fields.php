<?php declare(strict_types=1);
/**
 * The fields controller, renders view.fields.php.
 *
 *
 * view.fields.php gets rendered after handling the GET requests.
 * @see view.fields.php
 *
 * @package mna
 * @subpackage controllers
 *
 * @author Tom Andre Munkhaug <me@tombayo.com>
 */
class fields extends Controller {
	use BasicWebpage;
	
	public static function index() {
	  $ourfields = ['geving', 'saetnan'];
	  
	  $field = $_GET['field'] ?? $ourfields[0];
	  $field = (in_array($field,$ourfields)) ? $field : $ourfields[0];
	  
	  $template = Load::view('view.fields.'.$field);
	  $template = self::commonTemplateVars($template);
	  $template->render();
	}
}

?>