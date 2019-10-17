<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 3:51 PM
 */
namespace LiteCondition\Packages;

class ContentPackage extends BasePackage
{
    private $contents;

    public function __construct( $contents = '' )
    {
        $this->contents = $contents;
    }

    public function deliver(){
        return $this->contents;
    }

    static public function make( $contents = '' ){
        return new self($contents);
    }
}