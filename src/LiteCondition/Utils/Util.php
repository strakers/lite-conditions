<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 7:14 AM
 */
namespace LiteCondition\Utils;

class Util
{
    const DEFAULT_DATE_FORMAT = 'l, M j Y';
    static protected $_extra_utility_functions = [];

    // prevent instantiation
    private function __construct(){}

    /**
     * Return a list of all available utility functions by method name or alias
     * @param bool $use_alias
     * @return array
     */
    static public function functions( $use_alias = false )
    {
        // list of methods: method_name => alias
        $methods = [
            'pluralize' => 'pl',
            'oxfordComma' => 'impl',
            'hasValue' => 'ex',
            'equatesTo' => 'eq',
            'dateFormatConvert' => 'date',
        ];
        $function_map = [];

        // loop through standard utility functions
        foreach( $methods as $method => $alias ){
            if( method_exists(static::class,$method) ){
                $function_map[($use_alias?$alias:$method)] = static::class . "::{$method}";
            }
        }

        // loop through custom add-on utility functions
        foreach( static::$_extra_utility_functions as $alias => $function ){
            $function_map[$alias] = $function;
        }

        return $function_map;
    }

    /**
     * Handy alias for the functions method.
     * Get it? `Util::ities`, Utilities... yeah okay, I'll stick to my day job...
     * @param bool $use_alias
     * @return array
     */
    static public function ities( $use_alias = false )
    {
        return static::functions( $use_alias );
    }

    /**
     * Add utility function to list of available functions
     * @param string $alias
     * @param callable $callable
     * @return bool
     */
    static public function setUtility( $alias, callable $callable )
    {
        if( is_string($alias) && is_callable($callable) ) {
            static::$_extra_utility_functions[$alias] = $callable;
            return true;
        }
        return false;
    }

    /**
     * Remove utility function from list of available functions
     * @param string $alias
     * @return bool
     */
    static public function unsetUtility( $alias )
    {
        if( is_string($alias) && array_key_exists($alias,static::$_extra_utility_functions) ){
            unset(static::$_extra_utility_functions[$alias]);
            return true;
        }
        return false;
    }

    /**
     * Determines whether to use the singular or plural form depending on the value's count
     * @param array $value
     * @param $singular
     * @param $plural
     * @return mixed
     */
    static public function pluralize( array $value, $singular, $plural){
        $count = is_array($value)
            ? count($value)
            : (
            is_string($value) && !is_numeric($value)
                ? strlen($value)
                : $value * 1
            );
        return $count===1?$singular:$plural;
    }

    /**
     * Implodes an array of strings using oxford comma notation
     * @param array $array
     * @param string $conjunction
     * @param string $spacer
     * @return string
     */
    static public function oxfordComma(  $array, $conjunction = 'and', $spacer = ', ' ){
        if(count($array)>2){
            $last = array_pop($array);
            return implode($spacer,$array) . $spacer . "{$conjunction} " . $last;
        }
        else {
            return implode(" {$conjunction} ",$array);
        }
    }

    /**
     * Determines whether to output a value if the value is truthy or falsey
     * @param mixed $value
     * @param string $string
     * @param bool $condition
     * @return string
     */
    static public function hasValue( $value, $string, $condition = false ){
        return empty($value)===$condition?$string:'';
    }

    /**
     * Determines whether to output a value if the value equates to another (the comparator)
     * @param mixed $value
     * @param string $comparator
     * @param string $output
     * @param string $default
     * @return string
     */
    static public function equatesTo( $value, $comparator, $output = '', $default = '' ){
        return $value===$comparator?($output?:$value):$default;
    }

    /**
     * Converts a date string from one format to another
     * @param $dateString
     * @param string $startFormat
     * @param string $endFormat
     * @return string
     */
    static public function dateFormatConvert( $dateString, $startFormat = 'm/d/Y', $endFormat = self::DEFAULT_DATE_FORMAT )
    {
        $zone = new \DateTimeZone('America/New_York');
        $date = \DateTime::createFromFormat($startFormat, $dateString);
        if($date) {
            $date->setTimezone($zone);
            return $date->format($endFormat);
        }
        return $dateString;
    }
}