<?php declare(strict_types=1);

/**
 * A helper class for creating navigation menus.
 *
 * @author Tom Andre Munkhaug <me@tombayo.com>
 * @package pipless
 * @subpackage helpers
 */
class Menu {
  public $items;
  public $text;
  public $active;
  
  function __construct($text) {
    $this->text = $text;
  }
  
  /**
   * Adds either a new submenu or an item to this menu.
   * Returns itself for chaining.
   * 
   * @param unknown $item
   * @return Menu
   */
  public function add($item):Menu {
    $this->items[] = $item;
    if (!$this->active) {
      $this->active = ($item->active) ? true:false;
    }
    return $this;
  }
}

/**
 * A class that represents an item in Menu
 *
 * @author Tom Andre Munkhaug <me@tombayo.com>
 * @package pipless
 * @subpackage helpers
 */
class MenuItem {
  public $text;
  public $active;
  public $url;
  public $blank;
  
  /**
   * Create a new MenuItem.
   * 
   * @param string $text UI-text for this menuitem.
   * @param bool $active Whether or not the item is active.
   * @param string $url URL for the link this menuitem should point to.
   * @param bool $blank Whether or not the link should open a new page.
   */
  function __construct(string $text, bool $active, string $url, bool $blank=false) {
    $this->text = $text;
    $this->active = $active;
    $this->url = $url;
    $this->blank = $blank;
  }
  
}