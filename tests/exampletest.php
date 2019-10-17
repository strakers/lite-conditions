<?php

include_once dirname(__DIR__).'/vendor/autoload.php';
use LiteCondition\Conditions\ExampleCondition;

$condition1 = new ExampleCondition('1st','2nd');
$text1 = $condition1->resolve();
var_dump($text1);

$condition2 = new ExampleCondition('1st');
$text2 = $condition2->resolve();
var_dump($text2);

$condition3 = new ExampleCondition(null,'2nd');
$text3 = $condition3->resolve();
var_dump($text3);