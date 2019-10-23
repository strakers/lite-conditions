<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 7:17 AM
 */

namespace LiteCondition\Utils;

class Template
{
    // for temporarily storing data
    static protected $_temp_data = [];

    // prevent instantiation
    private function __construct(){}

    /**
     * Replace placeholders in a template with actual data
     * @param $template
     * @param $data
     * @return string
     * @throws \ErrorException
     */
    static public function parse( $template, $data )
    {
        // temporarily store data
        static::$_temp_data = $data;

        // declare variables for template replacing
        $originals = [];
        $replacements = [];
        $functions = Util::ities(true);

        // get all curly-brace instances
        if(preg_match_all("/{{(.+?)}}/", $template, $matches)) {
            foreach(end($matches) as $i => $match){

                // store replacement values
                $originals[$i] = $matches[0][$i];
                $replacements[$i] = $match;

                // if filter function
                if( strpos($match,':') !== false ){
                    list($fn,$arg_string) = explode(':',$match,2);
                    if( array_key_exists($fn, $functions) && is_callable($functions[$fn])){
                        $function = $functions[$fn];
                        $arguments = array_map([static::class,'str2var'],explode('|', $arg_string));

                        // convert boolean and numeric values from strings
                        foreach($arguments as &$arg){
                            if($arg === 'true' || $arg === 'false'){
                                $arg = filter_var($arg, FILTER_VALIDATE_BOOLEAN);
                            }
                            elseif(is_numeric($arg)){
                                $arg = strpos($arg,'.')&&strlen(substr($arg,strpos($arg,'.')+1))?(float)$arg:(int)$arg;
                            }
                        }

                        // perform replacements
                        $replacements[$i] = call_user_func_array($function,$arguments);
                    }
                    else {
                        throw new \ErrorException("Utility function/method {$fn} not found or declared.");
                    }
                }

                // if variable
                elseif( strpos($match,'$') !== false ){
                    $replacements[$i] = static::str2var($match);
                }
            }
        }

        // clear temp data
        static::$_temp_data = [];

        // output parsed replacement
        return str_replace($originals, $replacements, $template);
    }

    /**
     * Return data representation of string variable
     * @param $string
     * @return mixed
     */
    static protected function str2var( $string )
    {
        $trimmed = trim($string);
        $private_denotation = '__';
        if( strpos($trimmed,'$') === 0 && preg_match("/([a-zA-Z0-9_]+)/",$string,$match) ){
            $key = end($match);
            if( array_key_exists($key, static::$_temp_data)){
                return static::$_temp_data[$key];
            }
            elseif( strpos($key,$private_denotation) === 0 && property_exists(static::class,substr($key,strlen($private_denotation))) ){
                return constant(static::class.'::'.$key);
            }
        }
        return $string;
    }
}