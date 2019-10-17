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

    public function __construct( $first = '', $second = '', $fn_test = '' )
    {
        $this->vars['first'] = $first;
        $this->vars['second'] = $second;
        $this->vars['test_func'] = $fn_test;
        $this->vars['foo'] = 'bar';
        $this->vars['baz'] = ['bat','bin','bar'];
        $this->vars['count'] = 1;
        $this->vars['date'] = '2001-09-11';
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
            'eq_test' => 'Test that 5 = {{eq:5|5|five|seven}}.',
            'ex_test' => 'Test that cow exists and says {{ex:$foo|moo}}.',
            'pl_test' => 'Test that there {{pl:$baz|is one option|are multiple options}}.',
            'impl_test' => 'Test oxford comma format for the following values: {{impl:$baz}}.',
            'date_test' => 'Test date conversion that {{$date}} = {{df:$date|Y-m-d}}.',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function resolve()
    {
        if($this->vars['test_func']){
            switch($this->vars['test_func']){
                case 'eq': return $this->parseTemplate('eq_test');
                case 'ex': return $this->parseTemplate('ex_test');
                case 'pl': return $this->parseTemplate('pl_test');
                case 'impl': return $this->parseTemplate('impl_test');
                case 'date': return $this->parseTemplate('date_test');
            }
        }

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