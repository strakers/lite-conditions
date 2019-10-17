<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 3:46 PM
 */
namespace LiteCondition\Packages;

interface PackageInterface
{
    public function deliver();

    static public function make();

    static public function makeEmpty();
}