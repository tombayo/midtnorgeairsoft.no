<?php declare(strict_types=1);
/**
 * A trait used to define a basic controller.
 *
 * A trait that loads the view "view.classname.php" and supplies the view with some basic variables.
 * Used by controllers that only displays a standard index-view with no other logic.
 * Should NOT be used by classes that don't extend Controller
 *
 * @author Tom Andre Munkhaug <me@tombayo.com>
 * @package mna
 * @subpackage traits
 */
trait BasicWebpage {

  /**
   * Loads the view "view.classname.php", supplies some basic variables, and renders the view.
   */
  public static function index() {
    $template = Load::view('view.'.__CLASS__);
    $template = self::commonTemplateVars($template);
    $template->render();
  }
  
  /**
   * Takes a View and feed it with the common variables shared amongst the various templates.
   * 
   * @param View $view
   * @return View
   */
  private static function commonTemplateVars(View $view):View {
    global $config;
    $i18n = new i18nHelper($_SESSION['language'] ?? $config['language']);
    $view->set('controller', __CLASS__);
    $view->set('lang', $i18n);
    $view->set('url', function ($controller,$method='',$get=[],$frag='') {
      return parent::createUrl($controller,$method,$get,$frag);
    });
    $view->set('menu', self::createMenu($i18n, __CLASS__));
  
      return $view;
  }
  
  /**
   * Creates the menu for this web application.
   * 
   * @todo should be implemented as a config-file or something...
   * 
   * @param i18nHelper $lang
   * @param string $controller
   * @return Menu
   */
  private static function createMenu(i18nHelper $lang, string $controller):Menu {
    $menu = new Menu('topnav');
    $menu->add(
      new MenuItem(
        $lang->dict->nav->main,
        ($controller == 'main') ? true:false,
        parent::createUrl('main')
      )
    )->add(
      (
        new Menu($lang->dict->nav->information)
      )->add(
        new MenuItem(
          $lang->dict->nav->about,
          ($controller == 'about') ? true:false,
          parent::createUrl('about')
        )
      )->add(
        new MenuItem(
          $lang->dict->nav->airsoft,
          false,
          "http://nasf.no/index.php/informasjon/hva-er-airsoft-artikkel",
          true
        )
      )->add(
        new MenuItem(
          "FAQ",
          ($controller == 'faq') ? true:false,
          parent::createUrl('faq')
        )
      )
    )->add(
      (
        new Menu($lang->dict->nav->fields)
      )->add(
        new MenuItem(
          'Gevingåsen',
          (($_GET['fields'] ?? '') == 'geving') ? true:false,
          parent::createUrl('fields','',['field'=>'geving'])
        )
      )->add(
        new MenuItem(
          'Sætnan',
          (($_GET['fields'] ?? '') == 'saetnan') ? true:false,
          parent::createUrl('fields','',['field'=>'saetnan'])
        )
      )
    )->add(
      new MenuItem(
        $lang->dict->nav->join,
        ($controller == 'join') ? true:false,
        parent::createUrl('join')
      )
    );

    return $menu;
  }
}
