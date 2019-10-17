<?php
/**
 * Created by PhpStorm.
 * User: strakers
 * Date: 10/17/2019
 * Time: 8:30 AM
 */

namespace LiteCondition\Conditions;

class ExampleCondition extends BaseCondition
{

    public function __construct( $first = '', $second = '' )
    {
        $this->vars['first'] = $first;
        $this->vars['second'] = $second;
    }

    /**
     * {@inheritDoc}
     */
    protected function templates()
    {
        return [
            'main' => 'Who am I? First is the {{$first}}, and second is the {{$second}}.',
            'first_only' => 'Who am I? First is the {{$first}}.',
            'second_only' => 'Who am I? Second is the {{$second}}.',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function resolve()
    {
        if( $this->vars['first'] && $this->vars['second']) {
            return $this->parseTemplate('main');
        }
        elseif( $this->vars['first'] ){
            return $this->parseTemplate('first_only');
        }
        elseif( $this->vars['second'] ){
            return $this->parseTemplate('second_only');
        }

        return '';
    }
}