<?php declare(strict_types=1);

/**
 * A trait for controllers supplying JSON-encoded data.
 *
 * Calling setHeaders() will prepare the correct headers for the response.
 * Also implements a basic index()-method which can be used for testing the controller from the front-end.
 *
 * @author Tom Andre Munkhaug <me@tombayo.com>
 * @package pipless
 * @subpackage traits
 *
 */
trait JsonController {

  /**
   * Sets headers for JSON-data.
   */
  private static function setHeaders() {
    header("Content-Type: application/json; charset=UTF-8");
  }

  /**
   * Echoes "empty"=>"null" as JSON.
   */
  public static function index() {
    self::setHeaders();
    echo json_encode(['empty'=>'null']);
  }
}
