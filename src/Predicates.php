<?php namespace BapCat\Predicates;

use BapCat\Interfaces\Ioc\Ioc;

class Predicates {
  public static function identity() {
    return function() {
      return true;
    };
  }
  
  public static function is($val, $use_arg = 0) {
    return function(...$args) use($val, $use_arg) {
      return $args[$use_arg] === $val;
    };
  }
  
  public static function not(callable $predicate) {
    return function(...$args) use($predicate) {
      return !$predicate(...$args);
    };
  }
  
  public static function empty($use_arg = 0) {
    return function(...$args) use($use_arg) {
      return empty($args[$use_arg]);
    };
  }
  
  public static function null($use_arg = 0) {
    return self::is(null, $use_arg);
  }
  
  public static function wrap($class, array $use_args = [0]) {
    return function(...$args) use($class, $use_args) {
      return Ioc::instance()->make($class, array_intersect_key($args, array_flip($use_args)));
    };
  }
  
  public static function multi(callable... $predicates) {
    return function(...$args) use($predicates) {
      foreach($predicates as $predicate) {
        $predicate(...$args);
      }
    };
  }
  
  public static function chain(callable... $predicates) {
    return function(...$args) use($predicates) {
      foreach($predicates as $predicate) {
        if(!$predicate(...$args)) {
          return false;
        }
      }
      
      return true;
    };
  }
  
  public static function dump($use_arg = 0) {
    return function(...$args) use($use_arg) {
      var_dump($args[$use_arg]);
    };
  }
  
  public static function output($use_arg = 0) {
    return function(...$args) use($use_arg) {
      echo (string)$args[$use_arg];
    };
  }
  
  public static function newLine() {
    return function(...$args) {
      echo "\n";
    };
  }
  
  public static function sprintf($format, array $use_args = [0]) {
    return function(...$args) use($format, $use_args) {
      echo sprintf($format, ...array_intersect_key($args, array_flip($use_args)));
    };
  }
}
