<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 3:25 PM
 */
namespace LiteCondition\Packages;

abstract class BasePackage implements PackageInterface
{
    static public function makeEmpty(){
        return new static();
    }
}