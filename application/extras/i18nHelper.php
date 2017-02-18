<?php declare(strict_types=1);
/**
 * A class handling i18n 
 *
 * @author Tom Andre Munkhaug <me@tombayo.com>
 * @package mna
 * @subpackage helpers
 */
class i18nHelper {
  private $lang;
  public $dict;
  
  /**
   * Loads a JSON-encoded dictionary file based on the language specified.
   * 
   * @param string $lang
   */
  function __construct(string $lang) {
    global $config;
    
    $dictfile = file_get_contents(ROOT_DIR.'static/i18n/'.$lang.'/l10n.json');
    if($dictfile) {
      $dict = json_decode($dictfile);
    }
    if(!$dictfile || !$dict) {
      // Fall back to config-setup
      $dictfile = file_get_contents(ROOT_DIR.'static/i18n/'.$config['language'].'/l10n.json');
      $dict = json_decode($dictfile);
    }
    $this->lang = $lang;
    $this->dict = $dict;
  }
  
  /**
   * Instances of this class should return the language specified.
   * 
   * @return string
   */
  function __toString() {
    return $this->lang;
  }
  
  /**
   * Parses a specified Markdown-file from the static/i18n/ folder.
   *  
   * @param string $content name of file
   * @return string parsed string from the markdown file
   */
  public function cont(string $content):string {
    global $config;
    Load::plugin('Parsedown');
    $parsedown = new Parsedown();
    $parsedown->setBreaksEnabled(true);
    
    $md = file_get_contents(ROOT_DIR.'static/i18n/'.$this->lang.'/'.$content.'.md');
    if(!$md) {
      // Fall back to config-setup
      $md = file_get_contents(ROOT_DIR.'static/i18n/'.$config['language'].'/'.$content.'.md');
    }
    
    return $parsedown->text($md);
  }
}