#!/usr/bin/env php
<?php

include __DIR__ . '/vendor/autoload.php';

use BapCat\Collection\Collection;

use function BapCat\Predicates\chain;
use function BapCat\Predicates\is;
use function BapCat\Predicates\isNull;
use function BapCat\Predicates\isEmpty;
use function BapCat\Predicates\multi;
use function BapCat\Predicates\newline;
use function BapCat\Predicates\not;
use function BapCat\Predicates\output;
use function BapCat\Predicates\sprintf;
use function BapCat\Predicates\wrap;

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
  ->filter(not(isEmpty()))
  ->map(wrap(Test::class))
  ->each(multi(output(), newline()));

echo "\n";
echo "Second test\n";

(new Collection(['a', 'b', null, 'c', false, null, true, 'd']))
  ->filter(isNull())
  ->each(sprintf("Found null! Key=%s\n", [1]));

echo "\n";
echo "Third test\n";

(new Collection(['a', 'b', null, 'c', 'd']))
  ->filter(is(1, 1))
  ->each(multi(output(), newline()));


echo "\n";
echo "Third test\n";

(new Collection(['a', 'b', 'c']))->each(chain(wrap(Test::class), multi(function($arg) { echo get_class($arg), ' ', $arg; }, newline())));
