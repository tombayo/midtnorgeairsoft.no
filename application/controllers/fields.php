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
	  $template->set('album',self::imageAlbum($field));
	  $template->render();
	}
	
	/**
	 * Makes a list of all the files in the supplied folder.
	 * 
	 * $folder should be within ROOT_DIR/static/images
	 * 
	 * @param string $folder
	 * @return array
	 */
	private static function imageAlbum(string $folder):array {
	  $scanfolder = ROOT_DIR.'static/images/'.$folder.'/';
	  $filenames = scandir($scanfolder);
	  $files = [];
	  foreach ($filenames as $filename) {
	    $thisfile = $scanfolder.$filename;
	    if (is_file($thisfile)) {
	      $pathinfo = pathinfo($thisfile);
	      $file['name'] = $pathinfo['filename'];
	      $file['ext'] = $pathinfo['extension'];
	      $file['url'] = BASE_URL.'static/images/'.$folder.'/'.$filename;
	      $file['mtime'] = filemtime($thisfile);
	      $file['hash'] = sha1_file($thisfile);
	      $files[] = $file;
	    }
	  }
	  return $files;
	}
}

?>