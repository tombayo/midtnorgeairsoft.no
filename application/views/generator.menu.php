<?php
/**
 * A generator for generating a Menu.
 * 
 * Generates a menu based on $menu.
 * $menu must be an instance of Menu.
 *
 * @package mna
 * @subpackage views
 */

	foreach ($menu->items as $item) {
	  if (is_a($item, "Menu")) {
	    echo '<li class="dropdown';
	    if ($item->active) echo ' active';
      echo '">';
      echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
            aria-haspopup="true" aria-expanded="false">';
      echo $item->text.' <span class="caret"></span></a>';
	    echo '<ul class="dropdown-menu">';
	    foreach ($item->items as $subitem) {
	      echo '<li';
	      if ($subitem->active) echo ' class="active"';
	      echo '><a href="'.$subitem->url.'"';
	      if ($subitem->blank) echo ' target="_blank"';
	      echo '>'.$subitem->text.'</a></li>';
	    }
	    echo '</ul></li>';
	  } else {
		  echo '<li';
		  if ($item->active) echo ' class="active"';
		  echo '><a href="'.$item->url.'"';
		  if ($item->blank) echo ' target="_blank"';
		  echo '>'.$item->text.'</a></li>';
	  }
	}
?>