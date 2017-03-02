#!/usr/bin/env php
<?php

include __DIR__ . '/vendor/autoload.php';

use BapCat\Collection\Collection;
use BapCat\Predicates\Predicates as P;

BapCat\Phi\Phi::instance();

class Test {
  private $val;
  
  public function __construct($val) {
    $this->val = $val;
  }
  
  public function __toString() {
    return (string)$this->val;
  }
}

echo "First test\n";

(new Collection(['a', 'b', null, 'c', 'd']))
  ->filter(P::not(P::empty()))
  ->map(P::wrap(Test::class))
  ->each(P::multi(P::output(), P::newLine()));

echo "\n";
echo "Second test\n";

(new Collection(['a', 'b', null, 'c', false, null, true, 'd']))
  ->filter(P::null())
  ->each(P::sprintf("Found null! Key=%s\n", [1]));

echo "\n";
echo "Third test\n";

(new Collection(['a', 'b', null, 'c', 'd']))
  ->filter(P::is(1, 1))
  ->each(P::multi(P::output(), P::newLine()));
