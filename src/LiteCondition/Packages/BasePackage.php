<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 3:25 PM
 */
namespace LiteCondition\Packages;

abstract class BasePackage
{
    abstract public function deliver();

    abstract static public function make();

    static public function makeEmpty(){
        return new static();
    }
}