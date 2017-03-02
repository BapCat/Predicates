<?php namespace BapCat\Predicates;

use BapCat\Interfaces\Ioc\Ioc;

function identity() {
  return function() {
    return true;
  };
}

function is($val, $use_arg = 0) {
  return function(...$args) use($val, $use_arg) {
    return $args[$use_arg] === $val;
  };
}

function not(callable $predicate) {
  return function(...$args) use($predicate) {
    return !$predicate(...$args);
  };
}

function isEmpty($use_arg = 0) {
  return function(...$args) use($use_arg) {
    return empty($args[$use_arg]);
  };
}

function isNull($use_arg = 0) {
  return is(null, $use_arg);
}

function in(array $values, $use_arg = 0) {
  return function(...$args) use($values, $use_arg) {
    return in_array($args[$use_arg], $values);
  };
}

function wrap($class, array $use_args = [0]) {
  return function(...$args) use($class, $use_args) {
    return Ioc::instance()->make($class, array_intersect_key($args, array_flip($use_args)));
  };
}

function multi(callable... $predicates) {
  return function(...$args) use($predicates) {
    foreach($predicates as $predicate) {
      $predicate(...$args);
    }
  };
}

function chain(callable... $predicates) {
  return function(...$args) use($predicates) {
    foreach($predicates as $predicate) {
      if(!$predicate(...$args)) {
        return false;
      }
    }
    
    return true;
  };
}

function any(callable... $predicates) {
  return function(...$args) use($predicates) {
    foreach($predicates as $predicate) {
      if($predicate(...$args)) {
        return true;
      }
    }
    
    return false;
  };
}

function dump($use_arg = 0) {
  return function(...$args) use($use_arg) {
    var_dump($args[$use_arg]);
  };
}

function output($use_arg = 0) {
  return function(...$args) use($use_arg) {
    echo (string)$args[$use_arg];
  };
}

function newline() {
  return function(...$args) {
    echo "\n";
  };
}

function sprintf($format, array $use_args = [0]) {
  return function(...$args) use($format, $use_args) {
    echo \sprintf($format, ...array_intersect_key($args, array_flip($use_args)));
  };
}
