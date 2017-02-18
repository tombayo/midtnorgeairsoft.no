<?php declare(strict_types=1);

/**
 * A trait to enable calling static methods in an object context.
 *
 * Used by controllers to enable them to be createable instances in order to
 * use their private static functions within other controllers.
 *
 * @author Tom Andre Munkhaug <me@tombayo.com>
 * @package pipless
 * @subpackage traits
 *
 */
trait Objectify {

  /**
   * Tries to call any unaccessible methods in this class.
   *
   * @param string $name
   * @param array $args
   *
   * @return mixed
   */
  public function __call(string $name, array $args) {
    return $this->$name(...$args);
  }
}