<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 7:25 AM
 */
namespace LiteCondition\Conditions;
use LiteCondition\Utils\Template;
use LiteCondition\Packages\BasePackage;

abstract class BaseCondition
{
    protected $vars = [];
    
    /**
     * Process logic and output text
     * @return BasePackage
     */
    abstract protected function resolve();

    /**
     * Pass template and data to template processor
     * @param string $template_name
     * @return string
     * @throws \ErrorException
     */
    protected function parseTemplate( $template_name = '' )
    {
        $template = $this->getTemplate($template_name);
        return Template::parse( $template, $this->vars );
    }

    /**
     * Define a list of key=>value templates
     * @return array
     */
    protected function templates()
    {
        return [];
    }

    /**
     * Retrieve a particular named template
     * @param string $name
     * @return string
     */
    public function getTemplate( $name = '' )
    {
        $templates = $this->templates();
        if( array_key_exists($name, $templates) ){
            return $templates[$name];
        }
        return '';
    }
}