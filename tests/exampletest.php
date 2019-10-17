<?php

include_once dirname(__DIR__).'/vendor/autoload.php';
use LiteCondition\Conditions\ExampleCondition;

$condition = [];
$text = [];
$i = 0;

$condition[$i] = new ExampleCondition('1st','2nd');
$text[$i] = $condition[$i]->resolve();
var_dump($text[$i]);
$i++;

$condition[$i] = new ExampleCondition('1st');
$text[$i] = $condition[$i]->resolve();
var_dump($text[$i]);
$i++;

$condition[$i] = new ExampleCondition(null,'2nd');
$text[$i] = $condition[$i]->resolve();
var_dump($text[$i]);
$i++;

$condition[$i] = new ExampleCondition(null,null,'eq');
$text[$i] = $condition[$i]->resolve();
var_dump($text[$i]);
$i++;

$condition[$i] = new ExampleCondition(null,null,'ex');
$text[$i] = $condition[$i]->resolve();
var_dump($text[$i]);
$i++;

$condition[$i] = new ExampleCondition(null,null,'pl');
$text[$i] = $condition[$i]->resolve();
var_dump($text[$i]);
$i++;

$condition[$i] = new ExampleCondition(null,null,'impl');
$text[$i] = $condition[$i]->resolve();
var_dump($text[$i]);
$i++;

$condition[$i] = new ExampleCondition(null,null,'date');
$text[$i] = $condition[$i]->resolve();
var_dump($text[$i]);
$i++;