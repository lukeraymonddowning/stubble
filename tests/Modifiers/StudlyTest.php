<?php


namespace Lukeraymonddowning\Stubble\Tests\Modifiers;


use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class StudlyTest extends TestCase
{

    /**
     * @dataProvider studlyDataProvider
     */
    public function test_it_converts_replaced_values_to_studly_case($content, $values, $expectation)
    {
        $content = (new Stubble)->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function studlyDataProvider()
    {
        return [
            ['Hello {{ world | studly }}', ['world' => 'to the world'], 'Hello ToTheWorld'],
            ['{{class|studly}} extends BaseClass', ['class' => 'some-factory'], 'SomeFactory extends BaseClass'],
            ['{{studly|studly}} extends BaseClass', ['studly' => 'cool_beans'], 'CoolBeans extends BaseClass'],
        ];
    }

}
