<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 7:28 AM
 */

namespace LiteCondition\Conditions;

abstract class BaseTwigCondition extends BaseCondition
{

    /**
     * Pass template and data to template processor
     * @param string $template_name
     * @return string
     * @throws \ErrorException
     */
    protected function parseTemplate( $template_name = '' )
    {
        if( class_exists('Twig\Environment') && class_exists('Twig\Loader\ArrayLoader') ){
            $templates = $this->templates();
            $loader = new \Twig\Loader\ArrayLoader($templates);
            $twig = new \Twig\Environment($loader);
            return $twig->render( $template_name, $this->vars );
        }
        throw new \ErrorException("Twig package is not installed. Please run `composer require \"twig/twig:^2.0\"`.");
    }
}