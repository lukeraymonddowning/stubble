<?php

namespace Lukeraymonddowning\Stubble\Tests\Modifiers;

use Lukeraymonddowning\Stubble\Stubble;
use Lukeraymonddowning\Stubble\Tests\TestCase;

class SingularTest extends TestCase
{
    /**
     * @dataProvider singularDataProvider
     */
    public function test_it_converts_replaced_values_to_singular_case($content, $values, $expectation)
    {
        $content = (new Stubble())->replace($content, $values);

        expect($content)->toEqual($expectation);
    }

    public function singularDataProvider()
    {
        return [
            ['Hello {{ world | singular }}', ['world' => 'to the worlds'], 'Hello to the world'],
            ['{{class|singular}} extends BaseClass', ['class' => 'some factories'], 'some factory extends BaseClass'],
            ['{{singular|singular}} extends BaseClass', ['singular' => 'CoolBeans'], 'CoolBean extends BaseClass'],
            ['{{singular|singular|camel}} extends BaseClass', ['singular' => 'CoolBeans'], 'coolBean extends BaseClass'],
        ];
    }
}
